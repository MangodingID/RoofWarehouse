<?php

namespace App\Filament\Resources\TransactionResource\Widgets;

use App\Models\Transaction;
use App\Models\Warehouse;
use Illuminate\Database\Eloquent\Collection;

class TransactionOverviewWarehouse1 extends TransactionOverviewWarehouses
{
    /**
     * @return string
     */
    public function getDisplayName()
    {
        return strtoupper(Warehouse::warehouse()->first()->name);
    }

    /**
     * @return Collection
     */
    protected function getTransactions() : Collection
    {
        return Transaction::source(Warehouse::warehouse()->first())->get();
    }

    /**
     * @return Collection
     */
    protected function getTransactionsPeriod() : Collection
    {
        return Transaction::source(Warehouse::warehouse()->first())->period(date('m'), date('Y'))->get();
    }
}
