<?php

namespace App\Filament\Resources\TugasMagangs\Tables;

use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Actions\EditAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction as ActionsEditAction;
use Filament\Notifications\Notification;

class TugasMagangsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                // 🔹 Nama peserta (melalui relasi)
                TextColumn::make('peserta.nama')
                    ->label('Peserta Magang')
                    ->sortable()
                    ->searchable(),

                // 🔹 Judul tugas
                TextColumn::make('judul')
                    ->label('Judul Tugas')
                    ->searchable()
                    ->sortable(),

                // 🔹 Tanggal tugas
                TextColumn::make('tanggal_diberikan')
                    ->label('Diberikan')
                    ->date('d M Y')
                    ->sortable(),

                TextColumn::make('tenggat_waktu')
                    ->label('Tenggat Waktu')
                    ->date('d M Y')
                    ->sortable(),

                // 🔹 Status
                BadgeColumn::make('status')
                    ->label('Status')
                    ->colors([
                        'gray' => 'belum_dikerjakan',
                        'warning' => 'dikerjakan',
                        'success' => 'selesai',
                    ])
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'belum_dikerjakan' => 'Belum Dikerjakan',
                        'dikerjakan' => 'Sedang Dikerjakan',
                        'selesai' => 'Selesai',
                        default => ucfirst($state),
                    })
                    ->sortable(),

                // 🔹 File lampiran (klik untuk unduh)
                TextColumn::make('lampiran')
                    ->label('Lampiran')
                    ->url(fn ($record) => $record->lampiran ? asset('storage/' . $record->lampiran) : null, true)
                    ->formatStateUsing(fn ($state) => $state ? 'Lihat Lampiran' : '-')
                    ->openUrlInNewTab(),

                // 🔹 File pengumpulan
                TextColumn::make('file_pengumpulan')
                    ->label('Pengumpulan')
                    ->url(fn ($record) => $record->file_pengumpulan ? asset('storage/' . $record->file_pengumpulan) : null, true)
                    ->formatStateUsing(fn ($state) => $state ? 'Lihat File' : '-')
                    ->openUrlInNewTab(),

                // 🔹 Nilai
                TextColumn::make('nilai')
                    ->label('Nilai')
                    ->suffix('%')
                    ->sortable()
                    ->alignCenter(),

                // 🔹 Tanggal update terakhir
                TextColumn::make('updated_at')
                    ->label('Diperbarui')
                    ->dateTime('d M Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])

            // 🔹 Filter opsional
            ->filters([
                // Bisa tambahkan filter status nanti
            ])

            // 🔹 Aksi per baris (Edit)
            ->recordActions([
                ActionsEditAction::make()
                    ->label('Edit')
                    ->icon('heroicon-o-pencil-square')
                    ->successNotification(
                        Notification::make()
                            ->title('Data tugas berhasil diperbarui.')
                            ->success()
                    ),
            ])

            // 🔹 Toolbar (hapus massal)
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make()
                        ->label('Hapus Tugas Terpilih')
                        ->icon('heroicon-o-trash')
                        ->color('danger')
                        ->requiresConfirmation(),
                ]),
            ]);
    }
}
