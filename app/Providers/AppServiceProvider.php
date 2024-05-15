<?php

namespace App\Providers;

use App\Http\Controllers\Commands\AddBrandController;
use App\Http\Controllers\Commands\AddModelController;
use App\Http\Controllers\Queries\ListBrandsController;
use App\Http\Controllers\Queries\ShowBrandController;
use App\Repositories\IBrandRepository;
use App\Repositories\IModelRepository;
use App\Repositories\SQLBrandRepository;
use App\Repositories\SQLModelRepository;
use App\Serializers\BrandSerializer;
use App\Serializers\ModelSerializer;
use App\Services\BrandService;
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

        $this->app->bind(ListBrandsController::class, function ($app) {
            return new ListBrandsController(
                $app->get(BrandService::class),
                $app->get(BrandSerializer::class)
            );
        });

        $this->app->bind(ShowBrandController::class, function ($app) {
            return new ShowBrandController(
                $app->get(BrandService::class),
                $app->get(BrandSerializer::class)
            );
        });

        $this->app->bind(IBrandRepository::class, function ($app) {
            return new SQLBrandRepository();
        });

        $this->app->bind(IModelRepository::class, function ($app) {
            return new SQLModelRepository();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
