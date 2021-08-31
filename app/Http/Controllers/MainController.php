<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Menu\MenuController;
use App\Http\Controllers\URL\URLController;
use App\Models\Section;
use Illuminate\Http\Request;

class MainController extends Controller
{
    public function index()
    {
        $urls = URLController::init()->generateUrls()->slug()->get();
        return view('index');
    }
}
