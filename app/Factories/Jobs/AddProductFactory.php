<?php

namespace App\Factories\Jobs;

use App\Commands\AddProductCommand;
use App\Http\Requests\AddProduct as AddProductRequest;
use App\Jobs\AddProduct;
use App\Serializers\ProductSerializer;

class AddProductFactory
{
    public static function makeAddProduct(
        string $id,
        AddProductRequest $request
    ): AddProduct {
        /** @psalm-var array{
         *     description: string,
         *     mileage_distance: positive-int,
         *     mileage_unit: string,
         *     price_amount: positive-int,
         *     price_currency: string,
         *     model_id: string,
         * } $productData
         */
        $productData = $request->get(ProductSerializer::getType());

        $command = new AddProductCommand(
            $id,
            $productData['description'],
            $productData['mileage_distance'],
            $productData['mileage_unit'],
            $productData['price_amount'],
            $productData['price_currency'],
            $productData['model_id']
        );

        return new AddProduct($command);
    }
}
