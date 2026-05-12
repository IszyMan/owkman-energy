<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use App\Models\Cart;

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
        View::composer('*', function ($view) {

            if (Auth::check()) {

                $cartCount = Cart::where('user_id', Auth::id())
                    ->sum('quantity');

            } else {

                $cart = session()->get('cart', []);

                $cartCount = collect($cart)->sum('quantity');
            }

            $view->with('cartCount', $cartCount);
        });
    }
}
