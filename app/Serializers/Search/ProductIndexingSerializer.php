<?php

namespace App\Serializers\Search;

use App\Domain\Entities\Product;
use App\Exceptions\WrongTypeException;
use App\Serializers\ISerializable;
use App\Serializers\ISerializer;

class ProductIndexingSerializer implements ISerializer
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
                \sprintf(
                    'Wrong type provided %s but expected %s',
                    $serializable::class,
                    Product::class
                )
            );
        }

        return [
            'index' => self::TYPE,
            'id' => $serializable->getId(),
            'body' => [
                'description' => $serializable->description,
                'mileage_distance' => $serializable->mileage->distance,
                'mileage_unit' => $serializable->mileage->unit,
                'price_amount' => $serializable->price->amount,
                'price_currency' => $serializable->price->currency,
            ],
        ];
    }
}
