<?php

namespace App\Domain\Entities;

use App\Hydrators\IHydrateable;
use App\Serializers\ISerializable;

class Model implements IHydrateable, ISerializable
{
    private string $id;

    private string $name;

    private string $slug;

    private ?Brand $brand;

    public function __construct(
        string $id,
        string $name,
        string $slug,
        ?Brand $brand = null
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->slug = $slug;
        $this->brand = $brand;
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

    public static function getAllowedFields(): array
    {
        return [
            'id',
            'name',
            'slug',
        ];
    }
}
