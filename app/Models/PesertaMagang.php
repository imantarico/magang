<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PesertaMagang extends Model
{
    protected $table = 'peserta_magang';

    protected $fillable = [
        'user_id',
        'nama',
        'no_identitas',
        'jenis_kelamin',
        'tanggal_lahir',
        'no_hp',
        'email',
        'alamat',
        'foto',
        'cv',
        'jurusan',
        'semester',
        'asal_instansi',
        'surat_pengantar',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function tugasMagang()
    {
        return $this->hasMany(TugasMagang::class);
    }
}
