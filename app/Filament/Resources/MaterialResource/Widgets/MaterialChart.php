<?php

namespace App\Filament\Resources\MaterialResource\Widgets;

use App\Models\Material;
use Carbon\CarbonPeriod;
use Filament\Widgets\ChartWidget;

class MaterialChart extends ChartWidget
{
    /**
     * @var string|null
     */
    protected static ?string $heading = 'Bengkulangan';

    /**
     * @var string|null
     */
    protected static ?string $maxHeight = '250px';

    /**
     * @return array
     */
    protected function getData() : array
    {
        $data = [];

        collect($this->getRangeOfPeriods())->each(function ($date) use (&$data) {
            $data[] = Material::whereMonth('date', $date->format('m'))->whereYear('date', $date->format('Y'))->sum('amount');
        });

        return [
            'datasets' => [
                [
                    'label'           => 'Bengkulangan',
                    'data'            => $data,
                    'fill'            => true,
                    'backgroundColor' => 'rgba(45, 212, 191, .4)',
                ],
            ],
            'labels'   => $this->getLabels(),
        ];
    }

    /**
     * @return array|mixed[]|null
     */
    protected function getOptions() : ?array
    {
        return [
            'lineTension' => .4,
            'legend'      => true,
            'scales'      => [
                'y' => [
                    'title' => [
                        'display' => true,
                        'text'    => 'Jumlah Bengkulangan Masuk',
                    ],
                ],
            ],
        ];
    }

    protected function getType() : string
    {
        return 'line';
    }

    /**
     * @return array
     */
    private function getLabels() : array
    {
        $periods = $this->getRangeOfPeriods()->map(function ($date) {
            return $date->format('M') . ' ' . $date->format('Y');
        });

        return collect($periods)->toArray();
    }

    /**
     * @return CarbonPeriod
     */
    private function getRangeOfPeriods() : \Carbon\CarbonPeriod
    {
        return today()->startOfMonth()->subMonths(11)->monthsUntil(now());
    }
}
