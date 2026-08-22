<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\PrinterController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Categories
Route::apiResource('/categories', CategoryController::class)->only(['index', 'show']);

// Products (filterable via ?category_id, ?category, ?brand_id, ?search, ?sort, ?per_page)
Route::apiResource('/products', ProductController::class)->only(['index']);

// Printer model reference / compatibility lookup
Route::apiResource('/printers', PrinterController::class)->only(['index', 'show']);

// Convenience aliases — same ProductController, pre-filtered by category slug
Route::get('/toners', [ProductController::class, 'index'])->defaults('category', 'toners')->name('api.toners.index');
Route::get('/papers', [ProductController::class, 'index'])->defaults('category', 'papers')->name('api.papers.index');
Route::get('/inks', [ProductController::class, 'index'])->defaults('category', 'ink')->name('api.ink.index');

