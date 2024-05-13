<?php

namespace Finller\InseeSiren\Integrations\Insee;

use Finller\InseeSiren\InseeSirenClient;
use Finller\InseeSiren\Integrations\Insee\Requests\SirenRequest;
use Illuminate\Support\Facades\Cache;
use Saloon\CachePlugin\Contracts\Cacheable;
use Saloon\CachePlugin\Contracts\Driver;
use Saloon\CachePlugin\Drivers\LaravelCacheDriver;
use Saloon\CachePlugin\Traits\HasCaching;
use Saloon\Contracts\OAuthAuthenticator;
use Saloon\Helpers\OAuth2\OAuthConfig;
use Saloon\Http\Connector;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Saloon\RateLimitPlugin\Contracts\RateLimitStore;
use Saloon\RateLimitPlugin\Limit;
use Saloon\RateLimitPlugin\Stores\LaravelCacheStore;
use Saloon\RateLimitPlugin\Traits\HasRateLimits;
use Saloon\Traits\OAuth2\ClientCredentialsGrant;

/**
 * @see documentation at https://api.insee.fr/catalogue/api-docs/carbon.super/Sirene/V3.11?envName=Production%20and%20Sandbox
 */
class InseeApiConnector extends Connector implements Cacheable, InseeSirenClient
{
    use ClientCredentialsGrant;
    use HasCaching;
    use HasRateLimits;

    public string $version;

    public function __construct()
    {
        $this->version = config('insee-siren.version') ?? 'V3.11';
        $this->cachingEnabled = config('insee-siren.cache.enabled', true);
        $this->useRateLimitPlugin(config('insee-siren.rate_limit.enabled', false));
    }

    public function resolveBaseUrl(): string
    {
        return "https://api.insee.fr/entreprises/sirene/{$this->version}";
    }

    protected function defaultHeaders(): array
    {
        return [
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ];
    }

    public function resolveCacheDriver(): Driver
    {
        return new LaravelCacheDriver(Cache::store(config('insee-siren.cache.driver', 'file')));
    }

    public function cacheExpiryInSeconds(): int
    {
        return config('insee-siren.cache.expiry_seconds', 86_400);
    }

    protected function resolveRateLimitStore(): RateLimitStore
    {
        return new LaravelCacheStore(Cache::store(config('insee-siren.rate_limit.driver', 'array')));
    }

    protected function resolveLimits(): array
    {
        return [
            Limit::allow(config('insee-siren.rate_limit.every_minute'))->everyMinute(),
        ];
    }

    protected function defaultOauthConfig(): OAuthConfig
    {
        return OAuthConfig::make()
            ->setClientId(config('insee-siren.key'))
            ->setClientSecret(config('insee-siren.secret'))
            ->setTokenEndpoint('https://api.insee.fr/token')
            ->setRequestModifier(function (Request $request) {
                // Optional: Modify the requests being sent.
                $request->headers()->set([
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/x-www-form-urlencoded',
                ]);

                $request->query()->set([
                    'grant_type' => 'client_credentials',
                ]);
            });
    }

    public function siren(string $siren): Response
    {
        return $this->send(new SirenRequest($siren));
    }

    public function getCachedAccessToken(): OAuthAuthenticator
    {
        return Cache::remember('insee:authenticator', now()->addSeconds(604_800), function () {
            return $this->getAccessToken();
        });
    }

    public function getSiren(string $siren): array
    {
        $this->authenticate($this->getCachedAccessToken());

        return $this->siren($siren)->json(null, []);
    }
}
