<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Pendaftaran Peserta Magang' }}</title>

    {{-- 🔹 CSS & JS Filament --}}
    @filamentStyles
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="min-h-screen bg-gray-100 flex items-center justify-center font-sans antialiased">
    {{ $slot }}

    @livewireScripts
    @filamentScripts
</body>
</html>
