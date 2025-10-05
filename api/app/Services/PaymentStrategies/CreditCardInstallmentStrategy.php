<?php

namespace App\Services\PaymentStrategies;

use App\Enums\CartPaymentMethod;

class CreditCardInstallmentStrategy implements PaymentStrategy
{
    private const INTEREST_RATE_PER_INSTALLMENT = 0.01;
    private const MAX_INSTALLMENTS = 12;

    public function calculate(float $subtotal, array $data): float
    {
        $installments = $data['installments'] ?? 1;

        $total = $subtotal * pow((1 + self::INTEREST_RATE_PER_INSTALLMENT), $installments);

        return round($total, 2);
    }

    public function supports(string $paymentMethod, int $installments): bool
    {
        return $paymentMethod === CartPaymentMethod::METHOD_CREDIT_CARD->value
            && $installments >= 2
            && $installments <= self::MAX_INSTALLMENTS;
    }
}
