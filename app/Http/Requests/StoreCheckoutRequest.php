<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreCheckoutRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'first_name' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone_number' => 'required|string|max:20',
            'address' => 'required|string',
            'city' => 'required|string|max:255',
            'state_province' => 'required|string|max:255',
            'zip_code' => 'required|string|max:20',
            'order_notes' => 'nullable|string',
            'shipping_method_id' => 'required|exists:shipping_methods,id',
            'payment_method' => 'required|in:cod,stripe,aba',
        ];
    }
}
