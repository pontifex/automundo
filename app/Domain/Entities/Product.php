<?php

namespace App\Domain\Entities;

use App\Domain\ValueObjects\Mileage;
use App\Domain\ValueObjects\Price;
use App\Hydrators\IHydrateable;
use App\Serializers\ISerializable;

readonly class Product implements IHydrateable, ISerializable
{
    public function __construct(
        private string $id,
        private string $description,
        private Mileage $mileage,
        private Price $price,
        private ?Model $model = null
    ) {
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getMileage(): Mileage
    {
        return $this->mileage;
    }

    public function getPrice(): Price
    {
        return $this->price;
    }

    public function getModel(): ?Model
    {
        return $this->model;
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
