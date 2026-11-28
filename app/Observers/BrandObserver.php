<?php

namespace App\Observers;

use App\Models\Brand;
use Illuminate\Support\Facades\Cache;

class BrandObserver
{
    /**
     * Handle the Brand "saved" event (covers create and update).
     */
    public function saved(Brand $brand): void
    {
        $this->flushBrandCaches($brand);
    }

    /**
     * Handle the Brand "deleted" event.
     */
    public function deleted(Brand $brand): void
    {
        $this->flushBrandCaches($brand);
    }

    /**
     * Flush all brand-dependent cached data.
     */
    private function flushBrandCaches(Brand $brand): void
    {
        Cache::forget(config('catalog.cache.keys.homepage_curated', 'homepage_curated_products'));
        Cache::forget(config('catalog.cache.keys.catalog_categories', 'catalog_categories_list'));
        Cache::forget('printer_brands_list');

        $prefix = (string) config('catalog.cache.keys.category_brands_prefix', 'category_brands_');
        $categoryIds = $brand->products()->distinct()->pluck('category_id')->filter()->all();
        foreach ($categoryIds as $catId) {
            Cache::forget("{$prefix}{$catId}");
        }
    }
}
