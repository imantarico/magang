@if ($getRecord()->foto)
    <div class="flex justify-center my-3">
        <img src="{{ asset('storage/' . $getRecord()->foto) }}"
             alt="Foto Peserta"
             class="w-8 h-8 rounded-full object-cover shadow-md border">
    </div>
@else
    <p class="text-center text-gray-500">Tidak ada foto</p>
@endif
