<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PaymentResource\Pages;
use App\Filament\Resources\PaymentResource\RelationManagers;
use App\Models\Owner;
use App\Models\Payment;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;

class PaymentResource extends Resource
{
    protected static ?string $model = Payment::class;

    protected static ?string $navigationIcon = 'heroicon-o-banknotes';

    protected static ?string $navigationGroup = 'TRANSAKSI';

    protected static ?int $navigationSort = 3;

    /**
     * @return string
     */
    public static function getNavigationLabel() : string
    {
        return 'Pembayaran';
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

    public static function form(Form $form) : Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('owner_id')
                    ->label('Penggesek')
                    ->createOptionForm([
                        TextInput::make('name')->label('Nama')->required(),
                    ])
                    ->createOptionUsing(function (array $data) {
                        Owner::create($data);
                    })
                    ->searchable()
                    ->options(Owner::get()->pluck('name', 'id'))
                    ->columnSpan(2)
                    ->required(),

                TextInput::make('material')->label('Bengkulangan')->required(),
                TextInput::make('product')->label('Sirap')->required(),

                TextInput::make('amount')
                    ->label('Jumlah Uang')
                    ->numeric()
                    ->required(),

                DatePicker::make('date')
                    ->label('Tanggal Pembayaran')
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

    public static function getRelations() : array
    {
        return [
            //
        ];
    }

    public static function getPages() : array
    {
        return [
            'index' => Pages\ListPayments::route('/'),
        ];
    }
}
