<?php

namespace App\Filament\Resources\ProductionResource\Widgets;

use App\Models\Production;
use App\Models\Warehouse;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class ProductionOverview extends BaseWidget
{
    /**
     * @return array|Stat[]
     */
    protected function getStats() : array
    {
        $totalProductionWarehouses = Warehouse::warehouse()->get()->map(function ($warehouse, $i) {
            $cls = [
                'success', 'info', 'warning', 'danger',
            ];

            return Stat::make('Total Produksi ' . $warehouse->name, format_number(
                Production::source($warehouse)->sum('amount')
            ))
                ->chart(random_chart_data())
                ->color($cls[$i]);
        });

        $totalProductionWarehousesThisMonth = Warehouse::warehouse()->get()->map(function ($warehouse, $i) {
            $cls = [
                'success', 'info', 'warning', 'danger',
            ];

            return Stat::make('Total Produksi ' . $warehouse->name, format_number(
                Production::source($warehouse)->period(date('m'), date('Y'))->sum('amount')
            ))
                ->chart(random_chart_data())
                ->color($cls[$i]);
        });

        return [
            Stat::make('Total Produksi', format_number(Production::sum('amount')))
                ->chart(random_chart_data())
                ->color('danger'),
            ...$totalProductionWarehouses->toArray(),

            Stat::make('Total Produksi Bulan Ini', format_number(Production::period(date('m'), date('Y'))->sum('amount')))
                ->chart(random_chart_data())
                ->color('danger'),
            ...$totalProductionWarehousesThisMonth->toArray(),
        ];
    }
}
