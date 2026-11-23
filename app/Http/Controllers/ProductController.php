<?php

namespace App\Http\Controllers;

use App\Http\Requests\CatalogFilterRequest;
use App\Models\Product;
use App\Presenters\CategoryGridPresenter;
use App\Services\BreadcrumbTrail;
use App\Services\Catalog\CatalogService;
use App\Services\Catalog\HomepageService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function __construct(
        private readonly HomepageService $homepageService,
        private readonly CatalogService $catalogService,
        private readonly CategoryGridPresenter $gridPresenter,
        private readonly BreadcrumbTrail $breadcrumbTrail,
    ) {}

    /**
     * Display the homepage with curated product sections.
     */
    public function index(): View
    {
        $curated = $this->homepageService->getCuratedSections();

        return view('dashboard', $curated);
    }

    /**
     * Display the filterable, sortable product catalog.
     */
    public function catalogIndex(CatalogFilterRequest $request): View
    {
        $items = $this->breadcrumbTrail->resolveForCatalog();
        $products = $this->catalogService->paginateCatalog($request->filters());
        $categories = $this->catalogService->sidebarCategories();

        return view('products-catalog.index', compact('products', 'categories', 'items'));
    }

    /**
     * Display or filter a single category page (supports full-page and AJAX requests).
     */
    public function categoryIndex(CatalogFilterRequest $request, string $categorySlug): View|JsonResponse
    {
        $category = $this->catalogService->resolveCategory($categorySlug);
        $isAjax = $request->expectsJson();
        $products = $this->catalogService->paginateCategory($category, $request->filters(), $isAjax);

        if ($isAjax) {
            $gridConfig = $this->gridPresenter->present($products, $category);

            return response()->json([
                'html' => view('components.products._grid', $gridConfig)->render(),
                'count' => $products->total(),
            ]);
        }

        $items = $this->breadcrumbTrail->resolveForCategory($category->name, url()->current());
        $brands = $this->catalogService->brandsForCategory($category);
        $categories = $this->catalogService->sidebarCategories();
        $gridConfig = $this->gridPresenter->present($products, $category);
        $view = $this->catalogService->resolveView($category, $categorySlug);

        return view($view, compact('products', 'brands', 'items', 'category', 'categories', 'gridConfig'));
    }

    /**
     * Navigate backwards along the breadcrumb trail.
     */
    public function breadcrumbBack(Request $request): RedirectResponse
    {
        if ($request->query('from') === 'terminal') {
            $top = $this->breadcrumbTrail->top();

            return redirect(! empty($top['url']) ? $top['url'] : route('dashboard'));
        }

        $this->breadcrumbTrail->pop();
        $newTop = $this->breadcrumbTrail->top();

        return redirect(! empty($newTop['url']) ? $newTop['url'] : route('dashboard'));
    }

    /**
     * Display the product detail page.
     */
    public function show(Product $product): View
    {
        $product->loadMissing(['category', 'brand', 'compatibleModels:id,brand_id,model_name']);

        return view('products.show', compact('product'));
    }
}
