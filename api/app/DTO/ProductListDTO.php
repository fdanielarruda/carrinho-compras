<?php

namespace App\DTO;

class ProductListDTO
{
    public function __construct(
        public readonly ?string $search,
        public readonly ?string $per_page
    ) {}

    public static function fromRequest(array $data): self
    {
        return new self(
            search: $data['search'] ?? null,
            per_page: $data['per_page'] ?? null
        );
    }
}
