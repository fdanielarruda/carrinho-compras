<?php

namespace App\Services;

use App\DTO\ProductDTO;
use App\DTO\ProductListDTO;
use App\Models\Product;
use Illuminate\Pagination\LengthAwarePaginator;

class ProductService
{
    public function list(ProductListDTO $data): LengthAwarePaginator
    {
        $query = Product::query();
        $per_page = $data->per_page ?? 12;

        if (!empty($data->search)) {
            $query->where('name', 'LIKE', '%' . $data->search . '%');
        }

        return $query->paginate($per_page)
            ->withQueryString()
            ->through(fn(Product $product) => new ProductDTO(
                id: (int) $product->id,
                name: (string) $product->name,
                unit_price: (float) $product->unit_price
            ));
    }
}
