<?php

namespace App\Filament\Peserta\Widgets;

use App\Models\PesertaMagang;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatusMagangOverview extends BaseWidget
{
    protected function getStats(): array
    {
        $peserta = PesertaMagang::where('user_id', auth()->id())->first();

        if (! $peserta) {
            return [
                Stat::make('Status Magang', 'Belum Terdaftar')
                    ->description('Silakan daftar terlebih dahulu')
                    ->icon('heroicon-o-user-exclamation'),
            ];
        }

        $totalTugas = $peserta->tugasMagang()->count();
        $tugasSelesai = $peserta->tugasMagang()->where('status', 'selesai')->count();
        $progress = $totalTugas > 0 ? round(($tugasSelesai / $totalTugas) * 100) : 0;

        return [
            Stat::make('Status Magang', ucfirst($peserta->status ?? 'Aktif'))
                ->description('Status terkini peserta')
                ->icon('heroicon-o-clipboard-document-check'),

            Stat::make('Progress Tugas', "{$progress}%")
                ->description("{$tugasSelesai} dari {$totalTugas} tugas selesai")
                ->icon('heroicon-o-chart-bar'),

            Stat::make(
                'Periode Magang',
                ($peserta->tanggal_mulai ?? '-') . ' s/d ' . ($peserta->tanggal_selesai ?? '-')
            )
                ->description('Durasi pelaksanaan magang')
                ->icon('heroicon-o-calendar-days'),
        ];
    }
}
