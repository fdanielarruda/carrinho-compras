<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Product;

class ProductsApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_api_can_list_products()
    {
        Product::factory()->count(3)->create();

        $response = $this->get('/api/products');

        $response->assertStatus(200);

        $response->assertJsonCount(3, 'data');

        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'name',
                    'unit_price',
                    'created_at',
                    'updated_at',
                ]
            ]
        ]);
    }
}
