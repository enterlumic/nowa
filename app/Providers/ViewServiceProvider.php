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

                $cartCount = DB::table('carrito as c')
                    ->join('productos as p', function($join) {
                        $join->on('p.id', '=', 'c.producto_id')
                             ->where('p.b_status', '>', 0);
                    })
                    ->where('c.user_id', $userId)
                    ->count();

                $view->with('cartCount', $cartCount);

            }
        });
    }
}
