<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
        // Force HTTPS untuk production
        if (config('app.env') === 'production' || request()->header('x-forwarded-proto') === 'https') {
            URL::forceScheme('https');
            $this->app['request']->server->set('HTTPS', true);
        }

        // Pastikan storage link terbuat di production
        if (config('app.env') === 'production') {
            $this->ensureStorageLink();
        }

        // View composer untuk admin layout
        View::composer('admin.layouts.app', function ($view) {
            try {
                // Pastikan tabel orders ada
                if (Schema::hasTable('orders')) {
                    $pendingOrders = \App\Models\Order::where('payment_status', 'pending')->count();
                } else {
                    $pendingOrders = 0;
                }
            } catch (\Exception $e) {
                $pendingOrders = 0;
            }
            $view->with('pendingOrdersCount', $pendingOrders);
        });
    }

    /**
     * Ensure storage symlink exists
     */
    private function ensureStorageLink()
    {
        try {
            $target = storage_path('app/public');
            $link = public_path('storage');

            // Check jika symlink belum ada atau broken
            if (!file_exists($link) || !is_link($link)) {
                // Hapus jika ada file/folder dengan nama storage
                if (file_exists($link) && !is_link($link)) {
                    if (is_dir($link)) {
                        rmdir($link);
                    } else {
                        unlink($link);
                    }
                }

                // Buat symlink
                if (function_exists('symlink')) {
                    symlink($target, $link);
                } else {
                    // Fallback jika symlink tidak tersedia
                    $this->app->make('files')->link($target, $link);
                }
            }
        } catch (\Exception $e) {
            // Log error tapi jangan break aplikasi
            Log::warning('Failed to create storage symlink: ' . $e->getMessage());
        }
    }
}
