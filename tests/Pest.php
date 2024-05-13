<?php

use Finller\InseeSiren\Integrations\Insee\Requests\SirenRequest;
use Finller\InseeSiren\Tests\TestCase;
use Saloon\Config;
use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;
use Saloon\MockConfig;

uses(TestCase::class)->in(__DIR__);

Config::preventStrayRequests();

MockConfig::throwOnMissingFixtures();

uses()
    ->beforeEach(function () {
        MockClient::destroyGlobal();
        MockClient::global([
            'https://api.insee.fr/token' => MockResponse::fixture('insee-siren/token'),
            SirenRequest::class => MockResponse::fixture('insee-siren/897962361'),
        ]);
    })
    ->in(__DIR__);
