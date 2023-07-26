<?php

use App\Http\Controllers\API\v1\FilmController;
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
]);

Route::controller(FilmController::class)->prefix('films')->middleware('auth')->group(function () {
    Route::get('/{film}/watch', 'watch');
    Route::get('/{film}/unwatch', 'unwatch');
});

Route::controller(UserController::class)->middleware('auth')->group(function () {
    Route::get('/profile', 'profile');
    Route::get('/watched', 'watched');
});


