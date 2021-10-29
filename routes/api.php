<?php

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/menu/get/{type}', [\App\Http\Controllers\Menu\MenuController::class, 'init']);

Route::post('/page/', [\App\Http\Controllers\PageController::class, 'getPage']);

Route::post('/section/', [\App\Http\Controllers\PageController::class, 'getSection']);

Route::post('/page/content/', [\App\Http\Controllers\MainController::class, '']);

