<div class="space-y-1">
    {{-- Label (judul field) --}}
    <div class="text-sm font-medium text-gray-700 dark:text-gray-300">
        {{ $getLabel() }}
    </div>

    {{-- Konten file --}}
    @if ($getRecord()->{$getName()})
        <a
            href="{{ asset('storage/' . $getRecord()->{$getName()}) }}"
            target="_blank"
            rel="noopener noreferrer"
        >
            <span>Lihat File</span>
        </a>
    @else
        <span class="text-gray-500 italic">Tidak ada file</span>
    @endif
</div>
