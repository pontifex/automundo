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
        /** @psalm-var array{name: string} $modelData */
        $modelData = $request->get(BrandSerializer::getType());

        $command = new AddBrandCommand(
            $id,
            $modelData['name']
        );

        return new AddBrand($command);
    }
}
