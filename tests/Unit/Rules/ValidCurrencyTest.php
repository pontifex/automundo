<?php

namespace Tests\Unit\Rules;

use App\Domain\ValueObjects\Price;
use App\Rules\ValidCurrency;
use Illuminate\Support\Facades\Validator;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class ValidCurrencyTest extends TestCase
{
    #[DataProvider('currencyDataProvider')]
    public function testValidCurrency(
        string $currency,
        bool $expected
    )
    {
        /** @var ValidCurrency $validCurrency */
        $validCurrency = app()->get(ValidCurrency::class);

        $validator = Validator::make(
            ['price_currency' => $currency],
            ['price_currency' => $validCurrency],
        );

        $this->assertEquals($expected, $validator->passes());
    }

    public static function currencyDataProvider(): array
    {
        return [
            'valid_currency_should_pass' => [
                Price::CURRENCY_EUR,
                true,
            ],
            'non_valid_currency_should_fail' => [
                'PLN',
                false,
            ],
        ];
    }
}
