<?php


namespace App\Helpers;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Orchid\Screen\Actions\Menu;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Select;

class Section
{
    public static function makePropertiesList($section): array
    {
        $properties = $section->properties()->get();

        if ($properties->isNotEmpty()) {
            $properties = new Collection();
        }

        $res = [];

        $property_layout = [];
        // Получаем свойства (и их значения) элемента, который сейчас редактируется
        $property_relation = DB::table('section_property')
            ->where('section_id', $section->id)
            ->get();

        $values_array = [];
        $parent_id = $section->parent_section;
        while ($parent_id) {
            $parent_section = \App\Models\Section::find($parent_id);
            $parent_id = $parent_section->parent_section;
            $properties_ = $parent_section->properties()->get();
            foreach ($properties_ as $property) {
                $property->parent = $parent_section;
                $properties->add($property);
            }
        }
        foreach ($property_relation as $value) {
            $values_array[$value->property_id] = $value->value;
        }

        // Выводим его на странице редактирования элемента. Вывод меняется в зависимости
        // от типа свойства
        foreach ($properties as $property) {
            if (!isset($property->id)) {
                continue;
            }
            $property_value = isset($values_array[$property->id]) ? $values_array[$property->id] : '';
            if ($property->type == 'STRING') {
                $property_layout[] = Input::make('section.property.' . $property->id)
                    ->title($property->name)
                    ->required($property->is_required == 1)
                    ->value($property_value)
                    ->help(isset($property->parent) ? 'Родитель: ' . $property->parent->name : '');
            } elseif ($property->type == 'LIST') {
                $property_values = $property->list_values->pluck('value', 'id');
                if ($property_values->isNotEmpty()) {
                    $current_property = $property_values->pull($property_value);
                    $property_values->prepend($current_property, $property_value);
                }
                $property_values = $property_values->toArray();
                $property_layout[] = Select::make('section.property.' . $property->id)
                    ->title($property->name)
                    ->required($property->is_required == 1)
                    ->options($property_values)
                    ->help(isset($property->parent) ? 'Родитель: ' . $property->parent->name : '');;
            }
        }

        return $property_layout;
    }

    public static function makeTreeMenu($tree, $p = null, $menu = [])
    {
        foreach ($tree as $i => $t) {
            $menu[$t['id']] = Menu::make($t['name'])
                ->route('platform.section.list', $t['id'])
                ->icon('folder');

            if (isset($t['_children'])) {
                $list = self::makeTreeMenu($t['_children'], $t['parent_section']);
                $menu[$t['id']]->list($list);
            }
        }
        return $menu;
    }
}
