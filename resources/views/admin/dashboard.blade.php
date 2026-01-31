@extends('layouts.admin')

@section('content')
{{-- Load Animate.css --}}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>

<style>
    /* 3D Perspective Container */
    .perspective-1000 { perspective: 1000px; }

    /* 3D Card Effect */
    .card-3d {
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        transform-style: preserve-3d;
        backface-visibility: hidden;
    }
    .card-3d:hover {
        transform: translateY(-8px) scale(1.02);
        box-shadow: 0 20px 30px -10px rgba(0, 0, 0, 0.15);
        z-index: 10;
    }

    /* Glassmorphism Panel */
    .glass-panel {
        background: rgba(255, 255, 255, 0.9);
        backdrop-filter: blur(12px);
        border: 1px solid rgba(226, 232, 240, 0.8);
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
    }

    /* Modern Gradient Text */
    .text-gradient {
        background-clip: text;
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-image: linear-gradient(to right, #f8fafc, #93c5fd);
    }
</style>

<div class="space-y-8 pb-12 perspective-1000">

    {{-- 1. HERO SECTION & JAM REALTIME --}}
    <div class="relative bg-gradient-to-r from-slate-900 via-blue-900 to-indigo-900 rounded-[2rem] p-8 md:p-10 text-white shadow-2xl overflow-hidden border border-white/10 card-3d animate__animated animate__fadeInDown">
        {{-- Background Decorations --}}
        <div class="absolute top-0 right-0 -mr-20 -mt-20 w-96 h-96 rounded-full bg-yellow-500 opacity-10 blur-3xl animate-pulse"></div>
        <div class="absolute bottom-0 left-0 -ml-20 -mb-20 w-72 h-72 rounded-full bg-blue-500 opacity-10 blur-3xl animate-pulse" style="animation-delay: 1s;"></div>
        
        <div class="relative z-10 flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
            <div>
                <div class="inline-flex items-center px-3 py-1 rounded-full bg-white/10 border border-white/20 text-xs font-bold uppercase tracking-wider mb-3 text-blue-200">
                    <i class="fas fa-layer-group mr-2"></i> Dashboard Admin
                </div>
                <h1 class="text-3xl sm:text-4xl md:text-5xl font-extrabold tracking-tight leading-tight">
                    Halo, <span class="text-gradient">{{ Auth::user()->name }}</span>! 👋
                </h1>
                <p class="text-blue-100/80 mt-3 text-lg font-light max-w-xl leading-relaxed">
                    Selamat datang di Panel Kontrol Sistem Informasi Lapas Kelas IIB Jombang. Pantau aktivitas terkini dalam satu pandangan.
                </p>
            </div>
            
            {{-- Clock Widget --}}
            <div class="text-center md:text-right bg-white/10 p-5 rounded-2xl border border-white/10 backdrop-blur-md shadow-lg min-w-[200px] transform transition hover:scale-105">
                <p id="realtime-clock" class="text-4xl font-mono font-black text-white drop-shadow-md">{{ now()->format('H:i:s') }}</p>
                <p id="realtime-date" class="text-xs font-bold text-blue-200 uppercase tracking-widest mt-1">{{ now()->translatedFormat('l, d F Y') }}</p>
            </div>
        </div>
    </div>

    {{-- Akses Cepat (Quick Access) --}}
    <div class="mt-6 animate__animated animate__fadeInDown">
        <h3 class="text-xl font-bold text-slate-800 mb-4 flex items-center gap-2">
            <i class="fas fa-rocket text-blue-500"></i>
            Akses Cepat
        </h3>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4">
            {{-- Kontrol Antrian --}}
            <a href="{{ route('admin.antrian.kontrol') }}" class="group block bg-white/60 hover:bg-white border border-slate-100 rounded-2xl p-6 text-center shadow-sm hover:shadow-lg transform hover:-translate-y-1 transition-all" title="Kontrol Antrian">
                <div class="w-20 h-20 mx-auto rounded-full bg-blue-50 text-blue-600 flex items-center justify-center text-4xl mb-3 transform transition-transform group-hover:scale-105" aria-hidden="true">
                    <i class="fa-solid fa-desktop"></i>
                </div>
                <span class="block text-sm font-semibold text-slate-700">Kontrol Antrian</span>
            </a>

            {{-- Verifikasi Kunjungan --}}
            <a href="{{ route('admin.kunjungan.verifikasi') }}" class="group block bg-white/60 hover:bg-white border border-slate-100 rounded-2xl p-6 text-center shadow-sm hover:shadow-lg transform hover:-translate-y-1 transition-all" title="Verifikasi Kunjungan">
                <div class="w-20 h-20 mx-auto rounded-full bg-green-50 text-green-600 flex items-center justify-center text-4xl mb-3 transform transition-transform group-hover:scale-105" aria-hidden="true">
                    <i class="fa-solid fa-check-circle"></i>
                </div>
                <span class="block text-sm font-semibold text-slate-700">Verifikasi Kunjungan</span>
            </a>

            {{-- Data WBP --}}
            <a href="{{ route('admin.wbp.index') }}" class="group block bg-white/60 hover:bg-white border border-slate-100 rounded-2xl p-6 text-center shadow-sm hover:shadow-lg transform hover:-translate-y-1 transition-all" title="Data WBP">
                <div class="w-20 h-20 mx-auto rounded-full bg-indigo-50 text-indigo-600 flex items-center justify-center text-4xl mb-3 transform transition-transform group-hover:scale-105" aria-hidden="true">
                    <i class="fa-solid fa-users"></i>
                </div>
                <span class="block text-sm font-semibold text-slate-700">Data WBP</span>
            </a>

            {{-- Manajemen Berita --}}
            <a href="{{ route('news.index') }}" class="group block bg-white/60 hover:bg-white border border-slate-100 rounded-2xl p-6 text-center shadow-sm hover:shadow-lg transform hover:-translate-y-1 transition-all" title="Manajemen Berita">
                <div class="w-20 h-20 mx-auto rounded-full bg-purple-50 text-purple-600 flex items-center justify-center text-4xl mb-3 transform transition-transform group-hover:scale-105" aria-hidden="true">
                    <i class="fa-solid fa-newspaper"></i>
                </div>
                <span class="block text-sm font-semibold text-slate-700">Manajemen Berita</span>
            </a>
        </div>
    </div>

    {{-- 2. STATISTIK CARDS --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 animate__animated animate__fadeInUp delay-100">
        @php
            $stats = [
                ['label' => 'Menunggu Verifikasi', 'value' => $totalPendingKunjungans, 'icon' => 'fa-hourglass-half', 'color' => 'yellow', 'bg' => 'from-amber-400 to-orange-500'],
                ['label' => 'Disetujui Hari Ini', 'value' => $totalApprovedToday, 'icon' => 'fa-calendar-check', 'color' => 'green', 'bg' => 'from-emerald-500 to-teal-600'],
                ['label' => 'Total Pendaftar', 'value' => $totalKunjungans, 'icon' => 'fa-users', 'color' => 'blue', 'bg' => 'from-blue-600 to-indigo-600'],
                ['label' => 'Berita Publikasi', 'value' => $totalNews, 'icon' => 'fa-newspaper', 'color' => 'purple', 'bg' => 'from-purple-500 to-violet-600'],
            ];
        @endphp

        @foreach($stats as $stat)
        <div class="card-3d relative overflow-hidden rounded-2xl bg-gradient-to-br {{ $stat['bg'] }} p-6 text-white shadow-lg group">
            <div class="absolute top-0 right-0 p-4 opacity-10 group-hover:opacity-20 transition-opacity transform group-hover:scale-110 duration-500">
                <i class="fa-solid {{ $stat['icon'] }} text-6xl"></i>
            </div>
            
            <div class="relative z-10 flex flex-col justify-between h-full">
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-10 h-10 rounded-full bg-white/20 flex items-center justify-center backdrop-blur-sm shadow-inner">
                        <i class="fa-solid {{ $stat['icon'] }} text-lg"></i>
                    </div>
                    <p class="text-xs font-bold uppercase tracking-widest opacity-90">{{ $stat['label'] }}</p>
                </div>
                <div>
                    <h3 class="text-4xl font-black tracking-tight" data-counter="{{ $stat['value'] }}">
                        {{ $stat['value'] }}
                    </h3>
                </div>
            </div>
            {{-- Decorative Bar --}}
            <div class="absolute bottom-0 left-0 w-full h-1.5 bg-white/20"></div>
        </div>
        @endforeach
    </div>

    <div class="grid grid-cols-1 xl:grid-cols-3 gap-8">
        
        {{-- KOLOM KIRI (CHART & KUOTA) --}}
        <div class="xl:col-span-2 space-y-8 animate__animated animate__fadeInLeft delay-200">
            
            {{-- CHART KUNJUNGAN --}}
            <div class="glass-panel p-6 rounded-2xl shadow-sm relative overflow-hidden">
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h3 class="text-xl font-bold text-slate-800">Statistik Kunjungan</h3>
                        <p class="text-sm text-slate-500">Data kunjungan disetujui dalam 7 hari terakhir.</p>
                    </div>
                    <div class="bg-blue-50 p-2 rounded-lg text-blue-600">
                        <i class="fas fa-chart-bar text-xl"></i>
                    </div>
                </div>
                <div class="h-80 w-full">
                    <canvas id="visitsChart"></canvas>
                </div>
            </div>

            {{-- NEW CHARTS ROW --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                {{-- Monthly Visits Chart --}}
                <div class="glass-panel p-6 rounded-2xl shadow-sm">
                    <h3 class="text-xl font-bold text-slate-800 mb-4">Kunjungan Bulanan {{ date('Y') }}</h3>
                    <div class="h-80 w-full">
                        <canvas id="monthlyVisitsChart"></canvas>
                    </div>
                </div>

                {{-- Survey Ratings Chart --}}
                <div class="glass-panel p-6 rounded-2xl shadow-sm">
                    <h3 class="text-xl font-bold text-slate-800 mb-4">Statistik Survey IKM</h3>
                    <div class="h-80 w-full">
                        <canvas id="surveyRatingsChart"></canvas>
                    </div>
                </div>
            </div>

            {{-- KUOTA HARI INI --}}
            <div class="glass-panel p-6 rounded-2xl shadow-sm border-l-4 border-blue-500">
                <div class="flex justify-between items-start mb-6">
                    <div>
                        <h3 class="text-xl font-bold text-slate-800">Pantauan Kuota</h3>
                        <p class="text-sm text-slate-500 flex items-center gap-2 mt-1">
                            <i class="far fa-calendar-alt text-blue-500"></i>
                            {{ \Carbon\Carbon::today()->translatedFormat('l, d F Y') }}
                        </p>
                    </div>
                    @if($isMonday || $isVisitingDay)
                        <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-xs font-bold animate-pulse">
                            ● BUKA
                        </span>
                    @else
                        <span class="px-3 py-1 bg-red-100 text-red-700 rounded-full text-xs font-bold">
                            ● TUTUP
                        </span>
                    @endif
                </div>

                @if ($isMonday || $isVisitingDay)
                    {{-- PENDAFTARAN ONLINE --}}
                    <div class="mb-8">
                        <h4 class="text-lg font-bold text-slate-700 mb-4 border-b pb-2">Pendaftaran Online</h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            @if($isMonday)
                                {{-- Sesi Pagi --}}
                                @php $persenPagi = ($kuotaPagi > 0) ? ($pendaftarPagi / $kuotaPagi) * 100 : 0; @endphp
                                <div class="space-y-3">
                                    <div class="flex justify-between items-end">
                                        <span class="font-bold text-slate-700 flex items-center gap-2">
                                            <div class="w-8 h-8 rounded-lg bg-yellow-100 flex items-center justify-center text-yellow-600"><i class="fa-solid fa-sun"></i></div>
                                            Sesi Pagi
                                        </span>
                                        <div class="text-right">
                                            <span class="text-2xl font-black text-slate-800">{{ $pendaftarPagi }}</span>
                                            <span class="text-xs text-slate-400 font-bold uppercase">/ {{ $kuotaPagi }} Kuota</span>
                                        </div>
                                    </div>
                                    <div class="w-full bg-slate-100 rounded-full h-4 overflow-hidden shadow-inner border border-slate-200">
                                        <div class="bg-gradient-to-r from-yellow-400 to-orange-500 h-4 rounded-full transition-all duration-1000 ease-out shadow-sm" style="width: {{ $persenPagi }}%"></div>
                                    </div>
                                </div>

                                {{-- Sesi Siang --}}
                                @php $persenSiang = ($kuotaSiang > 0) ? ($pendaftarSiang / $kuotaSiang) * 100 : 0; @endphp
                                <div class="space-y-3">
                                    <div class="flex justify-between items-end">
                                        <span class="font-bold text-slate-700 flex items-center gap-2">
                                            <div class="w-8 h-8 rounded-lg bg-orange-100 flex items-center justify-center text-orange-600"><i class="fa-solid fa-cloud-sun"></i></div>
                                            Sesi Siang
                                        </span>
                                        <div class="text-right">
                                            <span class="text-2xl font-black text-slate-800">{{ $pendaftarSiang }}</span>
                                            <span class="text-xs text-slate-400 font-bold uppercase">/ {{ $kuotaSiang }} Kuota</span>
                                        </div>
                                    </div>
                                    <div class="w-full bg-slate-100 rounded-full h-4 overflow-hidden shadow-inner border border-slate-200">
                                        <div class="bg-gradient-to-r from-orange-400 to-red-500 h-4 rounded-full transition-all duration-1000 ease-out shadow-sm" style="width: {{ $persenSiang }}%"></div>
                                    </div>
                                </div>
                            @else
                                {{-- Hari Biasa --}}
                                @php $persenBiasa = ($kuotaBiasa > 0) ? ($pendaftarBiasa / $kuotaBiasa) * 100 : 0; @endphp
                                <div class="md:col-span-2 space-y-3">
                                    <div class="flex justify-between items-end">
                                        <span class="font-bold text-slate-700 flex items-center gap-2">
                                            <div class="w-8 h-8 rounded-lg bg-blue-100 flex items-center justify-center text-blue-600"><i class="fa-solid fa-users"></i></div>
                                            Total Kunjungan
                                        </span>
                                        <div class="text-right">
                                            <span class="text-2xl font-black text-slate-800">{{ $pendaftarBiasa }}</span>
                                            <span class="text-xs text-slate-400 font-bold uppercase">/ {{ $kuotaBiasa }} Kuota</span>
                                        </div>
                                    </div>
                                    <div class="w-full bg-slate-100 rounded-full h-4 overflow-hidden shadow-inner border border-slate-200">
                                        <div class="bg-gradient-to-r from-blue-500 to-indigo-600 h-4 rounded-full transition-all duration-1000 ease-out shadow-sm" style="width: {{ $persenBiasa }}%"></div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>

                    {{-- PENDAFTARAN OFFLINE --}}
                    <div>
                        <h4 class="text-lg font-bold text-slate-700 mb-4 border-b pb-2">Pendaftaran Offline</h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            @if($isMonday)
                                {{-- Sesi Pagi --}}
                                @php $persenOfflinePagi = ($kuotaOfflinePagi > 0) ? ($pendaftarOfflinePagi / $kuotaOfflinePagi) * 100 : 0; @endphp
                                <div class="space-y-3">
                                    <div class="flex justify-between items-end">
                                        <span class="font-bold text-slate-700 flex items-center gap-2">
                                            <div class="w-8 h-8 rounded-lg bg-yellow-100 flex items-center justify-center text-yellow-600"><i class="fa-solid fa-sun"></i></div>
                                            Sesi Pagi
                                        </span>
                                        <div class="text-right">
                                            <span class="text-2xl font-black text-slate-800">{{ $pendaftarOfflinePagi }}</span>
                                            <span class="text-xs text-slate-400 font-bold uppercase">/ {{ $kuotaOfflinePagi }} Kuota</span>
                                        </div>
                                    </div>
                                    <div class="w-full bg-slate-100 rounded-full h-4 overflow-hidden shadow-inner border border-slate-200">
                                        <div class="bg-gradient-to-r from-yellow-400 to-orange-500 h-4 rounded-full transition-all duration-1000 ease-out shadow-sm" style="width: {{ $persenOfflinePagi }}%"></div>
                                    </div>
                                </div>

                                {{-- Sesi Siang --}}
                                @php $persenOfflineSiang = ($kuotaOfflineSiang > 0) ? ($pendaftarOfflineSiang / $kuotaOfflineSiang) * 100 : 0; @endphp
                                <div class="space-y-3">
                                    <div class="flex justify-between items-end">
                                        <span class="font-bold text-slate-700 flex items-center gap-2">
                                            <div class="w-8 h-8 rounded-lg bg-orange-100 flex items-center justify-center text-orange-600"><i class="fa-solid fa-cloud-sun"></i></div>
                                            Sesi Siang
                                        </span>
                                        <div class="text-right">
                                            <span class="text-2xl font-black text-slate-800">{{ $pendaftarOfflineSiang }}</span>
                                            <span class="text-xs text-slate-400 font-bold uppercase">/ {{ $kuotaOfflineSiang }} Kuota</span>
                                        </div>
                                    </div>
                                    <div class="w-full bg-slate-100 rounded-full h-4 overflow-hidden shadow-inner border border-slate-200">
                                        <div class="bg-gradient-to-r from-orange-400 to-red-500 h-4 rounded-full transition-all duration-1000 ease-out shadow-sm" style="width: {{ $persenOfflineSiang }}%"></div>
                                    </div>
                                </div>
                            @else
                                {{-- Hari Biasa --}}
                                @php $persenOfflineBiasa = ($kuotaOfflineBiasa > 0) ? ($pendaftarOfflineBiasa / $kuotaOfflineBiasa) * 100 : 0; @endphp
                                <div class="md:col-span-2 space-y-3">
                                    <div class="flex justify-between items-end">
                                        <span class="font-bold text-slate-700 flex items-center gap-2">
                                            <div class="w-8 h-8 rounded-lg bg-blue-100 flex items-center justify-center text-blue-600"><i class="fa-solid fa-users"></i></div>
                                            Total Kunjungan
                                        </span>
                                        <div class="text-right">
                                            <span class="text-2xl font-black text-slate-800">{{ $pendaftarOfflineBiasa }}</span>
                                            <span class="text-xs text-slate-400 font-bold uppercase">/ {{ $kuotaOfflineBiasa }} Kuota</span>
                                        </div>
                                    </div>
                                    <div class="w-full bg-slate-100 rounded-full h-4 overflow-hidden shadow-inner border border-slate-200">
                                        <div class="bg-gradient-to-r from-blue-500 to-indigo-600 h-4 rounded-full transition-all duration-1000 ease-out shadow-sm" style="width: {{ $persenOfflineBiasa }}%"></div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                @else
                    <div class="bg-slate-50 text-slate-500 font-medium text-center p-8 rounded-xl border-2 border-dashed border-slate-200 flex flex-col items-center gap-2">
                        <i class="fas fa-door-closed text-4xl mb-2 text-slate-300"></i>
                        <span>Layanan Kunjungan Tidak Tersedia Hari Ini</span>
                    </div>
                @endif
            </div>
        </div>

        {{-- KOLOM KANAN (QUICK ACCESS & ACTIVITY) --}}
        <div class="space-y-8 animate__animated animate__fadeInRight delay-300">

            {{-- KONTROL ANTRIAN (REAL-TIME) --}}
            <div x-data="antrianController()" class="glass-panel p-6 rounded-2xl shadow-sm">
                <a href="{{ route('admin.antrian.kontrol') }}" class="text-lg font-bold text-slate-800 mb-6 flex items-center gap-2">
                    <i class="fas fa-users-cog text-purple-500"></i> Kontrol Antrian Hari Ini
                </a>
                <div class="space-y-6">
                    {{-- Sesi Pagi --}}
                    <div class="bg-blue-50 p-4 rounded-xl border-2 border-blue-100">
                        <div class="flex justify-between items-center">
                            <div>
                                <p class="text-sm font-bold text-blue-800">SESI PAGI</p>
                                <a href="{{ route('admin.antrian.kontrol') }}">
                                    <p class="text-4xl font-black text-blue-900" x-text="nomorPagi">...</p>
                                </a>
                            </div>
                            <div class="flex flex-col gap-2">
                                <button @click="panggil('pagi')" class="px-4 py-2 bg-blue-600 text-white font-bold rounded-lg hover:bg-blue-700 transition shadow-md flex items-center gap-2">
                                    <i class="fas fa-bullhorn"></i> Panggil
                                </button>
                                <button @click="reset('pagi')" class="px-4 py-1 bg-red-100 text-red-600 text-xs font-semibold rounded-lg hover:bg-red-200 transition">
                                    Reset
                                </button>
                            </div>
                        </div>
                    </div>
                    {{-- Sesi Siang --}}
                    <div class="bg-orange-50 p-4 rounded-xl border-2 border-orange-100">
                        <div class="flex justify-between items-center">
                            <div>
                                <p class="text-sm font-bold text-orange-800">SESI SIANG</p>
                                <a href="{{ route('admin.antrian.kontrol') }}">
                                <p class="text-4xl font-black text-orange-900" x-text="nomorSiang">...</p>
                                </a>
                            </div>
                            <div class="flex flex-col gap-2">
                                <button @click="panggil('siang')" class="px-4 py-2 bg-orange-500 text-white font-bold rounded-lg hover:bg-orange-600 transition shadow-md flex items-center gap-2">
                                    <i class="fas fa-bullhorn"></i> Panggil
                                </button>
                                <button @click="reset('siang')" class="px-4 py-1 bg-red-100 text-red-600 text-xs font-semibold rounded-lg hover:bg-red-200 transition">
                                    Reset
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            {{-- AKSES CEPAT --}}
            <div class="glass-panel p-6 rounded-2xl shadow-sm">
                <h3 class="text-lg font-bold text-slate-800 mb-6 flex items-center gap-2">
                    <i class="fas fa-rocket text-blue-500"></i> Akses Cepat
                </h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    @php $userRole = Auth::user()->role ?? 'user'; @endphp
                    @if(in_array($userRole, ['super_admin', 'admin_humas']))
                    <a href="{{ route('news.create') }}" class="group flex flex-col items-center justify-center p-4 bg-slate-50 hover:bg-white border border-slate-100 hover:border-blue-300 rounded-xl transition-all duration-300 shadow-sm hover:shadow-md hover:-translate-y-1">
                        <div class="w-12 h-12 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center mb-2 group-hover:scale-110 transition-transform">
                            <i class="fa-solid fa-pen-nib text-xl"></i>
                        </div>
                        <span class="text-sm font-bold text-slate-600 group-hover:text-blue-600">Tulis Berita</span>
                    </a>
                    @endif
                    
                    @if(in_array($userRole, ['super_admin', 'admin_humas']))
                    <a href="{{ route('announcements.create') }}" class="group flex flex-col items-center justify-center p-4 bg-slate-50 hover:bg-white border border-slate-100 hover:border-yellow-300 rounded-xl transition-all duration-300 shadow-sm hover:shadow-md hover:-translate-y-1">
                        <div class="w-12 h-12 rounded-full bg-yellow-100 text-yellow-600 flex items-center justify-center mb-2 group-hover:scale-110 transition-transform">
                            <i class="fa-solid fa-bullhorn text-xl"></i>
                        </div>
                        <span class="text-sm font-bold text-slate-600 group-hover:text-yellow-600">Umumkan</span>
                    </a>
                    @endif
                    
                    @if(in_array($userRole, ['super_admin', 'admin_registrasi']))
                    <a href="{{ route('admin.kunjungan.verifikasi') }}" class="group flex flex-col items-center justify-center p-4 bg-slate-50 hover:bg-white border border-slate-100 hover:border-green-300 rounded-xl transition-all duration-300 shadow-sm hover:shadow-md hover:-translate-y-1">
                        <div class="w-12 h-12 rounded-full bg-green-100 text-green-600 flex items-center justify-center mb-2 group-hover:scale-110 transition-transform">
                            <i class="fa-solid fa-qrcode text-xl"></i>
                        </div>
                        <span class="text-sm font-bold text-slate-600 group-hover:text-green-600">Scan QR</span>
                    </a>
                    @endif
                    
                    @if(in_array($userRole, ['super_admin', 'admin_registrasi', 'admin_umum']))
                    <a href="{{ route('admin.users.create') }}" class="group flex flex-col items-center justify-center p-4 bg-slate-50 hover:bg-white border border-slate-100 hover:border-purple-300 rounded-xl transition-all duration-300 shadow-sm hover:shadow-md hover:-translate-y-1">
                        <div class="w-12 h-12 rounded-full bg-purple-100 text-purple-600 flex items-center justify-center mb-2 group-hover:scale-110 transition-transform">
                            <i class="fa-solid fa-user-plus text-xl"></i>
                        </div>
                        <span class="text-sm font-bold text-slate-600 group-hover:text-purple-600">Tambah User</span>
                    </a>
                    @endif

                    @if(in_array($userRole, ['super_admin', 'admin_humas']))
                    <a href="{{ route('admin.surveys.index') }}" class="group flex flex-col items-center justify-center p-4 bg-slate-50 hover:bg-white border border-slate-100 hover:border-cyan-300 rounded-xl transition-all duration-300 shadow-sm hover:shadow-md hover:-translate-y-1">
                        <div class="w-12 h-12 rounded-full bg-cyan-100 text-cyan-600 flex items-center justify-center mb-2 group-hover:scale-110 transition-transform">
                            <i class="fa-solid fa-chart-pie text-xl"></i>
                        </div>
                        <span class="text-sm font-bold text-slate-600 group-hover:text-cyan-600">Survey IKM</span>
                    </a>
                    @endif

                    @if(in_array($userRole, ['super_admin', 'admin_umum', 'admin_registrasi']))
                    <a href="{{ route('admin.wbp.index') }}" class="group flex flex-col items-center justify-center p-4 bg-slate-50 hover:bg-white border border-slate-100 hover:border-rose-300 rounded-xl transition-all duration-300 shadow-sm hover:shadow-md hover:-translate-y-1">
                        <div class="w-12 h-12 rounded-full bg-rose-100 text-rose-600 flex items-center justify-center mb-2 group-hover:scale-110 transition-transform">
                            <i class="fa-solid fa-users-viewfinder text-xl"></i>
                        </div>
                        <span class="text-sm font-bold text-slate-600 group-hover:text-rose-600">Data WBP</span>
                    </a>
                    @endif
                </div>
            </div>

            {{-- AKTIVITAS TERBARU --}}
            <div class="glass-panel p-0 rounded-2xl shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50">
                    <h3 class="text-lg font-bold text-slate-800 flex items-center gap-2">
                        <i class="fas fa-history text-slate-400"></i> Aktivitas Terbaru
                    </h3>
                </div>
                <div class="p-4 space-y-2 max-h-[400px] overflow-y-auto">
                    @forelse($pendingKunjungans as $item)
                    <div class="flex items-start gap-4 p-3 rounded-xl hover:bg-slate-50 transition-colors border border-transparent hover:border-slate-100">
                        <div class="bg-amber-100 text-amber-600 h-10 w-10 flex-shrink-0 flex items-center justify-center rounded-full shadow-sm">
                            <i class="fa-solid fa-hourglass-start"></i>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="font-bold text-slate-800 text-sm truncate">{{ $item->nama_pengunjung }}</p>
                            <p class="text-xs text-slate-500 mt-0.5">Mendaftar kunjungan untuk:</p>
                            <p class="text-xs font-semibold text-blue-600">{{ \Carbon\Carbon::parse($item->tanggal_kunjungan)->translatedFormat('d M Y') }}</p>
                        </div>
                        <span class="text-[10px] font-bold text-slate-400 whitespace-nowrap bg-slate-100 px-2 py-1 rounded">
                            {{ $item->created_at->diffForHumans(null, true) }}
                        </span>
                    </div>
                    @empty
                    <div class="flex flex-col items-center justify-center py-8 text-center text-slate-400">
                        <i class="far fa-check-circle text-4xl mb-2 opacity-50"></i>
                        <p class="text-sm">Tidak ada pendaftaran pending.</p>
                    </div>
                    @endforelse
                </div>
                <div class="p-3 bg-slate-50 text-center border-t border-slate-100">
                    <a href="{{ route('admin.kunjungan.index') }}" class="text-xs font-bold text-blue-600 hover:text-blue-700 hover:underline">
                        Lihat Semua Aktivitas <i class="fas fa-arrow-right ml-1"></i>
                    </a>
                </div>
            </div>

        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // --- 1. Jam Realtime ---
    function updateClock() {
        const now = new Date();
        const timeString = now.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit', second: '2-digit' }).replace(/\./g, ':');
        const dateString = now.toLocaleDateString('id-ID', { weekday: 'long', day: 'numeric', month: 'long', year: 'numeric' });
        
        document.getElementById('realtime-clock').textContent = timeString;
        document.getElementById('realtime-date').textContent = dateString;
    }
    setInterval(updateClock, 1000);
    updateClock();

    // --- 2. ChartJS ---
    document.addEventListener('DOMContentLoaded', () => {
        const visitsChartCtx = document.getElementById('visitsChart')?.getContext('2d');
        if (visitsChartCtx) {
            // Gradient untuk Chart
            const gradient = visitsChartCtx.createLinearGradient(0, 0, 0, 400);
            gradient.addColorStop(0, 'rgba(59, 130, 246, 0.5)'); // Blue start
            gradient.addColorStop(1, 'rgba(59, 130, 246, 0.0)'); // Blue end

            new Chart(visitsChartCtx, {
                type: 'line', // Ubah ke Line agar lebih cantik untuk tren
                data: {
                    labels: @json($chartLabels),
                    datasets: [{
                        label: 'Kunjungan Disetujui',
                        data: @json($chartData),
                        backgroundColor: gradient,
                        borderColor: '#3b82f6',
                        borderWidth: 3,
                        pointBackgroundColor: '#ffffff',
                        pointBorderColor: '#3b82f6',
                        pointBorderWidth: 2,
                        pointRadius: 4,
                        pointHoverRadius: 6,
                        fill: true,
                        tension: 0.4 // Membuat garis melengkung halus
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            backgroundColor: 'rgba(15, 23, 42, 0.9)',
                            padding: 12,
                            cornerRadius: 8,
                            titleFont: { size: 13 },
                            bodyFont: { size: 14, weight: 'bold' }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: { color: 'rgba(226, 232, 240, 0.6)', borderDash: [5, 5] },
                            ticks: { precision: 0, font: { family: "'Inter', sans-serif" } }
                        },
                        x: {
                            grid: { display: false },
                            ticks: { font: { family: "'Inter', sans-serif" } }
                        }
                    }
                }
            });
        }

        const monthlyVisitsCtx = document.getElementById('monthlyVisitsChart')?.getContext('2d');
        if (monthlyVisitsCtx) {
            new Chart(monthlyVisitsCtx, {
                type: 'bar',
                data: {
                    labels: @json($monthlyVisitsLabels),
                    datasets: [{
                        label: 'Kunjungan',
                        data: @json($monthlyVisits),
                        backgroundColor: 'rgba(59, 130, 246, 0.5)',
                        borderColor: '#3b82f6',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: { precision: 0 }
                        }
                    }
                }
            });
        }

        const surveyRatingsCtx = document.getElementById('surveyRatingsChart')?.getContext('2d');
        if (surveyRatingsCtx) {
            new Chart(surveyRatingsCtx, {
                type: 'doughnut',
                data: {
                    labels: @json($surveyRatingsLabels),
                    datasets: [{
                        label: 'Rating',
                        data: @json($surveyRatings),
                        backgroundColor: [
                            'rgba(239, 68, 68, 0.7)',
                            'rgba(245, 158, 11, 0.7)',
                            'rgba(59, 130, 246, 0.7)',
                            'rgba(34, 197, 94, 0.7)'
                        ],
                        borderColor: [
                            '#ef4444',
                            '#f59e0b',
                            '#3b82f6',
                            '#22c55e'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                }
            });
        }
        
        // --- 3. Animasi Angka (Counter) ---
        const counters = document.querySelectorAll('[data-counter]');
        counters.forEach(counter => {
            const target = +counter.getAttribute('data-counter');
            const duration = 1500; 
            const increment = target / (duration / 16);
            
            let current = 0;
            const updateCount = () => {
                current += increment;
                if (current < target) {
                    counter.innerText = Math.ceil(current);
                    requestAnimationFrame(updateCount);
                } else {
                    counter.innerText = target;
                }
            };
            updateCount();
        });
    });

    function antrianController() {
        return {
            nomorPagi: '...',
            nomorSiang: '...',
            init() {
                this.fetchStatus();
            },
            async fetchStatus() {
                try {
                    const response = await fetch('{{ route("admin.antrian.status") }}');
                    const data = await response.json();
                    this.nomorPagi = data.pagi;
                    this.nomorSiang = data.siang;
                } catch (e) { console.error(e); this.nomorPagi = 'err'; this.nomorSiang = 'err'; }
            },
            async postAction(action, sesi) {
                try {
                    const response = await fetch(`{{ url('/antrian') }}/${action}`, {
                        method: 'POST',
                        headers: { 
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify({ sesi: sesi })
                    });
                    const data = await response.json();
                    if (data.sesi === 'pagi') this.nomorPagi = data.nomor_terpanggil;
                    if (data.sesi === 'siang') this.nomorSiang = data.nomor_terpanggil;
                } catch (e) { console.error(e); }
            },
            panggil(sesi) {
                this.postAction('panggil', sesi);
            },
            reset(sesi) {
                Swal.fire({
                    title: `Reset Antrian Sesi ${sesi.toUpperCase()}?`,
                    text: "Nomor antrian akan kembali ke 0.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    confirmButtonText: 'Ya, Reset!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        this.postAction('reset', sesi);
                    }
                });
            }
        }
    }
</script>
@endsection