<?php

namespace App\Orchid\Layouts\Section;

use App\Models\Section;
use App\Models\SectionProperty;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class SectionListPropertiesLayout extends Table
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'properties';

    public function __construct($section)
    {
        $this->section = $section;
    }

    /**
     * Get the table cells to be displayed.
     *
     * @return TD[]
     */
    protected function columns(): array
    {
        return [
            TD::make('name', 'Название')
                ->render(function (SectionProperty $sectionProperty) {
                    return Link::make($sectionProperty->name)
                        ->route('platform.section.property.edit', [$this->section->id, $sectionProperty->id]);
                }),

            TD::make('sort', 'Сортировка'),

            TD::make('type', 'Тип')
                ->render(function (SectionProperty $sectionProperty) {
                    $text = '';
                    switch ($sectionProperty->type) {
                        case ('STRING'):
                            $text = 'Строка';
                            break;
                        case ('LIST'):
                            $text = 'Список';
                            break;
                    }

                    return $text;
                }),

            TD::make('insert_into_child', 'Прим. в доч. элем.')
                ->render(function (SectionProperty $sectionProperty) {
                    return $sectionProperty->insert_into_child ? 'Да' : 'Нет';
                }),

            TD::make('is_required', 'Обяз.')
                ->render(function (SectionProperty $sectionProperty) {
                    return $sectionProperty->is_required ? 'Да' : 'Нет';
                }),

            TD::make('')
                ->align(TD::ALIGN_RIGHT)
                ->render(function (SectionProperty $sectionProperty) {
                    return DropDown::make()
                        ->icon('menu')
                        ->list([
                            Link::make('Редактировать')
                                ->route('platform.section.property.edit', [$this->section->id, $sectionProperty->id]),

                            Button::make('Удалить')
                                ->icon('trash')
                                ->confirm('Данное действие невозможно отменить')
                                ->method('removeProperty', [
                                    'id' => $sectionProperty->id
                                ])
                        ]);
                }),
        ];
    }

    public function total(): array
    {
        return [
            TD::make()
                ->render(function () {
                    return Link::make('Создать свойство')
                        ->icon('plus')
                        ->route('platform.section.property.edit', $this->section->id);
                }),
        ];
    }
}
