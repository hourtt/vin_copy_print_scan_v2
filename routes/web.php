<?php


use App\Http\Controllers\OrdersController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CheckoutController;
use Illuminate\Support\Facades\Route;


Route::middleware(['auth', 'user'])->group(function () {
    Route::get('/orders', [OrdersController::class, 'index'])->name('orders.index');
    Route::post('/orders', [OrdersController::class, 'store'])->name('orders.store');

    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');

    Route::get('orders/{order}', [OrdersController::class, 'show'])->name('orders.show');

    Route::get('/checkout/success', [CheckoutController::class, 'success'])->name('checkout.success');

    Route::get('/checkout/cancel', [CheckoutController::class, 'cancel'])->name('checkout.cancel');
});



Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::patch('/profile/field/{field}', [ProfileController::class, 'updateField'])->name('profile.updateField');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');


});

require __DIR__ . '/authentication/admin.php';
require __DIR__ . '/authentication/user.php';
require __DIR__ . '/auth.php';
require __DIR__ . '/carts.php';