<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CartCalculateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'items' => ['required', 'array', 'min:1'],
            'items.*.price' => ['required', 'numeric', 'min:0.01'],
            'items.*.quantity' => ['required', 'integer', 'min:1'],
            'payment_method' => [
                'required',
                'integer',
                Rule::in([1, 2])
            ],
            'installments' => [
                'required_if:payment_method,2',
                'integer',
                Rule::when($this->payment_method == 2, ['min:1', 'max:12'])
            ],
        ];
    }
}
