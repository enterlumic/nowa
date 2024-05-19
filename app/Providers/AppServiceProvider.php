<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\ConektaService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(ConektaService::class, function ($app) {
            return new ConektaService();
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
