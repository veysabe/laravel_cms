<?php

namespace App\Http\Controllers;

use App\Models\Page;
use Illuminate\Http\Request;

class PageController extends Controller
{
    /**
     * Возвращает из БД настройки страницы. URL страницы передается
     * в POST-запросе в параметре "url"
     *
     * @param Request $request
     * @return mixed
     *
     * Возвращает объект класса Collection
     */
    public function getPage(Request $request)
    {
        $page = Page::where('url', $request->get('url'))->first()->toJson();
        return $page;
    }

    /**
     * Принимает параметры блока через POST-запрос в параметре "cfg"
     *
     * @param Request $request
     * @return int
     *
     * Возд
     */
    public function getData(Request $request)
    {
        $cfg = $request['cfg'];
        if ($cfg['data']) {
            $data_type = $cfg['data']['items'];
            $filter = $cfg['data']['filter'];
            return (new MainController())->content($data_type, $filter);
        }
        return 0;
    }
}
