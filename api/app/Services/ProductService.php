<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Collection;

class ProductService
{
    public function list(): Collection
    {
        return Product::all();
    }
}
