<?php

namespace App\Orchid\Screens\Section;

use App\Models\Element;
use App\Models\Property;
use App\Models\Section;
use App\Models\SectionProperty;
use App\Orchid\Layouts\Examples\ChartBarExample;
use App\Orchid\Layouts\Section\Rows\SectionMainFields;
use App\Orchid\Layouts\Section\SectionStatsChart;
use App\Orchid\Layouts\Section\Metric\SectionStatsMetric;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Fields\CheckBox;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Relation;
use Orchid\Screen\Fields\Select;
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
        $query_list = $this->exists
            ? $this->section->reverseDepth()
            : Section::query();
        $property_layout = \App\Helpers\Section::makePropertiesList($this->section);

        $fields = [];
        $main_fields = [
            (new SectionMainFields($query_list, $this->section)),
        ];
        if (!empty($property_layout)) {
            $main_fields[] = Layout::rows($property_layout)->title('Свойства');
        }

        $fields[] = Layout::columns($main_fields);

        $tabs = [
            'Основные поля' => $main_fields,
            'Настройки' => Layout::rows([]),
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
            $activate_properties = $fill['activate_property'] ?? [];
            unset($fill['property'], $fill['section'], $fill['activate_property']);

            $section->fill($fill)->save();

            $section->section()->sync($sections);
            if ($properties) {
                foreach ($properties as $prop_id => $value) {
                    $section->properties()->sync([$prop_id => ['value' => $value]]);
                }
            }
            $section->properties()->sync(array_keys($activate_properties));
        });
        return redirect()->route('platform.section.list');

    }
}
