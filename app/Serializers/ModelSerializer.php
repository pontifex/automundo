<?php

namespace App\Serializers;

use App\Domain\Entities\Model;
use App\Exceptions\WrongTypeException;

class ModelSerializer implements ISerializer
{
    private const TYPE = 'models';

    /**
     * @psalm-return 'models'
     */
    public static function getType(): string
    {
        return self::TYPE;
    }

    public function serialize(ISerializable $serializable, array $fields): array
    {
        if (! $serializable instanceof Model) {
            throw new WrongTypeException(
                sprintf('Wrong type provided %s but expected %s', $serializable::class, Model::class)
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
                    $serialized['name'] = mb_convert_case($serializable->getName(), MB_CASE_UPPER);
                    break;
                case 'slug':
                    $serialized['slug'] = $serializable->getSlug();
                    break;
            }
        }

        return $serialized;
    }
}
