<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Inquiry;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use App\Services\BreadcrumbTrail;

class ProductController extends Controller
{
    /**
     * Display the homepage with product-first layout.
     */
    public function index()
    {
        if (auth()->check() && auth()->user()->role === 'admin') {
            return redirect('/admin');
        }

        $curatedIds = Cache::remember('homepage_curated_product_ids', 3600, function () {
            return [
                'featured' => Product::where('is_featured', true)
                    ->inStock()
                    ->latest()
                    ->take(4)
                    ->pluck('id')
                    ->all(),

                'popular' => Product::inStock()
                    ->orderByDesc('sales_count')
                    ->take(8)
                    ->pluck('id')
                    ->all(),

                'newArrivals' => Product::inStock()
                    ->latest()
                    ->take(8)
                    ->pluck('id')
                    ->all(),

                'hotSale' => Product::inStock()
                    ->whereNotNull('discount_price')
                    ->whereColumn('discount_price', '<', 'price')
                    ->orderByDesc('sales_count')
                    ->take(8)
                    ->pluck('id')
                    ->all(),
            ];
        });

        // Batch-hydrate all unique IDs across all sections in a single unified query
        $allIds = array_values(array_unique(array_merge(
            $curatedIds['featured'] ?? [],
            $curatedIds['popular'] ?? [],
            $curatedIds['newArrivals'] ?? [],
            $curatedIds['hotSale'] ?? []
        )));

        $allProducts = !empty($allIds)
            ? Product::with('category', 'brand')->whereIn('id', $allIds)->get()->keyBy('id')
            : collect();

        $mapOrdered = fn(array $ids) => collect($ids)->map(fn($id) => $allProducts->get($id))->filter()->values();

        $featured = $mapOrdered($curatedIds['featured'] ?? []);
        $popular = $mapOrdered($curatedIds['popular'] ?? []);
        $newArrivals = $mapOrdered($curatedIds['newArrivals'] ?? []);
        $hotSale = $mapOrdered($curatedIds['hotSale'] ?? []);

        return view('dashboard', compact('featured', 'popular', 'newArrivals', 'hotSale'));
    }

    public function product_catalog_index(Request $request, BreadcrumbTrail $breadcrumbTrail)
    {
        $items = $breadcrumbTrail->resolveForCatalog();

        $query = Product::with('category');

        if ($request->has('categories') && !empty($request->query('categories'))) {
            $query->whereIn('category_id', $request->query('categories'));
        }

        if ($request->has('min_price') && is_numeric($request->query('min_price'))) {
            $query->where('price', '>=', $request->query('min_price'));
        }
        if ($request->has('max_price') && is_numeric($request->query('max_price'))) {
            $query->where('price', '<=', $request->query('max_price'));
        }

        // Apply Sort
        $sort = $request->query('sort', 'recommended');
        switch ($sort) {
            case 'newest':
                $query->orderBy('created_at', 'desc');
                break;
            case 'price_asc':
                $query->orderBy('price', 'asc');
                break;
            case 'price_desc':
                $query->orderBy('price', 'desc');
                break;
            case 'recommended':
            default:
                $query->orderBy('id', 'desc');
                break;
        }

        $products = $query->paginate(12)->withQueryString();
        $categoryIds = Cache::remember('catalog_category_ids_v2', 43200, function () {
            return Category::orderBy('name')->pluck('id')->map(fn($id) => (int) $id)->all();
        });
        $categories = !empty($categoryIds)
            ? Category::select('id', 'name')->whereIn('id', array_filter($categoryIds, 'is_int'))->orderBy('name')->get()
            : collect();

        return view('products-catalog.index', compact('products', 'categories', 'items'));
    }

