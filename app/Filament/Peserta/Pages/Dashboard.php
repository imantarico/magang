<?php

namespace App\Filament\Peserta\Pages;

use Filament\Pages\Dashboard as BaseDashboard;
use App\Filament\Peserta\Widgets\StatusMagangOverview;
use App\Filament\Peserta\Widgets\NotifikasiTerbaruWidget;
use BackedEnum;

class Dashboard extends BaseDashboard
{
    protected static ?string $title = 'Dashboard Peserta';
    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-home';

    protected static string|\UnitEnum|null $navigationGroup = 'Menu Utama';
    protected static ?string $slug = 'dashboard';

    protected function getHeaderWidgets(): array
    {
        return [
            StatusMagangOverview::class,
        ];
    }

    // protected function getFooterWidgets(): array
    // {
    //     return [
    //         NotifikasiTerbaruWidget::class,
    //     ];
    // }
}
