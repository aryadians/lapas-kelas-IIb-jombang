<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Lapas Kelas IIB Jombang - Sistem Informasi Pemasyarakatan</title>

    {{-- Favicon --}}
    <link rel="icon" href="{{ asset('img/logo.png') }}" type="image/png">

    {{-- 1. ASSETS PENTING (Font, Icon, Tailwind) --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700;800&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.tailwindcss.com"></script>
    
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>

<body class="font-sans text-gray-900 antialiased">
    
    {{-- BACKGROUND & CONTAINER UTAMA --}}
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-12 sm:pt-8 bg-gradient-to-br from-slate-900 via-blue-900 to-slate-900 relative overflow-hidden">

        {{-- Animated Background Elements --}}
        <div class="absolute inset-0 z-0">
            <div class="absolute top-20 left-10 w-32 h-32 bg-blue-500/10 rounded-full blur-3xl animate-pulse"></div>
            <div class="absolute bottom-20 right-10 w-40 h-40 bg-yellow-500/10 rounded-full blur-3xl animate-pulse" style="animation-delay: 1s;"></div>
            <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-64 h-64 bg-purple-500/5 rounded-full blur-3xl animate-pulse" style="animation-delay: 2s;"></div>
            <div class="absolute inset-0 bg-[url('data:image/svg+xml,%3Csvg width="60" height="60" viewBox="0 0 60 60" xmlns="http://www.w3.org/2000/svg"%3E%3Cg fill="none" fill-rule="evenodd"%3E%3Cg fill="%23ffffff" fill-opacity="0.02"%3E%3Ccircle cx="30" cy="30" r="2"/%3E%3C/g%3E%3C/g%3E%3C/svg%3E')] opacity-30"></div>
        </div>

        {{-- LOGO DI ATAS FORM --}}
        <div class="mb-4 flex flex-col items-center">
            <a href="{{ url('/') }}" class="flex flex-col items-center group">
                {{-- Logo bulat dengan border --}}
                <div class="relative mb-4">
                    <img src="{{ asset('img/logo.png') }}" class="w-24 h-24 rounded-full border-4 border-yellow-500 shadow-2xl group-hover:scale-110 transition-transform duration-300 bg-white p-2" alt="Logo Lapas Kelas IIB Jombang">
                    <div class="absolute -inset-1 bg-gradient-to-r from-yellow-400 to-yellow-600 rounded-full blur opacity-30 group-hover:opacity-50 transition-opacity"></div>
                </div>
                <h2 class="text-2xl font-bold text-white tracking-wide text-center">LAPAS KELAS IIB JOMBANG</h2>
                <p class="text-sm text-yellow-400 font-semibold tracking-widest uppercase mt-1 text-center">Sistem Informasi Pemasyarakatan</p>
            </a>
        </div>

        {{-- KOTAK FORM LOGIN (SLOT) --}}
        <div class="w-full sm:max-w-md px-8 py-8 bg-white shadow-2xl overflow-hidden sm:rounded-2xl border-t-4 border-yellow-500 relative z-10 backdrop-blur-sm bg-white/95">
            {{-- Ini yang menampilkan Form Login --}}
            {{ $slot }}
        </div>


    </div>

    {{-- WIDGET AKSESIBILITAS --}}
    {{-- Pastikan file resources/views/components/aksesibilitas.blade.php sudah dibuat --}}
    <x-aksesibilitas /> 

    {{-- Alpine.js --}}
    <script src="//unpkg.com/alpinejs" defer></script>

    <script src="https://unpkg.com/nprogress@0.2.0/nprogress.js"></script>
    <link rel="stylesheet" href="https://unpkg.com/nprogress@0.2.0/nprogress.css">
    <style>
        #nprogress .bar { background: #3b82f6 !important; height: 3px !important; }
    </style>
    <script>
        window.addEventListener('beforeunload', () => NProgress.start());
    </script>

    <script src="//instant.page/5.2.0" type="module" integrity="sha384-jnZyxPjiipSbm6WFEJp1hi6VExjQ7uE6TRiMUNGR6fInGo4InAsISAbHsGuNwXAY"></script>
</body>
</html>