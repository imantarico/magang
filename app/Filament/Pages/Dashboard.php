<?php

namespace App\Filament\Pages;
use BackedEnum;
use Filament\Pages\Dashboard as BaseDashboard;
use App\Filament\Widgets\StatsOverviewWidget;
use App\Filament\Widgets\PesertaStatusChart;
use App\Filament\Widgets\TugasMagangChart;
use Filament\Widgets\StatsOverviewWidget as WidgetsStatsOverviewWidget;

class Dashboard extends BaseDashboard
{
    // ✅ Wajib gunakan tipe data yang kompatibel dengan v4
    protected static BackedEnum | string | null $navigationIcon = 'heroicon-o-home';
    protected static ?string $navigationLabel = 'Dashboard';
    protected static ?string $title = 'Dashboard Sistem Magang';

    protected static ?string $slug = 'dashboard'; // URL path: /admin/dashboard

    /**
     * ✅ Menentukan widget yang akan muncul di halaman dashboard
     */
   public function getWidgets(): array
{
    return [
        \App\Filament\Widgets\StatsOverviewMagang::class,
        \App\Filament\Widgets\TugasMagangChart::class,
    ];
}

    /**
     * ✅ Menentukan jumlah kolom grid (layout dashboard)
     */
    public function getColumns(): int
    {
        return 2; // Bisa ubah jadi 3 jika ingin tampilan grid lebih lebar
    }
}
