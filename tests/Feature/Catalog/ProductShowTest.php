<?php

namespace Tests\Feature\Catalog;

use App\Models\Brand;
use App\Models\Category;
use App\Models\PrinterModel;
use App\Models\Product;
use Tests\TestCase;

class ProductShowTest extends TestCase
{
    public function test_product_show_renders_successfully(): void
    {
        $category = Category::firstOrCreate(['slug' => 'toners'], ['name' => 'Toners']);
        $brand = Brand::firstOrCreate(['slug' => 'hp'], ['name' => 'HP']);

        $product = Product::create([
            'category_id' => $category->id,
            'brand_id' => $brand->id,
            'name' => 'HP 58A Black Toner',
            'slug' => 'hp-58a-black-toner',
            'price' => 85.00,
            'stock' => 15,
            'description' => 'Original HP LaserJet Toner Cartridge.',
        ]);

        $model = PrinterModel::firstOrCreate(
            ['slug' => 'laserjet-pro-m404dn'],
            ['brand_id' => $brand->id, 'model_name' => 'LaserJet Pro M404dn']
        );
        $product->compatibleModels()->attach($model->id);

        $response = $this->get(route('products.show', $product));

        $response->assertStatus(200);
        $response->assertViewIs('products.show');
        $response->assertViewHas('product');
        $response->assertSee('HP 58A Black Toner');
        $response->assertSee('LaserJet Pro M404dn');
    }
}
