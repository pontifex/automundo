<?php

namespace App\Commands;

readonly class AddBrandCommand
{
    public function __construct(
        public string $id,
        public string $name
    ) {
    }
}
