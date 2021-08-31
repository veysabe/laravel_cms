<?php

namespace App\Orchid\Screens\Property;

use App\Models\Section;
use App\Models\SectionProperty;
use Illuminate\Support\Facades\DB;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Fields\CheckBox;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Matrix;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Screen;
use Orchid\Screen\TD;
use Orchid\Support\Facades\Alert;
use Orchid\Support\Facades\Layout;

class SectionPropertyEdit extends Screen
{
    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'Создать свойство раздела';

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
    public function query(Section $section, SectionProperty $sectionProperty): array
    {
        $this->exists = $sectionProperty->exists;
        if ($this->exists) {
            $this->name = 'Редактировать свойство "' . $sectionProperty->name . '"';
        }
        $this->description = "Раздел «" . $section->name . "» [" . $section->id . "]";
        $this->sectionProperty = $sectionProperty;
        $this->list_values = $sectionProperty->list_values()->get();
        return [
            'sectionProperty' => $sectionProperty,
            'list_values' => $sectionProperty->list_values()->get()
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
            Button::make('Добавить свойство')
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
        return [
            Layout::wrapper('admin.property.propertyEdit', [
                'bar' =>
                    Layout::rows([
                        Input::make('sectionProperty.name')
                            ->title('Название'),
                        Select::make('sectionProperty.type')
                            ->title('Тип')
                            ->options([
                                'LIST' => 'Список',
                                'STRING' => 'Строка',
                            ]),
                        Input::make('sectionProperty.sort')
                            ->title('Сортировка')
                            ->type('number'),
                        CheckBox::make('sectionProperty.is_required')
                            ->placeholder('Обязательное поле'),
                        CheckBox::make('sectionProperty.insert_into_child')
                            ->placeholder('Применить в дочерних разделах'),
                    ])->title('Поля'),
                ]),
            Layout::view('admin.property.propertyEdit')
        ];
//        return [
//            Layout::columns([
//                Layout::rows([
//                    Input::make('sectionProperty.name')
//                        ->title('Название'),
//                    Select::make('sectionProperty.type')
//                        ->title('Тип')
//                        ->options([
//                            'LIST' => 'Список',
//                            'STRING' => 'Строка',
//                        ]),
//                    Input::make('sectionProperty.sort')
//                        ->title('Сортировка')
//                        ->type('number'),
//                    CheckBox::make('sectionProperty.is_required')
//                        ->placeholder('Обязательное поле'),
//                    CheckBox::make('sectionProperty.insert_into_child')
//                        ->placeholder('Применить в дочерних разделах'),
//                ])->title('Поля'),
//                Layout::rows([
//                    Matrix::make('sectionProperty.list_values')
//                        ->columns([
//                            'Значение' => 'value',
//                        ])
//                ])->title('Значения свойства типа "Список"')->canSee($this->sectionProperty->type == 'LIST')
//            ])
//
//        ];
    }

    public function createOrUpdate(Section $section, SectionProperty $sectionProperty, \Illuminate\Http\Request $request)
    {
        $fill = $request->get('sectionProperty');
        $list_values_array = isset($fill['list_values']) ? $fill['list_values'] : [];

        $fill['is_required'] = isset($fill['is_required']);
        $fill['insert_into_child'] = isset($fill['insert_into_child']);
        unset($fill['list_values']);

        if ($sectionProperty->id) {
            $sectionProperty->fill($fill)->save();
            $message = 'Свойство успешно отредактировано';
            Alert::success($message);
        } else {
            $sectionProperty = $section->properties()->create($fill);
            $message = 'Свойство успешно создано';
            Alert::success($message);
        }
        $list_values = [];
        if (!empty($list_values_array)) {
            $sectionProperty->list_values()->where('property_id', $sectionProperty->id)->delete();
            foreach ($list_values_array as $value) {
                $list_value = reset($value);
                $list_values[] = $list_value;
                $sectionProperty->list_values()->create(['property_id' => $sectionProperty->id, 'value' => $list_value]);
            }
        }
        return redirect()->route('platform.section.property.edit', [$section, $sectionProperty]);
    }
}
