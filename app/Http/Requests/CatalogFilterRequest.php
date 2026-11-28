<?php

namespace App\Http\Requests;

use App\Enums\ProductSort;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CatalogFilterRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'categories' => ['nullable', 'array'],
            'categories.*' => ['integer', 'min:1'],
            'min_price' => ['nullable', 'numeric', 'min:0'],
            'max_price' => ['nullable', 'numeric', 'min:0'],
            'printer_model_id' => ['nullable', 'integer', 'min:1'],
            'sort' => ['nullable', 'string', Rule::in(ProductSort::acceptedValues())],
            'search' => ['nullable', 'string', 'max:100'],
            'cat' => ['nullable', function ($attribute, $value, $fail) {
                if ($value !== 'all' && ! filter_var($value, FILTER_VALIDATE_INT)) {
                    $fail("The {$attribute} must be an integer or 'all'.");
                }
            }],
            'brand' => ['nullable', function ($attribute, $value, $fail) {
                if ($value !== 'all' && ! filter_var($value, FILTER_VALIDATE_INT)) {
                    $fail("The {$attribute} must be an integer or 'all'.");
                }
            }],
        ];
    }

    /**
     * Return normalized filter values with safe defaults.
     *
     * @return array{
     *     categories: array<int>,
     *     min_price: float|null,
     *     max_price: float|null,
     *     sort: string|null,
     *     search: string|null,
     *     brand_id: int|null,
     *     printer_model_id: int|null
     * }
     */
    public function filters(): array
    {
        $validated = $this->validated();

        // Normalize brand filter: 'cat' from frontend pills or 'brand'
        $brandId = null;
        $rawBrand = $validated['cat'] ?? ($validated['brand'] ?? null);
        if ($rawBrand !== null && $rawBrand !== 'all' && $rawBrand !== '') {
            $brandId = (int) $rawBrand;
        }

        return [
            'categories' => ! empty($validated['categories'])
                ? array_map('intval', (array) $validated['categories'])
                : [],
            'min_price' => isset($validated['min_price']) && is_numeric($validated['min_price'])
                ? (float) $validated['min_price']
                : null,
            'max_price' => isset($validated['max_price']) && is_numeric($validated['max_price'])
                ? (float) $validated['max_price']
                : null,
            'sort' => $validated['sort'] ?? null,
            'search' => isset($validated['search']) ? trim($validated['search']) : null,
            'brand_id' => $brandId,
            'printer_model_id' => isset($validated['printer_model_id']) ? (int) $validated['printer_model_id'] : null,
        ];
    }
}
