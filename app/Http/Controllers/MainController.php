<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Menu\MenuController;
use App\Http\Controllers\URL\URLController;
use App\Models\Page;
use App\Models\Section;
use Illuminate\Http\Request;

class MainController extends Controller
{
    public function __construct()
    {
        $this->request = new Request();
    }

    public function banner()
    {

    }

    public function content($table_name, $filter)
    {
        $data = $this->$table_name($filter);
        return $data;
    }

    public function sections($filter)
    {
        $query = Section::query();
        foreach ($filter as $key => $item) {
            if (is_array($item)) {
                $query = $query->whereIn($key, $item);
            } else {
                $query = $query->where($key, $item);
            }
        }
        return $query->get();
    }
}
