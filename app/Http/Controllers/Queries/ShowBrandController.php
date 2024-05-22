<?php

namespace App\Http\Controllers\Queries;

use App\Domain\Entities\Brand;
use App\Exceptions\ResourceNotFoundException;
use App\Helpers\Debug\Debug;
use App\Serializers\ISerializer;
use App\Serializers\Serialize;
use App\Services\BrandService;
use Exception;
use Illuminate\Routing\Controller as BaseController;
use Pontifex\Rest\Api\Fields\Exceptions\IncorrectFieldException;
use Pontifex\Rest\Api\Fields\Exceptions\NoFieldsException;
use Pontifex\Rest\Api\Fields\Fields;
use Pontifex\Rest\Api\IApi;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ShowBrandController extends BaseController
{
    use Debug;
    use Fields;
    use Serialize;

    public function __construct(
        private readonly BrandService $brandService,
        private readonly ISerializer $serializer
    ) {
    }

    /**
     * @psalm-api
     * @throws IncorrectFieldException
     * @throws NoFieldsException
     * @throws ResourceNotFoundException
     */
    public function index(Request $request, string $id): Response
    {
        $fields = $this->getFields(
            $request->get(IApi::FIELDS_PARAM, []),
            $this->serializer->getType(),
            Brand::getAllowedFields()
        );

        try {
            $brand = $this->brandService->getOneById($id);
        } catch (ResourceNotFoundException $e) {
            throw $e;
        } catch (Exception $e) {
            $this->debugException($e);
            throw new ResourceNotFoundException();
        }

        return new JsonResponse(
            $this->serialize($this->serializer, $brand, $fields)
        );
    }
}
