<?php

namespace App\Services;

use App\DTO\ProductDTO;
use App\DTO\ProductListDTO;
use App\Models\Product;
use Illuminate\Support\Collection;

class ProductService
{
    public function list(ProductListDTO $data): Collection
    {
        $query = Product::query();

        if (!empty($data->search)) {
            $query->where('name', 'LIKE', '%' . $data->search . '%');
        }

        $products = $query->get();

        return $products->map(fn(Product $product) => new ProductDTO(
            id: (int) $product->id,
            name: (string) $product->name,
            unit_price: (float) $product->unit_price,
            image: (string) $product->image ?? null,
            categories: (array) $product->categories ?? null
        ));
    }
}
