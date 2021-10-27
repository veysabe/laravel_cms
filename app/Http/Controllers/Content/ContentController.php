<?php

namespace App\Http\Controllers\Content;

use App\Http\Controllers\Controller;
use App\Models\Element;
use App\Models\Post;
use App\Models\Section;
use Illuminate\Http\Request;

class ContentController extends Controller
{
    public $table_name;
    public $filter;
    public function __construct($block)
    {
        $this->request = new Request();
        $this->table_name = $block['data']['items'];
        $this->filter = $block['data']['filter'];
    }

    public function draw()
    {
        $table_name = $this->table_name;
        $filter = $this->filter;
        return $this->$table_name($filter);
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
        return $query->with('banner')->get();
    }

    public function items($filter)
    {
        $query = Element::query();
        foreach ($filter as $key => $item) {
            if (is_array($item)) {
                $query = $query->whereIn($key, $item);
            } else {
                $query = $query->where($key, $item);
            }
        }
        return $query->with('banner')->get();
    }

    public function posts($filter)
    {
        $query = Post::query();
        foreach ($filter as $key => $item) {
            if (is_array($item)) {
                $query = $query->whereIn($key, $item);
            } else {
                $query = $query->where($key, $item);
            }
        }
        return $query->with('banner')->get();
    }
}
