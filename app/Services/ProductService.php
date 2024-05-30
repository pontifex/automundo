<?php

namespace App\Services;

use App\Domain\Entities\Product;
use App\Exceptions\ResourceNotFoundException;
use App\Factories\Entities\ProductFactory;
use App\Repositories\IModelRepository;
use App\Repositories\IProductRepository;
use App\Serializers\ISerializable;

readonly class ProductService
{
    /**
     * @psalm-api
     */
    public function __construct(
        private IProductRepository $productRepository,
        private IModelRepository $modelRepository
    ) {
    }

    /**
     * @throws ResourceNotFoundException
     */
    public function addOne(
        string $id,
        string $description,
        int $mileageDistance,
        string $mileageUnit,
        int $priceAmount,
        string $priceCurrency,
        string $modelId
    ): Product {
        $model = $this->modelRepository->getOneById($modelId);

        $product = ProductFactory::makeProduct(
            $id,
            $description,
            $mileageDistance,
            $mileageUnit,
            $priceAmount,
            $priceCurrency,
            $model
        );

        $this->productRepository->addOne(
            $product
        );

        return $product;
    }

    /**
     * @throws ResourceNotFoundException
     */
    public function getOneById(
        string $id
    ): Product {
        return $this->productRepository->getOneById($id);
    }

    /**
     * @psalm-return array<ISerializable>
     */
    public function list(int $pageNumber, int $pageSize): array
    {
        return $this->productRepository->list(
            $pageNumber,
            $pageSize
        );
    }
}
