<?php

namespace App\Filament\Peserta\Pages;

use App\Models\PesertaMagang;
use App\Models\User;
use Filament\Forms;
use Filament\Pages\Page;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Hash;

class RegisterPeserta extends Page
{
    use Forms\Concerns\InteractsWithForms;

    protected static ?string $title = 'Pendaftaran Peserta Magang';
    protected static ?string $slug = 'register'; // URL: /peserta/register
    // protected static string $view = 'filament.peserta.pages.register-peserta';
    protected static string $layout = 'filament-panels::components.layout.simple';
    protected static bool $shouldRegisterNavigation = false; // Tidak tampil di sidebar
    protected string $view = 'filament.peserta.pages.register-peserta';


    public ?array $data = [];
    public function hasLogo(): bool
    {
        return false;
    }
    /**
     * 🔹 Skema Formulir (sesuai PesertaMagangForm)
     */
    protected function getFormSchema(): array
    {
        return [
            Forms\Components\TextInput::make('nama')
                ->label('Nama Lengkap')
                ->required()
                ->maxLength(150),

            Forms\Components\TextInput::make('no_identitas')
                ->label('No. Identitas (KTP / NIM / NISN)')
                ->maxLength(50),

            Forms\Components\Select::make('jenis_kelamin')
                ->options([
                    'L' => 'Laki-laki',
                    'P' => 'Perempuan',
                ])
                ->required()
                ->label('Jenis Kelamin'),

            Forms\Components\DatePicker::make('tanggal_lahir')
                ->label('Tanggal Lahir')
                ->required(),

            Forms\Components\TextInput::make('no_hp')
                ->label('No. HP')
                ->tel()
                ->maxLength(20),

            Forms\Components\TextInput::make('email')
                ->label('Email')
                ->email()
                ->unique('users', 'email')
                ->required()
                ->maxLength(150),

            Forms\Components\Textarea::make('alamat')
                ->label('Alamat')
                ->columnSpanFull(),

            Forms\Components\FileUpload::make('foto')
                ->label('Pas Foto')
                ->image()
                ->directory('peserta/foto'),


            Forms\Components\FileUpload::make('cv')
                ->label('CV')
                ->directory('peserta/cv')
                ->acceptedFileTypes(['application/pdf'])
                ->maxSize(2048),

            Forms\Components\TextInput::make('jurusan')
                ->label('Jurusan')
                ->maxLength(100),

            Forms\Components\Select::make('semester')
                ->label('Semester')
                ->options(array_combine(range(1, 12), range(1, 12)))
                ->default(1),

            Forms\Components\TextInput::make('asal_instansi')
                ->label('Asal Instansi')
                ->maxLength(150),

            Forms\Components\FileUpload::make('surat_pengantar')
                ->label('Surat Pengantar')
                ->acceptedFileTypes(['application/pdf'])
                ->directory('peserta/surat_pengantar')
                ->maxSize(2048),
        ];
    }

    /**
     * 🔹 Proses submit formulir
     */
    public function submit(): void
    {
        $validated = $this->form->getState();

        // ✅ Buat akun user baru
        $user = User::create([
            'name' => $validated['nama'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['tanggal_lahir']), // default password = tanggal lahir
            'role' => 'peserta',
        ]);

        // ✅ Simpan data peserta magang
        // PesertaMagang::create([
        //     ...$validated,
        //     'user_id' => $user->id,
        //     'nama' => $validated['nama'],
        //     'status' => 'daftar',
        // ]);
        //buat perintah simpan sederhana
        $peserta = new PesertaMagang();
        $peserta->user_id = $user->id;
        $peserta->nama = $validated['nama'];
        $peserta->no_identitas = $validated['no_identitas'] ?? null;
        $peserta->jenis_kelamin = $validated['jenis_kelamin'];
        $peserta->tanggal_lahir = $validated['tanggal_lahir'];
        $peserta->no_hp = $validated['no_hp'] ?? null;
        $peserta->email = $validated['email'];
        $peserta->alamat = $validated['alamat'] ?? null;
        $peserta->foto = $validated['foto'] ?? null;
        $peserta->cv = $validated['cv'] ?? null;
        $peserta->jurusan = $validated['jurusan'] ?? null;
        $peserta->semester = $validated['semester'] ?? null;
        $peserta->asal_instansi = $validated['asal_instansi'] ?? null;
        $peserta->surat_pengantar = $validated['surat_pengantar'] ?? null;
        $peserta->status = 'daftar';
        $peserta->save();
        // ✅ Notifikasi sukses


        Notification::make()
            ->title('Pendaftaran Berhasil!')
            ->body('Akun Anda telah terdaftar. Silakan tunggu verifikasi dari admin.')
            ->success()
            ->send();

        $this->form->fill([]);
        $this->redirect('/peserta/login');
    }

    public static function shouldRegisterNavigation(): bool
    {
        return false;
    }
}
