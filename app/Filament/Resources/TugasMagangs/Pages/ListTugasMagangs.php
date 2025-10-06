<?php

namespace App\Filament\Resources\TugasMagangs\Pages;

use App\Filament\Resources\TugasMagangs\TugasMagangResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListTugasMagangs extends ListRecords
{
    protected static string $resource = TugasMagangResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
