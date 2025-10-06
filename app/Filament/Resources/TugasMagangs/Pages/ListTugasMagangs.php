<?php

namespace App\Filament\Resources\TugasMagangs\Pages;

use App\Filament\Resources\TugasMagangs\TugasMagangResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTugasMagangs extends ListRecords
{
    protected static string $resource = TugasMagangResource::class;

    protected static ?string $title = 'Daftar Tugas Magang'; // ubah judul halaman

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('Tambah Peserta Magang') // ✅ ubah label tombol
                ->icon('heroicon-o-plus-circle'), // (opsional) ubah ikon
        ];
    }
}
