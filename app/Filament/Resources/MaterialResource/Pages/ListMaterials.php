<?php

namespace App\Filament\Resources\MaterialResource\Pages;

use App\Filament\Resources\MaterialResource;
use Filament\Actions;
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Resources\Pages\ListRecords;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ListMaterials extends ListRecords
{
    protected static string $resource = MaterialResource::class;

    /**
     * @return string[]
     */
    protected function getHeaderWidgets() : array
    {
        return [
            MaterialResource\Widgets\MaterialChart::class,
        ];
    }

    /**
     * @return int
     */
    public function getHeaderWidgetsColumns() : int|string|array
    {
        return 1;
    }

    /**
     * @param  Table $table
     * @return Table
     */
    public function table(Table $table) : Table
    {
        return $table
            ->columns([
                TextColumn::make('date')->label('Tanggal')->date('d M Y'),
                TextColumn::make('owner.name')->label('Nama'),
                TextColumn::make('amount')->label('Jumlah'),
                TextColumn::make('warehouse.name')->label('Gudang'),
            ])
            ->actions([
                EditAction::make('edit')->label('UBAH'),
                DeleteAction::make('delete')->label('HAPUS')->requiresConfirmation(),
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
}
