<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Content\ContentController;
use Illuminate\Http\Request;

class MainController extends Controller
{
    public static function inject($block)
    {
        switch ($block['type']) {
            case 'content':
                return new ContentController($block);
            case 'search':
                return new SearchController();
        }
    }
}
