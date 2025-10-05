<?php

namespace App\Http\Controllers\Api;

use App\DTO\CartItemDTO;
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
        $payload = $request->validated();

        $payload['items'] = collect($payload['items'])
            ->map(fn(array $item) => new CartItemDTO(
                price: (float) $item['price'],
                quantity: (int) $item['quantity']
            ))
            ->all();

        $total_value = $this->service->calculate($payload);

        return response()->json([
            'total_value' => compact('total_value')
        ]);
    }
}
