<?php

namespace App\DTO;

final class ProductDTO
{
    public function __construct(
        public readonly int $id,
        public readonly string $name,
        public readonly float $unit_price,
        public readonly ?string $image,
        public readonly ?array $categories,
    ) {}

    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'unit_price' => $this->unit_price,
            'image' => $this->image ?? null,
            'categories' => $this->categories ?? null
        ];
    }
}
