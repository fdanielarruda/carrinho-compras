<?php

namespace App\Services;

use App\Enums\CartPaymentMethod;
use Exception;

class CartService
{
    public function calculate(array $data): float
    {
        $order_items = $data['items'];
        $payment_method_value = $data['payment_method'];
        $number_of_installments = $data['installments'];

        $subtotal_amount = $this->calculateSubtotal($order_items);

        $pix_discount_rate = 0.10;
        $interest_rate_per_installment = 0.01;

        if ($this->isPixPayment($payment_method_value)) {
            return round($subtotal_amount * (1 - $pix_discount_rate), 2);
        }

        if ($this->isCreditCardOneTimePayment($payment_method_value, $number_of_installments)) {
            return round($subtotal_amount * (1 - $pix_discount_rate), 2);
        }

        if ($this->isCreditCardInstallmentPayment($payment_method_value, $number_of_installments)) {
            return round($subtotal_amount * pow((1 + $interest_rate_per_installment), $number_of_installments), 2);
        }

        throw new Exception("Invalid payment method or installment count for calculation.");
    }

    private function calculateSubtotal(array $items): float
    {
        $running_subtotal = 0.0;

        foreach ($items as $item) {
            $unit_price = $item['price'] ?? 0.0;
            $item_quantity = $item['quantity'] ?? 1;
            $running_subtotal += $unit_price * $item_quantity;
        }

        return $running_subtotal;
    }

    private function isPixPayment(string $payment_method): bool
    {
        return $payment_method === CartPaymentMethod::METHOD_PIX->value;
    }

    private function isCreditCardOneTimePayment(string $payment_method, int $number_of_installments): bool
    {
        return $payment_method === CartPaymentMethod::METHOD_CREDIT_CARD->value
            && $number_of_installments === 1;
    }

    private function isCreditCardInstallmentPayment(string $payment_method, int $number_of_installments): bool
    {
        return $payment_method === CartPaymentMethod::METHOD_CREDIT_CARD->value
            && $number_of_installments >= 2
            && $number_of_installments <= 12;
    }
}
