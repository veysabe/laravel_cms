<?php

namespace App\Orchid\Screens;

use App\Models\CustomBlock;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Quill;
use Orchid\Screen\Layout;
use Orchid\Screen\Screen;

class CustomBlockEditScreen extends Screen
{
    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'Создать блок';

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
    public function query(CustomBlock $block): array
    {
        $this->exists = $block->exists;
        $this->block = $block;
        if ($this->exists) {
            $this->name = 'Редактировать блок';
        }
        return [
            'block' => $block,
            'fields' => $block->fields()->first()
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
            Button::make('Добавить пост')
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
            \Orchid\Support\Facades\Layout::rows([
                Input::make('block.id')
                    ->title('ID')
                    ->disabled(true)
                    ->canSee($this->exists),
                Input::make('fields.name')
                    ->title('Название'),
                Quill::make('fields.preview_text')
                    ->title('Краткое описание'),
                Quill::make('fields.detail_text')
                    ->title('Детальное описание'),
            ])
        ];
    }
}
