<?php

namespace App\Repositories;

use App\Domain\Entities\Brand;
use App\Exceptions\ResourceNotFoundException;

interface IBrandRepository
{
    public function addOne(
        Brand $brand
    ): void;

    /**
     * @throws ResourceNotFoundException
     */
    public function getOneById(
        string $id
    ): Brand;

    public function list(int $pageNumber, int $pageSize): array;

    public function isUnique(string $slug): bool;
}
