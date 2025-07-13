<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
Product::observe(ProductObserver::class);

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
        Product::observe(ProductObserver::class);
    }
}
