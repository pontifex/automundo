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
            $event->getProduct()->getId(),
            $event->getProduct()->getDescription(),
            $event->getProduct()->getMileage()->getDistance(),
            $event->getProduct()->getMileage()->getUnit(),
            $event->getProduct()->getPrice()->getAmount(),
            $event->getProduct()->getPrice()->getCurrency(),
            $event->getProduct()->getModel()?->getId() ?? ''
        );
    }
}
