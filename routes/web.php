<?php

use App\Http\Controllers\ImageController;
use App\Http\Controllers\InquiryController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'customer'])->group(function () {

    //  Inquiry (replaces cart/checkout for v2 catalog flow)
    Route::post('/inquire/{product}', [InquiryController::class, 'store'])
        ->name('inquire.store');
    Route::get('/profile/inquiries', [InquiryController::class, 'history'])
        ->name('profile.inquiries.index');

    // Customer Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::patch('/profile/field/{field}', [ProfileController::class, 'updateField'])->name('profile.updateField');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post('/profile/image', [ImageController::class, 'upload'])->name('image.upload');
    Route::delete('/profile/image', [ImageController::class, 'destroy'])->name('image.destroy');
});

require __DIR__.'/catalog.php';
require __DIR__.'/auth.php';
