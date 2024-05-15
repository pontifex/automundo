<?php

namespace App\Serializers;

interface ISerializable
{
    public function getId(): string;

    public static function getAllowedFields(): array;
}
