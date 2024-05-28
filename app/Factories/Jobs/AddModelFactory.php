<?php

namespace App\Factories\Jobs;

use App\Commands\AddModelCommand;
use App\Http\Requests\AddModel as AddModelRequest;
use App\Jobs\AddModel;
use App\Serializers\ModelSerializer;

class AddModelFactory
{
    public static function makeAddModel(
        string $id,
        AddModelRequest $request
    ): AddModel {
        /** @psalm-var array{name: string, brand_id: string} $brandData */
        $brandData = $request->get(ModelSerializer::getType());

        $command = new AddModelCommand(
            $id,
            $brandData['name'],
            $brandData['brand_id']
        );

        return new AddModel($command);
    }
}
