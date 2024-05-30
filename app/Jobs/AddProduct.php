<?php

namespace App\Jobs;

use App\Commands\AddProductCommand;
use App\Events\ProductAdded;
use App\Exceptions\ResourceNotFoundException;
use App\Services\ProductService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;

class AddProduct implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;

    public function __construct(
        private readonly AddProductCommand $command
    ) {
    }

    /**
     * @psalm-api
     *
     * @throws ResourceNotFoundException
     */
    public function handle(ProductService $service): void
    {
        $product = $service->addOne(
            $this->command->getId(),
            $this->command->getDescription(),
            $this->command->getMileageDistance(),
            $this->command->getMileageUnit(),
            $this->command->getPriceAmount(),
            $this->command->getPriceCurrency(),
            $this->command->getModelId()
        );

        ProductAdded::dispatch($product);
    }
}
