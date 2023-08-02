<?php

use App\Http\Controllers\API\v1\FilmController;
use App\Http\Controllers\API\v1\GenreController;
use App\Http\Controllers\API\v1\RatingController;
use App\Http\Controllers\API\v1\ReviewController;
use App\Http\Controllers\API\v1\RoleController;
use App\Http\Controllers\API\v1\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::apiResources([
    'films' => FilmController::class,
    'roles' => RoleController::class,
    'reviews' => ReviewController::class,
    'ratings' => RatingController::class,
    'genres' => GenreController::class,
]);

Route::controller(FilmController::class)->prefix('films')->group(function () {
    Route::post('/{film}/watch', 'watch');
    Route::delete('/{film}/unwatch', 'unwatch');

    Route::post('/{film}/favorite', 'favorite');
    Route::delete('/{film}/unfavorite', 'unfavorite');

    Route::get('/{film}/reviews', 'getReviews');
});

Route::controller(UserController::class)->middleware('auth')->group(
    function () {
        Route::get('/profile', 'profile');
        Route::get('/watched', 'watchedFilms');
        Route::get('/favorite', 'favoriteFilms');
        Route::get('/my-reviews', 'getReviews');
    }
);


