<?php

namespace App\Providers;

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
    public function boot(): void
    {
        //
        // I added this line to enable debugging output in the terminal
        //\Algolia\AlgoliaSearch\Log\DebugLogger::enable();
    }
}
