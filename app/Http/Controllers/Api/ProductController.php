<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Requests\ProductIndexRequest;

class ProductController extends Controller
{

    public function index(ProductIndexRequest $request)
    {
        $validated = $request->validated();

        $query = Product::with('category', 'brand');

        // Filter by category_id
        if (isset($validated['category_id'])) {
            $query->where('category_id', $validated['category_id']);
        }

        // Filter by category slug
        if (isset($validated['category'])) {
            $query->whereHas('category', fn($q) => $q->where('slug', $validated['category']));
        }

        // Filter by brand
        if (isset($validated['brand_id'])) {
            $query->where('brand_id', $validated['brand_id']);
        }

        // Name search
        if (isset($validated['search'])) {
            $query->where('name', 'like', '%' . $validated['search'] . '%');
        }

        // Sorting
        $sort = $validated['sort'] ?? 'newest';
        switch ($sort) {
            case 'price-asc':
                $query->orderBy('price', 'asc');
                break;
            case 'price-desc':
                $query->orderBy('price', 'desc');
                break;
            case 'name-asc':
                $query->orderBy('name', 'asc');
                break;
            default:
                $query->orderBy('created_at', 'desc');
                break;
        }

        // Pagination cap at 50 to prevent abuse
        $perPage = min((int) ($validated['per_page'] ?? 20), 50);
        $products = $query->paginate($perPage)->withQueryString();

        return ProductResource::collection($products);
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product): ProductResource
    {
        $product->loadMissing(['category', 'brand', 'compatibleModels.brand', 'images']);
        return new ProductResource($product);
    }
}
