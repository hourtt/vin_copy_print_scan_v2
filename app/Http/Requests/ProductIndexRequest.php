<?php

namespace App\Http\Requests;

use App\Enums\ProductSort;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProductIndexRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $rawCategory = $this->input('category') ?? $this->route('category');

        if (is_string($rawCategory) && $rawCategory !== '') {
            $normalized = strtolower(trim($rawCategory));
            $aliases = config('catalog.slug_aliases', []);

            $this->merge([
                'category' => $aliases[$normalized] ?? $normalized,
            ]);
        }
    }

    public function rules(): array
    {
        return [
            'category_id' => 'nullable|integer|exists:categories,id',
            'category' => 'nullable|string|exists:categories,slug',
            'brand_id' => 'nullable|integer|exists:brands,id',
            'printer_model_id' => 'nullable|integer|exists:printer_models,id',
            'search' => 'nullable|string|max:255',
            'sort' => ['nullable', 'string', Rule::in(ProductSort::acceptedValues())],
            'per_page' => 'nullable|integer|min:1|max:50',
        ];
    }
}
