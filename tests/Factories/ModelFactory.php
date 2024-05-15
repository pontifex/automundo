<?php

namespace Tests\Factories;

use App\Domain\Entities\Brand;
use App\Domain\Entities\Model;
use Illuminate\Support\Str;

class ModelFactory
{
    public static function make(
        ?string $id = null,
        ?Brand $brand = null,
        string $name = 'V50',
        string $slug = 'v50'
    ): Model {
        if (null === $id) {
            $id = Str::uuid()->toString();
        }

        if (null === $brand) {
            $brand = BrandFactory::make();
        }

        return new Model(
            $id,
            $name,
            $slug,
            $brand
        );
    }
}
