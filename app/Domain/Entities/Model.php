<?php

namespace App\Domain\Entities;

use App\Hydrators\IHydrateable;
use App\Serializers\ISerializable;

readonly class Model implements IHydrateable, ISerializable
{
    public function __construct(
        private string $id,
        private string $name,
        private string $slug,
        private ?Brand $brand = null
    ) {
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getSlug(): string
    {
        return $this->slug;
    }

    public function getBrand(): ?Brand
    {
        return $this->brand;
    }

    /**
     * @psalm-return array<string>
     */
    public static function getAllowedFields(): array
    {
        return [
            'id',
            'name',
            'slug',
        ];
    }
}
