<?php

namespace App\Http\Controllers;

use App\Models\Warehouse;
use App\Repository\ProductionRepository;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class ExportController extends Controller
{
    public function export(Request $request)
    {
        $year = $request->get('year');
        $month = $request->get('month');
        $warehouse = $request->get('warehouse');

        $filename = strtolower(sprintf('recap-%s-%s', $year, $month));
        if ($warehouse === 'ALL') {
            $warehouse = null;
        }

        if ($warehouse) {
            $filename = strtolower(sprintf('recap-%s-%s-%s', $year, $month, Warehouse::find($warehouse)->name));
        }

        $pdf = Pdf::loadView('recap', [
            'year'       => $year,
            'month'      => $month,
            'maxDays'    => Carbon::create($year, $month)->daysInMonth,
            'data'       => ProductionRepository::getRecapMonthlyGroupByOwners($year, $month, $warehouse),
            'grandTotal' => 0,
        ]);

        return $pdf->setPaper('B4', 'landscape')->stream(str($filename)->snake()->lower() . '.pdf');
    }
}
