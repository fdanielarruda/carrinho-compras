<?php

namespace App\DTO;

class ProductDTO
{
    public function __construct(
        public int $id,
        public string $name,
        public float $unit_price,
    ) {}
}
