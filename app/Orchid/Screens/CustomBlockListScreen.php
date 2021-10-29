<?php

namespace App\Orchid\Screens;

use App\Models\CustomBlock;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;
use Orchid\Screen\TD;
use Orchid\Support\Facades\Layout;

class CustomBlockListScreen extends Screen
{
    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'Кастомные блоки';

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
        return [
            'blocks' => CustomBlock::all()
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
            Link::make('Создать блок')
            ->route('platform.block.edit')
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
            Layout::table('blocks', [
                TD::make('Название')
                    ->render(function (CustomBlock $block) {
                        return Link::make($block->fields()->first()->name)
                            ->route('platform.block.edit', $block);
                    })
            ]),

        ];
    }
}
