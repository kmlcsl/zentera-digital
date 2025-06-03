<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController; // Public ProductController
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProductController as AdminProductController; // Admin ProductController
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\SettingController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Public Routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/products', [ProductController::class, 'index'])->name('products');

// Admin Routes
Route::prefix('admin')->name('admin.')->group(function () {

    // Auth Routes (Login/Logout)
    Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('login', [AuthController::class, 'login']);
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');

    // Protected Admin Routes (harus login dulu)
    Route::middleware(['admin'])->group(function () {

        // Dashboard
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('dashboard', [DashboardController::class, 'index']);

        // Quick Access Routes (untuk compatibility)
        Route::get('products', [AdminProductController::class, 'index'])->name('products');
        Route::get('orders', [OrderController::class, 'index'])->name('orders');
        Route::get('settings', [SettingController::class, 'index'])->name('settings');

        // Products Management
        Route::prefix('products')->name('products.')->group(function () {
            Route::get('/', [AdminProductController::class, 'index'])->name('index');
            Route::get('create', [AdminProductController::class, 'create'])->name('create');
            Route::post('/', [AdminProductController::class, 'store'])->name('store');
            Route::get('{id}', [AdminProductController::class, 'show'])->name('show');
            Route::get('{id}/edit', [AdminProductController::class, 'edit'])->name('edit');
            Route::put('{id}', [AdminProductController::class, 'update'])->name('update');
            Route::delete('{id}', [AdminProductController::class, 'destroy'])->name('destroy');

            // AJAX Actions
            Route::post('update-price', [AdminProductController::class, 'updatePrice'])->name('update-price');
            Route::post('toggle-visibility', [AdminProductController::class, 'toggleVisibility'])->name('toggle-visibility');
        });

        // Orders Management
        Route::prefix('orders')->name('orders.')->group(function () {
            Route::get('/', [OrderController::class, 'index'])->name('index');
            Route::get('create', [OrderController::class, 'create'])->name('create');
            Route::post('/', [OrderController::class, 'store'])->name('store');
            Route::get('{id}', [OrderController::class, 'show'])->name('show');
            Route::get('{id}/edit', [OrderController::class, 'edit'])->name('edit');
            Route::put('{id}', [OrderController::class, 'update'])->name('update');
            Route::delete('{id}', [OrderController::class, 'destroy'])->name('destroy');

            // AJAX Actions
            Route::post('{id}/update-status', [OrderController::class, 'updateStatus'])->name('update-status');
        });

        // Settings Management
        Route::prefix('settings')->name('settings.')->group(function () {
            Route::get('/', [SettingController::class, 'index'])->name('index');
            Route::post('business', [SettingController::class, 'updateBusiness'])->name('business');
            Route::post('profile', [SettingController::class, 'updateProfile'])->name('profile');
            Route::post('password', [SettingController::class, 'updatePassword'])->name('password');
        });
    });
});

// Fallback route for 404
Route::fallback(function () {
    return redirect()->route('home');
});
