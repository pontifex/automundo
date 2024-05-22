<?php

namespace App\Services;

use App\Domain\Entities\Brand;
use App\Exceptions\ResourceNotFoundException;
use App\Factories\Entities\BrandFactory;
use App\Repositories\IBrandRepository;

readonly class BrandService
{
    /**
     * @psalm-api
     */
    public function __construct(
        private IBrandRepository $brandRepository
    ) {
    }

    public function addOne(
        string $id,
        string $name
    ): Brand {
        $brand = BrandFactory::makeBrand($id, $name);

        $this->brandRepository->addOne(
            $brand
        );

        return $brand;
    }

    /**
     * @throws ResourceNotFoundException
     */
    public function getOneById(
        string $id
    ): Brand {
        return $this->brandRepository->getOneById($id);
    }

    public function list(int $pageNumber, int $pageSize): array
    {
        return $this->brandRepository->list(
            $pageNumber,
            $pageSize
        );
    }
}
