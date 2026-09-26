<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class CategoryController extends Controller
{
    public function index()
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
     * Return a single category by ID or slug,
     * with its products paginated.
     */
    public function show(Category $category)
    {
        // Category model handles ID/slug resolution via resolveRouteBinding
        $category->loadCount('products');
        return new CategoryResource($category);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
