<?php

namespace App\Filament\Resources\PesertaMagangs;

use App\Filament\Resources\PesertaMagangs\Pages\CreatePesertaMagang;
use App\Filament\Resources\PesertaMagangs\Pages\EditPesertaMagang;
use App\Filament\Resources\PesertaMagangs\Pages\ListPesertaMagangs;
use App\Filament\Resources\PesertaMagangs\Schemas\PesertaMagangForm;
use App\Filament\Resources\PesertaMagangs\Tables\PesertaMagangsTable;
use App\Models\PesertaMagang;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class PesertaMagangResource extends Resource
{
    protected static ?string $model = PesertaMagang::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function form(Schema $schema): Schema
    {
        return PesertaMagangForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PesertaMagangsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }
    public static function getPluralLabel(): ?string
{
    return 'Peserta Magang'; // untuk judul menu & halaman index
}

public static function getLabel(): ?string
{
    return 'Peserta Magang'; // untuk judul tunggal (edit, detail)
}
    public static function getPages(): array
    {
        return [
            'index' => ListPesertaMagangs::route('/'),
            'create' => CreatePesertaMagang::route('/create'),
            'edit' => EditPesertaMagang::route('/{record}/edit'),
        ];
    }

}
