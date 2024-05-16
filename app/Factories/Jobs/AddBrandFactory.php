<?php

namespace App\Factories\Jobs;

use App\Commands\AddBrandCommand;
use App\Http\Requests\AddBrand as AddBrandRequest;
use App\Jobs\AddBrand;
use App\Serializers\BrandSerializer;

class AddBrandFactory
{
    public static function makeAddBrand(
        string $id,
        AddBrandRequest $request
    ): AddBrand {
        $command = new AddBrandCommand(
            $id,
            $request->get(BrandSerializer::getType())['name']
        );

        return new AddBrand($command);
    }
}
