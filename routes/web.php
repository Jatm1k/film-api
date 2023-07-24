<?php

use App\Http\Controllers\API\v1\AuthController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::controller(AuthController::class)->group(function () {
    Route::post('register', 'register')->middleware('guest');
    Route::post('login', 'login')->middleware('guest');
    Route::delete('logout', 'logout')->middleware('auth');
});
