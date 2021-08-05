<?php

namespace App\Orchid\Screens\Element;

use App\Models\Element;
use App\Orchid\Layouts\Element\ElementListLayout;
use Illuminate\Http\Client\Request;
use Orchid\Alert\Toast;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;

class ElementListScreen extends Screen
{
    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'Список элементов';

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
    public function query(Element $element): array
    {
        $request = \Illuminate\Support\Facades\Request::all();
        return [
            'elements' => isset($request['s']) ? $element->inSection($request['s'])->get() : $element::all()
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
            Link::make('Создать элемент')
                ->icon('pencil')
                ->route('platform.element.edit')
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
            ElementListLayout::class
        ];
    }

    public function remove(\Illuminate\Http\Request $request)
    {
        Element::findOrFail($request->get('id'))->delete();

        \Orchid\Support\Facades\Toast::success('Элемент успешно удален');
    }
}
