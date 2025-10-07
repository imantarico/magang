<?php

namespace App\Http\Controllers;

use App\Models\PesertaMagang;
use Barryvdh\DomPDF\Facade\Pdf;

class LaporanPesertaController extends Controller
{
    public function cetak(PesertaMagang $peserta)
    {
        $tugas = $peserta->tugasMagang()->orderBy('tanggal_diberikan', 'asc')->get();

        $pdf = Pdf::loadView('laporan.peserta', [
            'peserta' => $peserta,
            'tugas' => $tugas,
        ])->setPaper('A4', 'portrait');

        return $pdf->stream('Laporan-Magang-' . $peserta->nama . '.pdf');
    }
}
