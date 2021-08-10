<?php

namespace App\Orchid\Layouts\Section;

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
        return [];
    }

    public function total(): array
    {
        return [
            TD::make()
                ->render(function () {
                    return Link::make('Создать свойство')
                        ->icon('plus')
                        ->route('platform.section.property.edit', $this->section->id);
                })
        ];
    }
}
