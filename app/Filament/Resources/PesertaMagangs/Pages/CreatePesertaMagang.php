<?php

namespace App\Filament\Resources\PesertaMagangs\Pages;

use App\Filament\Resources\PesertaMagangs\PesertaMagangResource;
use Filament\Resources\Pages\CreateRecord;

class CreatePesertaMagang extends CreateRecord
{
    protected static string $resource = PesertaMagangResource::class;
    protected static ?string $title = 'Tambah Peserta Magang';
    protected function getCreateFormActionLabel(): string
    {
        return 'Simpan';
    }
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $user = \App\Models\User::create([
            'name' => $data['nama'],
            'email' => $data['email'],
            'password' => bcrypt('12345678'),
            'role' => 'peserta',
        ]);

        $data['user_id'] = $user->id;

        return $data;
    }
}
