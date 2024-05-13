<?php

namespace Finller\InseeSiren\Tests;

use Finller\InseeSiren\InseeSirenServiceProvider;
use Illuminate\Database\Eloquent\Factories\Factory;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    public string $siren = '897962361';

    protected function setUp(): void
    {
        parent::setUp();

        Factory::guessFactoryNamesUsing(
            fn (string $modelName) => 'Finller\\InseeSiren\\Database\\Factories\\'.class_basename($modelName).'Factory'
        );
    }

    protected function getPackageProviders($app)
    {
        return [
            InseeSirenServiceProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app)
    {
        config()->set('database.default', 'testing');
        config()->set('insee-siren.key', 'REDACTED');
        config()->set('insee-siren.secret', 'REDACTED');

        /*
        $migration = include __DIR__.'/../database/migrations/create_laravel-insee-siren_table.php.stub';
        $migration->up();
        */
    }
}
