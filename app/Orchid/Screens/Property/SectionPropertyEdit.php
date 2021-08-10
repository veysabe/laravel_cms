<?php

namespace App\Orchid\Screens\Property;

use App\Models\Section;
use App\Models\SectionProperty;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Fields\CheckBox;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Matrix;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Screen;
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
        $this->description = "Раздел «" . $section->name . "» [" . $section->id . "]";
        $this->sectionProperty = $sectionProperty;
        return [
            'sectionProperty' => $sectionProperty
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
            Layout::columns([
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
                Layout::rows([
                    Matrix::make('sectionProperty.list_values')
                        ->columns([
                            'Значения'
                        ])
                ])->title('Значения свойства типа "Список"')->canSee($this->sectionProperty->type == 'LIST')
            ])

        ];
    }

    public function createOrUpdate(Section $section, \Illuminate\Http\Request $request)
    {
        $fill = $request->get('sectionProperty');

        Alert::success(print_r($fill,true));

        $fill['is_required'] = isset($fill['is_required']);
        $fill['insert_into_child'] = isset($fill['insert_into_child']);

        $section->properties()->create($fill);
    }
}
