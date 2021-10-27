<?php

namespace App\Orchid\Screens\Section;

use App\Models\Element;
use App\Models\Property;
use App\Models\Section;
use App\Models\SectionProperty;
use App\Orchid\Layouts\Examples\ChartBarExample;
use App\Orchid\Layouts\Section\Rows\SectionMainFields;
use App\Orchid\Layouts\Section\Rows\SectionMenuFields;
use App\Orchid\Layouts\Section\SectionStatsChart;
use App\Orchid\Layouts\Section\Metric\SectionStatsMetric;
use Illuminate\Http\Request;
use Illuminate\Mail\Markdown;
use Illuminate\Support\Facades\DB;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Fields\CheckBox;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Picture;
use Orchid\Screen\Fields\Quill;
use Orchid\Screen\Fields\Relation;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Fields\SimpleMDE;
use Orchid\Screen\Fields\TextArea;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Alert;
use Orchid\Support\Facades\Layout;

class SectionEditScreen extends Screen
{
    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'Создание раздела';

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
        $this->exists = $section->exists;
        $this->section = $section;

        if ($this->exists) {
            $this->name = 'Редактировать раздел "' . $section->name . '"';
            $metrics_q = $this->section->social()->first(['watch', 'share', 'change_percentage'])->toArray();
            $metrics = [];
            foreach ($metrics_q as $metric) {
                $metrics[] = [
                    'keyValue' => number_format($metric, 0),
                    'keyDiff' => 0
                ];
            }
            $return_array['metrics'] = $metrics;
        }

        $return_array['section'] = $section;

        return $return_array;
    }

    /**
     * Button commands.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): array
    {
        return [
            Button::make('Добавить раздел')
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
        // Выводим свойства
        $query_list = Section::query();

        $property_layout = \App\Helpers\Section::makePropertiesList($this->section);

        $fields = [];
        $main_fields = [
            (new SectionMainFields($query_list, $this->section)),
        ];
        if (!empty($property_layout)) {
            $main_fields[] = Layout::rows($property_layout)->title('Свойства');
        }

        $fields[] = Layout::columns($main_fields);

        $banner_fields = [
            Layout::rows([
                Input::make('section.banner.title')
                    ->title('Заголовок'),
                Quill::make('section.banner.text')
                    ->title('Текст'),
                Input::make('section.banner.href')
                    ->title('Ссылка'),
                Input::make('section.banner.button_text')
                    ->title('Текст на кнопке'),
                Picture::make('section.banner.picture')
                    ->title('Фоновое изображение')
            ])
        ];

        $tabs = [
            'Основные поля' => $main_fields,
            'Настройки' => [
                (new SectionMenuFields($this->section)),
                Layout::rows([
                    SimpleMDE::make('markdown')
                ])
            ],
            'Баннер' => $banner_fields
        ];

        if ($this->exists) {
            $return_array[] = SectionStatsMetric::class;
        }

        $return_array[] = Layout::tabs(
            $tabs
        );

        return $return_array;
    }

    public function createOrUpdate(Section $section, Request $request)
    {
        DB::transaction(function () use ($request, $section) {
            $request->validate([
                'section.code' => 'alpha_dash|nullable'
            ]);
            $fill = $request->get('section');

            if (!$fill['code']) {
                $fill['code'] = str_slug($fill['name']);
            }

            $fill['is_active'] = isset($fill['is_active']);
            $fill['sort'] = isset($fill['sort']) ? $fill['sort'] : 100;
            $properties = $fill['property'] ?? false;
            $sections = $fill['section'] ?? [];
            $menu_setup = $fill['menu'] ?? false;

            unset($fill['property'], $fill['section'], $fill['activate_property'], $fill['main_section'], $fill['menu']);

            $section->fill($fill)->save();

            $section->section()->sync($sections);
            if ($properties) {
                foreach ($properties as $prop_id => $value) {
                    $property_db = DB::table('section_property')->where(['property_id' => $prop_id, 'section_id' => $section->id]);
                    if ($property_db->get()->isNotEmpty()) {
                        $property_db->update(['value' => $value]);
                    } else {
                        DB::table('section_property')->insert(['property_id' => $prop_id, 'section_id' => $section->id, 'value' => $value]);
                    }
                }
            }
            $section->menu()->delete();
            if ($menu_setup) {
                $do_delete = true;
                foreach ($menu_setup as &$value) {
                    if (strlen($value)) $do_delete = false;
                    if ($value == 'on') $value = true;
                }
                if (!$do_delete) {
                    $section->menu()->create($menu_setup);
                }
            }
        });
        return redirect()->route('platform.section.edit', $section);

    }
}
