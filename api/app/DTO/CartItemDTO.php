<?php

namespace App\DTO;

class CartItemDTO
{
    public function __construct(
        public float $price,
        public int $quantity,
    ) {}

    public function getLineTotal(): float
    {
        return $this->price * $this->quantity;
    }
}
