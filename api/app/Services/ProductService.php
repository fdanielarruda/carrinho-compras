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
                id: $product->id,
                name: $product->name,
                price: $product->price
            ))
            ->toArray();
    }
}
