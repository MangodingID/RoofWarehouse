<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TransactionResource\Pages;
use App\Filament\Resources\TransactionResource\RelationManagers;
use App\Models\Transaction;
use App\Models\Warehouse;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Pages\PageRegistration;
use Filament\Resources\Resource;

class TransactionResource extends Resource
{
    protected static ?string $model = Transaction::class;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-cart';

    protected static ?string $navigationGroup = 'TRANSAKSI';

    /**
     * @return string
     */
    public static function getNavigationLabel() : string
    {
        return 'Penjualan';
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
                    ->default(Warehouse::warehouse()->first()->getKey())
                    ->options(function () {
                        return Warehouse::warehouse()->get()->pluck('name', 'id');
                    })
                    ->required(),

                DatePicker::make('date')
                    ->label('Tanggal Penjualan')
                    ->required()
                    ->default(now()),

                TextInput::make('amount')
                    ->label('Jumlah Sirap')
                    ->numeric()
                    ->required(),

                TextInput::make('price')
                    ->label('Harga Satuan')
                    ->numeric()
                    ->required(),

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
            'index' => Pages\ListTransactions::route('/'),
        ];
    }
}
