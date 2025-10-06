<?php

namespace App\Filament\Resources\PesertaMagangs\Pages;

use App\Filament\Resources\PesertaMagangs\PesertaMagangResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPesertaMagangs extends ListRecords
{
    protected static string $resource = PesertaMagangResource::class;

    protected static ?string $title = 'Daftar Peserta Magang'; // ubah judul halaman

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('Tambah Peserta Magang') // ✅ ubah label tombol
                ->icon('heroicon-o-plus-circle'), // (opsional) ubah ikon
        ];
    }
}
