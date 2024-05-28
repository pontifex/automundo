<?php

namespace App\Rules;

use App\Exceptions\ResourceNotFoundException;
use App\Repositories\IBrandRepository;
use Illuminate\Contracts\Validation\ValidationRule;

/**
 * Validates whether a brand exists based on its ID.
 *
 * This rule checks if a brand with the given ID exists in the data source.
 * If the brand does not exist, it fails the validation and provides an error message.
 */
readonly class ExistingBrand implements ValidationRule
{
    /**
     * @psalm-api
     */
    public function __construct(
        private IBrandRepository $brandRepository
    ) {
    }

    public function validate(
        string $attribute,
        mixed $value,
        \Closure $fail
    ): void {
        if (! is_string($value)) {
            $fail('Brand not exist');
            return;
        }

        try {
            $this->brandRepository->getOneById($value);
        } catch (ResourceNotFoundException) {
            $fail('Brand not exist');
        }
    }
}
