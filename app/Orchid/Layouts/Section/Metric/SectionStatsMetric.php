<?php

namespace App\Orchid\Layouts\Section\Metric;

use Orchid\Screen\Layouts\Metric;

class SectionStatsMetric extends Metric
{
    /**
     * Get the labels available for the metric.
     *
     * @return array
     */
    protected $labels = [
        'Просмотры',
        'Поделились',
        'Изменения, %'
    ];

    /**
     * The name of the key to fetch it from the query.
     *
     * @var string
     */
    protected $target = 'metrics';
}
