<?php

// config for Finller/InseeSiren

use Finller\InseeSiren\Integrations\Insee\InseeApiConnector;

return [
    'key' => env('INSEE_KEY'),
    'secret' => env('INSEE_SECRET'),
    'version' => env('INSEE_SIREN_VERSION'),

    'cache' => [
        'enabled' => true,
        'driver' => env('INSEE_CACHE_DRIVER', env('CACHE_DRIVER', 'file')),
        'expiry_seconds' => 604_800, // 1 week
    ],

    'rate_limit' => [
        'enabled' => false,
        'driver' => env('INSEE_RATE_LIMIT_DRIVER', env('CACHE_DRIVER', 'file')),
        'every_minute' => 30,
    ],

    'client' => InseeApiConnector::class,
];
