<?php

namespace Finller\InseeSiren\Enums;

enum CompanyCategory: int
{
    case Entrepreneur = 10;
    case SARL = 54;
    case SAS = 57;
    case Association = 92;
    case Fondation = 93;

    public function getLabel(): string
    {
        return __("insee-siren::enums.CompanyCategory.{$this->value}");
    }

    public static function fromLong(int|string $value): ?static
    {
        return self::from((string) str($value)->substr(0, 2));
    }

    public static function tryFromLong(int|string $value): ?static
    {
        return static::tryFrom((string) str($value)->substr(0, 2));
    }
}
