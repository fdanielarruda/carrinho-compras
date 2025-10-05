<?php

namespace App\Services\PaymentStrategies;

use App\Enums\CartPaymentMethod;

class PixPaymentStrategy implements PaymentStrategyInterface
{
    private const DISCOUNT_RATE = 0.10;

    public function calculate(float $subtotal, array $data): float
    {
        return round($subtotal * (1 - self::DISCOUNT_RATE), 2);
    }

    public function supports(string $paymentMethod, int $installments): bool
    {
        return $paymentMethod === CartPaymentMethod::METHOD_PIX->value;
    }
}
