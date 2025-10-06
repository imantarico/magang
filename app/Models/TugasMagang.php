<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TugasMagang extends Model
{
    use HasFactory;

    protected $table = 'tugas_magang';

    protected $fillable = [
        'peserta_magang_id',
        'judul',
        'deskripsi',
        'tanggal_diberikan',
        'tenggat_waktu',
        'lampiran',
        'status',
        'file_pengumpulan',
        'tanggal_pengumpulan',
        'catatan_admin',
        'nilai',
    ];

    public function peserta()
    {
        return $this->belongsTo(\App\Models\PesertaMagang::class, 'peserta_magang_id');
    }
}
