<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\ProductService;
use Illuminate\Http\JsonResponse;

class ProductController extends Controller
{
    public function __construct(
        protected ProductService $service
    ) {}

    public function index(): JsonResponse
    {
        $products = $this->service->list();

        return response()->json([
            'products' => $products
        ]);
    }
}
