<?php

namespace App\DTO;

class ProductListDTO
{
    public function __construct(
        public readonly ?string $search
    ) {}

    public static function fromRequest(array $data): self
    {
        return new self(
            search: $data['search'] ?? null
        );
    }
}
