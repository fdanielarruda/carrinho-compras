<?php

namespace Tests\Feature;

use Tests\TestCase;

class Exemple extends TestCase
{
    public function test_example(): void
    {
        $response = $this->get('/api');
        $response->assertStatus(200);
    }
}
