<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductIndexRequest;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ProductController extends Controller
{
    /**
     * Display a paginated listing of filtered products.
     */
    public function index(ProductIndexRequest $request): AnonymousResourceCollection
    {
        $validated = $request->validated();
        $perPage = min((int) ($validated['per_page'] ?? 20), 50);

        $products = Product::with('category', 'brand')
            ->filter($validated)
            ->paginate($perPage)
            ->withQueryString();

        return ProductResource::collection($products);
    }

    /**
     * Display the specified product resource.
     */
    public function show(Product $product): ProductResource
    {
        $product->loadMissing(['category', 'brand']);

        return new ProductResource($product);
    }
}
