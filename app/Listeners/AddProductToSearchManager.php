<?php

namespace App\Listeners;

use App\Events\ProductAdded;
use App\Exceptions\ResourceNotFoundException;
use App\Services\ProductSearchService;
use Illuminate\Contracts\Queue\ShouldQueue;

class AddProductToSearchManager implements ShouldQueue
{
    public string $connection = 'redis';

    public string $queue = 'default';

    public function __construct(
        private readonly ProductSearchService $productSearchService
    ) {
    }

    /**
     * @throws ResourceNotFoundException
     */
    public function handle(ProductAdded $event): void
    {
        $this->productSearchService->addOne(
            $event->product->getId(),
            $event->product->description,
            $event->product->mileage->distance,
            $event->product->mileage->unit,
            $event->product->price->amount,
            $event->product->price->currency,
            $event->product->model?->getId() ?? ''
        );
    }
}
