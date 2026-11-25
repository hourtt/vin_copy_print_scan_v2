<?php

namespace App\Observers;

use App\Http\Controllers\Api\CategoryController;
use App\Models\Product;
use Illuminate\Support\Facades\Cache;

class ProductObserver
{
    /**
     * Handle the Product "saved" event (covers create and update).
     */
    public function saved(Product $product): void
    {
        $this->flushProductCaches($product);
    }

    /**
     * Handle the Product "deleted" event.
     */
    public function deleted(Product $product): void
    {
        $this->flushProductCaches($product);
    }

    /**
     * Handle the Product "restored" event.
     */
    public function restored(Product $product): void
    {
        $this->flushProductCaches($product);
    }

    /**
     * Handle the Product "forceDeleted" event.
     */
    public function forceDeleted(Product $product): void
    {
        $this->flushProductCaches($product);
    }

    /**
     * Flush all product-dependent cached data.
     */
    private function flushProductCaches(Product $product): void
    {
        Cache::forget(config('catalog.cache.keys.homepage_curated', 'homepage_curated_products'));
        Cache::forget(config('catalog.cache.keys.catalog_categories', 'catalog_categories_list'));
        Cache::forget(CategoryController::CACHE_KEY);

        $prefix = (string) config('catalog.cache.keys.category_brands_prefix', 'category_brands_');

        if ($product->category_id) {
            Cache::forget("{$prefix}{$product->category_id}");
        }

        // If the category was modified, flush the old category's brand cache as well
        if ($product->wasChanged('category_id') && $product->getOriginal('category_id')) {
            $oldId = $product->getOriginal('category_id');
            Cache::forget("{$prefix}{$oldId}");
        }
    }
}
