<?php

namespace App\Filament\Resources\PesertaMagangs\Pages;

use App\Filament\Resources\PesertaMagangs\PesertaMagangResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditPesertaMagang extends EditRecord
{
    protected static string $resource = PesertaMagangResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
