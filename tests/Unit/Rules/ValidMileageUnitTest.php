<?php

namespace Tests\Unit\Rules;

use App\Domain\ValueObjects\Mileage;
use App\Rules\ValidMileageUnit;
use Illuminate\Support\Facades\Validator;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class ValidMileageUnitTest extends TestCase
{
    #[DataProvider('mileageUnitDataProvider')]
    public function testValidMileageUnit(
        string $mileageUnit,
        bool $expected
    )
    {
        /** @var ValidMileageUnit $validMileageUnit */
        $validMileageUnit = app()->get(ValidMileageUnit::class);

        $validator = Validator::make(
            ['mileage_unit' => $mileageUnit],
            ['mileage_unit' => $validMileageUnit],
        );

        $this->assertEquals($expected, $validator->passes());
    }

    public static function mileageUnitDataProvider(): array
    {
        return [
            'valid_mileage_unit_should_pass' => [
                Mileage::UNIT_KILOMETERS,
                true,
            ],
            'non_valid_mileage_unit_should_fail' => [
                'm', // meters
                false,
            ],
        ];
    }
}
