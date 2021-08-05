<?php

namespace App\Orchid\Screens\Property;

use Orchid\Screen\Screen;

class PropertyEditScreen extends Screen
{
    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'PropertyEditScreen';

    /**
     * Display header description.
     *
     * @var string|null
     */
    public $description = 'PropertyEditScreen';

    /**
     * Query data.
     *
     * @return array
     */
    public function query(): array
    {
        return [];
    }

    /**
     * Button commands.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): array
    {
        return [];
    }

    /**
     * Views.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): array
    {
        return [];
    }
}
