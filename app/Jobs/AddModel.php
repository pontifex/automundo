<?php

namespace App\Jobs;

use App\Commands\AddModelCommand;
use App\Events\ModelAdded;
use App\Exceptions\ResourceNotFoundException;
use App\Services\ModelService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;

class AddModel implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;

    public function __construct(
        private readonly AddModelCommand $command
    ) {
    }

    /**
     * @psalm-api
     *
     * @throws ResourceNotFoundException
     */
    public function handle(
        ModelService $modelService
    ): void {
        $model = $modelService->addOne(
            $this->command->getId(),
            $this->command->getName(),
            $this->command->getBrandId()
        );

        ModelAdded::dispatch($model);
    }
}
