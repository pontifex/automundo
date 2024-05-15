<?php

namespace Tests\Unit\Rules;

use App\Repositories\IModelRepository;
use App\Rules\UniqueBrand;
use App\Rules\UniqueModel;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class UniqueModelTest extends TestCase
{
    #[DataProvider('modelDataProvider')]
    public function testUniqueModel(
        string $brandId,
        string $slug,
        bool $expected
    ) {
        app()->bind(IModelRepository::class, function () use ($expected) {
            $modelRepositoryStub = $this->createMock(IModelRepository::class);
            $modelRepositoryStub->method('isUnique')->willReturn($expected);

            return $modelRepositoryStub;
        });

        /** @var UniqueBrand $uniqueModel */
        $uniqueModel = app()->get(UniqueModel::class);

        $validator = Validator::make(
            ['brand_id' => $brandId, 'name' => $slug],
            ['name' => $uniqueModel]
        );

        $this->assertEquals($expected, $validator->passes());
    }

    public static function modelDataProvider(): array
    {
        return [
            'unique_model_should_pass' =>
                [
                    Str::uuid()->toString(),
                    'A4',
                    true
                ],
            'non_unique_model_should_fail' =>
                [
                    Str::uuid()->toString(),
                    'V50',
                    false
                ],
        ];
    }
}
