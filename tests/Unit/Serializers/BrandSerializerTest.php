<?php

namespace Tests\Unit\Serializers;

use App\Domain\Entities\Brand;
use App\Exceptions\WrongTypeException;
use App\Serializers\BrandSerializer;
use App\Serializers\ISerializable;
use Illuminate\Support\Str;
use Tests\Factories\BrandFactory;
use Tests\TestCase;

class BrandSerializerTest extends TestCase
{
    private BrandSerializer $serializer;

    protected function setUp(): void
    {
        parent::setUp();

        $this->serializer = new BrandSerializer();
    }

    public function testGetType()
    {
        $this->assertSame('brands', BrandSerializer::getType());
    }

    public function testSerializeThrowsExceptionOnWrongType()
    {
        $this->expectException(WrongTypeException::class);

        $wrongType = $this->createMock(ISerializable::class);

        $this->serializer->serialize($wrongType, Brand::getAllowedFields());
    }

    public function testSerializeIdField()
    {
        $id = Str::uuid()->toString();
        $brand = BrandFactory::make($id);

        $fields = [BrandSerializer::getType() => ['id']];
        $result = $this->serializer->serialize($brand, $fields);

        $this->assertEquals(['id' => $id], $result);
    }

    public function testSerializeNameField()
    {
        $id = Str::uuid()->toString();
        $name = 'Lexus';
        $brand = BrandFactory::make($id, $name);

        $fields = [BrandSerializer::getType() => ['name']];
        $result = $this->serializer->serialize($brand, $fields);

        $this->assertEquals(['name' => 'LEXUS'], $result);
    }

    public function testSerializeSlugField()
    {
        $id = Str::uuid()->toString();
        $name = 'Lexus';
        $slug = 'lexus';
        $brand = BrandFactory::make($id, $name, $slug);

        $fields = [BrandSerializer::getType() => ['slug']];
        $result = $this->serializer->serialize($brand, $fields);

        $this->assertEquals(['slug' => $slug], $result);
    }

    public function testSerializeMultipleFields()
    {
        $id = Str::uuid()->toString();
        $name = 'Lexus';
        $slug = 'lexus';
        $brand = BrandFactory::make($id, $name, $slug);

        $fields = [BrandSerializer::getType() => ['id', 'name', 'slug']];
        $result = $this->serializer->serialize($brand, $fields);

        $this->assertEquals(
            [
                'id' => $id,
                'name' => 'LEXUS',
                'slug' => $slug,
            ],
            $result
        );
    }
}
