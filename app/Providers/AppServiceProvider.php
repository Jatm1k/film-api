<?php

namespace App\Providers;

use App\Contracts\API\v1\Films\FilmsContract;
use App\Services\API\v1\Films\FilmsService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(FilmsContract::class, FilmsService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
