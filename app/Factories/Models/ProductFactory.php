<?php

namespace App\Factories\Models;

use App\Domain\ValueObjects\Mileage;
use App\Domain\ValueObjects\Price;
use App\Models\Product as ProductORM;

class ProductFactory
{
    public static function makeProduct(
        string $id,
        string $description,
        Mileage $mileage,
        Price $price,
        string $modelId
    ): ProductORM {
        $model = new ProductORM();

        $model->id = $id;
        $model->description = $description;
        $model->mileageDistance = $mileage->getDistance();
        $model->mileageUnit = $mileage->getUnit();
        $model->priceAmount = $price->getAmount();
        $model->priceCurrency = $price->getCurrency();
        $model->model_id = $modelId;

        return $model;
    }
}
