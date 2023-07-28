<?php

namespace App\Providers;

use App\Contracts\API\v1\Auth\AuthContract;
use App\Contracts\API\v1\Files\FilesHelper;
use App\Contracts\API\v1\Films\FilmsContract;
use App\Contracts\API\v1\Reviews\ReviewsContract;
use App\Contracts\API\v1\Roles\RolesContract;
use App\Services\API\v1\Auth\AuthService;
use App\Services\API\v1\Exceptions\ExceptionsService;
use App\Services\API\v1\Files\FilesService;
use App\Services\API\v1\Films\FilmsService;
use App\Services\API\v1\Reviews\ReviewsService;
use App\Services\API\v1\Roles\RolesService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(FilmsContract::class, FilmsService::class);
//        $this->app->bind(FilesHelper::class, FilesService::class);
        $this->app->bind(AuthContract::class, AuthService::class);
        $this->app->bind(RolesContract::class, RolesService::class);
        $this->app->bind(ReviewsContract::class, ReviewsService::class);
        $this->app->bind('exceptionHelper', ExceptionsService::class);
        $this->app->bind('filesHelper', FilesService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
