<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UsersController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function () {
    Route::post('register', [AuthController::class, 'register'])
        ->name('register');
    Route::post('login', [AuthController::class, 'login'])
        ->name('login');
    Route::post('logout', [AuthController::class, 'logout'])
        ->name('logout');
    Route::post('refresh', [AuthController::class, 'refresh'])
        ->name('refresh');
    Route::post('me', [AuthController::class, 'me'])
        ->name('me');
});

Route::apiResources([
    'users' => UsersController::class,
], [
    'middleware' => 'api',
    'except' => ['create', 'edit']
]);
