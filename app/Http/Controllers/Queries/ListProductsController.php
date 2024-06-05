<?php

namespace App\Http\Controllers\Queries;

use App\Domain\Entities\Product;
use App\Exceptions\ResourceNotFoundException;
use App\Helpers\Debug\Debug;
use App\Serializers\ISerializer;
use App\Serializers\Serialize;
use App\Services\ProductSearchService;
use Exception;
use Illuminate\Routing\Controller as BaseController;
use Pontifex\Rest\Api\Fields\Exceptions\IncorrectFieldException;
use Pontifex\Rest\Api\Fields\Exceptions\NoFieldsException;
use Pontifex\Rest\Api\Fields\Fields;
use Pontifex\Rest\Api\Pagination\Exceptions\IncorrectPageNumberException;
use Pontifex\Rest\Api\Pagination\Exceptions\IncorrectPageSizeException;
use Pontifex\Rest\Api\Pagination\Pagination;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ListProductsController extends BaseController
{
    use Debug;
    use Fields;
    use Pagination;
    use Serialize;

    private const DEFAULT_PAGE_NUMBER = 1;

    private const DEFAULT_SIZE = 15;

    public function __construct(
        private readonly ProductSearchService $productSearchService,
        private readonly ISerializer $serializer
    ) {
    }

    /**
     * @psalm-api
     *
     * @throws IncorrectFieldException
     * @throws NoFieldsException
     * @throws ResourceNotFoundException
     * @throws IncorrectPageNumberException
     * @throws IncorrectPageSizeException
     */
    public function index(Request $request): Response
    {
        [$pageNumber, $pageSize] = $this->extractPaginationParams(
            $request->query,
            self::DEFAULT_PAGE_NUMBER,
            self::DEFAULT_SIZE
        );

        $fields = $this->getFields(
            $request->query,
            $this->serializer->getType(),
            Product::getAllowedFields()
        );

        try {
            $products = $this->productSearchService->list(
                $pageNumber,
                $pageSize
            );
        } catch (Exception $e) {
            $this->debugException($e);
            throw new ResourceNotFoundException();
        }

        return new JsonResponse(
            $this->serializeCollection(
                $this->serializer,
                $products,
                $fields
            )
        );
    }
}
