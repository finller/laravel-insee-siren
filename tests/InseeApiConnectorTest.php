<?php

use Finller\InseeSiren\Integrations\Insee\InseeApiConnector;
use Saloon\Contracts\OAuthAuthenticator;

it('can auth', function () {
    $connector = new InseeApiConnector();

    $authenticator = $connector->getAccessToken();

    expect($authenticator)->toBeInstanceOf(OAuthAuthenticator::class);
    expect($authenticator->getAccessToken())->not->toBe(null);
});

it('retrieve data from siren', function () {
    $connector = new InseeApiConnector();

    $connector->authenticate($connector->getCachedAccessToken());

    $response = $connector->siren($this->siren);

    expect($response->successful())->tobe(true);
});
