<?php

namespace App\Repositories;

use App\Domain\Entities\Model;
use App\Exceptions\ResourceNotFoundException;

interface IModelRepository
{
    public function addOne(
        Model $model
    ): void;

    /**
     * @throws ResourceNotFoundException
     */
    public function getOneById(
        string $id
    ): Model;

    public function list(int $pageNumber, int $pageSize): array;

    public function isUnique(string $slug, string $brandId): bool;
}
