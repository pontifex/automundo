<?php

namespace Tests\Factories;

use App\Domain\Entities\Model;
use App\Domain\Entities\Product;
use App\Domain\ValueObjects\Mileage;
use App\Domain\ValueObjects\Price;
use Illuminate\Support\Str;

class ProductFactory
{
    public static function make(
        ?string $id = null,
        ?Model $model = null,
        string $description = 'Some description here',
        string $mileageUnit = Mileage::UNIT_KILOMETERS,
        int $mileageDistance = 1,
        string $priceCurrency = Price::CURRENCY_EUR,
        int $priceAmount = 1
    ): Product {
        if ($id === null) {
            $id = Str::uuid()->toString();
        }

        if ($model === null) {
            $model = ModelFactory::make();
        }

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
