<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\TemporaryOrderController;
use App\Models\Product;
use App\Models\TemporaryOrder;
use Inertia\Inertia;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('login', [AuthController::class, 'login'])->name('login');
Route::post('login', [AuthController::class, 'store'])->name('login.store');


Route::post('temporary-order', [TemporaryOrderController::class, 'store'])->name('temporary-order.store');
Route::post('delete-order', [TemporaryOrderController::class, 'deleteOrder'])->name('temporary-order.delete');
Route::delete('cancel-order', [TemporaryOrderController::class, 'cancelOrder'])->name('temporary-order.cancel');
Route::post('checkout', [CheckoutController::class, 'store'])->name('checkout.store');

Route::post('checkout-update', [CheckoutController::class, 'updateTransactionMessage'])->name('checkout.update');

Route::middleware(['auth'])->group(function () {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');

    Route::resource('dashboard/users', UserController::class);
    Route::resource('dashboard/categories', CategoryController::class);
    Route::resource('dashboard/products', ProductController::class);
    Route::resource('dashboard/orders', OrderController::class);
    Route::resource('dashboard/payments', PaymentController::class);
});
