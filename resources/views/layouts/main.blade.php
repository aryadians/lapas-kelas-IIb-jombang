<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    {{-- CSRF Token Wajib untuk AJAX --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Lapas Kelas IIB Jombang</title>

    <link rel="icon" href="{{ asset('img/logo.png') }}" type="image/png">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    {{-- Font Khusus Disleksia --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/opendyslexic@latest/open-dyslexic.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.tailwindcss.com"></script>

    {{-- WAJIB: Script Alpine.js --}}
    <script src="//unpkg.com/alpinejs" defer></script>
    {{-- WAJIB: SweetAlert2 untuk Notifikasi Cantik --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        body {
            font-family: 'Inter', sans-serif;
            transition: filter 0.3s ease, font-size 0.3s ease;
        }

        /* Class untuk fitur aksesibilitas */
        .acc-grayscale { filter: grayscale(100%); }
        .acc-contrast { filter: invert(100%) hue-rotate(180deg); }
        .acc-dyslexia * { font-family: 'OpenDyslexic', sans-serif !important; }

        .acc-cursor,
        .acc-cursor a,
        .acc-cursor button {
            cursor: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="%23EAB308" stroke="%23000" stroke-width="2"><path d="M3 3l7.07 16.97 2.51-7.39 7.39-2.51L3 3z"/></svg>'), auto !important;
        }
    </style>
</head>

<body class="font-sans antialiased text-slate-900 bg-white leading-relaxed"
    x-data="accessibilityHandler()"
    :class="{ 
          'acc-grayscale': grayscale, 
          'acc-contrast': contrast, 
          'acc-dyslexia': dyslexia,
          'acc-cursor': bigCursor 
      }">

{{-- NAVBAR --}}
    <nav class="bg-gradient-to-br from-slate-950 via-blue-950 to-slate-950 backdrop-blur-md fixed w-full z-50 shadow-2xl border-b border-slate-800/50 transition-all duration-300">
        {{-- PERBAIKAN 1: Gunakan 'w-full' (lebar penuh) dan kurangi padding 'px-2' agar logo bisa lebih ke pojok kiri --}}
        <div class="w-full mx-auto px-2 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">

                {{-- Logo Kiri --}}
                {{-- PERBAIKAN 2: Margin negatif diperbesar (-ml-4 di mobile, -ml-10 di desktop) untuk menggeser paksa ke kiri --}}
              <div class="flex-shrink-0 flex items-center gap-2 -ml-2 lg:-ml-6 pl-6">
                    <a href="{{ url('/') }}" class="flex items-center gap-2 group">
                        <div class="relative">
                            {{-- Logo Image --}}
                            <img class="h-10 w-10 lg:h-12 lg:w-12 rounded-full border-2 border-yellow-500 shadow-lg group-hover:scale-105 transition-transform duration-300 bg-white p-1"
                                src="{{ asset('img/logo.png') }}"
                                alt="Logo Lapas">
                            <div class="absolute -inset-1 bg-gradient-to-r from-yellow-400 to-yellow-600 rounded-full blur opacity-20 group-hover:opacity-40 transition-opacity"></div>
                        </div>

                        <div class="flex flex-col">
                            {{-- Teks Logo --}}
                            <span class="font-bold text-white text-sm lg:text-base tracking-wide group-hover:text-yellow-400 transition-colors duration-300 whitespace-nowrap">
                                <span class="hidden xl:inline">LAPAS KELAS IIB JOMBANG</span> {{-- Tampil di layar sangat besar --}}
                                <span class="xl:hidden">LAPAS JOMBANG</span> {{-- Tampil di layar laptop biasa agar tidak nabrak --}}
                            </span>
                            <span class="text-[10px] text-yellow-500 uppercase tracking-wider font-semibold hidden md:block whitespace-nowrap">
                                KEMENTRIAN IMIGRASI DAN PEMASYARAKATAN RI
                            </span>
                        </div>
                    </a>
                </div>

                {{-- Menu Tengah --}}
                <div class="hidden md:flex space-x-4 lg:space-x-8 items-center justify-center flex-1"> 
                    {{-- Tambahkan flex-1 agar menu tengah berusaha mengambil ruang tengah, tapi logo tetap di kiri --}}
                    <a href="{{ url('/') }}" class="text-gray-300 hover:text-white hover:border-b-2 hover:border-yellow-500 px-1 py-2 text-sm lg:text-base font-semibold transition-all duration-300">Beranda</a>
                    <a href="{{ route('profile.index') }}" class="text-gray-300 hover:text-white hover:border-b-2 hover:border-yellow-500 px-1 py-2 text-sm lg:text-base font-semibold transition-all duration-300">Profil</a>
                    <a href="{{ route('news.public.index') }}" class="text-gray-300 hover:text-white hover:border-b-2 hover:border-yellow-500 px-1 py-2 text-sm lg:text-base font-semibold transition-all duration-300">Berita</a>
                    <a href="{{ route('announcements.public.index') }}" class="text-gray-300 hover:text-white hover:border-b-2 hover:border-yellow-500 px-1 py-2 text-sm lg:text-base font-semibold transition-all duration-300">Pengumuman</a>
                    <a href="{{ route('live.antrian') }}" class="text-gray-300 hover:text-white hover:border-b-2 hover:border-yellow-500 px-1 py-2 text-sm lg:text-base font-semibold transition-all duration-300 flex items-center gap-2">
                        <span class="relative flex h-2 w-2 lg:h-3 lg:w-3">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-2 w-2 lg:h-3 lg:w-3 bg-red-500"></span>
                        </span>
                        Live Antrian
                    </a>
                    <a href="{{ route('gallery.index') }}" class="text-yellow-400 hover:text-white hover:border-b-2 hover:border-yellow-500 px-1 py-2 text-sm lg:text-base font-bold transition-all duration-300 flex items-center gap-2">
                        <i class="fas fa-store"></i> Galeri
                    </a>
                </div>

                {{-- Menu Kanan --}}
                <div class="hidden md:flex items-center gap-4">
                    {{-- Button Pendaftaran --}}
                    <a href="{{ route('kunjungan.create') }}"
                        class="text-sm lg:text-base font-extrabold text-slate-900 bg-gradient-to-r from-yellow-400 to-yellow-500 hover:from-yellow-500 hover:to-yellow-600 px-5 lg:px-7 py-2 lg:py-3 rounded-full transition-all duration-300 shadow-lg hover:shadow-yellow-500/30 transform hover:-translate-y-1 whitespace-nowrap inline-flex items-center gap-2 group">
                        Daftar <span class="hidden lg:inline">Kunjungan</span> <i class="fa-solid fa-arrow-right-long text-sm group-hover:translate-x-1 transition-transform"></i>
                    </a>

                    <div class="h-6 w-px bg-slate-700/50 mx-1"></div>

                    {{-- Icon Login --}}
                    @if (Route::has('login'))
                    @auth
                    <a href="{{ url('/dashboard') }}" title="Dashboard"
                        class="p-2 text-slate-400 hover:text-yellow-400 hover:bg-slate-800/50 rounded-full transition-all duration-300 hover:scale-110">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 016 3.75h2.25A2.25 2.25 0 0110.5 6v2.25a2.25 2.25 0 01-2.25 2.25H6a2.25 2.25 0 01-2.25-2.25V6zM3.75 15.75A2.25 2.25 0 016 13.5h2.25a2.25 2.25 0 012.25 2.25V18a2.25 2.25 0 01-2.25 2.25H6A2.25 2.25 0 013.75 18v-2.25zM13.5 6a2.25 2.25 0 012.25-2.25H18A2.25 2.25 0 0120.25 6v2.25A2.25 2.25 0 0118 10.5h-2.25a2.25 2.25 0 01-2.25-2.25V6zM13.5 15.75a2.25 2.25 0 012.25-2.25H18a2.25 2.25 0 012.25 2.25V18A2.25 2.25 0 0118 20.25h-2.25A2.25 2.25 0 0113.5 18v-2.25z" />
                        </svg>
                    </a>
                    @else
                    <a href="{{ route('login') }}" title="Login Petugas"
                        class="group flex items-center gap-2 p-2 text-slate-400 hover:text-yellow-400 hover:bg-slate-800/50 rounded-full transition-all duration-300 hover:scale-110">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 group-hover:scale-110 transition-transform">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M12 9l-3 3m0 0l3 3m-3-3h12.75" />
                        </svg>
                    </a>
                    @endauth
                    @endif
                </div>

                {{-- Mobile Toggle --}}
                <div class="-mr-2 flex md:hidden">
                    <button type="button" onclick="document.getElementById('mobile-menu').classList.toggle('hidden')" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-white hover:bg-slate-800/50 focus:outline-none transition-all duration-300 hover:scale-110">
                        <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
        
        {{-- ... Kode Mobile Menu di bawah ini tetap sama ... --}}

                {{-- Mobile Toggle --}}
                <div class="-mr-2 flex md:hidden">
                    <button type="button" onclick="document.getElementById('mobile-menu').classList.toggle('hidden')" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-white hover:bg-slate-800/50 focus:outline-none transition-all duration-300 hover:scale-110">
                        <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        {{-- Mobile Menu --}}
        <div class="hidden md:hidden bg-gradient-to-b from-slate-950 to-blue-950 border-t border-slate-700/50" id="mobile-menu">
            <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3">
                <a href="{{ route('kunjungan.create') }}"
                    class="block w-full text-center px-5 py-3 rounded-md text-base font-extrabold text-slate-900 bg-gradient-to-r from-yellow-400 to-yellow-500 hover:from-yellow-500 hover:to-yellow-600 transition-all duration-300 shadow-lg">
                    <i class="fa-solid fa-user-plus mr-2"></i> Pendaftaran Kunjungan
                </a>
                <a href="{{ url('/') }}" class="block px-3 py-2 rounded-md text-base font-semibold text-white hover:bg-slate-800/50 transition-all duration-300">Beranda</a>
                <a href="{{ route('profile.index') }}" class="block px-3 py-2 rounded-md text-base font-semibold text-gray-300 hover:text-white hover:bg-slate-800/50 transition-all duration-300">Profil</a>
                <a href="{{ route('news.public.index') }}" class="block px-3 py-2 rounded-md text-base font-semibold text-gray-300 hover:text-white hover:bg-slate-800/50 transition-all duration-300">Berita</a>
                <a href="{{ route('announcements.public.index') }}" class="block px-3 py-2 rounded-md text-base font-semibold text-gray-300 hover:text-white hover:bg-slate-800/50 transition-all duration-300">Pengumuman</a>
                <a href="{{ route('live.antrian') }}" class="flex items-center gap-2 px-3 py-2 rounded-md text-base font-semibold text-gray-300 hover:text-white hover:bg-slate-800/50 transition-all duration-300">
                    <span class="relative flex h-3 w-3">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-3 w-3 bg-red-500"></span>
                    </span>
                    Live Antrian
                </a>
                {{-- TAMBAHAN: MENU GALERI MOBILE --}}
        <a href="{{ route('gallery.index') }}" class="block px-3 py-2 rounded-md text-base font-bold text-yellow-400 hover:text-white hover:bg-slate-800/50 transition-all duration-300">
            <i class="fas fa-store mr-2"></i> Galeri Karya
        </a>

                @if (Route::has('login'))
                <a href="{{ route('login') }}" class="block px-3 py-2 mt-2 rounded-md text-base font-medium text-gray-400 hover:text-yellow-400 hover:bg-slate-800/50 transition-all duration-300">
                    @auth Dashboard @else Login Petugas @endauth
                </a>
                @endif
            </div>
        </div>
    </nav>

    {{-- KONTEN UTAMA --}}
    <div class="pt-20">
        @yield('content')
    </div>

    {{-- ================================================================= --}}
    {{-- WIDGET DISABILITAS / AKSESIBILITAS (POJOK KIRI BAWAH) --}}
    {{-- ================================================================= --}}
    <div x-data="{ openAccess: false }" class="fixed bottom-6 left-6 z-50 print:hidden">

        {{-- Tombol Pemicu Disabilitas (Warna Tema: Slate 900 & Yellow 500) --}}
        <button @click="openAccess = !openAccess"
            class="flex items-center justify-center w-14 h-14 bg-slate-900 hover:bg-slate-800 text-yellow-500 rounded-full shadow-2xl border-2 border-yellow-500 transition transform hover:scale-110 focus:outline-none focus:ring-2 focus:ring-yellow-400"
            aria-label="Menu Aksesibilitas">
            <i class="fa-solid fa-universal-access text-2xl"></i>
        </button>

        {{-- Pop Up Menu --}}
        <div x-show="openAccess"
            style="display: none;"
            @click.away="openAccess = false"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 translate-y-4 scale-90"
            x-transition:enter-end="opacity-100 translate-y-0 scale-100"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 translate-y-0 scale-100"
            x-transition:leave-end="opacity-0 translate-y-4 scale-90"
            class="absolute bottom-16 left-0 w-72 bg-white rounded-xl shadow-2xl border border-gray-200 overflow-hidden">

            {{-- Header Pop Up (Warna Tema) --}}
            <div class="bg-slate-900 p-4 flex justify-between items-center text-white border-b border-slate-800">
                <h3 class="font-bold flex items-center gap-2 text-yellow-500">
                    <i class="fa-solid fa-universal-access"></i> Aksesibilitas
                </h3>
                <button @click="openAccess = false" class="hover:text-yellow-500 transition"><i class="fa-solid fa-times"></i></button>
            </div>

            {{-- Body Pop Up --}}
            <div class="p-4 space-y-5">

                {{-- Fitur 1: Pembaca Suara (TTS) --}}
                <div class="bg-slate-50 p-3 rounded-lg border border-slate-200">
                    <p class="text-xs font-bold text-slate-500 uppercase mb-2">Pembaca Suara (TTS)</p>
                    <div class="flex gap-2">
                        {{-- Tombol Play --}}
                        <button @click="speak()" :disabled="isSpeaking" :class="isSpeaking ? 'opacity-50 cursor-not-allowed' : 'hover:bg-yellow-400 hover:text-slate-900'" class="flex-1 bg-slate-200 text-slate-700 py-2 rounded text-xs font-bold border border-slate-300 transition flex items-center justify-center gap-1">
                            <i class="fa-solid fa-play"></i> Baca
                        </button>
                        {{-- Tombol Stop --}}
                        <button @click="stopSpeaking()" class="flex-1 bg-red-100 text-red-600 hover:bg-red-200 py-2 rounded text-xs font-bold border border-red-200 transition flex items-center justify-center gap-1">
                            <i class="fa-solid fa-stop"></i> Stop
                        </button>
                    </div>
                    <p class="text-[10px] text-slate-400 mt-1 italic leading-tight">*Blok teks yang ingin dibaca, lalu klik Baca.</p>
                </div>

                {{-- Fitur 2: Ukuran Font --}}
                <div>
                    <p class="text-xs font-bold text-slate-500 uppercase mb-2">Ukuran Teks</p>
                    <div class="flex gap-2">
                        <button @click="changeFontSize(-10)" class="flex-1 bg-slate-100 hover:bg-slate-200 py-2 rounded text-sm font-bold border border-slate-300 text-slate-700">A-</button>
                        <button @click="resetFontSize()" class="flex-1 bg-slate-100 hover:bg-slate-200 py-2 rounded text-sm font-bold border border-slate-300 text-slate-700">Normal</button>
                        <button @click="changeFontSize(10)" class="flex-1 bg-slate-100 hover:bg-slate-200 py-2 rounded text-sm font-bold border border-slate-300 text-slate-700">A+</button>
                    </div>
                </div>

                {{-- Fitur 3: Tampilan Visual --}}
                <div>
                    <p class="text-xs font-bold text-slate-500 uppercase mb-2">Tampilan Visual</p>
                    <div class="grid grid-cols-2 gap-2">
                        {{-- Tombol Toggle dengan Logika Warna Tema --}}
                        <button @click="grayscale = !grayscale" :class="grayscale ? 'bg-yellow-500 text-slate-900 border-yellow-600' : 'bg-slate-100 text-slate-600 border-slate-200'" class="py-2 px-3 rounded text-xs font-semibold border transition flex flex-col items-center gap-1">
                            <i class="fa-solid fa-eye-slash"></i> Grayscale
                        </button>
                        <button @click="contrast = !contrast" :class="contrast ? 'bg-yellow-500 text-slate-900 border-yellow-600' : 'bg-slate-100 text-slate-600 border-slate-200'" class="py-2 px-3 rounded text-xs font-semibold border transition flex flex-col items-center gap-1">
                            <i class="fa-solid fa-circle-half-stroke"></i> Kontras
                        </button>
                        <button @click="dyslexia = !dyslexia" :class="dyslexia ? 'bg-yellow-500 text-slate-900 border-yellow-600' : 'bg-slate-100 text-slate-600 border-slate-200'" class="py-2 px-3 rounded text-xs font-semibold border transition flex flex-col items-center gap-1">
                            <i class="fa-solid fa-font"></i> Disleksia
                        </button>
                        <button @click="bigCursor = !bigCursor" :class="bigCursor ? 'bg-yellow-500 text-slate-900 border-yellow-600' : 'bg-slate-100 text-slate-600 border-slate-200'" class="py-2 px-3 rounded text-xs font-semibold border transition flex flex-col items-center gap-1">
                            <i class="fa-solid fa-arrow-pointer"></i> Kursor
                        </button>
                    </div>
                </div>

                {{-- Reset --}}
                <button @click="resetAll()" class="w-full py-2 bg-red-50 text-red-600 text-xs font-bold rounded border border-red-200 hover:bg-red-100 transition">
                    <i class="fa-solid fa-rotate-left mr-1"></i> Reset Semua Pengaturan
                </button>
            </div>
        </div>
    </div>

    {{-- ========================================== --}}
{{-- WIDGET SURVEI KEPUASAN (FLOATING KANAN) --}}
{{-- ========================================== --}}
<div x-data="{ openSurvey: false }" class="fixed bottom-6 right-6 z-40 print:hidden">

    {{-- Tombol Pemicu --}}
    <button @click="openSurvey = !openSurvey"
        class="flex items-center gap-2 bg-slate-900 hover:bg-slate-800 text-white px-5 py-3 rounded-full shadow-2xl border-2 border-yellow-500 transition transform hover:scale-105 group">
        <span class="font-bold text-sm hidden group-hover:block transition-all duration-300">Survei Kepuasan</span>
        <div class="relative">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-yellow-500 animate-pulse" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
        </div>
    </button>

    {{-- Modal Form with 3D animation --}}
    <div x-show="openSurvey"
        @survey-success.window="openSurvey = false"
        x-transition:enter="transition ease-out duration-300 transform"
        x-transition:enter-start="opacity-0 translate-y-4 scale-90"
        x-transition:enter-end="opacity-100 translate-y-0 scale-100"
        x-transition:leave="transition ease-in duration-200 transform"
        x-transition:leave-start="opacity-100 translate-y-0 scale-100"
        x-transition:leave-end="opacity-0 translate-y-4 scale-90"
        class="absolute bottom-16 right-0 w-80 md:w-96 bg-white rounded-2xl shadow-2xl border border-gray-200 overflow-hidden"
        style="display: none; perspective: 1000px;">
        <div class="transform transition-transform duration-500" :class="openSurvey ? 'rotate-x-0' : '-rotate-x-12'">

            {{-- Header Modal --}}
            <div class="bg-gradient-to-r from-slate-900 to-slate-800 p-4 flex justify-between items-center">
                <div>
                    <h3 class="text-white font-bold text-lg">IKM Online</h3>
                    <p class="text-xs text-yellow-500">Indeks Kepuasan Masyarakat</p>
                </div>
                <button @click="openSurvey = false" class="text-gray-400 hover:text-white transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            {{-- Body Form --}}
            <div class="p-5 bg-slate-50">
                <form action="{{ route('survey.store') }}" method="POST" id="surveyForm">
                    @csrf

                    <div class="mb-5 text-center">
                        <label class="block text-sm font-bold text-slate-700 mb-3">Bagaimana pelayanan kami?</label>
                        <div class="flex justify-center gap-3">
                            <label class="cursor-pointer group">
                                <input type="radio" name="rating" value="1" class="hidden peer" required>
                                <div class="text-4xl grayscale peer-checked:grayscale-0 peer-checked:animate-bounce transition-transform duration-300 group-hover:scale-125">😡</div>
                                <span class="text-xs font-semibold text-slate-400 peer-checked:text-red-500 block">Buruk</span>
                            </label>
                            <label class="cursor-pointer group">
                                <input type="radio" name="rating" value="2" class="hidden peer">
                                <div class="text-4xl grayscale peer-checked:grayscale-0 peer-checked:animate-bounce transition-transform duration-300 group-hover:scale-125">😐</div>
                                <span class="text-xs font-semibold text-slate-400 peer-checked:text-yellow-500 block">Cukup</span>
                            </label>
                            <label class="cursor-pointer group">
                                <input type="radio" name="rating" value="3" class="hidden peer">
                                <div class="text-4xl grayscale peer-checked:grayscale-0 peer-checked:animate-bounce transition-transform duration-300 group-hover:scale-125">😃</div>
                                <span class="text-xs font-semibold text-slate-400 peer-checked:text-blue-500 block">Baik</span>
                            </label>
                            <label class="cursor-pointer group">
                                <input type="radio" name="rating" value="4" class="hidden peer">
                                <div class="text-4xl grayscale peer-checked:grayscale-0 peer-checked:animate-bounce transition-transform duration-300 group-hover:scale-125">🤩</div>
                                <span class="text-xs font-semibold text-slate-400 peer-checked:text-green-500 block">Sangat Baik</span>
                            </label>
                        </div>
                    </div>

                    <div class="mb-4 relative">
                        <label class="block text-sm font-bold text-slate-700 mb-2">Kritik & Saran</label>
                        <div class="relative">
                            <i class="fa-solid fa-pen-to-square absolute left-3 top-1/2 -translate-y-1/2 text-slate-400"></i>
                            <textarea name="saran" rows="3" class="w-full text-sm rounded-lg border-slate-300 focus:border-yellow-500 focus:ring-yellow-500 shadow-sm pl-9 placeholder-slate-400 bg-white" placeholder="Tulis masukan Anda disini..."></textarea>
                        </div>
                    </div>

                    <button type="submit" id="submitSurvey" class="w-full bg-gradient-to-r from-yellow-400 to-yellow-500 hover:from-yellow-500 hover:to-yellow-600 text-slate-900 font-bold py-3 rounded-lg transition-all shadow-lg hover:shadow-yellow-500/30 transform hover:-translate-y-1 disabled:opacity-50 disabled:cursor-not-allowed">
                        <span id="submitText">Kirim Penilaian</span>
                        <span id="loadingText" class="hidden items-center justify-center">
                            <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-slate-900 inline" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            Mengirim...
                        </span>
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
        
            {{-- FOOTER --}}
            <footer class="bg-gradient-to-br from-slate-900 via-blue-900 to-slate-900 text-white pt-16 pb-8 border-t border-slate-800/50 relative overflow-hidden">
                {{-- Background Pattern --}}
                <div class="absolute inset-0 z-0">
                    <div class="absolute inset-0 bg-[url('data:image/svg+xml,%3Csvg width="60" height="60" viewBox="0 0 60 60" xmlns="http://www.w3.org/2000/svg"%3E%3Cg fill="none" fill-rule="evenodd"%3E%3Cg fill="%23ffffff" fill-opacity="0.03"%3E%3Ccircle cx="30" cy="30" r="2"/%3E%3C/g%3E%3C/g%3E%3C/svg%3E')] opacity-20"></div>
                </div>
        
                {{-- Floating Elements --}}
                <div class="absolute top-20 left-10 w-20 h-20 bg-blue-500/5 rounded-full blur-xl animate-pulse"></div>
                <div class="absolute bottom-20 right-10 w-32 h-32 bg-yellow-500/5 rounded-full blur-xl animate-pulse" style="animation-delay: 1s;"></div>
        
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 lg:gap-16 items-start">
        
                        {{-- KOLOM KIRI: Google Maps --}}
                        <div class="w-full h-64 md:h-80 rounded-2xl overflow-hidden shadow-2xl border border-slate-700/50 relative group">
                            <iframe
                                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3955.149599388365!2d112.23126867575233!3d-7.558661674643537!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e78401e73999999%3A0x26906660d6ad0951!2sLapas%20Kelas%20IIB%20Jombang!5e0!3m2!1sid!2sid!4v1706869500000!5m2!1sid!2sid"
                                class="w-full h-full border-0 filter grayscale group-hover:grayscale-0 transition duration-500"
                                allowfullscreen=""
                                loading="lazy"
                                referrerpolicy="no-referrer-when-downgrade">
                            </iframe>
                            <div class="absolute bottom-4 left-4 bg-white/90 backdrop-blur text-slate-900 px-4 py-2 rounded-lg text-xs font-bold shadow-lg">
                                📍 Lokasi Lapas Kelas IIB Jombang
                            </div>
                            <div class="absolute top-4 right-4 bg-blue-600/90 backdrop-blur text-white px-3 py-1 rounded-lg text-xs font-semibold shadow-lg">
                                <i class="fas fa-map-marker-alt mr-1"></i> -7.5587, 112.2313
                            </div>
                        </div>
        
                                                {{-- KOLOM KANAN: Informasi Kontak --}}
                                                <div class="flex flex-col justify-center space-y-8">
                        
                                                    {{-- Logo & Judul --}}
                                                    <div>
                                                        <div class="flex items-center gap-3 mb-4">
                                                            <img src="{{ asset('img/logo.png') }}" alt="Logo" class="h-12 w-auto drop-shadow-lg">
                                                            <div class="min-h-12 flex flex-col justify-center">
                                                                <h3 class="text-xl font-bold text-white tracking-wide">KEMENTERIAN IMIGRASI DAN PEMASYARAKATAN</h3>
                                                                <p class="text-xs text-yellow-500 font-semibold tracking-wider uppercase">Republik Indonesia</p>
                                                            </div>
                                                        </div>
                                                        <p class="text-slate-400 text-sm leading-relaxed max-w-md">
                                                            Melayani dengan sepenuh hati, mewujudkan pemasyarakatan yang PASTI (Profesional, Akuntabel, Sinergi, Transparan, dan Inovatif).
                                                        </p>
                                                    </div>
                        
                                                    {{-- NEW: Unit Utama and Internal Links --}}
                                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-8">
                                                        <div>
                                                            <h4 class="text-lg font-bold text-white mb-4">Unit Utama</h4>
                                                            <ul class="space-y-2">
                                                                <li><a href="https://www.kemenkumham.go.id/" target="_blank" rel="noopener noreferrer" class="text-slate-400 hover:text-yellow-400 transition-colors duration-300 text-sm">Sekretariat Jenderal</a></li>
                                                                <li><a href="http://www.ditjenpas.go.id/" target="_blank" rel="noopener noreferrer" class="text-slate-400 hover:text-yellow-400 transition-colors duration-300 text-sm">Ditjen PAS</a></li>
                                                                <li><a href="https://imigrasi.go.id/id/" target="_blank" rel="noopener noreferrer" class="text-slate-400 hover:text-yellow-400 transition-colors duration-300 text-sm">Ditjen Imigrasi</a></li>
                                                                <li><a href="#" target="_blank" rel="noopener noreferrer" class="text-slate-400 hover:text-yellow-400 transition-colors duration-300 text-sm">Inspektorat Jenderal</a></li>
                                                                <li><a href="https://bpsdm.kemenimipas.go.id/" target="_blank" rel="noopener noreferrer" class="text-slate-400 hover:text-yellow-400 transition-colors duration-300 text-sm">BPSDM</a></li>
                                                            </ul>
                                                        </div>
                                                        <div>
                                                            <h4 class="text-lg font-bold text-white mb-4">Internal Links</h4>
                                                            <ul class="space-y-2">
                                                                <li><a href="{{ route('display.antrian') }}" target="_blank" rel="noopener noreferrer" class="text-slate-400 hover:text-yellow-400 transition-colors duration-300 text-sm">Display Antrian</a></li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                    {{-- END NEW --}}
                        
                                                    {{-- Detail Kontak --}}
                                                    <div class="space-y-4">
                                                        <div class="flex items-start gap-4 group">
                                                            <div class="bg-slate-800/50 p-3 rounded-lg text-yellow-500 group-hover:bg-yellow-500 group-hover:text-slate-900 transition-all duration-300 border border-slate-700/30">
                                                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                                </svg>
                                                            </div>
                                                            <div>
                                                                <p class="text-xs text-slate-400 font-bold uppercase mb-1">Alamat Kantor</p>
                                                                <p class="text-white font-medium leading-snug">
                                                                    Jl. KH. Wahid Hasyim No.155<br>
                                                                    Jombang, Jawa Timur 61419
                                                                </p>
                                                            </div>
                                                        </div>
                        
                                                        <div class="flex items-start gap-4 group">
                                                            <div class="bg-slate-800/50 p-3 rounded-lg text-blue-500 group-hover:bg-blue-500 group-hover:text-white transition-all duration-300 border border-slate-700/30">
                                                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                                                </svg>
                                                            </div>
                                                            <div>
                                                                <p class="text-xs text-slate-400 font-bold uppercase mb-1">Telepon & Fax</p>
                                                                <p class="text-white font-medium hover:text-yellow-400 transition-colors duration-300 cursor-pointer">
                                                                    +62 321 861205
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>
                        
                                                    {{-- Social Media Icons --}}
                                                    <div class="">
                                                        <p class="text-sm text-slate-300 font-bold uppercase mb-4">Ikuti Media Sosial Kami</p>
                                                        <div class="flex flex-wrap gap-4">
                                                            <a href="https://www.facebook.com/humaslapasjombang/" aria-label="Facebook" class="w-11 h-11 flex items-center justify-center rounded-full bg-slate-800/50 text-slate-400 hover:bg-[#1877F2] hover:text-white border border-slate-700/30 hover:border-[#1877F2] transition-all duration-300 transform hover:scale-110 shadow-lg">
                                                                <i class="fab fa-facebook-f text-xl"></i>
                                                            </a>
                                                            <a href="https://twitter.com/lapas_jombang" aria-label="Twitter" class="w-11 h-11 flex items-center justify-center rounded-full bg-slate-800/50 text-slate-400 hover:bg-[#1DA1F2] hover:text-white border border-slate-700/30 hover:border-[#1DA1F2] transition-all duration-300 transform hover:scale-110 shadow-lg">
                                                                <i class="fab fa-twitter text-xl"></i>
                                                            </a>
                                                            <a href="https://www.instagram.com/lapas_jombang/" aria-label="Instagram" class="w-11 h-11 flex items-center justify-center rounded-full bg-slate-800/50 text-slate-400 hover:bg-gradient-to-tr hover:from-yellow-500 hover:via-red-500 hover:to-purple-500 hover:text-white border border-slate-700/30 hover:border-pink-500 transition-all duration-300 transform hover:scale-110 shadow-lg">
                                                                <i class="fab fa-instagram text-xl"></i>
                                                            </a>
                                                            <a href="https://www.youtube.com/@humaslapasjombang" aria-label="YouTube" class="w-11 h-11 flex items-center justify-center rounded-full bg-slate-800/50 text-slate-400 hover:bg-[#FF0000] hover:text-white border border-slate-700/30 hover:border-[#FF0000] transition-all duration-300 transform hover:scale-110 shadow-lg">
                                                                <i class="fab fa-youtube text-xl"></i>
                                                            </a>
                                                            <a href="https://www.tiktok.com/@lapas_jombang" aria-label="TikTok" class="w-11 h-11 flex items-center justify-center rounded-full bg-slate-800/50 text-slate-400 hover:bg-black hover:text-white border border-slate-700/30 hover:border-slate-500 transition-all duration-300 transform hover:scale-110 shadow-lg">
                                                                <i class="fab fa-tiktok text-xl"></i>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>                    </div>
        
                    {{-- Copyright Bawah --}}
                    <div class="mt-12 pt-8 border-t border-slate-800/50 text-center text-slate-500 text-sm">
                        <p>© {{ date('Y') }} Lapas Kelas IIB Jombang. All rights reserved.</p>
                        <p class="mt-2 text-xs">Developed by Tim IT</p>
                    </div>
                </div>
            </footer>
        
            {{-- Script Logic Aksesibilitas dengan TTS & Survey AJAX --}}
            <script>
                // 1. Logic Survey AJAX
                document.addEventListener('DOMContentLoaded', function() {
                    const surveyForm = document.getElementById('surveyForm');
                    if (surveyForm) {
                        surveyForm.addEventListener('submit', function(e) {
                            e.preventDefault();
                            handleSurveySubmit(e.target);
                        });
                    }
                });
        
                function handleSurveySubmit(form) {
                    const submitBtn = form.querySelector('#submitSurvey');
                    const submitText = form.querySelector('#submitText');
                    const loadingText = form.querySelector('#loadingText');
        
                    submitBtn.disabled = true;
                    submitText.classList.add('hidden');
                    loadingText.classList.remove('hidden');
        
                    const formData = new FormData(form);
        
                    fetch(form.action, {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        }
                    })
                    .then(response => {
                        // Always parse the JSON to get the data
                        return response.json().then(data => ({ status: response.status, body: data }));
                    })
                    .then(({ status, body }) => {
                        if (status === 200) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil!',
                                text: body.message || 'Terima kasih atas penilaian Anda!',
                                timer: 3000,
                                showConfirmButton: false,
                                toast: true,
                                position: 'top-end'
                            });
                            form.reset();
                            // Dispatch event for Alpine to close the modal
                            window.dispatchEvent(new CustomEvent('survey-success'));
                        } else if (status === 422) {
                            // Handle validation errors
                            let errorMessages = Object.values(body.errors).map(msg => `<li>${msg}</li>`).join('');
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops... Ada yang salah!',
                                html: `<ul class="text-left list-disc list-inside">${errorMessages}</ul>`,
                            });
                        } else {
                            throw new Error(body.message || 'Terjadi kesalahan pada server.');
                        }
                    })
                    .catch(err => {
                        console.error(err);
                        Swal.fire('Error', err.message || 'Gagal mengirim data. Silakan coba lagi.', 'error');
                    })
                    .finally(() => {
                        submitBtn.disabled = false;
                        submitText.classList.remove('hidden');
                        loadingText.classList.add('hidden');
                    });
                }
        
        
                // 2. Logic Aksesibilitas (Alpine Data)
                function accessibilityHandler() {
                    return {
                        grayscale: false,
                        contrast: false,
                        dyslexia: false,
                        bigCursor: false,
                        fontSize: 100,
                        isSpeaking: false,
                        synth: window.speechSynthesis,
                        utterance: null,
        
                        changeFontSize(amount) {
                            this.fontSize += amount;
                            if (this.fontSize < 80) this.fontSize = 80;
                            if (this.fontSize > 130) this.fontSize = 130;
                            document.documentElement.style.fontSize = this.fontSize + '%';
                        },
        
                        resetFontSize() {
                            this.fontSize = 100;
                            document.documentElement.style.fontSize = '100%';
                        },
        
                        resetAll() {
                            this.grayscale = false;
                            this.contrast = false;
                            this.dyslexia = false;
                            this.bigCursor = false;
                            this.resetFontSize();
                            this.stopSpeaking();
                        },
        
                        // Logic Text to Speech (TTS)
                        speak() {
                            // Hentikan suara sebelumnya jika ada
                            this.stopSpeaking();
        
                            // Ambil teks yang diblok (selected)
                            let text = window.getSelection().toString();
        
                            // Jika tidak ada yang diblok, ambil seluruh teks di body (opsional, bisa diganti alert)
                            if (!text) {
                                text = document.body.innerText;
                            }
        
                            if (text) {
                                // Inisialisasi Utterance
                                this.utterance = new SpeechSynthesisUtterance(text);
                                this.utterance.lang = 'id-ID'; // Set bahasa Indonesia
                                this.utterance.rate = 1; // Kecepatan normal
        
                                // Event saat selesai bicara
                                this.utterance.onend = () => {
                                    this.isSpeaking = false;
                                };
        
                                // Mulai bicara
                                this.synth.speak(this.utterance);
                                this.isSpeaking = true;
                            } else {
                                alert("Silakan blok teks yang ingin dibaca terlebih dahulu.");
                            }
                        },
        
                        stopSpeaking() {
                            if (this.synth.speaking) {
                                this.synth.cancel();
                                this.isSpeaking = false;
                            }
                        }
                    }
                }
        
                // Alpine.js component for scroll-triggered animations
                document.addEventListener('alpine:init', () => {
                    Alpine.data('inView', () => ({
                        inView: false,
                        init() {
                            const observer = new IntersectionObserver((entries) => {
                                entries.forEach(entry => {
                                    if (entry.isIntersecting) {
                                        this.inView = true;
                                        observer.unobserve(this.$el); // Only animate once
                                    }
                                });
                            }, {
                                threshold: 0.1 // Trigger when 10% of the element is visible
                            });
                            observer.observe(this.$el);
                        }
                    }));
                });
            </script>
        
            @stack('scripts')
        {{-- NProgress for visual loading feedback --}}
    <script src="https://unpkg.com/nprogress@0.2.0/nprogress.js"></script>
    <link rel="stylesheet" href="https://unpkg.com/nprogress@0.2.0/nprogress.css">
    <style>
        #nprogress .bar { background: #3b82f6 !important; height: 3px !important; }
        #nprogress .peg { box-shadow: 0 0 10px #3b82f6, 0 0 5px #3b82f6 !important; }
    </style>

    <script>
        // Tampilkan loading bar saat mulai pindah halaman
        window.addEventListener('beforeunload', () => NProgress.start());
        // Jika menggunakan instant.page, kita bisa trigger start lebih awal
        document.addEventListener('click', (e) => {
            const link = e.target.closest('a');
            if (link && link.href && !link.target && !link.href.includes('#')) {
                NProgress.start();
            }
        });
    </script>

    {{-- Instant Page for Faster Navigation --}}
    <script src="//instant.page/5.2.0" type="module" integrity="sha384-jnZyxPjiipSbm6WFEJp1hi6VExjQ7uE6TRiMUNGR6fInGo4InAsISAbHsGuNwXAY"></script>
</body>
        
        </html>
        