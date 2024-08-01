<?php

namespace App\Domain\Entities;

use App\Serializers\ISerializable;

readonly class Model implements ISerializable
{
    public function __construct(
        private string $id,
        public string $name,
        public string $slug,
        public ?Brand $brand = null
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
