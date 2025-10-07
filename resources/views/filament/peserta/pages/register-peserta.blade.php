<x-filament-panels::page>
    <div class="max-w-3xl mx-auto bg-white rounded-xl shadow p-6">
        <h2 class="text-2xl font-semibold text-center mb-6 text-primary-600">
            Pendaftaran Peserta Magang
        </h2>

        <x-filament-forms::form wire:submit="submit">
            {{ $this->form }}

            <div class="mt-6 flex justify-center">
                <x-filament::button type="submit" color="primary" size="lg">
                    <x-heroicon-o-paper-airplane class="w-5 h-5 mr-2" />
                    Daftar Sekarang
                </x-filament::button>
            </div>
        </x-filament-forms::form>
    </div>
</x-filament-panels::page>
