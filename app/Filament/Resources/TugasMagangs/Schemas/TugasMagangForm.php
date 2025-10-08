<?php

namespace App\Filament\Resources\TugasMagangs\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\FileUpload;
use Filament\Schemas\Schema;

class TugasMagangForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([

            // 🔹 Pilih peserta magang
            Select::make('peserta_magang_id')
                ->label('Peserta Magang')
                ->relationship('peserta', 'nama')
                ->required(),

            // 🔹 Judul tugas
            TextInput::make('judul')
                ->label('Judul Tugas')
                ->placeholder('Contoh: Laporan Kegiatan Mingguan')
                ->required()
                ->maxLength(150),

            // 🔹 Deskripsi tugas
            Textarea::make('deskripsi')
                ->label('Deskripsi Tugas')
                ->placeholder('Tuliskan detail tugas yang harus dikerjakan peserta.')
                ->rows(4)
                ->columnSpanFull(),

            // 🔹 Lampiran tugas (opsional)
            FileUpload::make('lampiran')
                ->label('Lampiran (opsional)')
                ->directory('tugas/lampiran')
                ->acceptedFileTypes(['application/pdf', 'image/*'])
                ->maxSize(10240)
                ->columnSpanFull(),

            // 🔹 Tanggal tugas
            DatePicker::make('tanggal_diberikan')
                ->label('Tanggal Diberikan')
                ->default(now())
                ->required(),

            DatePicker::make('tenggat_waktu')
                ->label('Tenggat Waktu')
                ->required(),


            // 🔹 Status pengerjaan
            Select::make('status')
                ->label('Status')
                ->options([
                    'belum_dikerjakan' => 'Belum Dikerjakan',
                    'dikerjakan' => 'Sedang Dikerjakan',
                    'selesai' => 'Selesai',
                ])
                ->default('belum_dikerjakan')
                ->required(),

            // 🔹 File pengumpulan (oleh peserta)
            FileUpload::make('file_pengumpulan')
                ->label('File Pengumpulan (Peserta)')
                ->directory('tugas/pengumpulan')
                ->acceptedFileTypes(['application/pdf', 'image/*'])
                ->maxSize(10240)
                ->columnSpanFull(),

            // 🔹 Tanggal peserta mengumpulkan
            DatePicker::make('tanggal_pengumpulan')
                ->label('Tanggal Pengumpulan'),

            // 🔹 Catatan dari admin
            Textarea::make('catatan_admin')
                ->label('Catatan / Feedback Admin')
                ->placeholder('Tuliskan hasil evaluasi atau komentar.')
                ->rows(3)
                ->columnSpanFull(),

            // 🔹 Nilai tugas
            TextInput::make('nilai')
                ->label('Nilai (%)')
                ->numeric()
                ->minValue(0)
                ->maxValue(100)
                ->suffix('%')
                ->placeholder('Masukkan nilai peserta (0–100)')
                ->columnSpan(1),
        ]);
    }
}
