<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LaporanPesertaController;
Route::get('/', function () {
    //return to admin /admin/login
    return redirect('/admin/login');
});
Route::get('/laporan/peserta/{peserta}/cetak', [LaporanPesertaController::class, 'cetak'])
    ->name('laporan.peserta.cetak');
