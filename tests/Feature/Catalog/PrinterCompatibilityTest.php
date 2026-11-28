<?php

namespace Tests\Feature\Catalog;

use App\Models\Brand;
use App\Models\Category;
use App\Models\PrinterModel;
use App\Models\Product;
use Illuminate\Support\Facades\Cache;
use Tests\TestCase;

class PrinterCompatibilityTest extends TestCase
{
    private Brand $hp;

    private Brand $canon;

    private Category $toners;

    private PrinterModel $hpM404;

    private PrinterModel $canonMf445;

    private Product $hp26aToner;

    private Product $canon054Toner;

    protected function setUp(): void
    {
        parent::setUp();

        $this->hp = Brand::firstOrCreate(['slug' => 'hp'], ['name' => 'HP']);
        $this->canon = Brand::firstOrCreate(['slug' => 'canon'], ['name' => 'Canon']);
        $this->toners = Category::firstOrCreate(['slug' => 'toners'], ['name' => 'Toners', 'type' => 'toner']);

        $this->hpM404 = PrinterModel::firstOrCreate(
            ['slug' => 'hp-laserjet-pro-m404dn'],
            ['brand_id' => $this->hp->id, 'model_name' => 'LaserJet Pro M404dn']
        );

        $this->canonMf445 = PrinterModel::firstOrCreate(
            ['slug' => 'canon-imageclass-mf445dw'],
            ['brand_id' => $this->canon->id, 'model_name' => 'imageCLASS MF445dw']
        );

        $this->hp26aToner = Product::create([
            'category_id' => $this->toners->id,
            'brand_id' => $this->hp->id,
            'name' => 'HP 26A Black Toner',
            'slug' => 'hp-26a-black-toner-test',
            'price' => 89.00,
            'stock' => 10,
        ]);
        $this->hp26aToner->compatibleModels()->attach($this->hpM404->id);

        $this->canon054Toner = Product::create([
            'category_id' => $this->toners->id,
            'brand_id' => $this->canon->id,
            'name' => 'Canon 054 Black Toner',
            'slug' => 'canon-054-black-toner-test',
            'price' => 95.00,
            'stock' => 8,
        ]);
        $this->canon054Toner->compatibleModels()->attach($this->canonMf445->id);
    }

    public function test_compatibility_directory_lists_brands_and_printer_models(): void
    {
        $response = $this->get(route('compatibility.index'));

        $response->assertOk();
        $response->assertSee('Find Supplies by Printer Model');
        $response->assertSee('LaserJet Pro M404dn');
        $response->assertSee('imageCLASS MF445dw');
    }

    public function test_compatibility_directory_filters_by_brand_and_search(): void
    {
        $response = $this->get(route('compatibility.index', [
            'brand' => 'hp',
            'search' => 'm404',
        ]));

        $response->assertOk();
        $response->assertSee('LaserJet Pro M404dn');
        $response->assertDontSee('imageCLASS MF445dw');
    }

    public function test_compatibility_show_displays_only_compatible_products(): void
    {
        $response = $this->get(route('compatibility.show', $this->hpM404));

        $response->assertOk();
        $response->assertSee('HP LaserJet Pro M404dn');
        $response->assertSee('HP 26A Black Toner');
        $response->assertDontSee('Canon 054 Black Toner');
    }

    public function test_product_show_links_compatible_printer_models(): void
    {
        $response = $this->get(route('products.show', $this->hp26aToner));

        $response->assertOk();
        $response->assertSee(route('compatibility.show', $this->hpM404));
        $response->assertSee('HP LaserJet Pro M404dn');
    }

    public function test_catalog_and_api_filter_by_printer_model_id(): void
    {
        $catalogResponse = $this->get(route('product-catalog.index', [
            'printer_model_id' => $this->hpM404->id,
        ]));

        $catalogResponse->assertOk();
        $products = $catalogResponse->viewData('products');
        $this->assertTrue($products->contains('id', $this->hp26aToner->id));
        $this->assertFalse($products->contains('id', $this->canon054Toner->id));

        $apiResponse = $this->getJson("/api/products?printer_model_id={$this->hpM404->id}");
        $apiResponse->assertOk();
        $ids = collect($apiResponse->json('data'))->pluck('id');
        $this->assertTrue($ids->contains($this->hp26aToner->id));
        $this->assertFalse($ids->contains($this->canon054Toner->id));
    }

    public function test_api_printers_supports_search_and_slug_lookup(): void
    {
        $indexResponse = $this->getJson('/api/printers?search=m404');
        $indexResponse->assertOk();
        $slugs = collect($indexResponse->json('data'))->pluck('slug');
        $this->assertTrue($slugs->contains('hp-laserjet-pro-m404dn'));
        $this->assertFalse($slugs->contains('canon-imageclass-mf445dw'));

        $showBySlug = $this->getJson('/api/printers/hp-laserjet-pro-m404dn');
        $showBySlug->assertOk();
        $showBySlug->assertJsonPath('data.slug', 'hp-laserjet-pro-m404dn');
        $this->assertCount(1, $showBySlug->json('data.compatible_products'));
    }

    public function test_printer_model_observer_invalidates_printer_brands_cache(): void
    {
        Cache::put('printer_brands_list', ['cached'], 3600);
        $this->assertTrue(Cache::has('printer_brands_list'));

        PrinterModel::create([
            'brand_id' => $this->hp->id,
            'model_name' => 'LaserJet Pro M203dw',
            'slug' => 'hp-laserjet-pro-m203dw-cache-test',
        ]);

        $this->assertFalse(Cache::has('printer_brands_list'));
    }
}
