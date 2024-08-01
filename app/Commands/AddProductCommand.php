<?php

namespace App\Commands;

readonly class AddProductCommand
{
    public function __construct(
        public string $id,
        public string $description,
        public int $mileageDistance,
        public string $mileageUnit,
        public int $priceAmount,
        public string $priceCurrency,
        public string $modelId
    ) {
    }
}
