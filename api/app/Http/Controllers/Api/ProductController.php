<?php

namespace App\Http\Controllers\Api;

use App\DTO\ProductListDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProductIndexRequest;
use App\Services\ProductService;
use Illuminate\Http\JsonResponse;

class ProductController extends Controller
{
    public function __construct(
        protected ProductService $service
    ) {}

    public function index(ProductIndexRequest $request): JsonResponse
    {
        $dto = ProductListDTO::fromRequest($request->validated());

        $products = $this->service->list($dto);

        return response()->json([
            'products' => $products,
        ]);
    }
}
