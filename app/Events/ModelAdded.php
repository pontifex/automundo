<?php

namespace App\Events;

use App\Domain\Entities\Model;
use Illuminate\Foundation\Events\Dispatchable;

readonly class ModelAdded
{
    use Dispatchable;

    /**
     * @psalm-api
     */
    public function __construct(
        private Model $model
    ) {
    }

    public function getModel(): Model
    {
        return $this->model;
    }
}
