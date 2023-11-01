<?php

namespace App\Filament\Resources\Widgets;

use App\Models\Production;
use App\Models\Warehouse;
use Filament\Widgets\ChartWidget;

class ProductionChart extends ChartWidget
{
    protected static ?string $heading = 'Chart';

    protected static ?string $maxHeight = '250px';

    protected function getData() : array
    {
        $warehouses = Warehouse::get()->map(function (Warehouse $warehouse, $i) {
            $bg = [
                'rgba(255, 99, 132, .2)',
                'rgba(45, 212, 191, .4)',
                'rgba(45, 212, 191, .4)',
            ];

            $data = [];
            foreach (range(0, 12) as $month) {
                $data[] = Production::where('warehouse_id', $warehouse->id)->whereMonth('date', $month)->whereYear('date', date('Y'))->sum('result');
            }

            return [
                'label'           => $warehouse->name,
                'data'            => $data,
                'fill'            => true,
                'backgroundColor' => $bg[$i],
            ];
        });

        return [
            'datasets' => $warehouses->toArray(),
            'labels'   => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
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
                        'text'    => 'Jumlah Transaksi',
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
}
