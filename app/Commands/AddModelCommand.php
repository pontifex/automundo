<?php

namespace App\Commands;

readonly class AddModelCommand
{
    public function __construct(
        public string $id,
        public string $name,
        public string $brandId
    ) {
    }
}
