<?php

namespace App\Filament\Resources;

use App\Filament\Resources\WarehouseResource\Pages;
use App\Filament\Resources\WarehouseResource\RelationManagers;
use App\Models\Warehouse;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class WarehouseResource extends Resource
{
    protected static ?string $model = Warehouse::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'GUDANG';

    protected static ?int $navigationSort = 4;

    /**
     * @return string
     */
    public static function getNavigationLabel() : string
    {
        return 'Gudang';
    }

    /**
     * @return string
     */
    public static function getBreadcrumb() : string
    {
        return static::getNavigationLabel();
    }

    /**
     * @return string
     */
    public static function getModelLabel() : string
    {
        return static::getNavigationLabel();
    }

    /**
     * @return string
     */
    public static function getPluralModelLabel() : string
    {
        return static::getNavigationLabel();
    }

    /**
     * @param  Form $form
     * @return Form
     */
    public static function form(Form $form) : Form
    {
        return $form
            ->schema([
                TextInput::make('name')->label('Nama Gudang')->required()->columnSpan(2),
            ]);
    }

    /**
     * @param  Table $table
     * @return Table
     */
    public static function table(Table $table) : Table
    {
        return $table
            ->columns([
                TextColumn::make('name'),

                TextColumn::make('productions')
                    ->label('Jumlah Produksi')
                    ->formatStateUsing(function (Warehouse $record) {
                        return format_number($record->productions->sum('amount') ?? 0);
                    }),

                TextColumn::make('transactions')
                    ->label('Sirap Terjual')
                    ->formatStateUsing(function (Warehouse $record) {
                        return format_number($record->transactions->sum('amount'));
                    }),

                TextColumn::make('remainder')
                    ->label('Sirap Tersisa')
                    ->formatStateUsing(function ($state) {
                        if ($state === 0) {
                            return null;
                        }

                        return format_number($state);
                    }),

                TextColumn::make('materials')
                    ->label('Jumlah Bengkulangan')
                    ->formatStateUsing(function (Warehouse $record) {
                        return $record->materials->sum('amount') ?? 0;
                    }),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make()->label('UBAH'),
            ]);
    }

    public static function getPages() : array
    {
        return [
            'index' => Pages\ListWarehouses::route('/'),
        ];
    }
}
