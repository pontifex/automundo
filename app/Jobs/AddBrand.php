<?php

namespace App\Jobs;

use App\Commands\AddBrandCommand;
use App\Events\BrandAdded;
use App\Services\BrandService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;

class AddBrand implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;

    public function __construct(
        private readonly AddBrandCommand $command
    ) {
    }

    public function handle(BrandService $service): void
    {
        $brand = $service->addOne(
            $this->command->getId(),
            $this->command->getName()
        );

        BrandAdded::dispatch($brand);
    }
}
