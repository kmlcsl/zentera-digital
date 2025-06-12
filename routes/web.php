<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController; // Public ProductController
use App\Http\Controllers\DocumentUploadController;
use App\Http\Controllers\PaymentController;
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

// Document Upload Routes
Route::prefix('documents')->name('documents.')->group(function () {
    Route::get('/upload/repair', [DocumentUploadController::class, 'repairForm'])->name('upload.repair');
    Route::get('/upload/format', [DocumentUploadController::class, 'formatForm'])->name('upload.format');
    Route::get('/upload/plagiarism', [DocumentUploadController::class, 'plagiarismForm'])->name('upload.plagiarism');

    Route::post('/upload/repair', [DocumentUploadController::class, 'repairSubmit'])->name('upload.repair.submit');
    Route::post('/upload/format', [DocumentUploadController::class, 'formatSubmit'])->name('upload.format.submit');
    Route::post('/upload/plagiarism', [DocumentUploadController::class, 'plagiarismSubmit'])->name('upload.plagiarism.submit');
});

// Payment Routes
Route::prefix('payment')->name('payment.')->group(function () {
    Route::get('/{orderNumber}', [PaymentController::class, 'show'])->name('show');
    Route::post('/{orderNumber}/confirm', [PaymentController::class, 'confirm'])->name('confirm');
});

// Admin Routes
Route::prefix('admin')->name('admin.')->group(function () {

    // Auth Routes (Login/Logout) - TANPA MIDDLEWARE
    Route::get('login', function () {
        try {
            return app(App\Http\Controllers\Admin\AuthController::class)->showLoginForm();
        } catch (\Exception $e) {
            Log::error('Admin login route error: ' . $e->getMessage());
            return response()->view('errors.500', [], 500);
        }
    })->name('login');

    Route::post('login', [App\Http\Controllers\Admin\AuthController::class, 'login']);
    Route::post('logout', [App\Http\Controllers\Admin\AuthController::class, 'logout'])->name('logout');

    // Auth Routes (Login/Logout)
    // Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
    // Route::post('login', [AuthController::class, 'login']);
    // Route::post('logout', [AuthController::class, 'logout'])->name('logout');

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
            Route::get('filter', [OrderController::class, 'filter'])->name('filter'); // NEW
            Route::get('create', [OrderController::class, 'create'])->name('create');
            Route::post('/', [OrderController::class, 'store'])->name('store');
            Route::get('{id}', [OrderController::class, 'show'])->name('show');
            Route::get('{id}/edit', [OrderController::class, 'edit'])->name('edit');
            Route::put('{id}', [OrderController::class, 'update'])->name('update');
            Route::delete('{id}', [OrderController::class, 'destroy'])->name('destroy');

            // NEW AJAX Routes untuk DocumentOrder
            Route::get('{id}/details', [OrderController::class, 'getOrderDetails'])->name('details');
            Route::post('{id}/update-payment-status', [OrderController::class, 'updatePaymentStatus'])->name('update-payment-status');
            Route::get('{id}/download/{type}', [OrderController::class, 'downloadFile'])->name('download-file');
            Route::get('export', [OrderController::class, 'export'])->name('export'); // NEW
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

// Storage access route for Vercel (karena tidak ada symlink)
Route::get('/storage/{path}', function ($path) {
    $filePath = storage_path('app/public/' . $path);

    if (!file_exists($filePath)) {
        abort(404);
    }

    $mimeType = mime_content_type($filePath);

    return response()->file($filePath, [
        'Content-Type' => $mimeType,
        'Cache-Control' => 'public, max-age=31536000',
    ]);
})->where('path', '.*');

// Fallback route for 404
Route::fallback(function () {
    return redirect()->route('home');
});

// Debug route - TEMPORARY
Route::get('/debug-vercel', function () {
    try {
        return [
            'status' => 'OK',
            'timestamp' => now(),
            'app_env' => app()->environment(),
            'debug' => config('app.debug'),
            'session_driver' => config('session.driver'),
            'controllers' => [
                'AuthController' => class_exists(App\Http\Controllers\Admin\AuthController::class),
                'DashboardController' => class_exists(App\Http\Controllers\Admin\DashboardController::class),
            ],
            'views' => [
                'admin_login' => view()->exists('admin.auth.login'),
                'admin_dashboard' => view()->exists('admin.dashboard'),
            ],
            'memory_usage' => memory_get_usage(true),
            'memory_peak' => memory_get_peak_usage(true),
        ];
    } catch (\Exception $e) {
        return [
            'error' => $e->getMessage(),
            'file' => $e->getFile(),
            'line' => $e->getLine(),
            'trace' => $e->getTraceAsString()
        ];
    }
});

// Simple debug admin login
Route::get('/admin/debug-login', function () {
    try {
        return view('admin.auth.login');
    } catch (\Exception $e) {
        return response([
            'error' => $e->getMessage(),
            'file' => $e->getFile(),
            'line' => $e->getLine(),
        ], 500);
    }
});
