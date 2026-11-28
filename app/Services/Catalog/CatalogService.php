<?php

namespace App\Services\Catalog;

use App\Models\Brand;
use App\Models\Category;
use App\Models\PrinterModel;
use App\Models\Product;
use Illuminate\Contracts\Cache\Repository as CacheRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Contracts\View\Factory as ViewFactory;
use Illuminate\Support\Collection;

class CatalogService
{
    public function __construct(
        private readonly CacheRepository $cache,
        private readonly ViewFactory $viewFactory,
    ) {}

    /**
     * Paginate products for the full product catalog.
     *
     * @param  array<string, mixed>  $filters
     */
    public function paginateCatalog(array $filters, int $perPage = 12): LengthAwarePaginator
    {
        return Product::with('category')
            ->filter($filters)
            ->paginate($perPage)
            ->withQueryString();
    }

    /**
     * Paginate products for a specific category.
     *
     * @param  array<string, mixed>  $filters
     */
    public function paginateCategory(
        Category $category,
        array $filters,
        bool $isAjax = false,
        int $perPage = 20
    ): LengthAwarePaginator {
        $eagerLoad = $isAjax && ! $category->isPaper()
            ? ['brand']
            : ['category', 'brand'];

        return Product::with($eagerLoad)
            ->where('category_id', $category->id)
            ->filter($filters)
            ->paginate($perPage)
            ->withQueryString();
    }

    /**
     * Get all active categories for sidebar filters, cached.
     *
     * @return Collection<int, Category>
     */
    public function sidebarCategories(): Collection
    {
        $ttl = (int) config('catalog.cache.catalog_categories_ttl', 43200);
        $key = (string) config('catalog.cache.keys.catalog_categories', 'catalog_categories_list');

        $data = $this->cache->get($key);

        // If not cached or corrupted (e.g. __PHP_Incomplete_Class), re-query and re-cache clean scalar arrays
        if (! is_array($data)) {
            $this->cache->forget($key);

            $data = Category::select('id', 'name', 'slug')
                ->orderBy('name')
                ->get()
                ->map(fn (Category $c) => ['id' => $c->id, 'name' => $c->name, 'slug' => $c->slug])
                ->all();

            $this->cache->put($key, $data, $ttl);
        }

        return collect($data)->map(fn (array $item) => (new Category)->forceFill($item));
    }

    /**
     * Get brands that have products in this category, cached.
     *
     * @return Collection<int, Brand>
     */
    public function brandsForCategory(Category $category): Collection
    {
        $ttl = (int) config('catalog.cache.category_brands_ttl', 43200);
        $key = "category_brands_{$category->id}";

        $data = $this->cache->get($key);

        // If not cached or corrupted (e.g. __PHP_Incomplete_Class), re-query and re-cache clean scalar arrays
        if (!\is_array($data)) {
            $this->cache->forget($key);

            $data = Brand::whereHas('products', fn ($q) => $q->where('category_id', $category->id))
                ->orderBy('name')
                ->get()
                ->map(fn (Brand $b) => ['id' => $b->id, 'name' => $b->name, 'slug' => $b->slug])
                ->all();

            $this->cache->put($key, $data, $ttl);
        }

        return collect($data)->map(fn (array $item) => (new Brand)->forceFill($item));
    }

    /**
     * Resolve a category by slug or alias.
     */
    public function resolveCategory(string $slug): Category
    {
        return Category::resolveBySlug($slug);
    }

    /**
     * Determine view candidate hierarchy for category rendering.
     *
     * @return array<int, string>
     */
    public function viewCandidates(Category $category, string $categorySlug): array
    {
        return [
            "products.{$category->slug}.index",
            "products.{$categorySlug}.index",
            'products-catalog.index',
        ];
    }

    /**
     * Resolve the first existing view template for a category.
     */
    public function resolveView(Category $category, string $categorySlug): string
    {
        foreach ($this->viewCandidates($category, $categorySlug) as $view) {
            if ($this->viewFactory->exists($view)) {
                return $view;
            }
        }

        return 'products-catalog.index';
    }

    /**
     * Get brands that have printer models in the compatibility directory, cached.
     *
     * @return Collection<int, Brand>
     */
    public function printerBrands(): Collection
    {
        $ttl = (int) config('catalog.cache.catalog_categories_ttl', 43200);
        $key = 'printer_brands_list';

        $data = $this->cache->get($key);

        if (! \is_array($data)) {
            $this->cache->forget($key);

            $data = Brand::whereHas('printerModels')
                ->orderBy('name')
                ->get()
                ->map(fn (Brand $b) => ['id' => $b->id, 'name' => $b->name, 'slug' => $b->slug])
                ->all();

            $this->cache->put($key, $data, $ttl);
        }

        return collect($data)->map(fn (array $item) => (new Brand)->forceFill($item));
    }

    /**
     * Get printer models optionally filtered by brand ID and model search query.
     *
     * @return Collection<int, PrinterModel>
     */
    public function printerModels(?int $brandId = null, ?string $search = null): Collection
    {
        $trimmed = $search !== null ? trim($search) : null;
        $escaped = $trimmed
            ? str_replace(['\\', '%', '_'], ['\\\\', '\\%', '\\_'], $trimmed)
            : null;

        return PrinterModel::with('brand')
            ->withCount('compatibleProducts')
            ->when($brandId, fn ($q) => $q->where('brand_id', $brandId))
            ->when($escaped, fn ($q) => $q->whereLike('model_name', "%{$escaped}%", caseSensitive: false))
            ->orderBy('model_name')
            ->get();
    }

    /**
     * Get all compatible products (toners, ink cartridges) for a printer model.
     *
     * @return Collection<int, Product>
     */
    public function compatibleProducts(PrinterModel $printerModel): Collection
    {
        return $printerModel->compatibleProducts()
            ->with(['category', 'brand'])
            ->orderBy('category_id')
            ->orderBy('name')
            ->get();
    }
}
