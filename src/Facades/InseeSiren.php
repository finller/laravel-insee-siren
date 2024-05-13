<?php

namespace Finller\InseeSiren\Facades;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Facade;

/**
 * @method static Collection<string, mixed> get(string $siren)
 *
 * @see \Finller\InseeSiren\InseeSiren
 */
class InseeSiren extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \Finller\InseeSiren\InseeSiren::class;
    }
}
