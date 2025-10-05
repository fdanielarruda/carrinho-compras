<?php

namespace App\Services;

use App\Services\PaymentStrategies\CreditCardInstallmentStrategy;
use App\Services\PaymentStrategies\CreditCardOneTimeStrategy;
use App\Services\PaymentStrategies\PixPaymentStrategy;
use DomainException;

class CartService
{
    protected array $paymentStrategies;

    public function __construct(
        PixPaymentStrategy $pixStrategy,
        CreditCardOneTimeStrategy $oneTimeStrategy,
        CreditCardInstallmentStrategy $installmentStrategy
    ) {
        $this->paymentStrategies = [
            $pixStrategy,
            $oneTimeStrategy,
            $installmentStrategy,
        ];
    }

    public function calculate(array $data): float
    {
        $order_items = $data['items'];
        $payment_method_value = $data['payment_method'];
        $number_of_installments = $data['installments'];

        $subtotal_amount = $this->calculateSubtotal($order_items);

        foreach ($this->paymentStrategies as $strategy) {
            if ($strategy->supports($payment_method_value, $number_of_installments)) {
                return $strategy->calculate($subtotal_amount, $data);
            }
        }

        throw new DomainException("Método de pagamento ou contagem de parcelas inválida para cálculo.");
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
}
