<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Cache;

class CategoryController extends Controller
{
    /**
     * Display a listing of categories with product counts, cached.
     */
    public function index(): JsonResponse
    {
        $data = Cache::remember('api_categories_with_count', 3600, function () {
            $categories = Category::withCount('products')
                ->orderBy('sort_order')
                ->get();

            return CategoryResource::collection($categories)->resolve();
        });

        return response()->json(['data' => $data]);
    }

    /**
     * Return a single category by ID or slug with product count.
     */
    public function show(Category $category): CategoryResource
    {
        // Category model handles ID/slug resolution via resolveRouteBinding
        $category->loadCount('products');

        return new CategoryResource($category);
    }
}
