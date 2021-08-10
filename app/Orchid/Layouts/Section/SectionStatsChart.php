<?php

namespace App\Orchid\Layouts\Section;

use Orchid\Screen\Layouts\Chart;

class SectionStatsChart extends Chart
{
    /**
     * Add a title to the Chart.
     *
     * @var string
     */
    protected $title = 'Super Chart';

    /**
     * Available options:
     * 'bar', 'line',
     * 'pie', 'percentage'.
     *
     * @var string
     */
    protected $type = 'bar';

    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the chart.
     *
     * @var string
     */
    protected $target = 'charts';

    /**
     * Determines whether to display the export button.
     *
     * @var bool
     */
    protected $export = true;
}
