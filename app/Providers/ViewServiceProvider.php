<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{
    public function boot()
    {
        View::composer('*', function ($view) {
            if (auth()->check()) {
                $userId = auth()->id();
                $cartCount = DB::table('carrito')
                                ->where('user_id', $userId)
                                ->sum('cantidad');
                $view->with('cartCount', $cartCount);
            }
        });
    }
}
