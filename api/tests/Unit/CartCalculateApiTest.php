<?php

namespace Tests\Unit;

use Tests\TestCase;

class CartCalculateApiTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
    }

    public function test_pix_payment_applies_discount()
    {
        $payload = $this->makePayload(1, 1);

        $response = $this->postJson('/api/cart-calculate', $payload);

        $response->assertStatus(200);

        $result = $response->json('total_value');

        $expected = $this->expectedValue($payload);

        $this->assertEqualsWithDelta($expected, $result, 0.01);
    }

    public static function installmentsProvider(): array
    {
        $cases = [];
        for ($i = 1; $i <= 2; $i++) {
            $cases["{$i} installments"] = [$i];
        }
        return $cases;
    }

    public function test_credit_card_installments_adds_interest()
    {
        $payload = $this->makePayload(2, 1);

        $response = $this->postJson('/api/cart-calculate', $payload);

        $response->assertStatus(200);

        $result = $response->json('total_value');

        $expected = $this->expectedValue($payload);

        $this->assertEqualsWithDelta($expected, $result, 0.01);
    }

    public function test_credit_card_installments_adds_interest_multi()
    {
        $payload = $this->makePayload(2, 12);

        $response = $this->postJson('/api/cart-calculate', $payload);

        $response->assertStatus(200);

        $result = $response->json('total_value');

        $expected = $this->expectedValue($payload);

        $this->assertEqualsWithDelta($expected, $result, 0.01);
    }

    private function makePayload(int $paymentMethod, int $installments = 1): array
    {
        return [
            'items' => [
                ['price' => 1000, 'quantity' => 1],
                ['price' => 500, 'quantity' => 2],
            ],
            'payment_method' => $paymentMethod,
            'installments' => $installments,
        ];
    }

    private function expectedValue(array $payload): float
    {
        $price = collect($payload['items'])->sum(fn($item) => $item['price'] * $item['quantity']);

        $paymentMethod = $payload['payment_method'];
        $installments = $payload['installments'] ?? 1;

        if ($paymentMethod == 2 && $installments > 1) {
            $i = 0.01;
            $final_value = $price * pow(1 + $i, $installments);
            return round($final_value, 2);
        }

        return round($price * 0.9, 2);
    }
}
