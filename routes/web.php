<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\DocumentUploadController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\SettingController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
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

    // Login Form
    Route::get('login', function () {
        return view('admin.auth.login');
    })->name('login');

    // Login Process
    Route::post('login', function (Request $request) {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        try {
            $admin = \App\Models\AdminUser::where('email', $request->email)
                ->where('is_active', true)
                ->first();

            if ($admin && Hash::check($request->password, $admin->password)) {
                Session::put('admin_logged_in', true);
                Session::put('admin_id', $admin->id);
                Session::put('admin_name', $admin->name);
                Session::put('admin_email', $admin->email);
                Session::put('admin_role', $admin->role);

                $admin->updateLastLogin($request->ip());

                return redirect()->route('admin.dashboard')
                    ->with('success', 'Login berhasil! Selamat datang ' . $admin->name);
            }

            return back()->withErrors(['login' => 'Email atau password salah!'])
                ->withInput($request->only('email'));
        } catch (\Exception $e) {
            return back()->withErrors(['login' => 'Error: ' . $e->getMessage()]);
        }
    });

    // Logout
    Route::post('logout', function () {
        Session::forget(['admin_logged_in', 'admin_id', 'admin_name', 'admin_email', 'admin_role']);
        return redirect()->route('admin.login')->with('success', 'Logout berhasil!');
    })->name('logout');

    // Protected routes
    Route::middleware(['admin'])->group(function () {

        // Dashboard
        Route::get('/', function () {
            $stats = ['total_orders' => 0, 'pending_orders' => 0, 'monthly_revenue' => 0, 'weekly_orders' => 0];
            $recent_orders = [];
            $monthly_chart_data = ['labels' => [], 'revenue' => [], 'orders' => []];
            $adminName = Session::get('admin_name', 'Admin');

            return view('admin.dashboard', compact('stats', 'recent_orders', 'monthly_chart_data', 'adminName'));
        })->name('dashboard');

        Route::get('dashboard', function () {
            return redirect()->route('admin.dashboard');
        });

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
            Route::get('filter', [OrderController::class, 'filter'])->name('filter');
            Route::get('create', [OrderController::class, 'create'])->name('create');
            Route::post('/', [OrderController::class, 'store'])->name('store');
            Route::get('{id}', [OrderController::class, 'show'])->name('show');
            Route::get('{id}/edit', [OrderController::class, 'edit'])->name('edit');
            Route::put('{id}', [OrderController::class, 'update'])->name('update');
            Route::delete('{id}', [OrderController::class, 'destroy'])->name('destroy');

            // AJAX Routes
            Route::get('{id}/details', [OrderController::class, 'getOrderDetails'])->name('details');
            Route::post('{id}/update-payment-status', [OrderController::class, 'updatePaymentStatus'])->name('update-payment-status');
            Route::get('{id}/download/{type}', [OrderController::class, 'downloadFile'])->name('download-file');
            Route::get('export', [OrderController::class, 'export'])->name('export');
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

// Storage access route for Vercel
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

// Fallback route
Route::fallback(function () {
    return redirect()->route('home');
});
