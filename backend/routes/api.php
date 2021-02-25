<?php

use App\Http\Controllers\UsersController;
use Illuminate\Http\Request;
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
    Route::post('register', '\\App\\Http\\Controllers\\AuthController@register')->name('register');
    Route::post('login', '\\App\\Http\\Controllers\\AuthController@login')->name('login');
    Route::post('logout', '\\App\\Http\\Controllers\\AuthController@logout')->name('logout');
    Route::post('refresh', '\\App\\Http\\Controllers\\AuthController@refresh')->name('refresh');
    Route::post('me', '\\App\\Http\\Controllers\\AuthController@me')->name('me');
});

Route::group([
    'middleware' => 'api',
], function () {
    Route::resource('users', UsersController::class)->except(['create', 'edit']);
});
