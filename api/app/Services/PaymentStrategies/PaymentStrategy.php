<?php

namespace App\Services\PaymentStrategies;

interface PaymentStrategy
{
    public function calculate(float $subtotal, array $data): float;
    public function supports(string $paymentMethod, int $installments): bool;
}
