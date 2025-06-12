<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot()
    {
        try {
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
                    if (Schema::hasTable('orders')) {
                        $pendingOrders = \App\Models\Order::where('payment_status', 'pending')->count();
                    } else {
                        $pendingOrders = 0;
                    }
                } catch (\Exception $e) {
                    Log::error('Error in View Composer: ' . $e->getMessage());
                    $pendingOrders = 0;
                }
                $view->with('pendingOrdersCount', $pendingOrders);
            });
        } catch (\Exception $e) {
            Log::error('AppServiceProvider boot error: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
        }
    }

    private function ensureStorageLink()
    {
        try {
            Log::info('Attempting to create storage link...');

            $target = storage_path('app/public');
            $link = public_path('storage');

            Log::info("Target: $target, Link: $link");

            if (!file_exists($link)) {
                // Coba buat directory storage/app/public jika belum ada
                if (!file_exists($target)) {
                    mkdir($target, 0755, true);
                    Log::info('Created target directory: ' . $target);
                }

                // Buat symlink
                if (function_exists('symlink')) {
                    $result = symlink($target, $link);
                    Log::info('Symlink created: ' . ($result ? 'success' : 'failed'));
                } else {
                    $this->app->make('files')->link($target, $link);
                    Log::info('File link created via Laravel Files');
                }
            } else {
                Log::info('Storage link already exists');
            }
        } catch (\Exception $e) {
            Log::error('Storage link creation failed: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
        }
    }
}
