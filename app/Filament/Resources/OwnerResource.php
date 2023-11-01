<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OwnerResource\Pages;
use App\Filament\Resources\OwnerResource\RelationManagers;
use App\Models\Owner;
use Filament\Resources\Pages\PageRegistration;
use Filament\Resources\Resource;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class OwnerResource extends Resource
{
    protected static ?string $model = Owner::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'REKAP';

    protected static ?int $navigationSort = 3;

    /**
     * @return string
     */
    public static function getNavigationLabel() : string
    {
        return 'Rekap Penggesek';
    }

    /**
     * @param  Table $table
     * @return Table
     */
    public static function table(Table $table) : Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->label('Nama'),
                TextColumn::make('total_material')
                    ->label('Jumlah Bengkulangan')
                    ->formatStateUsing(function ($state) {
                        return format_number($state);
                    }),
                TextColumn::make('total_production')->label('Jumlah Sirap')
                    ->formatStateUsing(function ($state) {
                        return format_number($state);
                    }),
            ])
            ->filters([
                SelectFilter::make('id')
                    ->label('Penggesek')
                    ->searchable()
                    ->options(Owner::get()->pluck('name', 'id')),
            ], FiltersLayout::AboveContent);
    }

    /**
     * @return array|PageRegistration[]
     */
    public static function getPages() : array
    {
        return [
            'index' => Pages\ListOwners::route('/'),
        ];
    }
}
