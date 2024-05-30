<?php

namespace Tests\Unit\Rules;

use App\Exceptions\ResourceNotFoundException;
use App\Repositories\IModelRepository;
use App\Rules\ExistingModel;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Tests\Factories\ModelFactory;
use Tests\TestCase;

class ExistingModelTest extends TestCase
{
    public function testWithExistingModelShouldFail()
    {
        app()->bind(IModelRepository::class, function () {
            $modelRepositoryMock = $this->createMock(IModelRepository::class);
            $modelRepositoryMock->method('getOneById')->willThrowException(
                new ResourceNotFoundException()
            );

            return $modelRepositoryMock;
        });

        /** @var ExistingModel $existingModel */
        $existingModel = app()->get(ExistingModel::class);

        $validator = Validator::make(
            ['model_id' => Str::uuid()->toString()],
            ['model_id' => $existingModel]
        );

        $this->assertTrue($validator->fails());
    }

    public function testWithNotExistingModelShouldPass()
    {
        app()->bind(IModelRepository::class, function () {
            $modelId = Str::uuid()->toString();
            $model = ModelFactory::make($modelId);

            $modelRepositoryStub = $this->createMock(IModelRepository::class);
            $modelRepositoryStub->method('getOneById')->willReturn($model);

            return $modelRepositoryStub;
        });

        /** @var ExistingModel $existingModel */
        $existingModel = app()->get(ExistingModel::class);

        $validator = Validator::make(
            ['model_id' => Str::uuid()->toString()],
            ['model_id' => $existingModel]
        );

        $this->assertTrue($validator->passes());
    }
}
