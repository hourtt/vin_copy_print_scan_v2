<?php

namespace App\Observers;

use App\Models\Category;
use Illuminate\Support\Facades\Cache;

class CategoryObserver
{
    /**
     * Handle the Category "saved" event (covers create and update).
     */
    public function saved(Category $category): void
    {
        $this->flushCategoryCaches($category);
    }

    /**
     * Handle the Category "deleted" event.
     */
    public function deleted(Category $category): void
    {
        $this->flushCategoryCaches($category);
    }

    /**
     * Flush all category-dependent cached data.
     */
    private function flushCategoryCaches(Category $category): void
    {
        Cache::forget('catalog_categories_list');
        Cache::forget('homepage_curated_products');
        Cache::forget("category_brands_{$category->id}");

        // Clear legacy / fallback keys
        Cache::forget('homepage_curated_product_ids');
        Cache::forget('catalog_category_ids');
        Cache::forget('catalog_category_ids_v2');
        Cache::forget('all_active_category_ids_v2');
        Cache::forget("category_brand_ids_{$category->id}");
        Cache::forget("category_brand_ids_v2_{$category->id}");
    }
}
