<?php

use Finller\InseeSiren\Facades\InseeSiren;

it('can query data from siren', function () {
    $data = InseeSiren::get($this->siren);

    expect($data->get('uniteLegale'))->toBeArray();
    expect($data->get('uniteLegale')['siren'])->toBe($this->siren);
});
