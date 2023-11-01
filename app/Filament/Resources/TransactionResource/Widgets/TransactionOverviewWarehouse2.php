<?php

namespace App\Filament\Resources\TransactionResource\Widgets;

use App\Models\Transaction;
use App\Models\Warehouse;
use Illuminate\Database\Eloquent\Collection;

class TransactionOverviewWarehouse2 extends TransactionOverviewWarehouses
{
    /**
     * @return string
     */
    public function getDisplayName()
    {
        return strtoupper(Warehouse::warehouse()->latest('id')->first()->name);
    }

    /**
     * @return Collection
     */
    protected function getTransactions() : Collection
    {
        return Transaction::source(Warehouse::warehouse()->latest('id')->first())->get();
    }

    /**
     * @return Collection
     */
    protected function getTransactionsPeriod() : Collection
    {
        return Transaction::source(Warehouse::warehouse()->latest('id')->first())->period(date('m'), date('Y'))->get();
    }
}
