<?php

namespace App\Filament\Resources\ProductionResource\Widgets;

use App\Models\Production;
use App\Models\Warehouse;
use Filament\Widgets\ChartWidget;

class ProductionChart extends ChartWidget
{
    /**
     * @var string|null
     */
    protected static ?string $heading = 'Produksi';

    /**
     * @var string|null
     */
    protected static ?string $maxHeight = '250px';

    /**
     * @return array|mixed[]
     */
    protected function getData() : array
    {
        $warehouses = Warehouse::warehouse()->get()->map(function (Warehouse $warehouse, $i) {
            $bg = [
                'rgba(252, 165, 165, 0.5)',
                'rgba(134, 239, 172, 0.5)',
            ];

            $bd = [
                'rgba(252, 165, 165, 1.0)',
                'rgba(134, 239, 172, 1.0)',
            ];

            $data = [];
            foreach (range(0, 12) as $month) {
                $data[] = Production::where('warehouse_id', $warehouse->id)->whereMonth('date', $month)->whereYear('date', date('Y'))->sum('amount');
            }

            return [
                'label'           => $warehouse->name,
                'data'            => $data,
                'fill'            => true,
                'backgroundColor' => $bg[$i],
                'borderColor'     => $bd[$i],
            ];
        });

        return [
            'datasets' => $warehouses->toArray(),
            'labels'   => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
        ];
    }

    /**
     * @return array
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
                        'text'    => 'Jumlah Produksi Sirap',
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
