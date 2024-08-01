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
        public Brand $brand
    ) {
    }
}
