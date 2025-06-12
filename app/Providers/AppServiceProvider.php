<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\URL;
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
    // Tambahkan di boot() method:
    public function boot()
    {
        if (config('app.env') === 'production' || request()->header('x-forwarded-proto') === 'https') {
            URL::forceScheme('https');
            $this->app['request']->server->set('HTTPS', true);
        }

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
}
