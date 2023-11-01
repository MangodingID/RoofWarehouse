<?php

namespace App\Filament\Pages\Recap;

use App\Models\Warehouse;
use App\Repository\ProductionRepository;
use Filament\Pages\Page;
use Illuminate\Support\Carbon;

class ProductionRecap extends Page
{
    protected static ?string $navigationGroup = 'REKAP';

    public array $data = [];

    public int $month;

    public int $year;

    public int $grandTotal = 0;

    public ?string $warehouse = null;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.recap';

    protected static ?string $navigationLabel = 'Rekap Produksi';

    protected static ?int $navigationSort = 3;

    /**
     * @return void
     */
    public function mount() : void
    {
        $this->month = date('m');
        $this->year = date('Y');

        $this->refresh();
    }

    /**
     * @return void
     */
    public function export() : void
    {
        $query = [
            'year'      => $this->year,
            'warehouse' => $this->warehouse ?? 'ALL',
            'month'     => $this->month,
        ];

        $this->redirect(route('export') . '?' . http_build_query($query));
    }

    /**
     * @return void
     */
    public function refresh() : void
    {
        $this->data = [];
        $this->grandTotal = 0;

        $this->data = ProductionRepository::getRecapMonthlyGroupByOwners($this->year, $this->month, $this->warehouse);
    }

    /**
     * @return int
     */
    public function maxDays() : int
    {
        return Carbon::create($this->year, $this->month)->daysInMonth;
    }

    /**
     * @return mixed
     */
    public function getWarehouses() : array
    {
        return [
            null => 'Semua Gudang',
            ...Warehouse::all()->pluck('name', 'id')->toArray(),
        ];
    }
}
