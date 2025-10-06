<?php

namespace App\Filament\Resources\TugasMagangs;

use App\Filament\Resources\TugasMagangs\Pages\CreateTugasMagang;
use App\Filament\Resources\TugasMagangs\Pages\EditTugasMagang;
use App\Filament\Resources\TugasMagangs\Pages\ListTugasMagangs;
use App\Filament\Resources\TugasMagangs\Schemas\TugasMagangForm;
use App\Filament\Resources\TugasMagangs\Tables\TugasMagangsTable;
use App\Models\TugasMagang;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class TugasMagangResource extends Resource
{
    protected static ?string $model = TugasMagang::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function form(Schema $schema): Schema
    {
        return TugasMagangForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return TugasMagangsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListTugasMagangs::route('/'),
            'create' => CreateTugasMagang::route('/create'),
            'edit' => EditTugasMagang::route('/{record}/edit'),
        ];
    }
}
