<?php

namespace App\DTO;

final class CartCalculationDTO
{
    /**
     * @param CartItemDTO[] $items
     */
    public function __construct(
        public readonly array $items,
        public readonly string $payment_method,
        public readonly ?int $installments = null,
    ) {}

    public function getSubtotal(): float
    {
        return array_reduce(
            $this->items,
            fn(float $sum, CartItemDTO $item) => $sum + $item->getLineTotal(),
            0.0
        );
    }

    public function requiresInstallments(): bool
    {
        return $this->payment_method === 'credit_card';
    }
}
