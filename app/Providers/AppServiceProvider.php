<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
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
     * Mendaftarkan view pagination custom supaya tidak pakai Tailwind CSS.
     */
    public function boot(): void
    {
        Paginator::defaultView('vendor.pagination.custom');
    }
}
