<?php

namespace App\Factories\Entities;

use App\Domain\Entities\Brand;
use App\Domain\Entities\Model;
use Illuminate\Support\Str;

class ModelFactory
{
    public static function makeModel(
        string $id,
        string $name,
        ?Brand $brand = null
    ): Model {
        return new Model(
            $id,
            $name,
            Str::slug($name),
            $brand
        );
    }
}
