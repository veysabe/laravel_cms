<?php

use App\Helpers\Arrays;
use App\Models\Section;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Menu\MenuController;
use App\Http\Controllers\URL\URLController;

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


Route::get('/', function () {
    return view('index');
});

//$urls = URLController::init()->generateUrls()->slug()->get();
//
//foreach ($urls as $url) {
//    $slug = $url->slug;
//    Route::get($url->url, function () use ($slug) {
//        $section = Section::where('code', $slug)->first();
//        echo "<pre>";
//        echo print_r($section->name, true);
//        echo "</pre>";
//    });
//}
