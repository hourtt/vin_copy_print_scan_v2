<?php

use App\Http\Controllers\ProductController;
use App\Http\Middleware\RedirectAdminFromHome;
use Illuminate\Support\Facades\Route;

Route::middleware(RedirectAdminFromHome::class)->group(function () {
    Route::get('/', [ProductController::class, 'index'])->name('dashboard');
    Route::get('/product-catalog', [ProductController::class, 'catalogIndex'])->name('product-catalog.index');

    // Direct existing category routes to categoryIndex with slug defaults
    Route::get('/printers', [ProductController::class, 'categoryIndex'])
        ->defaults('categorySlug', 'printers')
        ->name('products.printers.index');

    Route::get('/toners', [ProductController::class, 'categoryIndex'])
        ->defaults('categorySlug', 'toners')
        ->name('products.toners.index');

    Route::get('/ink-cartridges', [ProductController::class, 'categoryIndex'])
        ->defaults('categorySlug', 'ink-cartridges')
        ->name('products.ink-cartridges.index');

    Route::get('/papers', [ProductController::class, 'categoryIndex'])
        ->defaults('categorySlug', 'papers')
        ->name('products.papers.index');

    // Dynamic category route fallback for any future categories
    Route::get('/category/{categorySlug}', [ProductController::class, 'categoryIndex'])
        ->name('products.category.index');

    Route::get('/products/{product:slug}', [ProductController::class, 'show'])->name('products.show');
    Route::get('/breadcrumb/back', [ProductController::class, 'breadcrumbBack'])->name('breadcrumb.back');
    Route::view('/services', 'services.index')->name('services');
});
