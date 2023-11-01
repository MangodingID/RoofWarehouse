<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductionResource\Pages;
use App\Filament\Resources\ProductionResource\RelationManagers;
use App\Models\Operator;
use App\Models\Owner;
use App\Models\Production;
use App\Models\Warehouse;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Pages\PageRegistration;
use Filament\Resources\Resource;

class ProductionResource extends Resource
{
    protected static ?string $model = Production::class;

    protected static ?string $navigationIcon = 'heroicon-o-circle-stack';

    protected static ?string $navigationLabel = 'Produksi Sirap';

    protected static ?string $navigationGroup = 'PRODUKSI';

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

                Select::make('warehouse_id')
                    ->label('Gudang')
                    ->searchable()
                    ->default(Warehouse::first()->getKey())
                    ->options(function () {
                        return Warehouse::get()->pluck('name', 'id');
                    })
                    ->required(),

                Select::make('owner_id')
                    ->label('Penggesek')
                    ->searchable()
                    ->createOptionForm([
                        TextInput::make('name')->label('Nama')->required(),
                    ])
                    ->createOptionUsing(function (array $data) {
                        Owner::create($data);
                    })
                    ->options(function () {
                        return Owner::get()->pluck('name', 'id');
                    })
                    ->required(),

                TextInput::make('amount')
                    ->label('Hasil Sirap')
                    ->default(0)
                    ->required(),

                DatePicker::make('date')
                    ->label('Tanggal Produksi')
                    ->required()
                    ->default(now()),

                MarkdownEditor::make('note')
                    ->label('Catatan')
                    ->disableToolbarButtons([
                        'attachFiles',
                    ])
                    ->columnSpan(2),
            ]);
    }

    /**
     * @return array|PageRegistration[]
     */
    public static function getPages() : array
    {
        return [
            'index' => Pages\ListProductions::route('/'),
        ];
    }
}
