<?php

namespace App\Services;

use App\DTO\CartCalculationDTO;
use App\DTO\CartItemDTO;
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

    public function calculate(CartCalculationDTO $data): float
    {
        $subtotal = $data->getSubtotal();

        foreach ($this->paymentStrategies as $strategy) {
            if ($strategy->supports($data->payment_method, $data->installments ?? 1)) {
                return $strategy->calculate($subtotal, [
                    'installments' => $data->installments ?? 1
                ]);
            }
        }

        throw new DomainException("Método de pagamento ou número de parcelas inválidas para cálculo.");
    }

    /**
     * @param CartItemDTO[] $items
     */
    private function calculateSubtotal(array $items): float
    {
        $running_subtotal = 0.0;

        foreach ($items as $item) {
            $running_subtotal += $item->getLineTotal();
        }

        return $running_subtotal;
    }
}
