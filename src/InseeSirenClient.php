<?php

namespace Finller\InseeSiren;

interface InseeSirenClient
{
    public function getSiren(string $siren): array;
}
