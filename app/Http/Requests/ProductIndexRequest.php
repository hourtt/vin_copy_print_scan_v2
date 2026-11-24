<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductIndexRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'category_id' => 'nullable|integer|exists:categories,id',
            'category' => 'nullable|string|exists:categories,slug',
            'brand_id' => 'nullable|integer|exists:brands,id',
            'search' => 'nullable|string|max:255',
            'sort' => 'nullable|string|in:price-asc,price-desc,newest,name-asc',
            'per_page' => 'nullable|integer|min:1|max:50',
        ];
    }
}
