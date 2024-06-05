<?php

namespace Tests\Unit\Rules;

use App\Rules\ValidElasticSearchIndex;
use App\Serializers\ProductSerializer;
use Illuminate\Support\Facades\Validator;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class ValidElasticSearchIndexTest extends TestCase
{
    #[DataProvider('indexDataProvider')]
    public function testValidCurrency(
        string $indexName,
        bool $expected
    ) {
        /** @var ValidElasticSearchIndex $validElasticSearchIndex */
        $validElasticSearchIndex = app()->get(ValidElasticSearchIndex::class);

        $validator = Validator::make(
            ['index_name' => $indexName],
            ['index_name' => $validElasticSearchIndex],
        );

        $this->assertEquals($expected, $validator->passes());
    }

    public static function indexDataProvider(): array
    {
        return [
            'valid_index_should_pass' => [
                ProductSerializer::getType(),
                true,
            ],
            'non_valid_index_should_fail' => [
                'not-existing-index',
                false,
            ],
        ];
    }
}
