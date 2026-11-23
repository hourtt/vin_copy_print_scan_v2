<?php

namespace Tests\Feature\Catalog;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Tests\TestCase;

class CatalogFilterTest extends TestCase
{
    private Category $category1;

    private Category $category2;

    private Brand $brand;

    protected function setUp(): void
    {
        parent::setUp();

        $this->category1 = Category::firstOrCreate(['slug' => 'printers'], ['name' => 'Printers']);
        $this->category2 = Category::firstOrCreate(['slug' => 'paper'], ['name' => 'Paper']);
        $this->brand = Brand::firstOrCreate(['slug' => 'canon'], ['name' => 'Canon']);
    }

    public function test_catalog_renders_with_pagination_and_categories(): void
    {
        Product::create([
            'category_id' => $this->category1->id,
            'name' => 'Test Product 1',
            'slug' => 'test-product-1',
            'price' => 100.00,
            'stock' => 5,
        ]);

        $response = $this->get(route('product-catalog.index'));

        $response->assertStatus(200);
        $response->assertViewIs('products-catalog.index');
        $response->assertViewHasAll(['products', 'categories', 'items']);
    }

    public function test_catalog_filters_by_category_ids(): void
    {
        $product1 = Product::create([
            'category_id' => $this->category1->id,
            'name' => 'Printer Alfa',
            'slug' => 'printer-alfa',
            'price' => 100.00,
            'stock' => 5,
        ]);

        $product2 = Product::create([
            'category_id' => $this->category2->id,
            'name' => 'Paper Beta',
            'slug' => 'paper-beta',
            'price' => 15.00,
            'stock' => 50,
        ]);

        $response = $this->get(route('product-catalog.index', [
            'categories' => [$this->category1->id],
        ]));

        $response->assertStatus(200);
        $products = $response->viewData('products');
        $this->assertTrue($products->contains('id', $product1->id));
        $this->assertFalse($products->contains('id', $product2->id));
    }

    public function test_catalog_filters_by_price_range(): void
    {
        $cheap = Product::create([
            'category_id' => $this->category1->id,
            'name' => 'Cheap Product',
            'slug' => 'cheap-product',
            'price' => 20.00,
            'stock' => 5,
        ]);

        $expensive = Product::create([
            'category_id' => $this->category1->id,
            'name' => 'Expensive Product',
            'slug' => 'expensive-product',
            'price' => 200.00,
            'stock' => 5,
        ]);

        $response = $this->get(route('product-catalog.index', [
            'min_price' => 50,
            'max_price' => 250,
        ]));

        $response->assertStatus(200);
        $products = $response->viewData('products');
        $this->assertTrue($products->contains('id', $expensive->id));
        $this->assertFalse($products->contains('id', $cheap->id));
    }

    public function test_catalog_sorting_orders_correctly(): void
    {
        $p1 = Product::create([
            'category_id' => $this->category1->id,
            'name' => 'Product 1',
            'slug' => 'product-1',
            'price' => 50.00,
            'stock' => 5,
        ]);

        $p2 = Product::create([
            'category_id' => $this->category1->id,
            'name' => 'Product 2',
            'slug' => 'product-2',
            'price' => 150.00,
            'stock' => 5,
        ]);

        // Price Ascending
        $responseAsc = $this->get(route('product-catalog.index', ['sort' => 'price_asc']));
        $responseAsc->assertStatus(200);
        $firstAsc = $responseAsc->viewData('products')->first();
        $this->assertEquals($p1->id, $firstAsc->id);

        // Price Descending
        $responseDesc = $this->get(route('product-catalog.index', ['sort' => 'price_desc']));
        $responseDesc->assertStatus(200);
        $firstDesc = $responseDesc->viewData('products')->first();
        $this->assertEquals($p2->id, $firstDesc->id);
    }

    public function test_invalid_filter_input_returns_validation_error(): void
    {
        // categories not an array
        $response = $this->getJson(route('product-catalog.index', [
            'categories' => 'not-an-array',
        ]));

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['categories']);
    }
}
