<?php

namespace App\Domain\ValueObjects;

class Mileage
{
    public const UNIT_MILES = 'mi';

    public const UNIT_KILOMETERS = 'km';

    public static array $validUnits = [
        self::UNIT_KILOMETERS,
        self::UNIT_MILES,
    ];

    public function __construct(
        private readonly int $distance,
        private readonly string $unit
    ) {
        if (! in_array($unit, self::$validUnits)) {
            throw new \DomainException('The Mileage unit is not valid!');
        }
    }

    public function getDistance(): int
    {
        return $this->distance;
    }

    public function getUnit(): string
    {
        return $this->unit;
    }
}
