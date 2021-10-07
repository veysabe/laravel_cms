<?php

namespace App\Orchid\Screens;

use App\Models\Page;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Fields\Code;
use Orchid\Screen\Fields\Quill;
use Orchid\Screen\Layout;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Alert;

class HomePageEditScreen extends Screen
{
    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'Редактирование главной страницы';

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
    public function query(): array
    {
        $page = Page::where('url', '/')->first();
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
            Button::make('Применить')
                ->icon('note')
                ->method('createOrUpdate')
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
            \Orchid\Support\Facades\Layout::rows([
                Code::make('page.config')
                    ->language(Code::JS)
                    ->title('Конфигурация'),
            ])
        ];
    }

    public function createOrUpdate(Request $request)
    {
        $page = Page::where('url', '/')->first();
        if (!$page) {
            $page = new Page();
            $page->url = '/';
        }
        $config = $request->get('page')['config'];
        $config = str_replace([' ', "\n", "\t", "\r"], '', $config);
        Alert::success(print_r($request->get('page')['config'], true));
        $page->config = $config;
        $page->save();
    }
}
