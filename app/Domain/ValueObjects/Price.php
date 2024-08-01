<?php

namespace App\Domain\ValueObjects;

class Price
{
    public const CURRENCY_EUR = 'EUR';

    public const CURRENCY_USD = 'USD';

    public static array $validCurrencies = [
        self::CURRENCY_EUR,
        self::CURRENCY_USD,
    ];

    public function __construct(
        public readonly int $amount,
        public readonly string $currency
    ) {
        if (! in_array($currency, self::$validCurrencies)) {
            throw new \DomainException('The Price currency is not valid!');
        }

        if ($amount <= 0) {
            throw new \DomainException('The Price amount is not valid!');
        }
    }
}
