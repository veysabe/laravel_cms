<?php

namespace App\Http\Controllers\URL;

use App\Helpers\Arrays;
use App\Http\Controllers\Controller;
use App\Models\Section;
use Illuminate\Http\Request;

class URLController extends Controller
{
    protected $urls = [];

    public static function init()
    {
        return new self();
    }

    public function get()
    {
        return $this->urls;
    }

    public function getRootUrls()
    {
        $sections = Section::where('parent_section', null)->get();
        Arrays::buildTree($sections, null, $url, $this->urls);
        return $this;
    }

    public function generateUrls()
    {
        $sections = Section::whereIs_active(true)->get();
        Arrays::buildTree($sections, null, $url, $this->urls);
        return $this;
    }

    public function slug()
    {
        foreach ($this->urls as &$url) {
            $url_a = explode('/', $url);
            $root_slug = $url_a[1];
            unset($url_a[0], $url_a[1]);
            foreach ($url_a as $slug) {
                $root_slug = $slug;
            }
            $url_object = new \stdClass();
            $url_object->url = $url;
            $url_object->slug = $root_slug;
            $url = $url_object;
        }
        return $this;
    }
}
