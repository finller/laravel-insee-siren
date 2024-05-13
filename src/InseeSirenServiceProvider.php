<?php

namespace Finller\InseeSiren;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class InseeSirenServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('laravel-insee-siren')
            ->hasConfigFile();
    }

    public function registeringPackage()
    {
        $this->app->scoped(InseeSiren::class, function () {
            $client = config('insee-siren.client');

            return new InseeSiren(new $client());
        });
    }
}
