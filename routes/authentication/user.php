<?php

use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

// * Guest Routes
Route::get('/', [ProductController::class, 'index'])->name('dashboard');
Route::get('/product-catalog', [ProductController::class, 'product_catalog_index'])->name('product-catalog.index');
Route::get('/printers', [ProductController::class, 'printers_index'])->name('products.printers.index');
Route::get('/toners', [ProductController::class, 'toners_index'])->name('products.toners.index');
Route::get('/inks', [ProductController::class, 'inks_index'])->name('products.inks.index');
Route::get('/papers', [ProductController::class, 'papers_index'])->name('products.papers.index');
Route::get('/breadcrumb/back', [ProductController::class, 'breadcrumbBack'])->name('breadcrumb.back');
Route::view('/services', 'services.index')->name('services');
