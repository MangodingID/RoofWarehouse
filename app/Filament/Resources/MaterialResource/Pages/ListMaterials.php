<?php

namespace App\Filament\Resources\MaterialResource\Pages;

use App\Filament\Resources\MaterialResource;
use App\Models\Owner;
use Filament\Actions;
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Resources\Pages\ListRecords;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;

class ListMaterials extends ListRecords
{
    protected static string $resource = MaterialResource::class;

    /**
     * @return string[]
     */
    protected function getHeaderWidgets() : array
    {
        return [
            MaterialResource\Widgets\MaterialOverview::class,
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
            ])
            ->bulkActions([
                ExportBulkAction::make(),
            ])
            ->filters([
                SelectFilter::make('owner_id')
                    ->label('Penggesek')
                    ->searchable()
                    ->options(Owner::get()->pluck('name', 'id')),


                SelectFilter::make('month')
                    ->label('Bulan')
                    ->searchable()
                    ->options(months())
                    ->query(function ($query, $data) {
                        $query->when($data['value'], function ($query) use ($data) {
                            $query->whereMonth('date', $data['value']);
                        });
                    }),

                SelectFilter::make('year')
                    ->label('Tahun')
                    ->searchable()
                    ->options(function () {
                        $years = [];
                        foreach (range(2022, date('Y')) as $year) {
                            $years[$year] = $year;
                        }

                        return $years;
                    })
                    ->query(function ($query, $data) {
                        $query->when($data['value'], function ($query) use ($data) {
                            $query->whereYear('date', $data['value']);
                        });
                    }),
            ], FiltersLayout::AboveContent);
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
