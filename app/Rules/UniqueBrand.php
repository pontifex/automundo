<?php

namespace App\Rules;

use App\Repositories\IBrandRepository;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Str;

/**
 * Validates whether a brand is unique based on its slug.
 *
 * This rule checks if a brand with the given slug exists in the data source.
 * If the brand exist, it fails the validation and provides an error message.
 */
readonly class UniqueBrand implements ValidationRule
{
    public function __construct(
        private IBrandRepository $brandRepository
    ) {
    }

    public function validate(
        string $attribute,
        mixed $value,
        \Closure $fail
    ): void {
        if (! $this->brandRepository->isUnique(Str::slug($value))) {
            $fail('Brand already exists');
        }
    }
}
