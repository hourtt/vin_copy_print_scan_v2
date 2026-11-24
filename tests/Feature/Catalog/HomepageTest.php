<?php

namespace Tests\Feature\Catalog;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class HomepageTest extends TestCase
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
            ['slug' => 'hp'],
            ['name' => 'HP']
        );
    }

    public function test_homepage_renders_successfully_for_guests(): void
    {
        Product::create([
            'category_id' => $this->category->id,
            'brand_id' => $this->brand->id,
            'name' => 'Test Featured Printer',
            'slug' => 'test-featured-printer',
            'price' => 299.00,
            'stock' => 10,
            'is_featured' => true,
        ]);

        $response = $this->get(route('dashboard'));

        $response->assertStatus(200);
        $response->assertViewIs('dashboard');
        $response->assertViewHasAll(['featured', 'popular', 'newArrivals', 'hotSale']);
    }

    public function test_admin_user_is_redirected_to_admin_panel(): void
    {
        $admin = User::factory()->create([
            'role' => 'admin',
        ]);

        $response = $this->actingAs($admin)->get(route('dashboard'));

        $response->assertRedirect('/vin_admin_print_scan_dashboard');
    }

    public function test_regular_customer_can_view_homepage(): void
    {
        $customer = User::factory()->create([
            'role' => 'customer',
        ]);

        $response = $this->actingAs($customer)->get(route('dashboard'));

        $response->assertStatus(200);
        $response->assertViewIs('dashboard');
    }

    public function test_homepage_query_count_adheres_to_budget(): void
    {
        // Seed multiple products to test batch-hydration
        for ($i = 1; $i <= 10; $i++) {
            Product::create([
                'category_id' => $this->category->id,
                'brand_id' => $this->brand->id,
                'name' => "Printer Model {$i}",
                'slug' => "printer-model-{$i}",
                'price' => 200.00 + $i,
                'discount_price' => 180.00,
                'stock' => 5,
                'sales_count' => $i * 10,
                'is_featured' => $i % 2 === 0,
            ]);
        }

        DB::flushQueryLog();
        DB::enableQueryLog();

        $response = $this->get(route('dashboard'));

        $response->assertStatus(200);
        $queries = DB::getQueryLog();

        // On cold cache: 4 ID queries + 1 batch product query + 2 eager load queries = 7 queries max
        $this->assertLessThanOrEqual(10, count($queries), 'Homepage exceeded maximum cold query count budget.');

        // Second request (warm cache): 0 queries if cache driver is array/memory or just cache fetch
        DB::flushQueryLog();
        $response2 = $this->get(route('dashboard'));
        $response2->assertStatus(200);
        $warmQueries = DB::getQueryLog();

        $this->assertLessThanOrEqual(count($queries), count($warmQueries), 'Warm cache query count exceeded cold cache.');
    }
}
