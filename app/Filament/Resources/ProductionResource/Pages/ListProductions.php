<?php

namespace App\Filament\Resources\ProductionResource\Pages;

use App\Filament\Resources\ProductionResource;
use App\Models\Warehouse;
use Filament\Actions;
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class ListProductions extends ListRecords
{
    protected static string $resource = ProductionResource::class;

    public function table(Table $table) : Table
    {
        return $table
            ->columns([
                TextColumn::make('warehouse.name')->label('Gudang'),
                TextColumn::make('owner.name')->label('Penggesek'),
                TextColumn::make('amount')->label('Jumlah Sirap'),
                TextColumn::make('date')->label('Tanggal Produksi')->date('d M Y'),
                TextColumn::make('created_at')->label('Tanggal Input')->date('d M Y H:i:s'),
            ])
            ->actions([
                EditAction::make('edit'),
                DeleteAction::make('delete')->requiresConfirmation(),
            ]);
    }

    /**
     * @return array|Action[]|ActionGroup[]
     */
    protected function getHeaderActions() : array
    {
        return [
            Actions\CreateAction::make()->label('TAMBAH')->icon('heroicon-o-plus')->createAnother(false),
        ];
    }

    /**
     * @return array|Tab[]
     */
    public function getTabs() : array
    {
        $warehouses = Warehouse::get()->flatMap(function (Warehouse $warehouse) {
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