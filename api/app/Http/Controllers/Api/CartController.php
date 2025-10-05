<?php

namespace App\Http\Controllers\Api;

use App\DTO\CartCalculationDTO;
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

        $items = collect($payload['items'])
            ->map(fn(array $item) => new CartItemDTO(
                price: (float) $item['price'],
                quantity: (int) $item['quantity']
            ))
            ->all();

        $payload = new CartCalculationDTO(
            items: $items,
            payment_method: $payload['payment_method'],
            installments: $payload['installments'] ?? null
        );

        $total_value = $this->service->calculate($payload);

        return response()->json(['total_value' => $total_value]);
    }
}
