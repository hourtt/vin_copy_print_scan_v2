<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Services\BreadcrumbService;

class ProductController extends Controller
{
    /**
     * Display the homepage with product-first layout.
     */
    public function index()
    {
        $featured = Product::with('category', 'brand')
            ->where('is_featured', true)
            ->inStock()
            ->latest()
            ->take(4)
            ->get();

        $popular = Product::with('category', 'brand')
            ->inStock()
            ->orderByDesc('sales_count')
            ->take(8)
            ->get();

        $newArrivals = Product::with('category', 'brand')
            ->inStock()
            ->latest()
            ->take(8)
            ->get();

        $hotSale = Product::with('category', 'brand')
            ->inStock()
            ->whereNotNull('discount_price')
            ->where('discount_price', '<', DB::raw('price'))
            ->orderByDesc('sales_count')
            ->take(8)
            ->get();

        return view('dashboard', compact('featured', 'popular', 'newArrivals', 'hotSale'));
    }

    public function product_catalog_index(Request $request, BreadcrumbService $breadcrumbService)
    {
        $breadcrumbService->push('Product Catalog', $request->fullUrl());
        $items = $breadcrumbService->getForListing('Product Catalog', $request->fullUrl());

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
        $categories = Category::select('id', 'name')->orderBy('name')->get();

        return view('products-catalog.index', compact('products', 'categories', 'items'));
    }

    private function calculatePercentageChange($current, $previous)
    {
        if ($previous == 0 && $current > 0) {
            return 100;
        }

        if ($previous == 0 && $current == 0) {
            return 0;
        }

        return (($current - $previous) / $previous) * 100;
    }

    public function admin_index()
    {
        $products = Product::with('category', 'voucher')->paginate(20);
        $category = cache()->remember('categories.all', 3600, fn() => Category::all());

        $now = Carbon::now();

        $currentMonthStart = $now->copy()->startOfMonth();
        $currentMonthEnd = $now->copy()->endOfMonth();
        $previousMonthStart = $now->copy()->subMonth()->startOfMonth();
        $previousMonthEnd = $now->copy()->subMonth()->endOfMonth();

        $currentHourStart = $now->copy()->startOfHour();
        $currentHourEnd = $now->copy()->endOfHour();
        $previousHourStart = $now->copy()->subHour()->startOfHour();
        $previousHourEnd = $now->copy()->subHour()->endOfHour();

        $totalRevenue = Order::where('status', 'delivered')->sum('total') ?? 0;
        $currentRevenue = Order::where('status', 'delivered')->whereBetween('created_at', [$currentMonthStart, $currentMonthEnd])->sum('total') ?? 0;
        $previousRevenue = Order::where('status', 'delivered')->whereBetween('created_at', [$previousMonthStart, $previousMonthEnd])->sum('total') ?? 0;
        $revenueGrowth = $this->calculatePercentageChange($currentRevenue, $previousRevenue);

        $totalOrders = Order::count() ?? 0;
        $currentOrders = Order::whereBetween('created_at', [$currentMonthStart, $currentMonthEnd])->count();
        $previousOrders = Order::whereBetween('created_at', [$previousMonthStart, $previousMonthEnd])->count();
        $orderGrowth = $this->calculatePercentageChange($currentOrders, $previousOrders);

        $activeCustomers = User::where('role', 'user')->count() ?? 0;
        $currentCustomers = User::where('role', 'user')->whereBetween('created_at', [$currentMonthStart, $currentMonthEnd])->count();
        $previousCustomers = User::where('role', 'user')->whereBetween('created_at', [$previousMonthStart, $previousMonthEnd])->count();
        $customerGrowth = $this->calculatePercentageChange($currentCustomers, $previousCustomers);

        $activeIssues = 0;
        $issueGrowth = $this->calculatePercentageChange(0, 0);

        return view('components.auth.admin.dashboard', compact(
            'products',
            'category',
            'totalRevenue',
            'totalOrders',
            'activeCustomers',
            'activeIssues',
            'revenueGrowth',
            'orderGrowth',
            'customerGrowth',
            'issueGrowth'
        ));
    }

    public function printers_index(Request $request, BreadcrumbService $breadcrumbService)
    {
        // * For AJAX filter requests: minimal eager loading, skip $brands query
        $isAjax = $request->ajax() || $request->wantsJson();

        if (!$isAjax) {
            $breadcrumbService->push('Printers', $request->fullUrl());
            $items = $breadcrumbService->getForListing('Printers', $request->fullUrl());
        }

        // Strict category isolation — only Printers (category_id = 1)
        $query = Product::with($isAjax ? ['brand'] : ['category', 'brand', 'voucher'])
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

        // Only run the brands query for full page loads (not AJAX)
        $brands = Brand::whereHas(
            'products',
            fn($q) =>
            $q->where('category_id', 1)
        )->orderBy('name')->get();

        return view('products.printers.index', compact('products', 'brands', 'items'));
    }

    public function toners_index(Request $request, BreadcrumbService $breadcrumbService)
    {
        // * For AJAX filter requests: minimal eager loading, skip $brands query
        $isAjax = $request->ajax() || $request->wantsJson();

        if (!$isAjax) {
            $breadcrumbService->push('Toners', $request->fullUrl());
            $items = $breadcrumbService->getForListing('Toners', $request->fullUrl());
        }

        // Strict category isolation — only Toners (category_id = 2)
        $query = Product::with($isAjax ? ['brand'] : ['category', 'brand', 'voucher'])
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

        // Only run the brands query for full page loads (not AJAX)
        $brands = Brand::whereHas(
            'products',
            fn($q) =>
            $q->where('category_id', 2)
        )->orderBy('name')->get();

        return view('products.toners.index', compact('products', 'brands', 'items'));
    }

    public function inks_index(Request $request, BreadcrumbService $breadcrumbService)
    {
        // * For AJAX filter requests: minimal eager loading, skip $brands query
        $isAjax = $request->ajax() || $request->wantsJson();

        if (!$isAjax) {
            $breadcrumbService->push('Ink Cartridges', $request->fullUrl());
            $items = $breadcrumbService->getForListing('Ink Cartridges', $request->fullUrl());
        }

        $query = Product::with($isAjax ? ['brand'] : ['category', 'brand', 'voucher'])
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

        // Only run the brands query for full page loads (not AJAX)
        $brands = Brand::whereHas(
            'products',
            fn($q) =>
            $q->whereHas('category', fn($q2) => $q2->where('slug', 'ink-cartridges'))
        )->orderBy('name')->get();

        return view('products.inks.index', compact('products', 'brands', 'items'));
    }

    public function papers_index(Request $request, BreadcrumbService $breadcrumbService)
    {
        // * For AJAX filter requests: minimal eager loading, skip $brands query
        $isAjax = $request->ajax() || $request->wantsJson();

        if (!$isAjax) {
            $breadcrumbService->push('Papers', $request->fullUrl());
            $items = $breadcrumbService->getForListing('Papers', $request->fullUrl());
        }

        // Papers grid groups by category, so we need 'category' for AJAX too
        $query = Product::with($isAjax ? ['brand', 'category'] : ['category', 'brand', 'voucher'])
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

        // Only run the brands query for full page loads (not AJAX)
        $brands = Brand::whereHas(
            'products',
            fn($q) =>
            $q->whereHas('category', fn($q2) => $q2->where('slug', 'paper'))
        )->orderBy('name')->get();

        return view('products.papers.index', compact('products', 'brands', 'items'));
    }

}
