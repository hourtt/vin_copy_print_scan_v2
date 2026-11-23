<?php

namespace Tests\Feature\Api;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Tests\TestCase;

class ProductApiTest extends TestCase
{
    private Category $category;

    private Brand $brand;

    protected function setUp(): void
    {
        parent::setUp();

        $this->category = Category::firstOrCreate(
            ['slug' => 'toners'],
            ['name' => 'Toners', 'sort_order' => 1]
        );

        $this->brand = Brand::firstOrCreate(
            ['slug' => 'hp'],
            ['name' => 'HP']
        );
    }

    public function test_api_products_index_returns_paginated_collection(): void
    {
        Product::create([
            'category_id' => $this->category->id,
            'brand_id' => $this->brand->id,
            'name' => 'HP LaserJet Toner 12A',
            'slug' => 'hp-laserjet-toner-12a',
            'price' => 75.00,
            'stock' => 20,
        ]);

        $response = $this->getJson('/api/products');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                '*' => ['id', 'name', 'slug', 'price', 'stock', 'category_id', 'brand_id'],
            ],
            'links',
            'meta',
        ]);
        $this->assertNotEmpty($response->json('data'));
    }

    public function test_api_products_filtering_and_sorting(): void
    {
        $canon = Brand::firstOrCreate(['slug' => 'canon-api'], ['name' => 'Canon']);

        Product::create([
            'category_id' => $this->category->id,
            'brand_id' => $this->brand->id,
            'name' => 'HP High Yield Black',
            'slug' => 'hp-high-yield-black',
            'price' => 100.00,
            'stock' => 15,
        ]);

        Product::create([
            'category_id' => $this->category->id,
            'brand_id' => $canon->id,
            'name' => 'Canon Standard Black',
            'slug' => 'canon-standard-black',
            'price' => 50.00,
            'stock' => 5,
        ]);

        // Filter by brand
        $response = $this->getJson("/api/products?brand_id={$this->brand->id}");
        $response->assertStatus(200);
        $names = collect($response->json('data'))->pluck('name');
        $this->assertTrue($names->contains('HP High Yield Black'));
        $this->assertFalse($names->contains('Canon Standard Black'));

        // Filter by search
        $searchResponse = $this->getJson('/api/products?search=Canon');
        $searchResponse->assertStatus(200);
        $searchNames = collect($searchResponse->json('data'))->pluck('name');
        $this->assertTrue($searchNames->contains('Canon Standard Black'));
        $this->assertFalse($searchNames->contains('HP High Yield Black'));

        // Sorting by price-asc
        $sortResponse = $this->getJson('/api/products?sort=price-asc');
        $sortResponse->assertStatus(200);
        $prices = collect($sortResponse->json('data'))->pluck('price')->values();
        $sortedPrices = $prices->sort()->values();
        $this->assertEquals($sortedPrices->toArray(), $prices->toArray());
    }

    public function test_api_category_alias_routes(): void
    {
        Product::create([
            'category_id' => $this->category->id,
            'brand_id' => $this->brand->id,
            'name' => 'HP Toner Direct',
            'slug' => 'hp-toner-direct',
            'price' => 60.00,
            'stock' => 12,
        ]);

        $response = $this->getJson('/api/toners');
        $response->assertStatus(200);
        $this->assertNotEmpty($response->json('data'));
    }

    public function test_api_categories_index(): void
    {
        $response = $this->getJson('/api/categories');
        $response->assertStatus(200);
        $response->assertJsonStructure(['data']);
    }
}
