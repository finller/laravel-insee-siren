<?php

namespace Finller\InseeSiren\Integrations\Insee\Requests;

use Saloon\Enums\Method;
use Saloon\Http\Request;

class SirenRequest extends Request
{
    protected Method $method = Method::GET;

    public function __construct(protected readonly string $siren)
    {
        //
    }

    public function resolveEndpoint(): string
    {
        return "/siren/{$this->siren}";
    }
}
