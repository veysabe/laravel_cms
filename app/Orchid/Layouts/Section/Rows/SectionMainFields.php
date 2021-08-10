<?php

namespace App\Orchid\Layouts\Section\Rows;

use Orchid\Screen\Field;
use Orchid\Screen\Fields\CheckBox;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Layouts\Rows;

class SectionMainFields extends Rows
{
    /**
     * Used to create the title of a group of form elements.
     *
     * @var string|null
     */
    protected $title;

    public function __construct($query_list, $section)
    {
        $this->query_list = $query_list;
        $this->section = $section;
    }

    /**
     * Get the fields elements to be displayed.
     *
     * @return Field[]
     */
    protected function fields(): array
    {
        return [
            Input::make('section.name')
                ->title('Название')
                ->placeholder('Введите название элемента')
                ->required(),

            Input::make('section.code')
                ->title('Символьный код')
                ->placeholder('Введите символьный код элемента'),

            Select::make('section.section')
                ->title('Раздел')
                ->fromQuery($this->query_list, 'name')
                ->multiple(),

            Input::make('section.sort')
                ->title('Сортировка')
                ->type('number'),

            CheckBox::make('section.is_active')
                ->value($this->section->is_active ? 1 : 0)
                ->placeholder('Активность'),
        ];
    }
}
