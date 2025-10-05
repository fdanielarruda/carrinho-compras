<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Product;

class ProductsApiTest extends TestCase
{
    use RefreshDatabase;

    /** Teste: listar produtos existentes. */
    public function test_given_existing_products_when_requesting_list_then_returns_all_products()
    {
        $products = Product::factory()->count(3)->create();

        $response = $this->getJson('/api/products');

        $response->assertStatus(200);

        $response->assertJsonCount(3, 'products');

        $response->assertJsonStructure([
            'products' => [
                '*' => ['id', 'name', 'unit_price']
            ]
        ]);

        foreach ($products as $product) {
            $response->assertJsonFragment([
                'id' => $product->id,
                'name' => $product->name,
                'unit_price' => (float) $product->unit_price,
            ]);
        }
    }

    /** Teste: lista vazia quando não há produtos. */
    public function test_given_no_products_when_requesting_list_then_returns_empty_array()
    {
        $response = $this->getJson('/api/products');

        $response->assertStatus(200);
        $response->assertJsonCount(0, 'products');
        $response->assertJson(['products' => []]);
    }
}
