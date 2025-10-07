<?php

namespace App\Filament\Peserta\Pages;

use App\Models\User;
use App\Models\PesertaMagang;
use Filament\Pages\Page;
use Filament\Forms;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Hash;
use BackedEnum;
use UnitEnum;

class RegisterPeserta extends Page
{
    use Forms\Concerns\InteractsWithForms;

    // 🔹 Konfigurasi dasar halaman
     protected static ?string $model = PesertaMagang::class;
    protected static ?string $title = 'Pendaftaran Peserta Magang';
    protected static ?string $navigationLabel = 'Peserta Magang';
    protected static UnitEnum|string|null $navigationGroup = 'Data Magang';
    protected static BackedEnum|string|null $navigationIcon = 'heroicon-o-user-group';
    protected static ?string $slug = 'peserta-magang';
    protected static ?string $recordTitleAttribute = 'nama';
    protected static string $layout = 'filament-panels::components.layout.simple';
    protected static bool $shouldRegisterNavigation = false;

    protected string $view = 'filament.peserta.pages.register-peserta';
    public ?array $data = [];

    /**
     * 🔹 Skema Formulir (Filament v4)
     */
    protected function getFormSchema(): array
    {
        return [
            Forms\Components\TextInput::make('nama')
                ->label('Nama Lengkap')
                ->required(),

            Forms\Components\TextInput::make('no_identitas')
                ->label('No Identitas (NIM/NIK)')
                ->unique('peserta_magang', 'no_identitas')
                ->required(),

            Forms\Components\Select::make('jenis_kelamin')
                ->label('Jenis Kelamin')
                ->options([
                    'L' => 'Laki-laki',
                    'P' => 'Perempuan',
                ])
                ->required(),

            Forms\Components\DatePicker::make('tanggal_lahir')
                ->label('Tanggal Lahir')
                ->required(),

            Forms\Components\TextInput::make('no_hp')
                ->label('Nomor HP / WhatsApp')
                ->tel()
                ->required(),

            Forms\Components\TextInput::make('email')
                ->label('Email Aktif')
                ->email()
                ->unique('users', 'email')
                ->required(),

            Forms\Components\Textarea::make('alamat')
                ->label('Alamat Lengkap')
                ->rows(3)
                ->required()
                ->columnSpanFull(),

            Forms\Components\TextInput::make('jurusan')
                ->label('Jurusan / Program Studi')
                ->required(),

            Forms\Components\TextInput::make('semester')
                ->label('Semester')
                ->numeric()
                ->minValue(1)
                ->maxValue(14)
                ->required(),

            Forms\Components\TextInput::make('asal_instansi')
                ->label('Asal Instansi / Kampus / Sekolah')
                ->required(),

            Forms\Components\FileUpload::make('foto')
                ->label('Pas Foto (max 2MB)')
                ->directory('peserta/foto')
                ->image()
                ->maxSize(2048)
                ->required(),

            Forms\Components\FileUpload::make('cv')
                ->label('Curriculum Vitae (PDF, max 2MB)')
                ->directory('peserta/cv')
                ->acceptedFileTypes(['application/pdf'])
                ->maxSize(2048)
                ->required(),

            Forms\Components\FileUpload::make('surat_pengantar')
                ->label('Surat Pengantar (PDF, max 2MB)')
                ->directory('peserta/surat')
                ->acceptedFileTypes(['application/pdf'])
                ->maxSize(2048)
                ->required(),
        ];
    }

    /**
     * 🔹 Proses submit formulir pendaftaran
     */
    public function submit(): void
    {
        $validated = $this->form->getState();

        // ✅ Buat akun user baru
        $user = User::create([
            'name' => $validated['nama'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['tanggal_lahir']), // password = tanggal lahir
            'role' => 'peserta',
        ]);

        // ✅ Simpan data peserta magang
        PesertaMagang::create([
            ...$validated,
            'user_id' => $user->id,
            'status' => 'daftar',
        ]);

        // ✅ Notifikasi sukses
        Notification::make()
            ->title('Pendaftaran Berhasil!')
            ->body('Akun Anda telah terdaftar. Silakan tunggu verifikasi dari admin.')
            ->success()
            ->send();

        // Kosongkan form & redirect
        $this->form->fill([]);
        $this->redirect('/peserta/login');
    }
}
