<?php

namespace App\Domain\Entities;

use App\Domain\ValueObjects\Mileage;
use App\Domain\ValueObjects\Price;
use App\Serializers\ISerializable;

readonly class Product implements ISerializable
{
    public function __construct(
        private string $id,
        public string $description,
        public Mileage $mileage,
        public Price $price,
        public ?Model $model = null
    ) {
    }

    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @psalm-return array<string>
     */
    public static function getAllowedFields(): array
    {
        return [
            'id',
            'description',
            'mileage',
            'price',
        ];
    }
}
