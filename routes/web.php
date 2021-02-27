<?php

use App\Http\Controllers\APIController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/swagger-ui', [APIController::class, 'swagger'])
    ->name('swagger');
Route::get('/redoc', [APIController::class, 'redoc'])
    ->name('redoc-ui');
Route::get('/swagger.json', [APIController::class, 'json'])
    ->name('swagger.json');

Route::get('{any}', function () {
    return view('app');
})->where('any', '.*');
