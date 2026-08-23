<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'first_name'   => ['sometimes', 'required', 'string', 'max:255'],
            'last_name'    => ['sometimes', 'required', 'string', 'max:255'],
            'email'        => [
                'sometimes',
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                Rule::unique(User::class)->ignore($this->user()->id),
            ],
            'phone_number' => ['sometimes', 'nullable', 'string', 'min:8', 'max:20', 'regex:/^[0-9\+\-\s]+$/'],
        ];
    }
}
