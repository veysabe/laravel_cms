<?php

namespace App\Http\Controllers;

use App\Models\Page;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function getPage(Request $request)
    {
        $page = Page::where('url', $request->get('url'))->first();
        return $page;
    }

    public function getData(Request $request)
    {
        $cfg = $request['cfg'];
        if ($cfg['data']) {
            $data_type = $cfg['data']['items'];
            $filter = $cfg['data']['filter'];
        }
        $content = (new MainController())->content($data_type, $filter);
        return $content;
    }
}
