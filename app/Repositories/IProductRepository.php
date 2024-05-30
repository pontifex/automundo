<?php

namespace App\Repositories;

use App\Domain\Entities\Product;
use App\Exceptions\ResourceNotFoundException;
use App\Serializers\ISerializable;

interface IProductRepository
{
    public function addOne(
        Product $product
    ): void;

    /**
     * @throws ResourceNotFoundException
     */
    public function getOneById(
        string $id
    ): Product;

    /**
     * @psalm-return array<ISerializable>
     */
    public function list(int $pageNumber, int $pageSize): array;
}
