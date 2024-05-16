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
        $command = new AddModelCommand(
            $id,
            $request->get(ModelSerializer::getType())['name'],
            $request->get(ModelSerializer::getType())['brand_id']
        );

        return new AddModel($command);
    }
}
