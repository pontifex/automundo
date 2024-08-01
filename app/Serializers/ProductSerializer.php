<?php

namespace App\Serializers;

use App\Domain\Entities\Product;
use App\Exceptions\WrongTypeException;

class ProductSerializer implements ISerializer
{
    private const TYPE = 'products';

    /**
     * @psalm-return 'products'
     */
    public static function getType(): string
    {
        return self::TYPE;
    }

    public function serialize(ISerializable $serializable, array $fields): array
    {
        if (! $serializable instanceof Product) {
            throw new WrongTypeException(
                sprintf('Wrong type provided %s but expected %s', $serializable::class, Product::class)
            );
        }

        $serialized = [];
        /** @psalm-var string $field */
        foreach ($fields[self::TYPE] as $field) {
            switch ($field) {
                case 'id':
                    $serialized['id'] = $serializable->getId();
                    break;
                case 'description':
                    $serialized['description'] = $serializable->description;
                    break;
                case 'mileage':
                    $serialized['mileage_distance'] = $serializable->mileage->distance;
                    $serialized['mileage_unit'] = $serializable->mileage->unit;
                    break;
                case 'price':
                    $serialized['price_amount'] = $serializable->price->amount;
                    $serialized['price_currency'] = $serializable->price->currency;
                    break;
            }
        }

        return $serialized;
    }
}
