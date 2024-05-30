<?php

namespace App\Factories\Entities;

use App\Domain\Entities\Model;
use App\Domain\Entities\Product;
use App\Domain\ValueObjects\Mileage;
use App\Domain\ValueObjects\Price;

class ProductFactory
{
    public static function makeProduct(
        string $id,
        string $description,
        int $mileageDistance,
        string $mileageUnit,
        int $priceAmount,
        string $priceCurrency,
        ?Model $model = null
    ): Product {
        $mileage = new Mileage(
            $mileageDistance,
            $mileageUnit
        );

        $price = new Price(
            $priceAmount,
            $priceCurrency
        );

        return new Product(
            $id,
            $description,
            $mileage,
            $price,
            $model
        );
    }
}
