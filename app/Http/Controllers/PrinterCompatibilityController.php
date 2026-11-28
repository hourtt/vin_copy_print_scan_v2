<?php

namespace App\Http\Controllers;

use App\Models\PrinterModel;
use App\Services\BreadcrumbTrail;
use App\Services\Catalog\CatalogService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PrinterCompatibilityController extends Controller
{
    public function __construct(
        private readonly CatalogService $catalogService,
        private readonly BreadcrumbTrail $breadcrumbTrail,
    ) {}

    /**
     * Display the Brand -> Printer Model directory for compatibility lookup.
     */
    public function index(Request $request): View
    {
        $validated = $request->validate([
            'brand' => ['nullable', 'string', 'max:100'],
            'search' => ['nullable', 'string', 'max:100'],
        ]);

        $brands = $this->catalogService->printerBrands();
        $brandSlug = $validated['brand'] ?? null;
        $selectedBrand = ($brandSlug && $brandSlug !== 'all')
            ? $brands->firstWhere('slug', $brandSlug)
            : null;

        $search = isset($validated['search']) ? trim($validated['search']) : null;
        $printerModels = $this->catalogService->printerModels($selectedBrand?->id, $search);
        $groupedModels = $printerModels->groupBy(fn (PrinterModel $m) => $m->brand?->name ?? 'Other');
        $items = $this->breadcrumbTrail->resolveForCompatibility();

        return view('compatibility.index', compact(
            'brands',
            'selectedBrand',
            'printerModels',
            'groupedModels',
            'search',
            'items',
        ));
    }

    /**
     * Display compatible products (toners, ink cartridges) for a printer model.
     */
    public function show(PrinterModel $printerModel): View
    {
        $printerModel->loadMissing('brand');

        $compatibleProducts = $this->catalogService->compatibleProducts($printerModel);
        $groupedProducts = $compatibleProducts->groupBy(fn ($product) => $product->category?->name ?? 'Compatible Supplies');
        $items = $this->breadcrumbTrail->resolveForCompatibility($printerModel->full_name ?: $printerModel->model_name);

        return view('compatibility.show', compact(
            'printerModel',
            'compatibleProducts',
            'groupedProducts',
            'items',
        ));
    }
}
