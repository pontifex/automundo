<?php

namespace App\Domain\Entities;

use App\Serializers\ISerializable;

readonly class Brand implements ISerializable
{
    public function __construct(
        private string $id,
        public string $name,
        public string $slug
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
            'name',
            'slug',
        ];
    }
}
