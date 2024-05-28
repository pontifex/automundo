<?php

namespace App\Events;

use App\Domain\Entities\Brand;
use Illuminate\Foundation\Events\Dispatchable;

readonly class BrandAdded
{
    use Dispatchable;

    /**
     * @psalm-api
     */
    public function __construct(
        private Brand $brand
    ) {
    }

    public function getBrand(): Brand
    {
        return $this->brand;
    }
}
