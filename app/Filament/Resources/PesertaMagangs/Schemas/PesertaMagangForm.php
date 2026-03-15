<?php

namespace App\Filament\Resources\PesertaMagangs\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class PesertaMagangForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([

            // Kalau mau otomatis generate user_id, bagian ini bisa dihapus atau pakai Select relation
            // Select::make('user_id')
            //     ->relationship('user', 'name')
            //     ->required(),

            TextInput::make('nama')
                ->label('Nama Lengkap')
                ->required()
                ->maxLength(150),

            TextInput::make('no_identitas')
                ->label('No. Identitas (KTP / NIM / NISN)')
                ->maxLength(50),

            Select::make('jenis_kelamin')
                ->options([
                    'L' => 'Laki-laki',
                    'P' => 'Perempuan',
                ])
                ->required()
                ->label('Jenis Kelamin'),

            DatePicker::make('tanggal_lahir')
                ->label('Tanggal Lahir')
                ->required(),

            TextInput::make('no_hp')
                ->label('No. HP')
                ->tel()
                ->maxLength(20),

            TextInput::make('email')
                ->label('Email')
                ->email()
                ->required()
                ->maxLength(150),

            Textarea::make('alamat')
                ->label('Alamat')
                ->columnSpanFull(),

            FileUpload::make('foto')
                ->label('Pas Foto')
                ->image()
                ->directory('peserta/foto'),

            FileUpload::make('cv')
                ->label('CV')
                ->acceptedFileTypes(['application/pdf'])
                ->directory('peserta/cv'),

            TextInput::make('jurusan')
                ->label('Jurusan')
                ->maxLength(100),

            Select::make('semester')
                ->label('Semester')
                ->options(array_combine(range(1, 12), range(1, 12)))
                ->default(1),

            TextInput::make('asal_instansi')
                ->label('Asal Instansi')
                ->maxLength(150),

            FileUpload::make('surat_pengantar')
                ->label('Surat Pengantar')
                ->acceptedFileTypes(['application/pdf'])
                ->directory('peserta/surat_pengantar'),

            DatePicker::make('tanggal_mulai')
                ->label('Tanggal Mulai Magang')
                ->required(),

            DatePicker::make('tanggal_selesai')
                ->label('Tanggal Selesai Magang')
                ->required(),

        ]);
    }
}
