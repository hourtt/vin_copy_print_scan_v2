<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreProductRequest;
use App\Http\Requests\Admin\UpdateProductRequest;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AdminProductController extends Controller
{
    /**
     * Display the paginated product list with search and filters.
     */
    public function index(Request $request)
    {
        $query = Product::with('category', 'brand', 'images')
            ->withTrashed(); // Include soft-deleted so admin can see them

        // Search
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // Category filter
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        // Brand filter
        if ($request->filled('brand_id')) {
            $query->where('brand_id', $request->brand_id);
        }

        // Stock filter
        if ($request->filled('stock_status')) {
            match ($request->stock_status) {
                'in_stock'    => $query->where('stock', '>', 0)->whereNull('deleted_at'),
                'low_stock'   => $query->whereBetween('stock', [1, 5])->whereNull('deleted_at'),
                'out_of_stock'=> $query->where('stock', 0)->whereNull('deleted_at'),
                'deleted'     => $query->onlyTrashed(),
                default       => null,
            };
        } else {
            $query->whereNull('deleted_at'); // Default: only active
        }

        // Sort
        $sort = $request->query('sort', 'newest');
        match ($sort) {
            'price_asc'  => $query->orderBy('price', 'asc'),
            'price_desc' => $query->orderBy('price', 'desc'),
            'name_asc'   => $query->orderBy('name', 'asc'),
            'stock_desc' => $query->orderBy('stock', 'desc'),
            default      => $query->latest(),
        };

        $products   = $query->paginate(15)->withQueryString();
        $categories = Category::orderBy('name')->get();
        $brands     = Brand::orderBy('name')->get();

        return view('admin.products.index', compact('products', 'categories', 'brands'));
    }

    /**
     * Show the create form.
     */
    public function create()
    {
        $categories = Category::orderBy('sort_order')->get();
        $brands     = Brand::orderBy('name')->get();
        return view('admin.products.create', compact('categories', 'brands'));
    }

    /**
     * Store a new product with gallery images.
     */
    public function store(StoreProductRequest $request)
    {
        DB::transaction(function () use ($request) {
            $data = $request->validated();

            // Auto-generate slug if not provided
            $data['slug'] = $data['slug'] ?? Str::slug($data['name']);

            // Create the product
            $product = Product::create($data);

            // Handle gallery image uploads
            if ($request->hasFile('images')) {
                $isPrimary = true;
                foreach ($request->file('images') as $file) {
                    $path = $file->store('products', 'public');
                    ProductImage::create([
                        'product_id' => $product->id,
                        'image_path' => $path,
                        'is_primary' => $isPrimary,
                        'sort_order' => $isPrimary ? 0 : 1,
                    ]);
                    // Set the products.image column from the first uploaded image
                    if ($isPrimary) {
                        $product->update(['image' => $path]);
                        $isPrimary = false;
                    }
                }
            }
        });

        return redirect()->route('admin.products.index')
            ->with('success', 'Product created successfully.');
    }

    /**
     * Show product detail.
     */
    public function show(Product $product)
    {
        $product->load('category', 'brand', 'images', 'compatibleModels.brand');
        return view('admin.products.show', compact('product'));
    }

    /**
     * Show the edit form.
     */
    public function edit(Product $product)
    {
        $product->load('images');
        $categories = Category::orderBy('sort_order')->get();
        $brands     = Brand::orderBy('name')->get();
        return view('admin.products.edit', compact('product', 'categories', 'brands'));
    }

    /**
     * Update the product and manage gallery images.
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        DB::transaction(function () use ($request, $product) {
            $data = $request->validated();

            // Auto-generate slug if cleared
            $data['slug'] = $data['slug'] ?? Str::slug($data['name']);

            // Delete explicitly removed images
            if ($request->filled('delete_images')) {
                $toDelete = ProductImage::whereIn('id', $request->delete_images)
                    ->where('product_id', $product->id)
                    ->get();

                // 1. Loop ONLY to remove physical files from disk
                foreach ($toDelete as $image) {
                    Storage::disk('public')->delete($image->image_path);
                }

                // 2. Delete all database records in 1 single SQL query!
                ProductImage::whereIn('id', $toDelete->pluck('id'))->delete();
            }

            // Append new gallery images
            if ($request->hasFile('images')) {
                $sortOffset = $product->images()->count();
                foreach ($request->file('images') as $index => $file) {
                    $path = $file->store('products', 'public');
                    ProductImage::create([
                        'product_id' => $product->id,
                        'image_path' => $path,
                        'is_primary' => false,
                        'sort_order' => $sortOffset + $index,
                    ]);
                }
            }

            // Sync products.image with current primary
            $primary = $product->fresh()->images()->where('is_primary', true)->first()
                ?? $product->fresh()->images()->orderBy('sort_order')->first();
            $data['image'] = $primary?->image_path ?? $product->image;

            $product->update($data);
        });

        return redirect()->route('admin.products.edit', $product)
            ->with('success', 'Product updated successfully.');
    }

    /**
     * Soft-delete the product. Blocks deletion if the product has order items.
     */
    public function destroy(Product $product)
    {
        // Safety: refuse hard-delete if order history exists (soft delete is used instead)
        $product->delete(); // Uses SoftDeletes

        return redirect()->route('admin.products.index')
            ->with('success', 'Product archived (soft deleted).');
    }

    /**
     * Toggle is_featured via AJAX.
     */
    public function toggleFeatured(Product $product)
    {
        $product->update(['is_featured' => !$product->is_featured]);
        return response()->json(['is_featured' => $product->is_featured]);
    }

    /**
     * Set a specific image as the product's primary/thumbnail.
     */
    public function setImagePrimary(Product $product, ProductImage $image)
    {
        abort_unless($image->product_id === $product->id, 403);

        // Reset all images to non-primary, then set the chosen one
        $product->images()->update(['is_primary' => false]);
        $image->update(['is_primary' => true]);
        $product->update(['image' => $image->image_path]);

        return response()->json(['success' => true, 'image_path' => $image->image_path]);
    }

    /**
     * Delete a single gallery image.
     */
    public function destroyImage(Product $product, ProductImage $image)
    {
        abort_unless($image->product_id === $product->id, 403);

        Storage::disk('public')->delete($image->image_path);
        $image->delete();

        // If this was primary, promote the next image
        if ($image->is_primary) {
            $next = $product->fresh()->images()->orderBy('sort_order')->first();
            if ($next) {
                $next->update(['is_primary' => true]);
                $product->update(['image' => $next->image_path]);
            } else {
                $product->update(['image' => null]);
            }
        }

        return response()->json(['success' => true]);
    }
}
