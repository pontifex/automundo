<?php

namespace App\Rules;

use App\Exceptions\ResourceNotFoundException;
use App\Repositories\IModelRepository;
use Illuminate\Contracts\Validation\ValidationRule;

/**
 * Validates whether a model exists based on its ID.
 *
 * This rule checks if a model with the given ID exists in the data source.
 * If the model does not exist, it fails the validation and provides an error message.
 */
readonly class ExistingModel implements ValidationRule
{
    /**
     * @psalm-api
     */
    public function __construct(
        private IModelRepository $modelRepository
    ) {
    }

    public function validate(
        string $attribute,
        mixed $value,
        \Closure $fail
    ): void {
        if (! is_string($value)) {
            $fail('Model not exist');

            return;
        }

        try {
            $this->modelRepository->getOneById($value);
        } catch (ResourceNotFoundException) {
            $fail('Model not exist');
        }
    }
}
