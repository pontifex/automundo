<?php

namespace App\Repositories;

use App\Domain\Entities\Product;
use App\Exceptions\ResourceNotFoundException;
use App\Factories\Entities\ProductFactory;
use App\Serializers\ISerializable;
use App\Serializers\Search\ProductIndexingSerializer;
use App\Serializers\Serialize;
use Elastic\Elasticsearch\Client;
use Elastic\Elasticsearch\Exception\ClientResponseException;
use Elastic\Elasticsearch\Exception\MissingParameterException;
use Elastic\Elasticsearch\Exception\ServerResponseException;
use Elastic\Elasticsearch\Response\Elasticsearch;

readonly class ElasticSearchProductRepository implements IProductRepository
{
    use Serialize;

    public function __construct(
        private Client $client,
        private ProductIndexingSerializer $productIndexingSerializer
    ) {
    }

    /**
     * @throws ClientResponseException
     * @throws MissingParameterException
     * @throws ServerResponseException
     */
    public function addOne(
        Product $product
    ): void {
        /**
         * @var array{
         *     products: array{
         *         index: string,
         *         id: string,
         *         body: array{
         *             description: string,
         *             mileage_distance: int,
         *             mileage_unit: string,
         *             price_amount: int,
         *             price_currency: string,
         *         }
         *     }
         * } $params
         */
        $params = $this->serialize(
            $this->productIndexingSerializer,
            $product,
            []
        );

        /** @psalm-suppress InvalidArgument */
        $this->client->index($params[ProductIndexingSerializer::getType()]);
    }

    /**
     * @throws ResourceNotFoundException
     */
    public function getOneById(string $id): Product
    {
        /** @psalm-var array{
         *      id: string,
         *      index: string
         * } $params
         */
        $params = [
            'index' => 'products',
            'id' => $id,
        ];

        try {
            /** @psalm-suppress InvalidArgument */
            $response = $this->client->getSource($params);
        } catch (\Exception) {
            throw new ResourceNotFoundException();
        }

        /** @psalm-var array{
         *     id: string,
         *     description: string,
         *     mileage_distance: positive-int,
         *     mileage_unit: string,
         *     price_amount: positive-int,
         *     price_currency: string,
         *     model_id: string,
         * } $response
         */
        return ProductFactory::makeProduct(
            $id,
            $response['description'],
            $response['mileage_distance'],
            $response['mileage_unit'],
            $response['price_amount'],
            $response['price_currency'],
        );
    }

    /**
     * @psalm-return array<ISerializable>
     */
    public function list(int $pageNumber, int $pageSize): array
    {
        $products = [];

        $params = [
            'index' => 'products',
            'body' => [
                'query' => [
                    'match_all' => new \stdClass(),
                ],
            ],
            'size' => $pageSize,
            'from' => ($pageNumber - 1) * $pageSize,
        ];

        try {
            /**
             * @psalm-suppress InvalidArgument
             *
             * @var Elasticsearch $response
             */
            $response = $this->client->search($params);
        } catch (ClientResponseException|ServerResponseException) {
            return $products;
        }

        $responseAsArray = $response->asArray();

        /** @psalm-var array{
         *     hits: array{
         *         hits: array{
         *             _id: string,
         *             _source: array{
         *                 description: string,
         *                 mileage_distance: int,
         *                 mileage_unit: string,
         *                 price_amount: int,
         *                 price_currency: string
         *             }
         *         }
         *     []}
         * } $responseAsArray
         */
        foreach ($responseAsArray['hits']['hits'] as $hit) {
            $products[] = ProductFactory::makeProduct(
                $hit['_id'],
                $hit['_source']['description'],
                $hit['_source']['mileage_distance'],
                $hit['_source']['mileage_unit'],
                $hit['_source']['price_amount'],
                $hit['_source']['price_currency'],
            );
        }

        return $products;
    }
}
