<?php

namespace App\Observers;

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
        Cache::forget('homepage_curated_products');
        Cache::forget('catalog_categories_list');
        Cache::forget('homepage_curated_product_ids');
        Cache::forget('catalog_category_ids');
        Cache::forget('catalog_category_ids_v2');
        Cache::forget('all_active_category_ids_v2');

        if ($product->category_id) {
            Cache::forget("category_brands_{$product->category_id}");
            Cache::forget("category_brand_ids_{$product->category_id}");
            Cache::forget("category_brand_ids_v2_{$product->category_id}");
        }

        // If the category was modified, flush the old category's brand cache as well
        if ($product->wasChanged('category_id') && $product->getOriginal('category_id')) {
            $oldId = $product->getOriginal('category_id');
            Cache::forget("category_brands_{$oldId}");
            Cache::forget("category_brand_ids_{$oldId}");
            Cache::forget("category_brand_ids_v2_{$oldId}");
        }
    }
}
