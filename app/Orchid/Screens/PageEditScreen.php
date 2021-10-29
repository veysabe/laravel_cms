<?php

namespace App\Orchid\Screens;

use App\Models\Page;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Fields\Code;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;

class PageEditScreen extends Screen
{
    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'Создание страницы';

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
    public function query(Page $page): array
    {
        $this->exists = $page->exists;
        $this->page = $page;
        if ($this->exists) {
            $this->name = 'Редактировать страницу';
            $this->description = $page->name;
        }
        return [
            'page' => $page
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
            Button::make('Создать')
                ->icon('plus')
                ->method('createOrUpdate')
                ->canSee(!$this->exists),
            Button::make('Применить')
                ->icon('note')
                ->method('createOrUpdate')
                ->canSee($this->exists),
            Button::make('Удалить')
                ->icon('trash')
                ->method('remove')
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
            Layout::rows([
                Input::make('page.name')
                    ->title('Название'),
                Input::make('page.url')
                    ->title('URL'),
                Code::make('page.config')
                    ->language(Code::JS)
                    ->title('Конфигурация'),
            ])
        ];
    }
}
