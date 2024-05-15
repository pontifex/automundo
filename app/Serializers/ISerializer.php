<?php

namespace App\Serializers;

interface ISerializer
{
    public function serialize(ISerializable $serializable, array $fields): array;

    public static function getType(): string;
}
