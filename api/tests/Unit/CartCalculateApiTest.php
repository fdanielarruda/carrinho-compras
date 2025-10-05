<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class CartCalculateApiTest extends TestCase
{
    use RefreshDatabase;

    private const PIX = 1;
    private const CREDIT_CARD = 2;

    /** Teste: Pix aplica desconto de 10% corretamente. */
    public function test_given_pix_payment_when_calculating_total_then_applies_discount()
    {
        $payload = $this->makeCartPayload(paymentMethod: self::PIX);

        $response = $this->postJson('/api/cart-calculate', $payload);

        $response->assertStatus(200);
        $this->assertEqualsWithDelta(1800.00, $response->json('total_value'), 0.01);
    }

    /** Teste: Crédito à vista (1x) aplica desconto de 10%. */
    public function test_given_credit_card_one_time_when_calculating_total_then_applies_discount()
    {
        $payload = $this->makeCartPayload(paymentMethod: self::CREDIT_CARD, installments: 1);

        $response = $this->postJson('/api/cart-calculate', $payload);

        $response->assertStatus(200);
        $this->assertEqualsWithDelta(1800.00, $response->json('total_value'), 0.01);
    }

    /** Teste: Crédito parcelado aplica juros corretamente nos limites (2x, 12x). */
    #[DataProvider('creditCardInstallmentsProvider')]
    public function test_given_credit_card_installments_when_calculating_total_then_applies_interest(int $installments, float $expectedTotal)
    {
        $payload = $this->makeCartPayload(paymentMethod: self::CREDIT_CARD, installments: $installments);

        $response = $this->postJson('/api/cart-calculate', $payload);

        $response->assertStatus(200);
        $response->assertJsonStructure(['total_value']);

        $this->assertEqualsWithDelta($expectedTotal, $response->json('total_value'), 0.01);
    }

    public static function creditCardInstallmentsProvider(): array
    {
        return [
            'minimum installments (2x)' => [2, 2040.20],
            'maximum installments (12x)' => [12, 2253.65],
        ];
    }

    /** Teste: Payload inválido (items ausentes) retorna erro de validação (422). */
    public function test_given_invalid_payload_when_calculating_total_then_returns_validation_error()
    {
        $payload = $this->makeCartPayload(paymentMethod: self::PIX);
        unset($payload['items']);

        $response = $this->postJson('/api/cart-calculate', $payload);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['items']);
    }

    /** Teste: Parcelas fora da faixa (13x) deve falhar com erro de validação (422). */
    public function test_given_installments_out_of_range_when_calculating_total_then_returns_error()
    {
        $payload = $this->makeCartPayload(paymentMethod: self::CREDIT_CARD, installments: 13);

        $response = $this->postJson('/api/cart-calculate', $payload);

        $response->assertStatus(422);
    }

    private function makeCartPayload(int $paymentMethod, int $installments = 1): array
    {
        $payload = [
            'items' => [
                ['price' => 1000, 'quantity' => 1],
                ['price' => 500, 'quantity' => 2],
            ],
            'payment_method' => $paymentMethod,
        ];

        if ($paymentMethod === self::CREDIT_CARD) {
            $payload['installments'] = $installments;
        }

        return $payload;
    }
}
