<?php

namespace App\Livewire\Peserta;

use App\Models\User;
use App\Models\PesertaMagang;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Livewire\WithFileUploads;

class RegisterPeserta extends Component
{
    use WithFileUploads;

    // 🔹 Semua field dari tabel peserta_magang
    public $nama;
    public $no_identitas;
    public $jenis_kelamin;
    public $tanggal_lahir;
    public $no_hp;
    public $email;
    public $alamat;
    public $foto;
    public $cv;
    public $jurusan;
    public $semester = 1;
    public $asal_instansi;
    public $surat_pengantar;

    public function submit()
    {
        // 🔒 Validasi dasar
        $this->validate([
            'nama' => 'required|string|max:150',
            'jenis_kelamin' => 'required|in:L,P',
            'tanggal_lahir' => 'required|date',
            'email' => 'required|email|unique:users,email',
            'cv' => 'nullable|mimes:pdf|max:2048',
            'surat_pengantar' => 'nullable|mimes:pdf|max:2048',
            'foto' => 'nullable|image|max:2048',
        ]);

        // 🧾 Simpan file upload (kalau ada)
        $cvPath = $this->cv?->store('peserta/cv', 'public');
        $fotoPath = $this->foto?->store('peserta/foto', 'public');
        $suratPath = $this->surat_pengantar?->store('peserta/surat_pengantar', 'public');

        // 👤 Buat akun user baru
        $user = User::create([
            'name' => $this->nama,
            'email' => $this->email,
            'password' => Hash::make($this->tanggal_lahir), // default password = tanggal lahir
            'role' => 'peserta',
        ]);

        // 💾 Simpan data peserta ke tabel peserta_magang
        PesertaMagang::create([
            'user_id' => $user->id,
            'nama' => $this->nama,
            'no_identitas' => $this->no_identitas,
            'jenis_kelamin' => $this->jenis_kelamin,
            'tanggal_lahir' => $this->tanggal_lahir,
            'no_hp' => $this->no_hp,
            'email' => $this->email,
            'alamat' => $this->alamat,
            'foto' => $fotoPath,
            'cv' => $cvPath,
            'jurusan' => $this->jurusan,
            'semester' => $this->semester,
            'asal_instansi' => $this->asal_instansi,
            'surat_pengantar' => $suratPath,
            'status' => 'daftar',
        ]);

        // 🔔 Pesan sukses
        session()->flash('success', 'Pendaftaran berhasil! Silakan tunggu verifikasi dari admin.');

        // 🔄 Reset form
        $this->reset();

        return redirect('/peserta/login');
    }

    public function render()
    {
        return view('livewire.peserta.register-peserta')
            ->layout('components.layouts.simple');
    }
}
