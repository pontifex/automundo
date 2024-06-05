<?php

namespace App\Services;

use App\Exceptions\IndexNotExistException;
use Elastic\Elasticsearch\Client;
use Elastic\Elasticsearch\Exception\ClientResponseException;
use Elastic\Elasticsearch\Exception\MissingParameterException;
use Elastic\Elasticsearch\Exception\ServerResponseException;
use Elastic\Elasticsearch\Response\Elasticsearch;
use Elastic\Transport\Exception\NoNodeAvailableException;

readonly class ElasticSearchService
{
    private const INDICES_DIR = 'elasticsearch/indices';

    public function __construct(private Client $client)
    {
    }

    /**
     * @throws ClientResponseException
     * @throws MissingParameterException
     * @throws ServerResponseException
     * @throws NoNodeAvailableException
     * @throws IndexNotExistException
     */
    public function createIndex(string $indexName): void
    {
        $indexFile = sprintf(
            '%s/%s.php',
            self::INDICES_DIR,
            $indexName
        );

        if (! is_readable($indexFile)) {
            throw new IndexNotExistException();
        }

        /**
         * @var array{ index: string } $indexParams
         *
         * @psalm-suppress UnresolvableInclude
         */
        $indexParams = require $indexFile;

        /** @psalm-suppress InvalidArgument */
        $this->client->indices()->create($indexParams);
    }

    /**
     * @throws ClientResponseException
     * @throws MissingParameterException
     * @throws ServerResponseException
     */
    public function deleteIndex(string $indexName): void
    {
        $params = [
            'index' => [$indexName],
        ];

        /**
         * @psalm-suppress InvalidArgument
         *
         * @var Elasticsearch $response
         */
        $response = $this->client->indices()->exists($params);

        if ($response->getStatusCode() === 404) {
            return;
        }

        /** @psalm-suppress InvalidArgument */
        $this->client->indices()->delete($params);
    }
}
