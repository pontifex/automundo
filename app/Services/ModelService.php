<?php

namespace App\Services;

use App\Domain\Entities\Model;
use App\Exceptions\ResourceNotFoundException;
use App\Factories\Entities\ModelFactory;
use App\Repositories\IBrandRepository;
use App\Repositories\IModelRepository;

readonly class ModelService
{
    /**
     * @psalm-api
     */
    public function __construct(
        private IModelRepository $modelRepository,
        private IBrandRepository $brandRepository
    ) {
    }

    /**
     * @throws ResourceNotFoundException
     */
    public function addOne(
        string $id,
        string $name,
        string $brandId
    ): Model {
        $brand = $this->brandRepository->getOneById(
            $brandId
        );

        $model = ModelFactory::makeModel($id, $name, $brand);

        $this->modelRepository->addOne(
            $model
        );

        return $model;
    }
}
