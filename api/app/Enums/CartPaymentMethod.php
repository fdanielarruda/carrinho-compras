<?php

namespace App\Enums;

enum CartPaymentMethod: string
{
    case METHOD_PIX = '1';
    case METHOD_CREDIT_CARD = '2';

    public function text(): string
    {
        return match ($this) {
            self::METHOD_PIX => 'Pix',
            self::METHOD_CREDIT_CARD => 'Cartão de Crédito'
        };
    }
}
