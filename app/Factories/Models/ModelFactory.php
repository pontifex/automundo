<?php

namespace App\Factories\Models;

use App\Models\Model as ModelORM;

class ModelFactory
{
    public static function makeModel(
        string $id,
        string $name,
        string $slug,
        string $brandId
    ): ModelORM {
        $model = new ModelORM();

        $model->id = $id;
        $model->name = $name;
        $model->slug = $slug;
        $model->brand_id = $brandId;

        return $model;
    }
}
