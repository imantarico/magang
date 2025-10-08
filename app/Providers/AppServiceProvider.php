<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Filament\Peserta\Widgets\StatusMagangOverview;
use Livewire\Livewire;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Livewire::component('app.filament.peserta.widgets.status-magang-overview', StatusMagangOverview::class);
    }
}
