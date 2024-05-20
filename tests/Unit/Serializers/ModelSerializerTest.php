<?php

namespace Tests\Unit\Serializers;

use App\Domain\Entities\Model;
use App\Exceptions\WrongTypeException;
use App\Serializers\ISerializable;
use App\Serializers\ModelSerializer;
use Illuminate\Support\Str;
use Tests\Factories\BrandFactory;
use Tests\Factories\ModelFactory;
use Tests\TestCase;

class ModelSerializerTest extends TestCase
{
    private ModelSerializer $serializer;

    protected function setUp(): void
    {
        parent::setUp();

        $this->serializer = new ModelSerializer();
    }

    public function testGetType()
    {
        $this->assertSame('models', ModelSerializer::getType());
    }

    public function testSerializeThrowsExceptionOnWrongType()
    {
        $this->expectException(WrongTypeException::class);

        $wrongType = $this->createMock(ISerializable::class);

        $this->serializer->serialize($wrongType, Model::getAllowedFields());
    }

    public function testSerializeIdField()
    {
        $id = Str::uuid()->toString();
        $model = ModelFactory::make($id);

        $fields = [ModelSerializer::getType() => ['id']];
        $result = $this->serializer->serialize($model, $fields);

        $this->assertEquals(['id' => $id], $result);
    }

    public function testSerializeNameField()
    {
        $id = Str::uuid()->toString();
        $name = 'A4';
        $model = ModelFactory::make($id, BrandFactory::make(), $name);

        $fields = [ModelSerializer::getType() => ['name']];
        $result = $this->serializer->serialize($model, $fields);

        $this->assertEquals(['name' => 'A4'], $result);
    }

    public function testSerializeSlugField()
    {
        $id = Str::uuid()->toString();
        $name = 'A4';
        $slug = 'a4';
        $model = ModelFactory::make($id, BrandFactory::make(), $name, $slug);

        $fields = [ModelSerializer::getType() => ['slug']];
        $result = $this->serializer->serialize($model, $fields);

        $this->assertEquals(['slug' => $slug], $result);
    }

    public function testSerializeMultipleFields()
    {
        $id = Str::uuid()->toString();
        $name = 'A4';
        $slug = 'a4';
        $model = ModelFactory::make($id, BrandFactory::make(), $name, $slug);

        $fields = [ModelSerializer::getType() => ['id', 'name', 'slug']];
        $result = $this->serializer->serialize($model, $fields);

        $this->assertEquals(
            [
                'id' => $id,
                'name' => $name,
                'slug' => $slug,
            ],
            $result
        );
    }
}
