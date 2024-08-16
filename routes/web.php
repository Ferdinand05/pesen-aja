<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;

Route::inertia('/', 'Home')->name('home');
Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

Route::get('login', [AuthController::class, 'login'])->name('login');
Route::get('login', [AuthController::class, 'store'])->name('login.store');
Route::post('logout', [AuthController::class, 'logout'])->name('logout');

Route::resource('dashboard/users', UserController::class);
Route::resource('dashboard/categories', CategoryController::class);
Route::resource('dashboard/products', ProductController::class);
Route::resource('dashboard/orders', OrderController::class);
Route::resource('dashboard/payments', PaymentController::class);
