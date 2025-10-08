<?php

namespace App\Filament\Resources\PesertaMagangs\Tables;

use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\SelectColumn;
use Filament\Tables\Columns\TextInputColumn;
use Filament\Actions\Action;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Actions\BulkAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Notifications\Notification;
use App\Models\TugasMagang;
use Carbon\Carbon;

class PesertaMagangsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
            // === IDENTITAS PESERTA ===
            // ImageColumn::make('foto')
            //     ->label('Foto')
            //     ->disk('public')
            //     ->circular()
            //     ->width(50)
            //     ->height(50),

            TextColumn::make('nama')
                    ->label('Nama Lengkap')
                    ->searchable()
                    ->sortable(),

            TextColumn::make('no_identitas')
                ->label('No Identitas')
                ->searchable()
                ->sortable(),

            TextColumn::make('jenis_kelamin')
                ->label('Jenis Kelamin')
                ->formatStateUsing(fn($state) => $state === 'L' ? 'Laki-laki' : 'Perempuan'),

            TextColumn::make('tanggal_lahir')
                ->label('Tanggal Lahir')
                ->date('d M Y')
                ->sortable(),

            TextColumn::make('no_hp')
                ->label('Nomor HP')
                    ->searchable(),

                TextColumn::make('email')
                    ->label('Email')
                    ->searchable(),

            TextColumn::make('asal_instansi')
                ->label('Instansi Asal')
                ->searchable()
                ->sortable(),

            TextColumn::make('jurusan')
                ->label('Jurusan')
                ->sortable(),

            TextColumn::make('semester')
                ->label('Semester')
                ->sortable(),

            // === STATUS & TANGGAL MAGANG ===
            SelectColumn::make('status')
                    ->label('Status')
                    ->options([
                        'daftar' => 'Daftar',
                        'diterima' => 'Diterima',
                        'aktif' => 'Aktif',
                        'selesai' => 'Selesai',
                        'ditolak' => 'Ditolak',
                    ])
                    ->afterStateUpdated(function ($record, $state) {
                        $updates = ['status' => $state];

                        if ($state === 'aktif' && !$record->tanggal_mulai) {
                            $updates['tanggal_mulai'] = now();
                        }

                        if ($state === 'selesai' && !$record->tanggal_selesai) {
                            $updates['tanggal_selesai'] = now();
                        }

                        $record->update($updates);

                        Notification::make()
                            ->title('Status Diperbarui')
                            ->body("Status peserta {$record->nama} diubah menjadi " . ucfirst($state))
                            ->success()
                            ->send();
                }),

            TextColumn::make('tanggal_mulai')
                ->label('Mulai Magang')
                ->date('d M Y')
                ->sortable(),
            TextColumn::make('tanggal_selesai')
                ->label('Selesai Magang')
                ->date('d M Y')
                ->sortable(),

            ])

            // === AKSI PER RECORD ===
            ->recordActions([
                // 🔹 Lihat Data
                ViewAction::make()
                    ->label('Lihat')
                    ->icon('heroicon-o-eye')
                    ->color('info')
                    ->modalHeading('Detail Peserta Magang')
                    ->form([
                        \Filament\Forms\Components\ViewField::make('foto')
                            ->label('Foto')
                            ->view('filament.components.view-foto'),

                \Filament\Forms\Components\TextInput::make('nama')->label('Nama Lengkap')->disabled(),
                \Filament\Forms\Components\TextInput::make('no_identitas')->label('No Identitas')->disabled(),
                \Filament\Forms\Components\TextInput::make('jenis_kelamin')->label('Jenis Kelamin')->disabled(),
                \Filament\Forms\Components\TextInput::make('email')->label('Email')->disabled(),
                \Filament\Forms\Components\TextInput::make('no_hp')->label('Nomor HP')->disabled(),
                \Filament\Forms\Components\Textarea::make('alamat')->label('Alamat')->disabled()->columnSpanFull(),
                \Filament\Forms\Components\TextInput::make('jurusan')->label('Jurusan')->disabled(),
                \Filament\Forms\Components\TextInput::make('semester')->label('Semester')->disabled(),
                \Filament\Forms\Components\TextInput::make('asal_instansi')->label('Asal Instansi')->disabled(),

                \Filament\Forms\Components\ViewField::make('cv')
                    ->label('CV')
                    ->view('filament.components.view-file'),

                \Filament\Forms\Components\ViewField::make('surat_pengantar')
                    ->label('Surat Pengantar')
                    ->view('filament.components.view-file'),

                    \Filament\Forms\Components\TextInput::make('status')->label('Status')->disabled(),
                ])
                ->modalWidth('2xl'),

            // 🔹 Cetak Laporan
            Action::make('cetakLaporan')
                ->label('Cetak Laporan')
                ->icon('heroicon-o-printer')
                ->color('success')
                ->url(fn($record) => route('laporan.peserta.cetak', $record))
                ->openUrlInNewTab(),

            // 🔹 Edit Data
            EditAction::make(),
            ])

            // === AKSI MASSAL ===
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),

                // 🔹 Bulk Action: Beri Tugas
                BulkAction::make('beriTugas')
                        ->label('Beri Tugas')
                        ->icon('heroicon-o-clipboard-document')
                        ->color('success')
                        ->form([
                            TextInput::make('judul')
                        ->label('Judul Tugas')
                                ->required()
                                ->columnSpanFull(),

                            Textarea::make('deskripsi')
                                ->label('Deskripsi Tugas')
                                ->rows(4)
                                ->required()
                                ->columnSpanFull(),

                            DatePicker::make('tenggat_waktu')
                                ->label('Tenggat Waktu')
                                ->required()
                                ->rule('after_or_equal:today'),

                            FileUpload::make('lampiran')
                                ->label('Lampiran (opsional)')
                                ->directory('tugas/lampiran')
                                ->acceptedFileTypes(['application/pdf', 'image/*'])
                                ->columnSpanFull(),
                        ])
                        ->action(function (array $data, $records) {
                            foreach ($records as $peserta) {
                                TugasMagang::create([
                                    'peserta_magang_id' => $peserta->id,
                                    'judul' => $data['judul'],
                                    'deskripsi' => $data['deskripsi'] ?? null,
                                    'tenggat_waktu' => $data['tenggat_waktu'] ?? null,
                                    'lampiran' => $data['lampiran'] ?? null,
                                    'tanggal_diberikan' => now(),
                                    'status' => 'belum_dikerjakan',
                                ]);
                            }

                            Notification::make()
                        ->title('Tugas Diberikan')
                        ->body('Tugas "' . $data['judul'] . '" telah diberikan ke ' . count($records) . ' peserta.')
                                ->success()
                                ->send();
                        })
                        ->requiresConfirmation()
                    ->modalHeading('Beri Tugas Kepada Peserta')
                    ->modalButton('Kirim'),
                ]),
            ]);
    }
}
