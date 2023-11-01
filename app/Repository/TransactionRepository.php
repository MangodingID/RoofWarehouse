<?php

namespace App\Repository;

use App\Models\Transaction;
use Illuminate\Database\Eloquent\Collection;

class TransactionRepository
{
    /**
     * @return Collection
     */
    public function getSellingAll() : Collection
    {
        return Transaction::get();
    }

    /**
     * @param  int $month
     * @param  int $year
     * @return mixed
     */
    public function getSellingByMonth(int $month, int $year)
    {
        return Transaction::whereMonth('date', $month)->whereYear('date', $year)->get();
    }

    public function getSellingThisMonth()
    {
        return $this->getSellingByMonth(date('m'), date('Y'));
    }

    /**
     * @param  int $month
     * @param  int $year
     * @return float
     */
    public function getSellingItemByMonth(int $month, int $year) : float
    {
        return Transaction::whereMonth('date', $month)->whereYear('date', $year)->sum('amount');
    }

    /**
     * @return float
     */
    public function getSellingItemThisMonth() : float
    {
        return $this->getSellingItemByMonth(date('m'), date('Y'));
    }
}
