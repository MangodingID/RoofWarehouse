<?php

namespace App\Filament\Resources\TransactionResource\Pages;

use App\Filament\Resources\TransactionResource;
use App\Models\Warehouse;
use Filament\Actions;
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class ListTransactions extends ListRecords
{
    protected static string $resource = TransactionResource::class;

    public function table(Table $table) : Table
    {
        return $table
            ->columns([
                TextColumn::make('date')->label('Tanggal Produksi')->date('d M Y'),
                TextColumn::make('warehouse.name')->label('Gudang'),
                TextColumn::make('amount')->label('Jumlah'),
                TextColumn::make('price')->label('Harga Satuan')->money('IDR', true),
                TextColumn::make('total')->label('Total')->money('IDR', true),
            ]);
    }

    /**
     * @return array|Action[]|ActionGroup[]
     */
    protected function getHeaderActions() : array
    {
        return [
            Actions\CreateAction::make()->label('TAMBAH')->icon('heroicon-o-plus')->createAnother(false)->modalWidth('3xl'),
        ];
    }

    /**
     * @return array|Tab[]
     */
    public function getTabs() : array
    {
        $warehouses = Warehouse::warehouse()->get()->flatMap(function (Warehouse $warehouse) {
            return [
                Str::slug($warehouse->name) => Tab::make()->label($warehouse->name)->query(function ($query) use ($warehouse) {
                    $query->where('warehouse_id', $warehouse->id);
                }),
            ];
        })
            ->toArray();

        return array_merge([
            null => Tab::make()->label('Semua'),
        ], $warehouses);
    }
}
