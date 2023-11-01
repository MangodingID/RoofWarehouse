<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\TransactionResource\Widgets\TransactionOverviewWarehouse1;
use App\Filament\Resources\TransactionResource\Widgets\TransactionOverviewWarehouse2;
use App\Filament\Resources\TransactionResource\Widgets\TransactionOverviewWarehouses;
use Kenepa\MultiWidget\MultiWidget;

class TransactionOverviewTabsWidget extends MultiWidget
{
    public array $widgets = [
        TransactionOverviewWarehouses::class,
        TransactionOverviewWarehouse1::class,
        TransactionOverviewWarehouse2::class,
    ];
}
