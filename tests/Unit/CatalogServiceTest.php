<?php

namespace Tests\Unit;

use App\Models\Category;
use App\Services\Catalog\CatalogService;
use Illuminate\Contracts\Cache\Repository as CacheRepository;
use Illuminate\Contracts\View\Factory as ViewFactory;
use Mockery;
use Tests\TestCase;

class CatalogServiceTest extends TestCase
{
    public function test_view_candidates_order(): void
    {
        $cache = Mockery::mock(CacheRepository::class);
        $viewFactory = Mockery::mock(ViewFactory::class);
        $service = new CatalogService($cache, $viewFactory);

        $category = new Category([
            'name' => 'Printers',
            'slug' => 'printers',
        ]);

        $candidates = $service->viewCandidates($category, 'printer');

        $this->assertEquals([
            'products.printers.index',
            'products.printer.index',
            'products-catalog.index',
        ], $candidates);
    }

    public function test_resolve_view_returns_first_existing(): void
    {
        $cache = Mockery::mock(CacheRepository::class);
        $viewFactory = Mockery::mock(ViewFactory::class);
        $viewFactory->shouldReceive('exists')
            ->with('products.printers.index')
            ->andReturn(true);

        $service = new CatalogService($cache, $viewFactory);

        $category = new Category(['slug' => 'printers']);
        $view = $service->resolveView($category, 'printer');

        $this->assertEquals('products.printers.index', $view);
    }

    public function test_resolve_category_by_alias(): void
    {
        Category::firstOrCreate(['slug' => 'ink-cartridges'], ['name' => 'Ink Cartridges']);

        $cache = Mockery::mock(CacheRepository::class);
        $viewFactory = Mockery::mock(ViewFactory::class);
        $service = new CatalogService($cache, $viewFactory);

        // 'inks' and 'ink' are aliases for 'ink-cartridges'
        $resolved = $service->resolveCategory('inks');
        $this->assertEquals('ink-cartridges', $resolved->slug);

        $resolved2 = $service->resolveCategory('ink');
        $this->assertEquals('ink-cartridges', $resolved2->slug);
    }
}
