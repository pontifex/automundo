<?php

namespace App\Providers;

use App\Events\BrandAdded;
use App\Events\ModelAdded;
use App\Events\ProductAdded;
use App\Listeners\AddProductToSearchManager;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array<string, array<int, string>>
     */
    protected $listen = [
        BrandAdded::class => [
        ],
        ModelAdded::class => [
        ],
        ProductAdded::class => [
            AddProductToSearchManager::class,
        ],
    ];

    public function boot(): void
    {
    }
}
