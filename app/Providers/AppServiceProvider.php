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
            // Force HTTPS untuk production dengan proxy support
            if (config('app.env') === 'production') {
                URL::forceScheme('https');
                $this->app['request']->server->set('HTTPS', true);
                $this->app['request']->server->set('SERVER_PORT', 443);

                // Untuk Vercel/proxy headers
                if (request()->header('x-forwarded-proto') === 'https') {
                    $this->app['request']->server->set('HTTPS', 'on');
                }
            }

            // Fix storage URL untuk production (Vercel)
            if (config('app.env') === 'production') {
                $this->configureProductionStorage();
            }

            // View composer untuk admin layout (dengan safety check)
            if (class_exists('\App\Models\Order')) {
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
            }
        } catch (\Exception $e) {
            Log::error('AppServiceProvider boot error: ' . $e->getMessage());
        }
    }

    private function configureProductionStorage()
    {
        try {
            // Karena Vercel tidak support symlink, kita configure storage untuk akses via route
            config([
                'filesystems.disks.public.url' => env('APP_URL') . '/storage',
                'filesystems.disks.public.root' => storage_path('app/public'),
                'filesystems.disks.public.driver' => 'local',
                'filesystems.disks.public.visibility' => 'public',
            ]);

            Log::info('Storage configured for production (route-based access)');
        } catch (\Exception $e) {
            Log::error('Storage configuration failed: ' . $e->getMessage());
        }
    }
}
