<?php

namespace App\Events;

use App\Domain\Entities\Product;
use Illuminate\Foundation\Events\Dispatchable;

readonly class ProductAdded
{
    use Dispatchable;

    /**
     * @psalm-api
     */
    public function __construct(
        public Product $product
    ) {
    }
}
