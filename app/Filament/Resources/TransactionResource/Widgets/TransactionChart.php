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
        $total = [];

        Warehouse::warehouse()->get()->each(function (Warehouse $warehouse, int $i) use (&$data, &$total) {
            $selling = [];
            collect($this->getRangeOfPeriods())->each(function ($date, $i) use ($warehouse, &$selling, &$total) {
                $selling[$i] = Transaction::source($warehouse)->whereMonth('date', $date->format('m'))->whereYear('date', $date->format('Y'))->sum('amount');
                $total[$i] = $selling[$i] + ($total[$i] ?? 0);
            });

            $bg = [
                'rgba(252, 165, 165, 0.5)',
                'rgba(134, 239, 172, 0.5)',
            ];

            $bd = [
                'rgba(252, 165, 165, 1.0)',
                'rgba(134, 239, 172, 1.0)',
            ];

            $data[] = [
                'label'           => $warehouse->name,
                'data'            => $selling,
                'fill'            => true,
                'backgroundColor' => $bg[$i],
                'borderColor'     => $bd[$i],
            ];
        });

        $data = array_merge($data, [
            [
                'label'           => 'Semua Gudang',
                'data'            => $total,
                'fill'            => true,
                'backgroundColor' => 'rgba(165, 180, 252, 0.5)',
                'borderColor'     => 'rgba(165, 180, 252, 1.0)',
            ],
        ]);

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
