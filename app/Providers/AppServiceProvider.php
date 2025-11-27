<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Schema;
use App\Models\Order;
use App\Models\Setting;
use App\Models\Promotion;
use Carbon\Carbon;

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
    public function boot(): void
    {
        // ✅ Only run this after 'settings' table exists
        if (Schema::hasTable('settings')) {
            $dbSettings = Setting::pluck('value', 'key')->toArray();
        } else {
            $dbSettings = [];
        }

        $defaultSettings = [
            'site_name' => 'Eyetails.co',
            'default_email' => 'support@eyetails.co',
            'default_phone' => '+62 812 XXXX XXXX',
            'address' => 'Jl. xxxx No. 123, Jakarta Pusat',
            'logo_path' => null,
            'favicon_path' => null,
        ];

        $settings = array_merge($defaultSettings, $dbSettings);
        View::share('siteSettings', $settings);

        // Composer untuk layout sisi PENGGUNA (layouts.app)
        View::composer('layouts.app', function ($view) {
            $activePromotions = Promotion::where('is_active', true)
                ->where(function ($query) {
                    $query->where('start_date', '<=', Carbon::now())
                        ->orWhereNull('start_date');
                })
                ->where(function ($query) {
                    $query->where('end_date', '>=', Carbon::now())
                        ->orWhereNull('end_date');
                })
                ->get();

            $view->with('activePromotions', $activePromotions);
        });

        // Composer untuk layout sisi ADMIN (admin.layouts.sidebar)
        View::composer('admin.layouts.sidebar', function ($view) {
            $pendingOrdersCount = Order::where('order_status', 'Pending')->count();
            $view->with('pendingOrdersCount', $pendingOrdersCount);
        });
    }
}
