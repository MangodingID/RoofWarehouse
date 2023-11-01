<?php

namespace App\Filament\Resources\TransactionResource\Widgets;

use App\Models\Transaction;
use App\Models\Warehouse;
use Carbon\CarbonPeriod;
use Filament\Widgets\ChartWidget;

class TransactionChart extends ChartWidget
{
    protected static ?string $heading = 'Chart';

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

        Warehouse::warehouse()->get()->each(function (Warehouse $warehouse, int $i) use (&$data) {
            $selling = [];
            collect($this->getRangeOfPeriods())->each(function ($date) use ($warehouse, &$selling) {
                $selling[] = Transaction::source($warehouse)->whereMonth('date', $date->format('m'))->whereYear('date', $date->format('Y'))->sum('amount');
            });

            $bg = [
                'rgba(255, 99, 132, .2)',
                'rgba(45, 212, 191, .4)',
            ];

            $data[] = [
                'label'           => $warehouse->name,
                'data'            => $selling,
                'fill'            => true,
                'backgroundColor' => $bg[$i],
            ];
        });

        return [
            'datasets' => $data,
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

    /**
     * @return string
     */
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
    private function getRangeOfPeriods() : CarbonPeriod
    {
        return today()->startOfMonth()->subMonths(11)->monthsUntil(now());
    }
}
