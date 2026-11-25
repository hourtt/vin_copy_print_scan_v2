<?php

namespace App\Observers;

use App\Http\Controllers\Api\CategoryController;
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
        Cache::forget(config('catalog.cache.keys.catalog_categories', 'catalog_categories_list'));
        Cache::forget(config('catalog.cache.keys.homepage_curated', 'homepage_curated_products'));
        Cache::forget(CategoryController::CACHE_KEY);

        $prefix = (string) config('catalog.cache.keys.category_brands_prefix', 'category_brands_');
        Cache::forget("{$prefix}{$category->id}");
    }
}
