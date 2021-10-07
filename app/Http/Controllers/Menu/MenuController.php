<?php

namespace App\Http\Controllers\Menu;

use App\Helpers\Arrays;
use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\Section;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    protected $submenu = true;

    public function render($tree, $r = 0, $p = null, $menu_type = 'header')
    {
        foreach ($tree as $i => $t) {
            echo "<div class='parent'>";
            echo '- <a href="' . $t['url'] . '">' . $t['name'] . '</a>';
            $hide_children = isset($t['menu']['hide_children'])
                && ($t['menu']['hide_children'] == $menu_type || $t['menu']['hide_children'] == 'everywhere');
            if (count($t['_children']) > 0 && !$hide_children) {
                echo '<div class="child" style="padding-left: 20px">';
                $this->render($t['_children'], ++$r, $t['parent_section']);
                echo '</div>';
                --$r;
            }
            echo "</div>";
        }
    }

    public static function init(Request $request)
    {
        $menu_type = $request->get('type');
        $sections = Section::whereHas('menu', function ($query) use ($menu_type) {
            $query->where(function ($q) use ($menu_type) {
                $q->where($menu_type, true)
                    ->orWhere($menu_type, null);
            })->where('hide_everywhere', null);
        })->orWhereDoesntHave('menu')->where('is_active', true)->with('menu')->get();
        $tree = Arrays::buildTree($sections);
        return $tree->toJson();
//        echo '<div class="header">';
//        (new MenuController)->render($tree->toArray(), 0, null, $menu_type);
//        echo '</ul>';
    }
}
