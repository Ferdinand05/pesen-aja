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
    Route::post('order/selesai-order', [OrderController::class, 'selesaiOrder'])->name('selesai-order');
    Route::get('dashboard/orders-history', [OrderController::class, 'orderHistory'])->name('orders.history');
    Route::resource('dashboard/orders', OrderController::class);
    Route::get('payments/print-invoice/{order_id}', [PaymentController::class, 'printInvoice'])->name('print.invoice');
    Route::get('payments/export-pdf', [PaymentController::class, 'exportPdf'])->name('export.pdf');
    Route::get('payments/export-excel', [PaymentController::class, 'exportExcel'])->name('export.excel');
    Route::resource('dashboard/payments', PaymentController::class);

    //SECTION Manager Access
    Route::middleware('isManager')->group(function () {
        Route::resource('dashboard/categories', CategoryController::class);
        Route::resource('dashboard/users', UserController::class);
        Route::resource('dashboard/products', ProductController::class);
    });
});
