<?php

namespace App\Rules;

use App\Domain\ValueObjects\Mileage;
use Illuminate\Contracts\Validation\ValidationRule;

readonly class ValidMileageUnit implements ValidationRule
{
    public function validate(
        string $attribute,
        mixed $value,
        \Closure $fail
    ): void {
        if (! in_array($value, Mileage::$validUnits)) {
            $fail('Not valid mileage unit');
        }
    }
}