    public function categoryIndex(Request $request, string $categorySlug, BreadcrumbTrail $breadcrumbTrail)
    {
        // 1. Resolve Category safely by slug or ID fallback
        $category = Category::where('slug', $categorySlug)
            ->orWhere(function ($q) use ($categorySlug) {
                if (in_array($categorySlug, ['printers', 'printer']))
                    $q->where('id', 1)->orWhere('slug', 'printers');
                if (in_array($categorySlug, ['toners', 'toner']))
                    $q->where('id', 2)->orWhere('slug', 'toners');
                if (in_array($categorySlug, ['inks', 'ink']))
                    $q->where('slug', 'ink-cartridges');
                if (in_array($categorySlug, ['papers', 'paper']))
                    $q->where('slug', 'paper');
            })
            ->firstOrFail();

        $isAjax = $request->ajax() || $request->wantsJson();

        // 2. Resolve Breadcrumbs for full page loads
        $items = null;
        if (!$isAjax) {
            $items = $breadcrumbTrail->resolveForCategory($category->name, url()->current());
        }

        // 3. Category flag detection
        $isPaper = in_array($category->slug, ['paper', 'papers']);
        $isInk = in_array($category->slug, ['ink-cartridges', 'ink', 'inks']);

        // 4. Build query with conditional eager loading
        $eagerLoad = $isAjax && !$isPaper ? ['brand'] : ['category', 'brand'];

        $query = Product::with($eagerLoad)->where('category_id', $category->id);

        if (method_exists(Product::class, 'scopeFilter')) {
            $query->filter($request->all());
        } else {
            if ($request->query('search')) {
                $query->where('name', 'like', '%' . $request->query('search') . '%');
            }
            if ($request->query('cat') && $request->query('cat') !== 'all') {
                $query->where('brand_id', $request->query('cat'));
            }
            $sort = $request->query('sort', 'default');
            match ($sort) {
                'price-asc' => $query->orderBy('price', 'asc'),
                'price-desc' => $query->orderBy('price', 'desc'),
                'year-desc' => $query->orderBy('created_at', 'desc'),
                'name-asc' => $query->orderBy('name', 'asc'),
                'stock-desc' => $query->orderBy('stock', 'desc'),
                default => $query->latest(),
            };
        }

        $products = $query->paginate(20)->withQueryString();

        // 5. Handle AJAX response
        if ($isAjax) {
            $gridConfig = [
                'products' => $products,
                'groupBy' => $isPaper ? 'category_id' : 'brand_id',
                'headingRelation' => $isPaper ? 'category' : 'brand',
                'headingFallback' => $isPaper ? 'Uncategorized' : 'Other',
                'subLabelRelation' => $isPaper ? 'category' : 'brand',
                'subLabelFallback' => $isPaper ? 'Paper' : ($isInk ? 'Ink' : ($category->id === 1 ? 'Printer' : 'Toner')),
                'compatKey' => $isInk ? 'spec:Compatible Printers' : 'compatibility',
                'emptyMessage' => "No {$category->name} found.",
                'badgeCase' => $isInk ? 'capitalize' : 'uppercase',
            ];

            return response()->json([
                'html' => view('components.products._grid', $gridConfig)->render(),
                'count' => $products->total(),
            ]);
        }

        // 6. Cache brand IDs for full page loads (store only plain int IDs to avoid serialization issues)
        $brandIds = Cache::remember("category_brand_ids_v2_{$category->id}", 43200, function () use ($category) {
            return Brand::whereHas('products', fn($q) => $q->where('category_id', $category->id))
                ->orderBy('name')
                ->pluck('id')
                ->map(fn($id) => (int) $id)
                ->all();
        });

        $brands = !empty($brandIds)
            ? Brand::whereIn('id', array_filter($brandIds, 'is_int'))->orderBy('name')->get()
            : collect();

        // Load all categories for the sidebar filter (cache only IDs, hydrate fresh to avoid Collection deserialization issues)
        $allCategoryIds = Cache::remember('all_active_category_ids_v2', 43200, function () {
            return Category::orderBy('name')->pluck('id')->map(fn($id) => (int) $id)->all();
        });
        $categories = !empty($allCategoryIds)
            ? Category::select('id', 'name', 'slug')->whereIn('id', array_filter($allCategoryIds, 'is_int'))->orderBy('name')->get()
            : collect();

        // 7. Route to individual view if it exists, otherwise fall back to common views
        $viewName = match (true) {
            view()->exists("products.{$category->slug}.index") => "products.{$category->slug}.index",
            view()->exists("products.{$categorySlug}.index") => "products.{$categorySlug}.index",
            view()->exists('products.index') => 'products.index',
            default => 'products-catalog.index',
        };

        return view($viewName, compact('products', 'brands', 'items', 'category', 'categories'));
    }

    public function breadcrumbBack(Request $request, BreadcrumbTrail $breadcrumbTrail)
    {
        $from = $request->query('from', 'category');

        if ($from === 'terminal') {
            $top = $breadcrumbTrail->top();
            if ($top && !empty($top['url'])) {
                return redirect($top['url']);
            }
            return redirect()->route('dashboard');
        }

        $breadcrumbTrail->pop();
        $newTop = $breadcrumbTrail->top();

        if ($newTop && !empty($newTop['url'])) {
            return redirect($newTop['url']);
        }

        return redirect()->route('dashboard');
    }

    public function show(Product $product)
    {
        $product->load(['category', 'brand', 'compatibleModels.brand', 'images']);
        return view('products.show', compact('product'));
    }
}