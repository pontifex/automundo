<?php

namespace App\Rules;

use App\Repositories\IModelRepository;
use App\Serializers\ModelSerializer;
use Illuminate\Contracts\Validation\DataAwareRule;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Str;

/**
 * Validates whether a model is unique based on its slug and brand ID.
 *
 * This rule checks if a model with the given slug and brand ID exists in the data source.
 * If the model exist, it fails the validation and provides an error message.
 */
class UniqueModel implements DataAwareRule, ValidationRule
{
    private array $data = [];

    /**
     * @psalm-api
     */
    public function __construct(
        private readonly IModelRepository $modelRepository
    ) {
    }

    public function setData(array $data): void
    {
        $this->data = $data;
    }

    public function validate(
        string $attribute,
        mixed $value,
        \Closure $fail
    ): void {
        /**
         * @psalm-var array{
         *      models: array{
         *          brand_id: string,
         *          name: string
         *      }
         *  }
         *     $data
         */
        $data = $this->data;

        $brandId = $data[ModelSerializer::getType()]['brand_id'] ?? '';

        if (
            ! is_string($value)
            || ! $this->modelRepository->isUnique(Str::slug($value), $brandId)
        ) {
            $fail('Model already exists');
        }
    }
}
