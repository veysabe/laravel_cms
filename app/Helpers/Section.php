<?php


namespace App\Helpers;


use App\Models\SectionProperty;
use Illuminate\Support\Facades\DB;
use Orchid\Screen\Fields\CheckBox;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Select;
use Orchid\Support\Facades\Layout;

class Section
{
    public static function makePropertiesList($section): array
    {
        $properties = $section->properties()->get()->isNotEmpty() ? $section->properties()->get() : [];

        $parents = $section->getParents()->get();
        foreach ($parents as $parent) {
            $property = $parent->properties()->where('section_properties.insert_into_child', true)->get();
            if ($property->isNotEmpty()) {
                $properties[] = $property;
            }
        }

        $property_layout = [];
        // Получаем свойства и их значения элемента, который сейчас редактируется
        $property_relation = DB::table('section_property')
            ->where('section_id', $section->id)
            ->get();

        $values_array = [];
        foreach ($property_relation as $value) {
            $values_array[$value->property_id] = $value->value;
        }

        $property_relation = $property_relation->pluck('id', 'property_id')->toArray();

        // Выводим его на странице редактирования элемента. Вывод меняется в зависимости
        // от типа свойства
        foreach ($properties as $property) {
            $property = $property->first();
            $property_value = $values_array[$property->id];
            if ($property->type == 'STRING') {
                $property_layout[] = Input::make('section.property.' . $property->id)
                    ->title($property->name)
                    ->required($property->is_required > 1)
                    ->value($property_value);
            } elseif ($property->type == 'LIST') {
                $property_values = $property->list_values->pluck('value', 'id');
                if ($property_values->isNotEmpty()) {
                    $current_property = $property_values->pull($property_value);
                    $property_values->prepend($current_property, $property_value);
                }
                $property_values = $property_values->toArray();
                $property_layout[] = Select::make('section.property.' . $property->id)
                    ->title($property->name)
                    ->required($property->is_required > 1)
                    ->options($property_values);
            }
        }

        return $property_layout;
    }

    public static function getAllSectionProperties()
    {

        // Теперь получаем вообще все возможные свойства для вывода во вкладке
        $activate_property_layout = [];
        $insert_properties = [];

        $all_properties_qr = SectionProperty::all();
        foreach ($all_properties_qr as $qr_property) {
            $insert_properties[$qr_property->type][] = $qr_property->toArray();
        }

        foreach ($insert_properties as $type_key => $insert_property) {
            $current_props = [];
            foreach ($insert_property as $item) {
                $current_props[] = CheckBox::make('section.activate_property.' . $item['id'])
                    ->value(isset($property_relation[$item['id']]) ? 1 : 0)
                    ->placeholder($item['name'])
                    ->help('Тип: ' . $item['type']);
            }
            $current_row = Layout::rows($current_props);
            $activate_property_layout[] = Layout::columns([$current_row]);
        }

        return $activate_property_layout;
    }
}
