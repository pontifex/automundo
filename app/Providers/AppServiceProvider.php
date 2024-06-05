<?php

namespace App\Providers;

use App\Http\Controllers\Commands\AddBrandController;
use App\Http\Controllers\Commands\AddModelController;
use App\Http\Controllers\Commands\AddProductController;
use App\Http\Controllers\Queries\ListBrandsController;
use App\Http\Controllers\Queries\ListProductsController;
use App\Http\Controllers\Queries\ShowBrandController;
use App\Http\Controllers\Queries\ShowProductController;
use App\Repositories\ElasticSearchProductRepository;
use App\Repositories\IBrandRepository;
use App\Repositories\IModelRepository;
use App\Repositories\SQLBrandRepository;
use App\Repositories\SQLModelRepository;
use App\Repositories\SQLProductRepository;
use App\Serializers\BrandSerializer;
use App\Serializers\ModelSerializer;
use App\Serializers\ProductSerializer;
use App\Serializers\Search\ProductIndexingSerializer;
use App\Services\BrandService;
use App\Services\ProductSearchService;
use App\Services\ProductService;
use Elastic\Elasticsearch\Client;
use Elastic\Elasticsearch\ClientBuilder;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(AddBrandController::class, function ($app) {
            return new AddBrandController(
                $app->get(BrandSerializer::class)
            );
        });

        $this->app->bind(AddModelController::class, function ($app) {
            return new AddModelController(
                $app->get(ModelSerializer::class)
            );
        });

        $this->app->bind(AddProductController::class, function ($app) {
            return new AddProductController(
                $app->get(ProductSerializer::class)
            );
        });

        $this->app->bind(ListBrandsController::class, function ($app) {
            return new ListBrandsController(
                $app->get(BrandService::class),
                $app->get(BrandSerializer::class)
            );
        });

        $this->app->bind(ListProductsController::class, function ($app) {
            return new ListProductsController(
                $app->get(ProductSearchService::class),
                $app->get(ProductSerializer::class)
            );
        });

        $this->app->bind(ShowBrandController::class, function ($app) {
            return new ShowBrandController(
                $app->get(BrandService::class),
                $app->get(BrandSerializer::class)
            );
        });

        $this->app->bind(ShowProductController::class, function ($app) {
            return new ShowProductController(
                $app->get(ProductSearchService::class),
                $app->get(ProductSerializer::class)
            );
        });

        $this->app->bind(IBrandRepository::class, function ($app) {
            return new SQLBrandRepository();
        });

        $this->app->bind(IModelRepository::class, function ($app) {
            return new SQLModelRepository();
        });

        $this->app->bind(ProductService::class, function ($app) {
            return new ProductService(
                new SQLProductRepository(),
                $app->get(IModelRepository::class)
            );
        });

        $this->app->bind(ProductSearchService::class, function ($app) {
            return new ProductSearchService(
                new ElasticSearchProductRepository(
                    $app->get(Client::class),
                    $app->get(ProductIndexingSerializer::class)
                ),
                $app->get(IModelRepository::class)
            );
        });

        $this->app->bind(Client::class, function ($app) {
            return ClientBuilder::create()
                ->setSSLVerification(false)
                ->setHosts(
                    [
                        sprintf(
                            '%s:%d',
                            env('ELASTICSEARCH_HOST', 'localhost'),
                            env('ELASTICSEARCH_HOST_HTTP_PORT', 9200)
                        ),
                    ]
                )->build();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
    }
}
