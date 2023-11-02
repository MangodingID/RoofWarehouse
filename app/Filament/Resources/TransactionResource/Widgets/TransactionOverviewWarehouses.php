<?php

namespace App\Filament\Resources\TransactionResource\Widgets;

use App\Models\Transaction;
use App\Repository\TransactionRepository;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Database\Eloquent\Collection;

class TransactionOverviewWarehouses extends BaseWidget
{
    protected TransactionRepository $repository;

    /**
     *
     */
    public function __construct()
    {
        $this->repository = new TransactionRepository;
    }

    /**
     * @return string
     */
    public function getDisplayName()
    {
        return 'SEMUA GUDANG';
    }

    /**
     * @return array|Stat[]
     */
    protected function getStats() : array
    {
        $transaction = $this->getTransactions();
        $transactionPeriod = $this->getTransactionsPeriod();

        return [
            Stat::make('Total Penjualan', format_money($transaction->sum('total')))
                ->chart(random_chart_data())
                ->color('success'),
            Stat::make('Total Sirap Terjual', format_number($transaction->sum('amount')))
                ->chart(random_chart_data())
                ->color('info'),
            Stat::make('Penjualan Bulan Ini', format_money($transactionPeriod->sum('total')))
                ->chart(random_chart_data())
                ->color('warning'),
            Stat::make('Sirap Terjual Bulan Ini', format_number($transactionPeriod->sum('amount')))
                ->chart(random_chart_data())
                ->color('danger'),
        ];
    }

    /**
     * @return int
     */
    protected function getColumns() : int
    {
        return 4;
    }

    /**
     * @return Collection
     */
    protected function getTransactions() : Collection
    {
        return Transaction::get();
    }

    /**
     * @return Collection
     */
    protected function getTransactionsPeriod() : Collection
    {
        return Transaction::period(date('m'), date('Y'))->get();
    }
}
