<?php

namespace App\Console\Commands;

use App\Rules\ValidElasticSearchIndex;
use App\Services\ElasticSearchService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Validator;

/**
 * @psalm-suppress PropertyNotSetInConstructor
 */
class ElasticSearchIndexRecreate extends Command
{
    protected $signature = 'elasticsearch:index:recreate {index_name}';

    protected $description = 'Recreate Elastic Search index';

    public function __construct(
        private readonly ElasticSearchService $elasticSearchService,
        private readonly ValidElasticSearchIndex $validElasticSearchIndex
    ) {
        parent::__construct();
    }

    public function handle(): void
    {
        $indexName = $this->argument('index_name');

        $validator = Validator::make(
            ['index_name' => $indexName],
            ['index_name' => $this->validElasticSearchIndex],
        );

        if ($validator->fails()) {
            $this->error('Index does not exist');

            return;
        }

        /** @var string $indexName */
        try {
            $this->elasticSearchService->deleteIndex($indexName);
            $this->elasticSearchService->createIndex($indexName);
        } catch (\Exception $e) {
            $this->error($e->getMessage());
        }

        $this->info('Done');
    }
}
