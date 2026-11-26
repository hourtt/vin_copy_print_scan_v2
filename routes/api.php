<?php

use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\PrinterController;
use App\Http\Controllers\Api\ProductController;
use Illuminate\Support\Facades\Route;

// Categories
Route::apiResource('/categories', CategoryController::class)->only(['index', 'show']);

// Products (filterable via ?category_id, ?category, ?brand_id, ?search, ?sort, ?per_page)
Route::apiResource('/products', ProductController::class)->only(['index']);

// Printer model reference / compatibility lookup
Route::apiResource('/printers', PrinterController::class)->only(['index', 'show']);

// Convenience aliases — same ProductController, pre-filtered by category slug
Route::get('/toners', [ProductController::class, 'index'])->defaults('category', 'toners')->name('api.toners.index');
Route::get('/papers', [ProductController::class, 'index'])->defaults('category', 'papers')->name('api.papers.index');
Route::get('/inks', [ProductController::class, 'index'])->defaults('category', 'ink-cartridges')->name('api.ink.index');
