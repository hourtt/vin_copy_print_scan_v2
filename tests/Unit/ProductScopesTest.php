<?php

namespace Tests\Unit;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Tests\TestCase;

class ProductScopesTest extends TestCase
{
    private Category $category;

    private Brand $brand;

    protected function setUp(): void
    {
        parent::setUp();

        $this->category = Category::firstOrCreate(['slug' => 'printers'], ['name' => 'Printers']);
        $this->brand = Brand::firstOrCreate(['slug' => 'hp'], ['name' => 'HP']);
    }

    public function test_scope_in_stock(): void
    {
        $inStock = Product::create([
            'category_id' => $this->category->id,
            'name' => 'In Stock Item',
            'slug' => 'in-stock-item',
            'price' => 100.00,
            'stock' => 5,
        ]);

        $outOfStock = Product::create([
            'category_id' => $this->category->id,
            'name' => 'Out of Stock Item',
            'slug' => 'out-of-stock-item',
            'price' => 100.00,
            'stock' => 0,
        ]);

        $results = Product::inStock()->get();

        $this->assertTrue($results->contains('id', $inStock->id));
        $this->assertFalse($results->contains('id', $outOfStock->id));
    }

    public function test_scope_on_sale(): void
    {
        $saleItem = Product::create([
            'category_id' => $this->category->id,
            'name' => 'Sale Item',
            'slug' => 'sale-item',
            'price' => 100.00,
            'discount_price' => 80.00,
            'stock' => 5,
        ]);

        $regularItem = Product::create([
            'category_id' => $this->category->id,
            'name' => 'Regular Item',
            'slug' => 'regular-item',
            'price' => 100.00,
            'discount_price' => null,
            'stock' => 5,
        ]);

        $zeroDiscountItem = Product::create([
            'category_id' => $this->category->id,
            'name' => 'Zero Discount Item',
            'slug' => 'zero-discount-item',
            'price' => 800.00,
            'discount_price' => 0,
            'stock' => 5,
        ]);

        $equalDiscountItem = Product::create([
            'category_id' => $this->category->id,
            'name' => 'Equal Discount Item',
            'slug' => 'equal-discount-item',
            'price' => 800.00,
            'discount_price' => 800.00,
            'stock' => 5,
        ]);

        $results = Product::onSale()->get();

        $this->assertTrue($results->contains('id', $saleItem->id));
        $this->assertFalse($results->contains('id', $regularItem->id));
        $this->assertFalse($results->contains('id', $zeroDiscountItem->id));
        $this->assertFalse($results->contains('id', $equalDiscountItem->id));

        $this->assertNull($zeroDiscountItem->discount_price);
        $this->assertFalse($zeroDiscountItem->is_on_sale);
        $this->assertSame('800.00', $zeroDiscountItem->effective_price);

        $this->assertNull($equalDiscountItem->discount_price);
        $this->assertFalse($equalDiscountItem->is_on_sale);
        $this->assertSame('800.00', $equalDiscountItem->effective_price);
    }

    public function test_scope_popular(): void
    {
        $lessPopular = Product::create([
            'category_id' => $this->category->id,
            'name' => 'Low Sales',
            'slug' => 'low-sales',
            'price' => 50.00,
            'stock' => 5,
            'sales_count' => 2,
        ]);

        $morePopular = Product::create([
            'category_id' => $this->category->id,
            'name' => 'High Sales',
            'slug' => 'high-sales',
            'price' => 50.00,
            'stock' => 5,
            'sales_count' => 100,
        ]);

        $results = Product::popular()->get();

        $this->assertEquals($morePopular->id, $results->first()->id);
    }

    public function test_scope_filter_with_search_and_brand_id(): void
    {
        $canon = Brand::firstOrCreate(['slug' => 'canon'], ['name' => 'Canon']);

        $hpProduct = Product::create([
            'category_id' => $this->category->id,
            'brand_id' => $this->brand->id,
            'name' => 'HP LaserJet Pro',
            'slug' => 'hp-laserjet-pro',
            'price' => 200.00,
            'stock' => 5,
        ]);

        $canonProduct = Product::create([
            'category_id' => $this->category->id,
            'brand_id' => $canon->id,
            'name' => 'Canon PIXMA',
            'slug' => 'canon-pixma',
            'price' => 150.00,
            'stock' => 5,
        ]);

        $results = Product::filter([
            'search' => 'LaserJet',
            'brand_id' => $this->brand->id,
        ])->get();

        $this->assertTrue($results->contains('id', $hpProduct->id));
        $this->assertFalse($results->contains('id', $canonProduct->id));
    }
}
