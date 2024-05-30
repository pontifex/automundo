<?php

namespace App\Http\Controllers\Commands;

use App\Factories\Jobs\AddProductFactory;
use App\Http\Requests\AddProduct as AddProductRequest;
use App\Serializers\ISerializer;
use App\Serializers\Serialize;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class AddProductController extends BaseController
{
    use DispatchesJobs;
    use Serialize;

    public function __construct(
        private readonly ISerializer $serializer
    ) {
    }

    /**
     * @psalm-api
     */
    public function index(AddProductRequest $request): Response
    {
        $id = Str::uuid();

        $this->dispatch(
            AddProductFactory::makeAddProduct($id->toString(), $request)
        );

        return new JsonResponse(
            $this->serializeId($this->serializer, $id->toString())
        );
    }
}
