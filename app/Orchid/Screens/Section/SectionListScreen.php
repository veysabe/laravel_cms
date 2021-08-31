<?php

namespace App\Orchid\Screens\Section;

use App\Helpers\Arrays;
use App\Models\Section;
use App\Models\SectionProperty;
use App\Orchid\Layouts\Section\SectionListLayout;
use App\Orchid\Layouts\Section\SectionListPropertiesLayout;
use App\Orchid\Layouts\Section\SectionListSettingsLayout;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;
use Orchid\Screen\Actions\Link;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\Screen;

class SectionListScreen extends Screen
{
    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'Список разделов';

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
    public function query(Section $section): array
    {
        $request = Request::all();
        $sections = Section::all();
        $this->exists = $section->exists;
        $this->section = $section;

        if ($this->exists) {
            $this->name = $section->name;
            $sections = Section::where('parent_section', $section->id)->get();
        }
        if (isset($request['sort'])) {
            $sections = stristr($request['sort'], '-')
                ? $sections->sortByDesc(str_replace('-', '', $request['sort']))
                : $sections->sortBy($request['sort']);
        }
        if (isset($request['filter'])) {
            $sections = Section::query()->get();
            foreach ($request['filter'] as $filter_key => $filter_value) {
                $sections = $sections->filter(function ($value, $key) use ($filter_value, $filter_key) {
                    if (stristr($filter_value, ',')) {
                        $filter_array = explode(',', $filter_value);
                        foreach ($filter_array as &$fil_value) {
                            $fil_value = trim($fil_value);
                        }
                        return in_array($value->$filter_key, $filter_array);
                    }
                    return stristr($value->$filter_key, $filter_value);
                })->all();
            }
        }
        return [
            'sections' => $sections,
            'settings' => $sections,
            'properties' => $section->properties()->get()
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
            Link::make('Создать раздел')
                ->icon('plus')
                ->route('platform.section.edit', ['bs' => $this->section->id]),
            Link::make('Изменить раздел')
                ->icon('pencil')
                ->route('platform.section.edit', $this->section)
                ->canSee($this->exists)
        ];
    }

    /**
     * Views.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): array
    {
        $tabs = [
            'Список' => SectionListLayout::class,
        ];
        if ($this->exists) {
            $tabs['Настройки'] = Layout::view('admin.sectionSettings');
            $tabs['Свойства'] = (new SectionListPropertiesLayout($this->section));
        }
        $layout = Layout::tabs($tabs);
        return [
            $layout
        ];
    }

    public function remove(\Illuminate\Http\Request $request)
    {
        Section::findOrFail($request->get('id'))->delete();

        \Orchid\Support\Facades\Toast::success('Раздел успешно удален');
    }

    public function removeProperty(\Illuminate\Http\Request $request) {
        SectionProperty::findOrFail($request->get('id'))->delete();

        DB::table('section_property')->where('property_id', $request->get('id'))->delete();

        \Orchid\Support\Facades\Toast::success('Свойство успешно удалено');
    }
}
