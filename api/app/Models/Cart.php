<?php

namespace App\Models;

use App\Enums\CartPaymentMethod;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $fillable = [
        'payment_method',
        'installments',
        'subtotal_value',
        'discount_value',
        'increment_value',
        'final_value'
    ];

    protected $casts = [
        'payment_method' => CartPaymentMethod::class
    ];
}
