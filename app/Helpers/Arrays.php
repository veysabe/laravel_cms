<?php


namespace App\Helpers;


class Arrays
{
    public static function makeParentChildrenTree($parents, $children) {
        $p_temp = [];
        foreach ($parents as $key => $parent) {
            $p_temp[$parent][$children[$key]] = $children[$key];
        }
        $p_temp = array_reverse($p_temp, true);
        foreach ($p_temp as $key => &$value) {
            foreach ($value as $c_key => &$c_value) {
                if (isset($p_temp[$c_key])) {
                    $c_value = $p_temp[$c_key];
                }
            }
        }
        return $p_temp;
    }

    public static function getIds($tree, &$result) {
        foreach ($tree as $k => $j) {
            if(is_array($j)){
                $result[] = $k;
                static::getIds($j, $result);
            } else {
                $result[] = $j;
            }
        }
    }

    public static function getParentIds($tree, $value, &$result, &$flag = false) {
        foreach ($tree as $k => $j) {
            if (is_array($j)) {
                static::getParentIds($j, $value, $result, $flag);
                if ($flag) {
                    $result[$k] = $k;
                }
            }
            if ($j == $value) {
                $flag = true;
            }
        }
    }
}
