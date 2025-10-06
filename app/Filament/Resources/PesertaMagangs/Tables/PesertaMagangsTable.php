<?php

namespace App\Filament\Resources\PesertaMagangs\Tables;

use Filament\Tables\Table;
use Filament\Actions\BulkAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\SelectColumn;
use Filament\Tables\Columns\TextInputColumn;
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
                TextColumn::make('nama')
                    ->label('Nama Lengkap')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('asal_instansi')
                    ->label('Instansi')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('email')
                    ->label('Email')
                    ->searchable(),

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
                    })
                    ->sortable(),

                TextInputColumn::make('tanggal_mulai')
                    ->label('Tanggal Mulai')
                    ->type('date')
                    ->disabled(fn ($record) => $record->status !== 'aktif')
                    ->afterStateUpdated(function ($record, $state) {
                        if ($record->tanggal_selesai && $state > $record->tanggal_selesai) {
                            Notification::make()
                                ->title('Gagal')
                                ->body('Tanggal mulai tidak boleh setelah tanggal selesai.')
                                ->danger()
                                ->send();
                            return;
                        }

                        $record->update(['tanggal_mulai' => $state]);

                        Notification::make()
                            ->title('Tanggal Mulai Diperbarui')
                            ->body("Tanggal mulai {$record->nama} diubah menjadi " . Carbon::parse($state)->format('d M Y'))
                            ->success()
                            ->send();
                    }),

                TextInputColumn::make('tanggal_selesai')
                    ->label('Tanggal Selesai')
                    ->type('date')
                    ->disabled(fn ($record) => $record->status !== 'aktif')
                    ->afterStateUpdated(function ($record, $state) {
                        if ($record->tanggal_mulai && $state < $record->tanggal_mulai) {
                            Notification::make()
                                ->title('Gagal')
                                ->body('Tanggal selesai tidak boleh sebelum tanggal mulai.')
                                ->danger()
                                ->send();
                            return;
                        }

                        $record->update(['tanggal_selesai' => $state]);

                        Notification::make()
                            ->title('Tanggal Selesai Diperbarui')
                            ->body("Tanggal selesai {$record->nama} diubah menjadi " . Carbon::parse($state)->format('d M Y'))
                            ->success()
                            ->send();
                    }),

                TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime('d M Y H:i')
                    ->sortable(),
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),

                    // 🔹 Bulk Action: Beri tugas ke banyak peserta
                    BulkAction::make('beriTugas')
                        ->label('Beri Tugas')
                        ->icon('heroicon-o-clipboard-document')
                        ->color('success')
                        ->form([
                            TextInput::make('judul')
                                ->label('Judul Tugas')
                                ->placeholder('Contoh: Laporan Kegiatan Mingguan')
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
                                ->title('Tugas Berhasil Diberikan')
                                ->body('Tugas "' . $data['judul'] . '" diberikan ke ' . count($records) . ' peserta.')
                                ->icon('heroicon-o-check-circle')
                                ->success()
                                ->send();
                        })
                        ->requiresConfirmation()
                        ->modalHeading('Beri Tugas Kepada Peserta Terpilih')
                        ->modalButton('Kirim Tugas'),
                ]),
            ]);
    }
}
