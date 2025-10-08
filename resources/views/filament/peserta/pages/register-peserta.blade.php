<x-filament-panels::page.simple>
    <div class="max-w-2xl mx-auto space-y-6">
        <x-filament::section>
            <x-slot name="heading">
                📝 Pendaftaran Peserta Magang
            </x-slot>

            {{-- Semua form otomatis di-render --}}
            {{ $this->form }}

            <div class="mt-4">
                <x-filament::button wire:click="submit" class="w-full">
                    Daftar Sekarang
                </x-filament::button>
            </div>
        </x-filament::section>
    </div>
</x-filament-panels::page.simple>
