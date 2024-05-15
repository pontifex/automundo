<?php

namespace App\Http\Controllers\Commands;

use App\Commands\AddBrandCommand;
use App\Http\Requests\AddBrand as AddBrandRequest;
use App\Jobs\AddBrand;
use App\Serializers\ISerializer;
use App\Serializers\Serialize;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class AddBrandController extends BaseController
{
    use DispatchesJobs;
    use Serialize;

    public function __construct(
        private readonly ISerializer $serializer
    ) {
    }

    public function index(AddBrandRequest $request): Response
    {
        $id = Str::uuid();

        $command = new AddBrandCommand(
            $id->toString(),
            $request->get($this->serializer->getType())['name']
        );

        $this->dispatch(
            new AddBrand($command)
        );

        return new JsonResponse(
            $this->serializeId($this->serializer, $id->toString())
        );
    }
}
