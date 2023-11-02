<?php

namespace App\Filament\Resources\TransactionResource\Pages;

use App\Filament\Resources\TransactionResource;
use App\Filament\Widgets\TransactionOverviewTabsWidget;
use App\Models\Owner;
use App\Models\Warehouse;
use Filament\Actions;
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;

class ListTransactions extends ListRecords
{
    protected static string $resource = TransactionResource::class;

    /**
     * @return string[]
     */
    protected function getHeaderWidgets() : array
    {
        return [
            TransactionOverviewTabsWidget::class,
            TransactionResource\Widgets\TransactionChart::class,
        ];
    }

    /**
     * @return int|string|array
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
                TextColumn::make('date')->label('Tanggal Penjualan')->date('d M Y'),
                TextColumn::make('warehouse.name')->label('Gudang'),
                TextColumn::make('amount')->label('Jumlah'),
                TextColumn::make('price')->label('Harga Satuan')->money('IDR', true),
                TextColumn::make('total')->label('Total')->money('IDR', true),
                TextColumn::make('created_at')->label('Tanggal Input')->date('d M Y H:i:s'),
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
            Actions\CreateAction::make()->label('TAMBAH')->icon('heroicon-o-plus')->modalWidth('3xl'),
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
