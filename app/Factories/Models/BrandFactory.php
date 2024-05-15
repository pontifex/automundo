<?php

namespace App\Factories\Models;

use App\Models\Brand as BrandORM;

class BrandFactory
{
    public static function makeBrand(
        string $id,
        string $name,
        string $slug
    ): BrandORM {
        $brandORM = new BrandORM();

        $brandORM->id = $id;
        $brandORM->name = $name;
        $brandORM->slug = $slug;

        return $brandORM;
    }
}
