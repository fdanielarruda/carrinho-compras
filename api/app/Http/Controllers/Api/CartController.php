<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CartCalculateRequest;
use App\Services\CartService;
use Illuminate\Http\JsonResponse;

class CartController extends Controller
{
    public function __construct(
        protected CartService $service
    ) {}

    public function calculate(CartCalculateRequest $request): JsonResponse
    {
        $data = $request->validated();

        $total_value = $this->service->calculate($data);

        return response()->json([
            'total_value' => $total_value
        ]);
    }
}
