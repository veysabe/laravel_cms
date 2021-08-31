<?php


namespace App\Helpers;


use Illuminate\Support\Collection;

class Arrays
{
    public static function buildTree($data, $parent = null, &$url = '', &$urls = []) {
        $tree = new Collection();
        foreach ($data as $d) {
            if ($d->parent_section == $parent) {
                $url2 = $url;
                $url2 .= '/' . $d['code'];
                $d->url = $url2;
                $urls[] = $url2;
                $children = self::buildTree($data, $d['id'], $url2, $urls);
                if (!empty($children)) {
                    $d->_children = $children;
                }
                $tree->add($d);
            }
        }
        return $tree;
    }
}
