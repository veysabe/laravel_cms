<?php

namespace App\Orchid\Layouts\Section;

use App\Models\Section;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class SectionListLayout extends Table
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'sections';

    /**
     * Get the table cells to be displayed.
     *
     * @return TD[]
     */
    protected function columns(): array
    {
        return [
            TD::make('name', 'Название')
                ->render(function (Section $section) {
                    return Link::make($section->name)
                        ->route('platform.section.list', $section);
                })
                ->filter(TD::FILTER_TEXT),

            TD::make('id', 'ID')
                ->sort(),

            TD::make('is_active', 'Активность')
                ->sort()
                ->render(function (Section $section) {
                    return $section->is_active ? 'Да' : 'Нет';
                }),

            TD::make('sort', 'Сорт.')
                ->sort(),

            TD::make('updated_at', 'Дата изменения')
                ->sort()
                ->render(function (Section $section) {
                    return $section->created_at->toDateTimeString();
                }),

            TD::make('section.social.watch', 'Просмотры')
                ->sort()
                ->render(function (Section $section) {
                    $social = $section->social()->first();
                    return $social ? $social['watch'] : 0;
                }),

            TD::make('section.social.share', 'Поделились')
                ->sort()
                ->render(function (Section $section) {
                    $social = $section->social()->first();
                    return $social ? $social['share'] : 0;
                }),

            TD::make('section.social.change_percentage', 'Изм., %')
                ->sort()
                ->render(function (Section $section) {
                    $social = $section->social()->first();
                    return $social ? $social['change_percentage'] : 0;
                }),

            TD::make('')
                ->align(TD::ALIGN_LEFT)
                ->render(function (Section $section) {
                    return DropDown::make()
                        ->icon('menu')
                        ->list([
                            Link::make('Редактировать')
                                ->route('platform.section.edit', $section),

                            Button::make('Удалить')
                                ->icon('trash')
                                ->confirm('Данное действие невозможно отменить')
                                ->method('remove', [
                                    'id' => $section->id
                                ])
                        ]);
                }),
        ];
    }

    public function total(): array
    {
        return [
            TD::make()
                ->align(TD::ALIGN_LEFT)
                ->render(function () {
                    return Link::make('Создать раздел')
                        ->icon('plus')
                        ->route('platform.section.edit');
                })
        ];
    }
}
