<?php

namespace App\Serializers;

use App\Domain\Entities\Brand;
use App\Exceptions\WrongTypeException;

class BrandSerializer implements ISerializer
{
    private const TYPE = 'brands';

    /**
     * @psalm-return 'brands'
     */
    public static function getType(): string
    {
        return self::TYPE;
    }

    public function serialize(ISerializable $serializable, array $fields): array
    {
        if (! $serializable instanceof Brand) {
            throw new WrongTypeException(
                sprintf('Wrong type provided %s but expected %s', $serializable::class, Brand::class)
            );
        }

        $serialized = [];
        /** @psalm-var string $field */
        foreach ($fields[self::TYPE] as $field) {
            switch ($field) {
                case 'id':
                    $serialized['id'] = $serializable->getId();
                    break;
                case 'name':
                    $serialized['name'] = mb_convert_case($serializable->name, MB_CASE_UPPER);
                    break;
                case 'slug':
                    $serialized['slug'] = $serializable->slug;
                    break;
            }
        }

        return $serialized;
    }
}
