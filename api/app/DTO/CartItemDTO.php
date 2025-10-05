<?php

namespace App\DTO;

final class CartItemDTO
{
    public function __construct(
        public readonly float $price,
        public readonly int $quantity,
    ) {}

    public function getLineTotal(): float
    {
        return $this->price * $this->quantity;
    }
}
