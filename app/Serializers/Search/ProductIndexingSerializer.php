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
                'description' => $serializable->getDescription(),
                'mileage_distance' => $serializable->getMileage()->getDistance(),
                'mileage_unit' => $serializable->getMileage()->getUnit(),
                'price_amount' => $serializable->getPrice()->getAmount(),
                'price_currency' => $serializable->getPrice()->getCurrency(),
            ],
        ];
    }
}
