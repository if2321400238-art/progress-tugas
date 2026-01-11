<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;

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
        // Custom Blade directive untuk auth check
        Blade::if('auth', function () {
            return session()->has('user_id');
        });

        Blade::if('guest', function () {
            return !session()->has('user_id');
        });
    }
}
