<?php

namespace Tests\Unit\Rules;

use App\Repositories\IBrandRepository;
use App\Rules\UniqueBrand;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class UniqueBrandTest extends TestCase
{
    #[DataProvider('brandDataProvider')]
    public function testUniqueBrand(
        string $brandId,
        bool $expected
    ) {
        app()->bind(IBrandRepository::class, function () use ($expected) {
            $brandRepositoryStub = $this->createMock(IBrandRepository::class);
            $brandRepositoryStub->method('isUnique')->willReturn($expected);

            return $brandRepositoryStub;
        });

        /** @var UniqueBrand $uniqueBrand */
        $uniqueBrand = app()->get(UniqueBrand::class);

        $validator = Validator::make(
            ['brand_id' => $brandId],
            ['brand_id' => $uniqueBrand]
        );

        $this->assertEquals($expected, $validator->passes());
    }

    public static function brandDataProvider(): array
    {
        return [
            'unique_brand_should_pass' => [
                Str::uuid()->toString(),
                true,
            ],
            'non_unique_brand_should_fail' => [
                Str::uuid()->toString(),
                false,
            ],
        ];
    }
}
