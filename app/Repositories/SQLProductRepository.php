<?php

namespace App\Repositories;

use App\Domain\Entities\Product;
use App\Exceptions\ResourceNotFoundException;
use App\Factories\Entities\ProductFactory;
use App\Factories\Models\ProductFactory as ProductORMFactory;
use App\Models\Product as ProductORM;
use App\Serializers\ISerializable;

class SQLProductRepository implements IProductRepository
{
    public function addOne(
        Product $product
    ): void {
        $productORM = ProductORMFactory::makeProduct(
            $product->getId(),
            $product->description,
            $product->mileage,
            $product->price,
            $product->model?->getId() ?? ''
        );

        $productORM->save();
    }

    /**
     * @throws ResourceNotFoundException
     */
    public function getOneById(string $id): Product
    {
        $productORM = ProductORM::find($id);

        if ($productORM === null) {
            throw new ResourceNotFoundException();
        }

        return ProductFactory::makeProduct(
            $productORM->id,
            $productORM->description,
            $productORM->mileageDistance,
            $productORM->mileageUnit,
            $productORM->priceAmount,
            $productORM->priceCurrency
        );
    }

    /**
     * @psalm-return array<ISerializable>
     */
    public function list(int $pageNumber, int $pageSize): array
    {
        $offset = ($pageNumber - 1) * $pageSize;

        $collection = ProductORM::offset($offset)
            ->limit($pageSize)
            ->get();

        $products = [];
        /** @psalm-var array{
         *     id: string,
         *     description: string,
         *     mileageDistance: positive-int,
         *     mileageUnit: string,
         *     priceAmount: positive-int,
         *     priceCurrency: string,
         *     modelId: string,
         * } $item
         */
        foreach ($collection->toArray() as $item) {
            $products[] = ProductFactory::makeProduct(
                $item['id'],
                $item['description'],
                $item['mileageDistance'],
                $item['mileageUnit'],
                $item['priceAmount'],
                $item['priceCurrency']
            );
        }

        return $products;
    }
}
