<?php

namespace Tests\Factories;

use App\Domain\Entities\Brand;
use Illuminate\Support\Str;

class BrandFactory
{
    public static function make(
        ?string $id = null,
        string $name = 'Volvo',
        string $slug = 'volvo'
    ): Brand {
        if (null === $id) {
            $id = Str::uuid()->toString();
        }

        return new Brand(
            $id,
            $name,
            $slug
        );
    }
}
