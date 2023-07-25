<?php

use App\Http\Controllers\API\v1\FilmController;
use App\Http\Controllers\API\v1\RoleController;
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

Route::get('user', function () {
    return new \App\Http\Resources\API\v1\UserResource(auth()->user());
})->middleware(['auth']);


