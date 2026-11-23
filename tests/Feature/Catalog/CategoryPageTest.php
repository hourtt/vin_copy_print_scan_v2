<?php

namespace Tests\Feature\Catalog;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class CategoryPageTest extends TestCase
{
    private Category $category;

    private Brand $brand;

    protected function setUp(): void
    {
        parent::setUp();

        $this->category = Category::firstOrCreate(
            ['slug' => 'printers'],
            ['name' => 'Printers', 'sort_order' => 1]
        );

        $this->brand = Brand::firstOrCreate(
            ['slug' => 'brother'],
            ['name' => 'Brother']
        );
    }

    public function test_category_resolved_by_slug_and_by_alias(): void
    {
        Product::create([
            'category_id' => $this->category->id,
            'brand_id' => $this->brand->id,
            'name' => 'Brother Laser Printer',
            'slug' => 'brother-laser-printer',
            'price' => 250.00,
            'stock' => 10,
        ]);

        // Direct route: /printers
        $response1 = $this->get('/printers');
        $response1->assertStatus(200);

        // Alias via dynamic route: /category/printer
        $response2 = $this->get('/category/printer');
        $response2->assertStatus(200);

        // Canonical via dynamic route: /category/printers
        $response3 = $this->get('/category/printers');
        $response3->assertStatus(200);
    }

    public function test_unknown_category_returns_404(): void
    {
        $response = $this->get('/category/non-existent-category');

        $response->assertStatus(404);
    }

    public function test_ajax_category_request_returns_json_with_html_and_count(): void
    {
        Product::create([
            'category_id' => $this->category->id,
            'brand_id' => $this->brand->id,
            'name' => 'Printer Model X',
            'slug' => 'printer-model-x',
            'price' => 300.00,
            'stock' => 8,
        ]);

        $response = $this->getJson('/printers');

        $response->assertStatus(200);
        $response->assertJsonStructure(['html', 'count']);
        $this->assertEquals(1, $response->json('count'));
        $this->assertStringContainsString('Printer Model X', $response->json('html'));
    }

    public function test_ajax_category_filtering_by_brand_pill(): void
    {
        $brother = $this->brand;
        $canon = Brand::firstOrCreate(['slug' => 'canon'], ['name' => 'Canon']);

        $p1 = Product::create([
            'category_id' => $this->category->id,
            'brand_id' => $brother->id,
            'name' => 'Brother Printer One',
            'slug' => 'brother-printer-one',
            'price' => 200.00,
            'stock' => 5,
        ]);

        $p2 = Product::create([
            'category_id' => $this->category->id,
            'brand_id' => $canon->id,
            'name' => 'Canon Printer Two',
            'slug' => 'canon-printer-two',
            'price' => 250.00,
            'stock' => 5,
        ]);

        // Request with cat={brother->id} sent by frontend category-filter.js
        $response = $this->getJson("/printers?cat={$brother->id}");

        $response->assertStatus(200);
        $this->assertEquals(1, $response->json('count'));
        $this->assertStringContainsString('Brother Printer One', $response->json('html'));
        $this->assertStringNotContainsString('Canon Printer Two', $response->json('html'));
    }

    public function test_category_page_query_count_adheres_to_budget(): void
    {
        for ($i = 1; $i <= 8; $i++) {
            Product::create([
                'category_id' => $this->category->id,
                'brand_id' => $this->brand->id,
                'name' => "Printer Benchmark {$i}",
                'slug' => "printer-benchmark-{$i}",
                'price' => 150.00 + $i,
                'stock' => 10,
            ]);
        }

        DB::flushQueryLog();
        DB::enableQueryLog();

        $response = $this->get('/printers');

        $response->assertStatus(200);
        $queries = DB::getQueryLog();

        // Target: Category resolve (1) + Count (1) + Products (1) + Eager Brands (1) + Brand pills (1) = 5 queries max
        $this->assertLessThanOrEqual(8, count($queries), 'Category page exceeded maximum query count budget.');
    }
}
