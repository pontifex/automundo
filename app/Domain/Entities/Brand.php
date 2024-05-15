<?php

namespace App\Domain\Entities;

use App\Hydrators\IHydrateable;
use App\Serializers\ISerializable;

class Brand implements IHydrateable, ISerializable
{
    private string $id;

    private string $name;

    private string $slug;

    public function __construct(
        string $id,
        string $name,
        string $slug
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->slug = $slug;
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

    public static function getAllowedFields(): array
    {
        return [
            'id',
            'name',
            'slug',
        ];
    }
}
