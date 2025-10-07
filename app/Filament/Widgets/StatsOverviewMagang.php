<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\PesertaMagang;
use App\Models\TugasMagang;

class StatsOverviewMagang extends BaseWidget
{
    protected ?string $heading = 'Statistik Umum Magang';

    protected function getStats(): array
    {
        return [
            Stat::make('Peserta Daftar', PesertaMagang::where('status', 'daftar')->count()),
            Stat::make('Peserta Diterima', PesertaMagang::where('status', 'diterima')->count()),
            Stat::make('Peserta Aktif', PesertaMagang::where('status', 'aktif')->count()),
            Stat::make('Peserta Selesai', PesertaMagang::where('status', 'selesai')->count()),
            Stat::make('Total Tugas', TugasMagang::count()),
        ];
    }
}
