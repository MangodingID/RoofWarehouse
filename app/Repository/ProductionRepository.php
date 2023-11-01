<?php

namespace App\Repository;

use App\Models\Operator;
use App\Models\Owner;
use App\Models\Production;
use Illuminate\Support\Carbon;

class ProductionRepository
{
    /**
     * @param  int         $year
     * @param  int         $month
     * @param  string|null $warehouse
     * @return array
     */
    public static function getRecapMonthlyGroupByOwners(int $year, int $month, string $warehouse = null) : array
    {
        $data = [];

        foreach (Owner::get() as $owner) {
            $query = self::dailyByOwner($owner, $year, $month);

            $query->when($warehouse, function ($query, $warehouse) {
                return $query->where('warehouse_id', $warehouse);
            });

            $data[] = [
                'name' => $owner->name,
                'ttal' => 0,
                'data' => $query->get()->groupBy('date')->map(function ($production) {
                    return $production->sum('amount');
                }),
            ];
        }

        foreach ($data as $i => $row) {
            $temp = [];
            foreach (range(1, Carbon::create($year, $month)->daysInMonth) as $date) {
                $date = sprintf('%04d-%02d-%02d', $year, $month, $date);
                $temp[$date] = $row['data'][$date] ?? 0;
            }

            $data[$i]['data'] = collect($temp);
        }

        return $data;
    }

    /**
     * @param  Owner $owner
     * @param  int   $year
     * @param  int   $month
     * @return mixed
     */
    protected static function dailyByOwner(Owner $owner, int $year, int $month)
    {
        return Production::own($owner)->whereMonth('date', $month)->whereYear('date', $year);
    }
}
