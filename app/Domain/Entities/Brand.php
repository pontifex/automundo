<?php

namespace App\Domain\Entities;

use App\Serializers\ISerializable;

readonly class Brand implements ISerializable
{
    public function __construct(
        private string $id,
        private string $name,
        private string $slug
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
