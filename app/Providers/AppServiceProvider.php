<?php

namespace App\Providers;

use App\Contracts\API\v1\Auth\AuthContract;
use App\Contracts\API\v1\Files\FilesHelper;
use App\Contracts\API\v1\Films\FilmsContract;
use App\Services\API\v1\Auth\AuthService;
use App\Services\API\v1\Files\FilesService;
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
        $this->app->bind(FilesHelper::class, FilesService::class);
        $this->app->bind(AuthContract::class, AuthService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
