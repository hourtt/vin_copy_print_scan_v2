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
        Cache::forget('homepage_curated_products');
        Cache::forget('catalog_categories_list');

        $categoryIds = $brand->products()->distinct()->pluck('category_id')->filter()->all();
        foreach ($categoryIds as $catId) {
            Cache::forget("category_brands_{$catId}");
            Cache::forget("category_brand_ids_{$catId}");
            Cache::forget("category_brand_ids_v2_{$catId}");
        }
    }
}
