<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PrinterResource;
use App\Models\PrinterModel as Printer;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class PrinterController extends Controller
{
    /**
     * Display a paginated listing of printer models, optionally filtered by brand.
     */
    public function index(Request $request): AnonymousResourceCollection
    {
        $validated = $request->validate([
            'brand_id' => ['nullable', 'integer', 'exists:brands,id'],
            'search' => ['nullable', 'string', 'max:100'],
            'per_page' => ['nullable', 'integer', 'min:1', 'max:100'],
        ]);

        $search = isset($validated['search']) ? trim($validated['search']) : null;
        $escapedSearch = $search
            ? str_replace(['\\', '%', '_'], ['\\\\', '\\%', '\\_'], $search)
            : null;

        $printers = Printer::query()
            ->with('brand')
            ->when(
                $validated['brand_id'] ?? null,
                fn ($q, $brandId) => $q->where('brand_id', $brandId)
            )
            ->when(
                $escapedSearch,
                fn ($q) => $q->whereLike('model_name', "%{$escapedSearch}%", caseSensitive: false)
            )
            ->orderBy('model_name')
            ->orderByDesc('id') // tiebreaker for stable pagination
            ->paginate($validated['per_page'] ?? 10)
            ->withQueryString();

        return PrinterResource::collection($printers);
    }

    /**
     * Return a single printer model with its brand
     * and the products compatible with it.
     */
    public function show(string $id): PrinterResource
    {
        $query = Printer::with('brand', 'compatibleProducts.brand', 'compatibleProducts.category');

        $printer = ctype_digit($id)
            ? $query->findOrFail((int) $id)
            : $query->where('slug', $id)->firstOrFail();

        return new PrinterResource($printer);
    }
}
