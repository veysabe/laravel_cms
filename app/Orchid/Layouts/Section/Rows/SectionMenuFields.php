<?php

namespace App\Orchid\Layouts\Section\Rows;

use App\Models\Menu;
use Orchid\Screen\Field;
use Orchid\Screen\Fields\CheckBox;
use Orchid\Screen\Fields\RadioButtons;
use Orchid\Screen\Layouts\Rows;

class SectionMenuFields extends Rows
{
    /**
     * Used to create the title of a group of form elements.
     *
     * @var string|null
     */
    protected $title;

    public function __construct($section)
    {
        $this->section = $section;
    }

    /**
     * Get the fields elements to be displayed.
     *
     * @return Field[]
     */
    protected function fields(): array
    {
        $menu = $this->section->menu()->get();
        $show_menu = isset($menu->id);
        return [
            RadioButtons::make('section.menu.header')
                ->options([
                    true => 'Показывать',
                    false => 'Не показывать',
                    '' => 'По умолчанию'
                ])->title('Шапка'),
            RadioButtons::make('section.menu.footer')
                ->options([
                    true => 'Показывать',
                    false => 'Не показывать',
                    '' => 'По умолчанию'
                ])->title('Подвал'),
            RadioButtons::make('section.menu.hide_children')
                ->options([
                    'header' => 'Шапка',
                    'footer' => 'Подвал',
                    'everywhere' => 'Нигде',
                    '' => 'По умолчанию'
                ])->title('Не показывать вложенные разделы'),
            CheckBox::make('section.menu.hide_everywhere')
                ->placeholder('Не показывать нигде')
                ->value($show_menu && $menu->hide_everywhere == 1),
        ];
    }
}
