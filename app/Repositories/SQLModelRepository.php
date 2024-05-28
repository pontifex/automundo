<?php

namespace App\Repositories;

use App\Domain\Entities\Model;
use App\Exceptions\ResourceNotFoundException;
use App\Factories\Entities\ModelFactory;
use App\Factories\Models\ModelFactory as ModelORMFactory;
use App\Models\Model as ModelORM;

class SQLModelRepository implements IModelRepository
{
    public function addOne(
        Model $model
    ): void {
        $modelORM = ModelORMFactory::makeModel(
            $model->getId(),
            $model->getName(),
            $model->getSlug(),
            $model->getBrand()?->getId() ?? ''
        );

        $modelORM->save();
    }

    /**
     * @throws ResourceNotFoundException
     */
    public function getOneById(string $id): Model
    {
        $modelORM = ModelORM::find($id);

        if ($modelORM === null) {
            throw new ResourceNotFoundException();
        }

        return ModelFactory::makeModel(
            $modelORM->id,
            $modelORM->name
        );
    }

    public function list(int $pageNumber, int $pageSize): array
    {
        $offset = ($pageNumber - 1) * $pageSize;

        $collection = ModelORM::offset($offset)
            ->limit($pageSize)
            ->get();

        $models = [];
        /** @psalm-var array{id: string, name: string, slug: string} $item */
        foreach ($collection->toArray() as $item) {
            $models[] = new Model(
                $item['id'],
                $item['name'],
                $item['slug'],
            );
        }

        return $models;
    }

    public function isUnique(string $slug, string $brandId): bool
    {
        $existingModel = ModelORM::where('slug', $slug)
            ->where('brand_id', $brandId)
            ->exists();

        return ! $existingModel;
    }
}
