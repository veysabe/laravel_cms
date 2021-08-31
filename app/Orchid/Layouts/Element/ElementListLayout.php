<?php

namespace App\Orchid\Layouts\Element;

use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;
use App\Models\Element;

class ElementListLayout extends Table
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'elements';

    /**
     * Get the table cells to be displayed.
     *
     * @return TD[]
     */
    protected function columns(): array
    {
        return [
            TD::make('id', 'ID'),

            TD::make('name', 'Название')
                ->render(function (Element $element) {
                    return Link::make($element->name)
                        ->route('platform.element.edit', $element);
                }),

            TD::make('sort', 'Сортировка'),

            TD::make('element.section', 'Раздел')
                ->render(function (Element $element) {
                    $sections = $element->section()->get();
                    if ($sections->count() > 1) {
                        $section_list = [];
                        foreach ($sections as $section) {
                            $section_list[] = Link::make($section->name)->route('platform.section.edit', $section);
                        }
                        return DropDown::make('Несколько...')->list($section_list);
                    } else {
                        $section = $sections->first();
                        return Link::make($section->name)
                            ->route('platform.section.edit', $section);
                    }
//                    return Link::make($element->section()->first()->name);
                }),

            TD::make('Действия')
                ->align(TD::ALIGN_RIGHT)
                ->render(function (Element $element) {
                    return DropDown::make()
                        ->icon('options-vertical')
                        ->list([
                            Link::make('Редактировать')
                                ->route('platform.element.edit', $element),

                            Button::make('Удалить')
                                ->icon('trash')
                                ->confirm('Данное действие невозможно отменить')
                                ->method('remove', [
                                    'id' => $element->id
                                ])
                        ]);
                })
        ];
    }
}
