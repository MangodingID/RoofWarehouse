<?php

namespace App\Filament\Resources\PaymentResource\Pages;

use App\Filament\Resources\PaymentResource;
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

class ListPayments extends ListRecords
{
    protected static string $resource = PaymentResource::class;

    /**
     * @param  Table $table
     * @return Table
     * @throws \Exception
     */
    public function table(Table $table) : Table
    {
        return $table
            ->columns([
                TextColumn::make('owner.name')->label('Penggesek'),
                TextColumn::make('material')->label('Bengkulangan'),
                TextColumn::make('product')->label('Sirap'),
                TextColumn::make('amount')->label('Jumlah Uang')->formatStateUsing(function ($state) {
                    return format_money($state);
                }),
                TextColumn::make('date')->label('Tanggal Pembayaran')->date('d M Y'),
                TextColumn::make('created_at')->label('Tanggal Input')->date('d M Y'),
            ])
            ->actions([
                EditAction::make('edit')->label('UBAH'),
                DeleteAction::make('delete')->label('HAPUS'),
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
            Actions\CreateAction::make()->label('TAMBAH')->icon('heroicon-o-plus'),
        ];
    }
}
