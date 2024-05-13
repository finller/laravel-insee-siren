<?php

use Finller\InseeSiren\Enums\CompanyCategory;

it('cast from long category version', function () {
    expect(CompanyCategory::tryFromLong(5410))->toBe(CompanyCategory::SARL);
    expect(CompanyCategory::fromLong(5410))->toBe(CompanyCategory::SARL);
});
