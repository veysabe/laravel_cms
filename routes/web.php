<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use App\Models\Section;
use App\Models\Element;

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

Route::get('/{section}', function (Section $section) {
    echo "<pre>";
    echo print_r($section->reverseDepth($section->id)->get()->toArray(), true);
    echo "</pre>";
});
