<?php

namespace App\Services;

use App\DTO\ProductDTO;
use App\Models\Product;

class ProductService
{
    public function list(): array
    {
        return Product::all()
            ->map(fn(Product $product) => new ProductDTO(
                id: (int) $product->id,
                name: (string) $product->name,
                unit_price: (float) $product->unit_price
            ))
            ->toArray();
    }
}
