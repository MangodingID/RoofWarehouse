<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MaterialResource\Pages;
use App\Filament\Resources\MaterialResource\RelationManagers;
use App\Models\Material;
use App\Models\Owner;
use App\Models\Warehouse;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Pages\PageRegistration;
use Filament\Resources\Resource;

class MaterialResource extends Resource
{
    protected static ?string $model = Material::class;

    protected static ?string $navigationIcon = 'heroicon-o-inbox-arrow-down';

    protected static ?string $navigationGroup = 'TRANSAKSI';

    /**
     * @return string
     */
    public static function getNavigationLabel() : string
    {
        return 'Bahan Baku';
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
                    ->default(Warehouse::bengkulangan()->first()->getKey())
                    ->options(function () {
                        return Warehouse::bengkulangan()->get()->pluck('name', 'id');
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
                    ->label('Jumlah Bengkulangan')
                    ->numeric()
                    ->required()
                    ->default(0),

                DatePicker::make('date')
                    ->label('Tanggal')
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
            'index' => Pages\ListMaterials::route('/'),
        ];
    }
}
