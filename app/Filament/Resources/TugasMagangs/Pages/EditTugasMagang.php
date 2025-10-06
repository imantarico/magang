<?php

namespace App\Filament\Resources\TugasMagangs\Pages;

use App\Filament\Resources\TugasMagangs\TugasMagangResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditTugasMagang extends EditRecord
{
    protected static string $resource = TugasMagangResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
