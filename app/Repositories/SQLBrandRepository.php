<?php

namespace App\Repositories;

use App\Domain\Entities\Brand;
use App\Exceptions\ResourceNotFoundException;
use App\Factories\Entities\BrandFactory;
use App\Factories\Models\BrandFactory as BrandORMFactory;
use App\Models\Brand as BrandORM;
use App\Serializers\ISerializable;

class SQLBrandRepository implements IBrandRepository
{
    public function addOne(
        Brand $brand
    ): void {
        $brandORM = BrandORMFactory::makeBrand(
            $brand->getId(),
            $brand->getName(),
            $brand->getSlug()
        );

        $brandORM->save();
    }

    /**
     * @throws ResourceNotFoundException
     */
    public function getOneById(string $id): Brand
    {
        $brandORM = BrandORM::find($id);

        if ($brandORM === null) {
            throw new ResourceNotFoundException();
        }

        return BrandFactory::makeBrand(
            $brandORM->id,
            $brandORM->name
        );
    }

    /**
     * @psalm-return array<ISerializable>
     */
    public function list(int $pageNumber, int $pageSize): array
    {
        $offset = ($pageNumber - 1) * $pageSize;

        $collection = BrandORM::offset($offset)
            ->limit($pageSize)
            ->get();

        $brands = [];
        /** @psalm-var array{id: string, name: string, slug: string} $item */
        foreach ($collection->toArray() as $item) {
            $brands[] = new Brand(
                $item['id'],
                $item['name'],
                $item['slug'],
            );
        }

        return $brands;
    }

    public function isUnique(string $slug): bool
    {
        $existingBrand = BrandORM::where('slug', $slug)->exists();

        return ! $existingBrand;
    }
}
