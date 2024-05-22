<?php

namespace App\Events;

use App\Domain\Entities\Model;
use Illuminate\Foundation\Events\Dispatchable;

final class ModelAdded
{
    use Dispatchable;

    /**
     * @psalm-api
     */
    public function __construct(
        private readonly Model $model
    ) {
    }

    public function getModel(): Model
    {
        return $this->model;
    }
}
