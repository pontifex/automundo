<?php

namespace Tests\Unit\Rules;

use App\Exceptions\ResourceNotFoundException;
use App\Repositories\IBrandRepository;
use App\Rules\ExistingBrand;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Tests\Factories\BrandFactory;
use Tests\TestCase;

class ExistingBrandTest extends TestCase
{
    public function testWithExistingBrandShouldFail()
    {
        app()->bind(IBrandRepository::class, function () {
            $brandRepositoryMock = $this->createMock(IBrandRepository::class);
            $brandRepositoryMock->method('getOneById')->willThrowException(
                new ResourceNotFoundException()
            );

            return $brandRepositoryMock;
        });

        /** @var ExistingBrand $existingBrand */
        $existingBrand = app()->get(ExistingBrand::class);

        $validator = Validator::make(
            ['brand_id' => Str::uuid()->toString()],
            ['brand_id' => $existingBrand]
        );

        $this->assertTrue($validator->fails());
    }

    public function testWithNotExistingBrandShouldPass()
    {
        app()->bind(IBrandRepository::class, function () {
            $brandId = Str::uuid()->toString();
            $brand = BrandFactory::make($brandId);

            $brandRepositoryStub = $this->createMock(IBrandRepository::class);
            $brandRepositoryStub->method('getOneById')->willReturn($brand);

            return $brandRepositoryStub;
        });

        /** @var ExistingBrand $existingBrand */
        $existingBrand = app()->get(ExistingBrand::class);

        $validator = Validator::make(
            ['brand_id' => Str::uuid()->toString()],
            ['brand_id' => $existingBrand]
        );

        $this->assertTrue($validator->passes());
    }
}
