<?php

namespace App\Factories\Entities;

use App\Domain\Entities\Brand;
use Illuminate\Support\Str;

class BrandFactory
{
    public static function makeBrand(
        string $id,
        string $name
    ): Brand {
        return new Brand(
            $id,
            $name,
            Str::slug($name)
        );
    }
}
