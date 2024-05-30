<?php

namespace Tests\Unit\Serializers;

use App\Domain\Entities\Product;
use App\Domain\ValueObjects\Mileage;
use App\Domain\ValueObjects\Price;
use App\Exceptions\WrongTypeException;
use App\Serializers\ISerializable;
use App\Serializers\ProductSerializer;
use Illuminate\Support\Str;
use Tests\Factories\ModelFactory;
use Tests\Factories\ProductFactory;
use Tests\TestCase;

class ProductSerializerTest extends TestCase
{
    private ProductSerializer $serializer;

    protected function setUp(): void
    {
        parent::setUp();

        $this->serializer = new ProductSerializer();
    }

    public function testGetType()
    {
        $this->assertSame('products', ProductSerializer::getType());
    }

    public function testSerializeThrowsExceptionOnWrongType()
    {
        $this->expectException(WrongTypeException::class);

        $wrongType = $this->createMock(ISerializable::class);

        $this->serializer->serialize($wrongType, Product::getAllowedFields());
    }

    public function testSerializeIdField()
    {
        $id = Str::uuid()->toString();
        $product = ProductFactory::make($id);

        $fields = [ProductSerializer::getType() => ['id']];
        $result = $this->serializer->serialize($product, $fields);

        $this->assertEquals(['id' => $id], $result);
    }

    public function testSerializeDescriptionField()
    {
        $id = Str::uuid()->toString();
        $description = 'I wanna sell my super car!';
        $product = ProductFactory::make($id, ModelFactory::make(), $description);

        $fields = [ProductSerializer::getType() => ['description']];
        $result = $this->serializer->serialize($product, $fields);

        $this->assertEquals(
            ['description' => 'I wanna sell my super car!'],
            $result
        );
    }

    public function testSerializeMileageField()
    {
        $id = Str::uuid()->toString();
        $description = 'I wanna sell my super car!';

        $mileageUnit = Mileage::UNIT_MILES;
        $mileageDistance = 149000;

        $product = ProductFactory::make(
            $id,
            ModelFactory::make(),
            $description,
            $mileageUnit,
            $mileageDistance
        );

        $fields = [ProductSerializer::getType() => ['mileage']];
        $result = $this->serializer->serialize($product, $fields);

        $this->assertEquals(
            [
                'mileage_distance' => $mileageDistance,
                'mileage_unit' => $mileageUnit,
            ],
            $result
        );
    }

    public function testSerializePriceField()
    {
        $id = Str::uuid()->toString();
        $description = 'I wanna sell my super car!';

        $mileageUnit = Mileage::UNIT_MILES;
        $mileageDistance = 149000;

        $priceAmount = 9999;
        $priceCurrency = Price::CURRENCY_USD;

        $product = ProductFactory::make(
            $id,
            ModelFactory::make(),
            $description,
            $mileageUnit,
            $mileageDistance,
            $priceCurrency,
            $priceAmount
        );

        $fields = [ProductSerializer::getType() => ['price']];
        $result = $this->serializer->serialize($product, $fields);

        $this->assertEquals(
            [
                'price_amount' => $priceAmount,
                'price_currency' => $priceCurrency,
            ],
            $result
        );
    }

    public function testSerializeMultipleFields()
    {
        $id = Str::uuid()->toString();
        $description = 'I wanna sell my super car!';

        $mileageUnit = Mileage::UNIT_MILES;
        $mileageDistance = 149000;

        $priceAmount = 9999;
        $priceCurrency = Price::CURRENCY_USD;

        $product = ProductFactory::make(
            $id,
            ModelFactory::make(),
            $description,
            $mileageUnit,
            $mileageDistance,
            $priceCurrency,
            $priceAmount
        );

        $fields = [
            ProductSerializer::getType() => [
                'id',
                'description',
                'mileage',
                'price',
            ]
        ];
        $result = $this->serializer->serialize($product, $fields);

        $this->assertEquals(
            [
                'id' => $id,
                'description' => 'I wanna sell my super car!',
                'mileage_distance' => $mileageDistance,
                'mileage_unit' => $mileageUnit,
                'price_amount' => $priceAmount,
                'price_currency' => $priceCurrency,
            ],
            $result
        );
    }
}
