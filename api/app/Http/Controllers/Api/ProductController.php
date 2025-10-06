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

        $products_paginator = $this->service->list($dto);

        return response()->json([
            'total' => $products_paginator->total(),
            'current_page' => $products_paginator->currentPage(),
            'last_page' => $products_paginator->lastPage(),
            'products' => $products_paginator->items(),
        ]);
    }
}
