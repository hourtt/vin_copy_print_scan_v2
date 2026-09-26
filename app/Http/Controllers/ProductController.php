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

        // Fast hydration using primary key lookup while preserving ordered IDs
        $fetchOrdered = function (array $ids) {
            if (empty($ids)) {
                return collect();
            }
            $products = Product::with('category', 'brand')->whereIn('id', $ids)->get()->keyBy('id');
            return collect($ids)->map(fn ($id) => $products->get($id))->filter()->values();
        };

        $featured    = $fetchOrdered($curatedIds['featured'] ?? []);
        $popular     = $fetchOrdered($curatedIds['popular'] ?? []);
        $newArrivals = $fetchOrdered($curatedIds['newArrivals'] ?? []);
        $hotSale     = $fetchOrdered($curatedIds['hotSale'] ?? []);

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
        $categoryIds = Cache::remember('catalog_category_ids', 86400, function () {
            return Category::orderBy('name')->pluck('id')->all();
        });
        $categories = !empty($categoryIds)
            ? Category::select('id', 'name')->whereIn('id', $categoryIds)->orderBy('name')->get()
            : collect();

        return view('products-catalog.index', compact('products', 'categories', 'items'));
    }

    public function printers_index(Request $request, BreadcrumbTrail $breadcrumbTrail)
    {
        // * For AJAX filter requests: minimal eager loading, skip $brands query
        $isAjax = $request->ajax() || $request->wantsJson();

        if (!$isAjax) {
            $items = $breadcrumbTrail->resolveForCategory('Printer', route('products.printers.index'));
        }

        // Strict category isolation — only Printers (category_id = 1)
        $query = Product::with($isAjax ? ['brand'] : ['category', 'brand'])
            ->where('category_id', 1);

        if ($request->query('search')) {
            $query->where('name', 'like', '%' . $request->query('search') . '%');
        }

        // Pills are brand pills — filter by brand_id within this category
        if ($request->query('cat') && $request->query('cat') !== 'all') {
            $query->where('brand_id', $request->query('cat'));
        }

        $sort = $request->query('sort', 'default');
        switch ($sort) {
            case 'price-asc':
                $query->orderBy('price', 'asc');
                break;
            case 'price-desc':
                $query->orderBy('price', 'desc');
                break;
            case 'year-desc':
                $query->orderBy('created_at', 'desc');
                break;
            case 'name-asc':
                $query->orderBy('name', 'asc');
                break;
            case 'stock-desc':
                $query->orderBy('stock', 'desc');
                break;
            default:
                $query->latest();
                break;
        }

        $products = $query->paginate(20);

        if ($isAjax) {
            return response()->json([
                'html' => view('components.products._grid', [
                    'products' => $products,
                    'groupBy' => 'brand_id',
                    'headingRelation' => 'brand',
                    'headingFallback' => 'Other',
                    'subLabelRelation' => 'brand',
                    'subLabelFallback' => 'Printer',
                    'compatKey' => 'compatibility',
                    'emptyMessage' => 'No printers found.',
                    'badgeCase' => 'uppercase',
                ])->render(),
                'count' => $products->total(), // total() avoids an extra COUNT query
            ]);
        }

        // Only run the brands query for full page loads (cached for 24 hours)
        $brandIds = Cache::remember('category_brand_ids_1', 86400, function () {
            return Brand::whereHas(
                'products',
                fn($q) => $q->where('category_id', 1)
            )->orderBy('name')->pluck('id')->all();
        });
        $brands = !empty($brandIds)
            ? Brand::whereIn('id', $brandIds)->orderBy('name')->get()
            : collect();

        return view('products.printers.index', compact('products', 'brands', 'items'));
    }

    public function toners_index(Request $request, BreadcrumbTrail $breadcrumbTrail)
    {
        // * For AJAX filter requests: minimal eager loading, skip $brands query
        $isAjax = $request->ajax() || $request->wantsJson();

        if (!$isAjax) {
            $items = $breadcrumbTrail->resolveForCategory('Toners', route('products.toners.index'));
        }

        // Strict category isolation — only Toners (category_id = 2)
        $query = Product::with($isAjax ? ['brand'] : ['category', 'brand'])
            ->where('category_id', 2);

        if ($request->query('search')) {
            $query->where('name', 'like', '%' . $request->query('search') . '%');
        }

        // Pills are brand pills — filter by brand_id within this category
        if ($request->query('cat') && $request->query('cat') !== 'all') {
            $query->where('brand_id', $request->query('cat'));
        }

        $sort = $request->query('sort', 'default');
        switch ($sort) {
            case 'price-asc':
                $query->orderBy('price', 'asc');
                break;
            case 'price-desc':
                $query->orderBy('price', 'desc');
                break;
            case 'name-asc':
                $query->orderBy('name', 'asc');
                break;
            default:
                $query->latest();
                break;
        }

        $products = $query->paginate(20);

        if ($isAjax) {
            return response()->json([
                'html' => view('components.products._grid', [
                    'products' => $products,
                    'groupBy' => 'brand_id',
                    'headingRelation' => 'brand',
                    'headingFallback' => 'Other',
                    'subLabelRelation' => 'brand',
                    'subLabelFallback' => 'Toner',
                    'compatKey' => 'compatibility',
                    'emptyMessage' => 'No toners found.',
                    'badgeCase' => 'uppercase',
                ])->render(),
                'count' => $products->total(), // total() avoids an extra COUNT query
            ]);
        }

        // Only run the brands query for full page loads (cached for 24 hours)
        $brandIds = Cache::remember('category_brand_ids_2', 86400, function () {
            return Brand::whereHas(
                'products',
                fn($q) => $q->where('category_id', 2)
            )->orderBy('name')->pluck('id')->all();
        });
        $brands = !empty($brandIds)
            ? Brand::whereIn('id', $brandIds)->orderBy('name')->get()
            : collect();

        return view('products.toners.index', compact('products', 'brands', 'items'));
    }

    public function inks_index(Request $request, BreadcrumbTrail $breadcrumbTrail)
    {
        // * For AJAX filter requests: minimal eager loading, skip $brands query
        $isAjax = $request->ajax() || $request->wantsJson();

        if (!$isAjax) {
            $items = $breadcrumbTrail->resolveForCategory('Ink', route('products.inks.index'));
        }

        $query = Product::with($isAjax ? ['brand'] : ['category', 'brand'])
            ->whereHas('category', fn($q) => $q->where('slug', 'ink-cartridges'));

        if ($request->query('search')) {
            $query->where('name', 'like', '%' . $request->query('search') . '%');
        }

        // Pills filter by brand_id
        if ($request->query('cat') && $request->query('cat') !== 'all') {
            $query->where('brand_id', $request->query('cat'));
        }

        $sort = $request->query('sort', 'default');
        switch ($sort) {
            case 'price-asc':
                $query->orderBy('price', 'asc');
                break;
            case 'price-desc':
                $query->orderBy('price', 'desc');
                break;
            case 'name-asc':
                $query->orderBy('name', 'asc');
                break;
            default:
                $query->latest();
                break;
        }

        $products = $query->paginate(20);

        if ($isAjax) {
            return response()->json([
                'html' => view('components.products._grid', [
                    'products' => $products,
                    'groupBy' => 'brand_id',
                    'headingRelation' => 'brand',
                    'headingFallback' => 'Other',
                    'subLabelRelation' => 'brand',
                    'subLabelFallback' => 'Ink',
                    'compatKey' => 'spec:Compatible Printers',
                    'emptyMessage' => 'No ink cartridges found.',
                    'badgeCase' => 'capitalize',
                ])->render(),
                'count' => $products->total(), // total() avoids an extra COUNT query
            ]);
        }

        // Only run the brands query for full page loads (cached for 24 hours)
        $brandIds = Cache::remember('category_brand_ids_inks', 86400, function () {
            return Brand::whereHas(
                'products',
                fn($q) => $q->whereHas('category', fn($q2) => $q2->where('slug', 'ink-cartridges'))
            )->orderBy('name')->pluck('id')->all();
        });
        $brands = !empty($brandIds)
            ? Brand::whereIn('id', $brandIds)->orderBy('name')->get()
            : collect();

        return view('products.inks.index', compact('products', 'brands', 'items'));
    }

    public function papers_index(Request $request, BreadcrumbTrail $breadcrumbTrail)
    {
        // * For AJAX filter requests: minimal eager loading, skip $brands query
        $isAjax = $request->ajax() || $request->wantsJson();

        if (!$isAjax) {
            $items = $breadcrumbTrail->resolveForCategory('Paper', route('products.papers.index'));
        }

        // Papers grid groups by category, so we need 'category' for AJAX too
        $query = Product::with($isAjax ? ['brand', 'category'] : ['category', 'brand'])
            ->whereHas('category', fn($q) => $q->where('slug', 'paper'));

        if ($request->query('search')) {
            $query->where('name', 'like', '%' . $request->query('search') . '%');
        }

        // Pills are now brand pills — filter by brand_id
        if ($request->query('cat') && $request->query('cat') !== 'all') {
            $query->where('brand_id', $request->query('cat'));
        }

        $sort = $request->query('sort', 'default');
        switch ($sort) {
            case 'price-asc':
                $query->orderBy('price', 'asc');
                break;
            case 'price-desc':
                $query->orderBy('price', 'desc');
                break;
            case 'name-asc':
                $query->orderBy('name', 'asc');
                break;
            case 'stock-desc':
                $query->orderBy('stock', 'desc');
                break;
            default:
                $query->latest();
                break;
        }

        $products = $query->paginate(20);

        if ($isAjax) {
            return response()->json([
                'html' => view('components.products._grid', [
                    'products' => $products,
                    'groupBy' => 'category_id',
                    'headingRelation' => 'category',
                    'headingFallback' => 'Uncategorized',
                    'subLabelRelation' => 'category',
                    'subLabelFallback' => 'Paper',
                    'compatKey' => 'compatibility',
                    'emptyMessage' => 'No paper products found.',
                    'badgeCase' => 'uppercase',
                ])->render(),
                'count' => $products->total(), // total() avoids an extra COUNT query
            ]);
        }

        // Only run the brands query for full page loads (cached for 24 hours)
        $brandIds = Cache::remember('category_brand_ids_papers', 86400, function () {
            return Brand::whereHas(
                'products',
                fn($q) => $q->whereHas('category', fn($q2) => $q2->where('slug', 'paper'))
            )->orderBy('name')->pluck('id')->all();
        });
        $brands = !empty($brandIds)
            ? Brand::whereIn('id', $brandIds)->orderBy('name')->get()
            : collect();

        return view('products.papers.index', compact('products', 'brands', 'items'));
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
