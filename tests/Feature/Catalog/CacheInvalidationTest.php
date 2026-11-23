<?php

namespace Tests\Feature\Catalog;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Facades\Cache;
use Tests\TestCase;

class CacheInvalidationTest extends TestCase
{
    public function test_product_update_invalidates_caches(): void
    {
        $category = Category::firstOrCreate(['slug' => 'printers'], ['name' => 'Printers']);
        $brand = Brand::firstOrCreate(['slug' => 'epson'], ['name' => 'Epson']);

        $product = Product::create([
            'category_id' => $category->id,
            'brand_id' => $brand->id,
            'name' => 'Epson EcoTank L3250',
            'slug' => 'epson-ecotank-l3250',
            'price' => 219.00,
            'stock' => 10,
        ]);

        // Prime cache keys
        Cache::put('homepage_curated_products', ['seeded'], 3600);
        Cache::put("category_brands_{$category->id}", ['seeded'], 3600);

        $this->assertTrue(Cache::has('homepage_curated_products'));
        $this->assertTrue(Cache::has("category_brands_{$category->id}"));

        // Update product
        $product->update(['price' => 199.00]);

        // Assert caches are cleared
        $this->assertFalse(Cache::has('homepage_curated_products'));
        $this->assertFalse(Cache::has("category_brands_{$category->id}"));
    }

    public function test_category_update_invalidates_category_cache(): void
    {
        $category = Category::firstOrCreate(['slug' => 'paper'], ['name' => 'Paper']);

        Cache::put('catalog_categories_list', ['seeded'], 3600);
        $this->assertTrue(Cache::has('catalog_categories_list'));

        $category->update(['name' => 'Premium Paper']);

        $this->assertFalse(Cache::has('catalog_categories_list'));
    }

    public function test_brand_update_invalidates_brand_and_catalog_caches(): void
    {
        $category = Category::firstOrCreate(['slug' => 'printers'], ['name' => 'Printers']);
        $brand = Brand::firstOrCreate(['slug' => 'canon'], ['name' => 'Canon']);

        Product::create([
            'category_id' => $category->id,
            'brand_id' => $brand->id,
            'name' => 'Canon G2020',
            'slug' => 'canon-g2020',
            'price' => 160.00,
            'stock' => 5,
        ]);

        Cache::put("category_brands_{$category->id}", ['seeded'], 3600);
        $this->assertTrue(Cache::has("category_brands_{$category->id}"));

        $brand->update(['name' => 'Canon Inc.']);

        $this->assertFalse(Cache::has("category_brands_{$category->id}"));
    }
}
