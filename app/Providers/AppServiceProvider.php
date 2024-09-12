<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

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
        DB::listen(function ($query) {
            Log::debug("SQL Query Log:\n" .
                "Query: " . $query->sql . "\n" .
                "Bindings: " . json_encode($query->bindings, JSON_PRETTY_PRINT) . "\n" .
                "Time: " . $query->time . "ms");
        });
    }
}