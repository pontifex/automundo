<?php

namespace App\Rules;

use App\Domain\ValueObjects\Price;
use Illuminate\Contracts\Validation\ValidationRule;

readonly class ValidCurrency implements ValidationRule
{
    public function validate(
        string $attribute,
        mixed $value,
        \Closure $fail
    ): void {
        if (! in_array($value, Price::$validCurrencies)) {
            $fail('Not valid currency');
        }
    }
}
