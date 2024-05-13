# Insee Siren API for Laravel

[![Latest Version on Packagist](https://img.shields.io/packagist/v/finller/laravel-insee-siren.svg?style=flat-square)](https://packagist.org/packages/finller/laravel-insee-siren)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/finller/laravel-insee-siren/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/finller/laravel-insee-siren/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/finller/laravel-insee-siren/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/finller/laravel-insee-siren/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/finller/laravel-insee-siren.svg?style=flat-square)](https://packagist.org/packages/finller/laravel-insee-siren)

Simple package to use Insee Siren API in Laravel.

It provides cache, rate limiting and auth.

## Installation

You can install the package via composer:

```bash
composer require finller/laravel-insee-siren
```

You can publish and run the migrations with:

```bash
php artisan vendor:publish --tag="insee-siren-config"
```

This is the contents of the published config file:

```php
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
```

## Usage

```php
$data = InseeSiren::get("897962361");

$data->get('uniteLegale')
```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

-   [Quentin Gabriele](https://github.com/QuentinGab)
-   [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
