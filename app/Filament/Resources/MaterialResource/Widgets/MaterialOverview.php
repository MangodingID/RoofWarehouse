<?php

namespace App\Filament\Resources\MaterialResource\Widgets;

use App\Models\Material;
use App\Models\Warehouse;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class MaterialOverview extends BaseWidget
{
    /**
     * @return array|Stat[]
     */
    protected function getStats() : array
    {
        $totalProductionWarehouses = Warehouse::bengkulangan()->get()->map(function ($warehouse) {
            return Stat::make('Total Jumlah Masuk Bengkulangan', format_number(
                Material::source($warehouse)->sum('amount')
            ));
        });

        $totalProductionWarehousesThisMonth = Warehouse::bengkulangan()->get()->map(function ($warehouse) {
            return Stat::make('Jumlah Masuk Bengkulangan Bulan Ini', format_number(
                Material::source($warehouse)->period(date('m'), date('Y'))->sum('amount')
            ));
        });

        return [
            ...$totalProductionWarehouses->toArray(),
            ...$totalProductionWarehousesThisMonth->toArray(),
        ];
    }

    /**
     * @return int
     */
    public function getColumns() : int
    {
        return 2;
    }
}
