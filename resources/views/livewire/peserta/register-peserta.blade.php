<div class="max-w-2xl mx-auto bg-white p-8 rounded-2xl shadow-lg">
    <h2 class="text-2xl font-bold text-center mb-6 text-gray-800">
        Pendaftaran Peserta Magang
    </h2>

    @if (session('success'))
        <div class="p-4 mb-4 text-green-800 bg-green-100 border border-green-300 rounded-lg">
            {{ session('success') }}
        </div>
    @endif

    <form wire:submit.prevent="submit" class="space-y-5">
        {{-- Nama --}}
        <div>
            <label class="block font-semibold text-sm mb-1">Nama Lengkap</label>
            <input type="text" wire:model="nama" class="w-full border-gray-300 rounded-lg focus:ring-primary-500 focus:border-primary-500" />
            @error('nama') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        {{-- No Identitas --}}
        <div>
            <label class="block font-semibold text-sm mb-1">No. Identitas (KTP / NIM / NISN)</label>
            <input type="text" wire:model="no_identitas" class="w-full border-gray-300 rounded-lg focus:ring-primary-500 focus:border-primary-500" />
        </div>

        {{-- Jenis Kelamin --}}
        <div>
            <label class="block font-semibold text-sm mb-1">Jenis Kelamin</label>
            <select wire:model="jenis_kelamin" class="w-full border-gray-300 rounded-lg">
                <option value="">-- Pilih --</option>
                <option value="L">Laki-laki</option>
                <option value="P">Perempuan</option>
            </select>
            @error('jenis_kelamin') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        {{-- Tanggal Lahir --}}
        <div>
            <label class="block font-semibold text-sm mb-1">Tanggal Lahir</label>
            <input type="date" wire:model="tanggal_lahir" class="w-full border-gray-300 rounded-lg focus:ring-primary-500 focus:border-primary-500" />
            @error('tanggal_lahir') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        {{-- No HP --}}
        <div>
            <label class="block font-semibold text-sm mb-1">No. HP</label>
            <input type="tel" wire:model="no_hp" class="w-full border-gray-300 rounded-lg focus:ring-primary-500 focus:border-primary-500" />
        </div>

        {{-- Email --}}
        <div>
            <label class="block font-semibold text-sm mb-1">Email</label>
            <input type="email" wire:model="email" class="w-full border-gray-300 rounded-lg focus:ring-primary-500 focus:border-primary-500" />
            @error('email') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        {{-- Alamat --}}
        <div>
            <label class="block font-semibold text-sm mb-1">Alamat</label>
            <textarea wire:model="alamat" class="w-full border-gray-300 rounded-lg focus:ring-primary-500 focus:border-primary-500" rows="3"></textarea>
        </div>

        {{-- Foto --}}
        <div>
            <label class="block font-semibold text-sm mb-1">Pas Foto</label>
            <input type="file" wire:model="foto" class="w-full border-gray-300 rounded-lg" />
            @error('foto') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        {{-- CV --}}
        <div>
            <label class="block font-semibold text-sm mb-1">CV (PDF)</label>
            <input type="file" wire:model="cv" class="w-full border-gray-300 rounded-lg" />
            @error('cv') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        {{-- Jurusan --}}
        <div>
            <label class="block font-semibold text-sm mb-1">Jurusan</label>
            <input type="text" wire:model="jurusan" class="w-full border-gray-300 rounded-lg focus:ring-primary-500 focus:border-primary-500" />
        </div>

        {{-- Semester --}}
        <div>
            <label class="block font-semibold text-sm mb-1">Semester</label>
            <select wire:model="semester" class="w-full border-gray-300 rounded-lg">
                @for ($i = 1; $i <= 12; $i++)
                    <option value="{{ $i }}">{{ $i }}</option>
                @endfor
            </select>
        </div>

        {{-- Asal Instansi --}}
        <div>
            <label class="block font-semibold text-sm mb-1">Asal Instansi</label>
            <input type="text" wire:model="asal_instansi" class="w-full border-gray-300 rounded-lg focus:ring-primary-500 focus:border-primary-500" />
        </div>

        {{-- Surat Pengantar --}}
        <div>
            <label class="block font-semibold text-sm mb-1">Surat Pengantar (PDF)</label>
            <input type="file" wire:model="surat_pengantar" class="w-full border-gray-300 rounded-lg" />
            @error('surat_pengantar') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <button type="submit"
            class="w-full bg-primary-600 hover:bg-primary-700 text-white font-semibold py-2 rounded-lg transition">
            Daftar Sekarang
        </button>
    </form>

    <p class="text-center text-sm text-gray-500 mt-6">
        Sudah punya akun?
        <a href="/peserta/login" class="text-primary-600 font-semibold hover:underline">Masuk di sini</a>
    </p>
</div>
