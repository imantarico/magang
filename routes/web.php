<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LaporanPesertaController;
use App\Livewire\Peserta\RegisterPeserta;

Route::get('/', function () {
    return redirect('/admin/login');
});
Route::get('/laporan/peserta/{peserta}/cetak', [LaporanPesertaController::class, 'cetak'])
    ->name('laporan.peserta.cetak');


Route::get('/peserta/register', RegisterPeserta::class)->name('peserta.register');
