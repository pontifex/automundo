<?php

namespace App\Rules;

use App\Serializers\BrandSerializer;
use App\Serializers\ModelSerializer;
use App\Serializers\ProductSerializer;
use Illuminate\Contracts\Validation\ValidationRule;

readonly class ValidElasticSearchIndex implements ValidationRule
{
    public function validate(
        string $attribute,
        mixed $value,
        \Closure $fail
    ): void {
        if (
            ! in_array($value, [
                ProductSerializer::getType(),
                BrandSerializer::getType(),
                ModelSerializer::getType(),
            ],
                true
            )
        ) {
            $fail('Not valid ElasticSearch index');
        }
    }
}
