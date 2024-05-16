<?php

namespace App\Http\Controllers\Commands;

use App\Factories\Jobs\AddModelFactory;
use App\Http\Requests\AddModel as AddModelRequest;
use App\Serializers\ISerializer;
use App\Serializers\Serialize;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class AddModelController extends BaseController
{
    use DispatchesJobs;
    use Serialize;

    public function __construct(
        private readonly ISerializer $serializer
    ) {
    }

    public function index(AddModelRequest $request): Response
    {
        $id = Str::uuid();

        $this->dispatch(
            AddModelFactory::makeAddModel($id->toString(), $request)
        );

        return new JsonResponse(
            $this->serializeId($this->serializer, $id->toString())
        );
    }
}
