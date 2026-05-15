<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Order;
use App\Models\Review;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot()
    {
        View::composer('*', function ($view) {

            $view->with([
                'ordersCount' => Order::where('status', 'pending')->count(),
                'reviewsCount' => Review::where('is_read', false)->count(),
            ]);

        });
    }
}




