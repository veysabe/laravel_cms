<?php

namespace App\Orchid\Screens\Section;

use App\Models\Element;
use App\Models\Property;
use App\Models\Section;
use App\Models\SectionProperty;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Fields\CheckBox;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Relation;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Alert;
use Orchid\Support\Facades\Layout;

class SectionEditScreen extends Screen
{
    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'Создание раздела';

    /**
     * Display header description.
     *
     * @var string|null
     */
    public $description = '';

    /**
     * Query data.
     *
     * @return array
     */
    public function query(Section $section): array
    {
        $this->exists = $section->exists;
        $this->section = $section;

        if ($this->exists) {
            $this->name = 'Редактировать раздел "' . $section->name . '"';
        }

        return [
            'section' => $section
        ];
    }

    /**
     * Button commands.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): array
    {
        return [
            Button::make('Добавить раздел')
                ->icon('check')
                ->method('createOrUpdate')
                ->canSee(!$this->exists),

            Button::make('Применить')
                ->icon('note')
                ->method('createOrUpdate')
                ->canSee($this->exists),

            Button::make('Удалить')
                ->icon('trash')
                ->method('remove')
                ->confirm('Данное действие невозможно отменить')
                ->canSee($this->exists),
        ];
    }

    /**
     * Views.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): array
    {
        // Выводим свойства
        if (!$this->exists) {
            $query_list = Section::query();
        } else {
            $query_list = $this->section->reverseDepth($this->section->id);
        }
        $property_layout = [];

        // Получаем свойства и их значения элемента, который сейчас редактируется
        $property_relation = DB::table('section_property')
            ->where('section_id', $this->section->id)
            ->get();
        $properties = $this->section->properties()->get();

        $values_array = [];
        foreach ($property_relation as $value) {
            $values_array[$value->property_id] = $value->value;
        }

        $property_relation = $property_relation->pluck('id', 'property_id')->toArray();

        // Выводим его на странице редактирования элемента. Вывод меняется в зависимости
        // от типа свойства
        foreach ($properties as $property) {
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

        // Теперь получаем вообще все возможные свойства для вывода во вкладке

        $all_properties_qr = SectionProperty::all();
        $insert_properties = [];
        foreach ($all_properties_qr as $qr_property) {
            $insert_properties[$qr_property->type][] = $qr_property->toArray();
        }

        $activate_property_layout = [];

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


        $fields = [
            Layout::rows([
                Input::make('section.name')
                    ->title('Название')
                    ->placeholder('Введите название элемента')
                    ->required(),

                Input::make('section.code')
                    ->title('Символьный код')
                    ->placeholder('Введите символьный код элемента'),

                Select::make('section.section')
                    ->title('Раздел')
                    ->fromQuery($query_list, 'name')
                    ->multiple(),

                Input::make('section.sort')
                    ->title('Сортировка')
                    ->type('number'),

                CheckBox::make('section.is_active')
                    ->value($this->section->is_active ? 1 : 0)
                    ->placeholder('Активность'),
            ]),
        ];

        if (!empty($property_layout)) {
            $fields[] = Layout::rows($property_layout);
        }

        $fields = Layout::columns($fields);

        $tabs = [
            'Основные поля' => $fields,
            'Настройки' => Layout::rows([]),
            'Активация свойств' => $activate_property_layout,
        ];

        $return_array[] = Layout::tabs(
            $tabs
        );

        return $return_array;
    }

    public function createOrUpdate(Section $section, Request $request)
    {
        DB::transaction(function () use ($request, $section) {
            $request->validate([
                'section.code' => 'alpha_dash|nullable'
            ]);
            $fill = $request->get('section');

            if (!$fill['code']) {
                $fill['code'] = str_slug($fill['name']);
            }

            $fill['is_active'] = isset($fill['is_active']);
            $fill['sort'] = isset($fill['sort']) ? $fill['sort'] : 100;
            $properties = $fill['property'] ?? false;
            $sections = $fill['section'] ?? [];
            $activate_properties = $fill['activate_property'] ?? [];
            unset($fill['property'], $fill['section'], $fill['activate_property']);

            $section->fill($fill)->save();

            $section->section()->sync($sections);
            if ($properties) {
                foreach ($properties as $prop_id => $value) {
                    $section->properties()->sync([$prop_id => ['value' => $value]]);
                }
            }
            $section->properties()->sync(array_keys($activate_properties));
        });
        return redirect()->route('platform.section.list');

    }
}
