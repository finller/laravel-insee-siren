<?php

namespace Finller\InseeSiren;

use Illuminate\Support\Collection;

class InseeSiren
{
    public function __construct(
        public InseeSirenClient $client
    ) {
        //
    }

    public function get(string $siren): Collection
    {
        return collect($this->client->getSiren($siren));
    }
}
