<?php

namespace App\Providers\Filament;

use App\Filament\Peserta\Pages\Auth\Login;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class PesertaPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->id('peserta')
            ->path('peserta')
            ->login(Login::class)
            ->homeUrl('/peserta')
            ->colors([
                'primary' => Color::Amber,
            ])
            ->discoverWidgets(in: app_path('Filament/Peserta/Widgets'), for: 'App\Filament\Peserta\Widgets')
            ->discoverResources(in: app_path('Filament/Peserta/Resources'), for: 'App\Filament\Peserta\Resources')
            ->discoverPages(in: app_path('Filament/Peserta/Pages'), for: 'App\Filament\Peserta\Pages')
            ->pages([
            \App\Filament\Peserta\Pages\Dashboard::class,
            // \App\Filament\Peserta\Pages\RegisterPeserta::class,
        ])
            ->discoverWidgets(in: app_path('Filament/Peserta/Widgets'), for: 'App\Filament\Peserta\Widgets')
            ->widgets([
            // AccountWidget::class,
            // FilamentInfoWidget::class,
        ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                \App\Http\Middleware\AuthPesertaPanel::class, // ✅ custom middleware
            ]);
    }
}
