@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<style>
    .stat-card {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }
    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 20px 40px -12px rgba(0,0,0,0.18);
    }
    .glass {
        background: rgba(255,255,255,0.92);
        backdrop-filter: blur(12px);
        border: 1px solid rgba(226,232,240,0.7);
    }
    .quick-link {
        transition: all 0.25s cubic-bezier(0.4,0,0.2,1);
    }
    .quick-link:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 24px -6px rgba(0,0,0,0.12);
    }
</style>

<div class="space-y-6 pb-12">

    {{-- ═══════════════ 1. HERO ═══════════════ --}}
    <div class="relative bg-gradient-to-br from-slate-900 via-blue-950 to-indigo-900 rounded-3xl p-8 md:p-10 text-white shadow-2xl overflow-hidden">
        <div class="absolute -top-24 -right-24 w-96 h-96 rounded-full bg-blue-500 opacity-[0.08] blur-3xl pointer-events-none"></div>
        <div class="absolute -bottom-16 -left-16 w-72 h-72 rounded-full bg-indigo-500 opacity-[0.08] blur-3xl pointer-events-none"></div>

        <div class="relative z-10 flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
            <div>
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/10 border border-white/20 text-xs font-bold uppercase tracking-wider mb-4 text-blue-200">
                    <i class="fas fa-layer-group text-[10px]"></i> Panel Kontrol Admin
                </div>
                <h1 class="text-3xl sm:text-4xl font-black tracking-tight leading-tight">
                    Halo, <span class="bg-gradient-to-r from-white to-blue-200 bg-clip-text text-transparent">{{ Auth::user()->name }}</span>! 👋
                </h1>
                <p class="text-blue-200/70 mt-2 text-sm max-w-lg leading-relaxed">
                    Selamat datang di Sistem Informasi Lapas Kelas IIB Jombang. Pantau seluruh aktivitas kunjungan dari sini.
                </p>
            </div>

            {{-- Clock Widget --}}
            <div class="text-center bg-white/10 border border-white/15 backdrop-blur-sm rounded-2xl px-6 py-4 flex-shrink-0 min-w-[180px]">
                <p id="realtime-clock" class="text-3xl font-mono font-black text-white tracking-tight">{{ now()->format('H:i:s') }}</p>
                <p id="realtime-date" class="text-[11px] font-bold text-blue-200/80 uppercase tracking-widest mt-1">{{ now()->translatedFormat('l, d F Y') }}</p>
                <div class="mt-2 h-px bg-white/10"></div>
                <div class="flex items-center justify-center gap-1.5 mt-2">
                    @if($isMonday || $isVisitingDay)
                    <span class="w-2 h-2 bg-emerald-400 rounded-full animate-pulse shadow-[0_0_8px_rgba(52,211,153,0.7)]"></span>
                    <span class="text-[10px] font-black text-emerald-300 uppercase tracking-widest">Hari Kunjungan</span>
                    @else
                    <span class="w-2 h-2 bg-slate-400 rounded-full"></span>
                    <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Libur Kunjungan</span>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- ═══════════════ 2. STAT CARDS ═══════════════ --}}
    @php
        $stats = [
            ['label' => 'Menunggu Verifikasi', 'value' => $totalPendingKunjungans, 'icon' => 'fa-hourglass-half',  'from' => '#f59e0b', 'to' => '#f97316'],
            ['label' => 'Disetujui Hari Ini',  'value' => $totalApprovedToday,    'icon' => 'fa-calendar-check', 'from' => '#10b981', 'to' => '#0284c7'],
            ['label' => 'Total Pendaftar',      'value' => $totalKunjungans,       'icon' => 'fa-users',          'from' => '#3b82f6', 'to' => '#6366f1'],
            ['label' => 'Berita Publikasi',     'value' => $totalNews,             'icon' => 'fa-newspaper',      'from' => '#8b5cf6', 'to' => '#ec4899'],
        ];
    @endphp
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
        @foreach($stats as $s)
        <div class="stat-card relative bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden p-5">
            <div class="absolute top-0 left-0 w-full h-0.5" style="background: linear-gradient(to right, {{ $s['from'] }}, {{ $s['to'] }})"></div>
            <div class="flex items-start justify-between mb-3">
                <div class="w-10 h-10 rounded-xl flex items-center justify-center text-white flex-shrink-0"
                    style="background: linear-gradient(135deg, {{ $s['from'] }}, {{ $s['to'] }})">
                    <i class="fas {{ $s['icon'] }} text-sm"></i>
                </div>
            </div>
            <p class="text-2xl font-black text-slate-900 tracking-tight" data-counter="{{ $s['value'] }}">{{ $s['value'] }}</p>
            <p class="text-[11px] font-bold text-slate-400 uppercase tracking-widest mt-1">{{ $s['label'] }}</p>
        </div>
        @endforeach
    </div>

    {{-- ═══════════════ 3. MAIN LAYOUT ═══════════════ --}}
    <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">

        {{-- ── KOLOM KIRI (xl:span 2) ── --}}
        <div class="xl:col-span-2 space-y-6">

            {{-- Chart Kunjungan 7 Hari --}}
            <div class="glass rounded-2xl shadow-sm p-6">
                <div class="flex items-center justify-between mb-5">
                    <div>
                        <h3 class="font-black text-slate-800 text-base">Tren Kunjungan</h3>
                        <p class="text-xs text-slate-400 mt-0.5">Data kunjungan disetujui dalam 7 hari terakhir.</p>
                    </div>
                    <div class="w-9 h-9 bg-blue-50 rounded-xl flex items-center justify-center text-blue-600">
                        <i class="fas fa-chart-line text-sm"></i>
                    </div>
                </div>
                <div class="h-64 w-full">
                    <canvas id="visitsChart"></canvas>
                </div>
            </div>

            {{-- Chart Bulanan & Survey --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="glass rounded-2xl shadow-sm p-6">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-8 h-8 bg-indigo-50 rounded-xl flex items-center justify-center text-indigo-600">
                            <i class="fas fa-chart-bar text-sm"></i>
                        </div>
                        <h3 class="font-black text-slate-800 text-sm">Kunjungan Bulanan {{ date('Y') }}</h3>
                    </div>
                    <div class="h-56 w-full">
                        <canvas id="monthlyVisitsChart"></canvas>
                    </div>
                </div>
                <div class="glass rounded-2xl shadow-sm p-6">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-8 h-8 bg-violet-50 rounded-xl flex items-center justify-center text-violet-600">
                            <i class="fas fa-chart-pie text-sm"></i>
                        </div>
                        <h3 class="font-black text-slate-800 text-sm">Statistik Survey IKM</h3>
                    </div>
                    <div class="h-56 w-full">
                        <canvas id="surveyRatingsChart"></canvas>
                    </div>
                </div>
            </div>

            {{-- Kuota Hari Ini --}}
            <div class="glass rounded-2xl shadow-sm p-6 border-l-4 border-blue-500">
                <div class="flex items-center justify-between mb-5">
                    <div>
                        <h3 class="font-black text-slate-800 text-base">Pantauan Kuota</h3>
                        <p class="text-xs text-slate-400 mt-0.5 flex items-center gap-1.5">
                            <i class="far fa-calendar-alt text-blue-400"></i>
                            {{ \Carbon\Carbon::today()->translatedFormat('l, d F Y') }}
                        </p>
                    </div>
                    @if($isMonday || $isVisitingDay)
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-emerald-100 text-emerald-700 rounded-full text-[10px] font-black uppercase tracking-widest border border-emerald-200 animate-pulse">
                        <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full"></span> Buka
                    </span>
                    @else
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-red-100 text-red-600 rounded-full text-[10px] font-black uppercase tracking-widest border border-red-200">
                        <span class="w-1.5 h-1.5 bg-red-500 rounded-full"></span> Tutup
                    </span>
                    @endif
                </div>

                @if($isMonday || $isVisitingDay)
                    <div class="space-y-5">
                        <h4 class="text-xs font-black text-slate-400 uppercase tracking-widest border-b border-slate-100 pb-2">Pendaftaran Online</h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            @if($isMonday)
                                @php $persenPagi = ($kuotaPagi > 0) ? ($pendaftarPagi / $kuotaPagi) * 100 : 0; @endphp
                                <div class="space-y-2">
                                    <div class="flex justify-between items-center">
                                        <span class="text-sm font-bold text-slate-600 flex items-center gap-1.5">
                                            <i class="fas fa-sun text-amber-400 text-xs"></i> Sesi Pagi
                                        </span>
                                        <span class="text-sm font-black text-slate-800">{{ $pendaftarPagi }} <span class="text-slate-400 font-bold text-xs">/ {{ $kuotaPagi }}</span></span>
                                    </div>
                                    <div class="w-full bg-slate-100 rounded-full h-2.5 overflow-hidden">
                                        <div class="bg-gradient-to-r from-amber-400 to-orange-500 h-2.5 rounded-full transition-all duration-1000" style="width: {{ $persenPagi }}%"></div>
                                    </div>
                                    <p class="text-[10px] text-slate-400 text-right font-bold">{{ round($persenPagi) }}% terisi</p>
                                </div>
                                @php $persenSiang = ($kuotaSiang > 0) ? ($pendaftarSiang / $kuotaSiang) * 100 : 0; @endphp
                                <div class="space-y-2">
                                    <div class="flex justify-between items-center">
                                        <span class="text-sm font-bold text-slate-600 flex items-center gap-1.5">
                                            <i class="fas fa-cloud-sun text-orange-400 text-xs"></i> Sesi Siang
                                        </span>
                                        <span class="text-sm font-black text-slate-800">{{ $pendaftarSiang }} <span class="text-slate-400 font-bold text-xs">/ {{ $kuotaSiang }}</span></span>
                                    </div>
                                    <div class="w-full bg-slate-100 rounded-full h-2.5 overflow-hidden">
                                        <div class="bg-gradient-to-r from-orange-400 to-rose-500 h-2.5 rounded-full transition-all duration-1000" style="width: {{ $persenSiang }}%"></div>
                                    </div>
                                    <p class="text-[10px] text-slate-400 text-right font-bold">{{ round($persenSiang) }}% terisi</p>
                                </div>
                            @else
                                @php $persenBiasa = ($kuotaBiasa > 0) ? ($pendaftarBiasa / $kuotaBiasa) * 100 : 0; @endphp
                                <div class="md:col-span-2 space-y-2">
                                    <div class="flex justify-between items-center">
                                        <span class="text-sm font-bold text-slate-600 flex items-center gap-1.5">
                                            <i class="fas fa-users text-blue-400 text-xs"></i> Total Kunjungan
                                        </span>
                                        <span class="text-sm font-black text-slate-800">{{ $pendaftarBiasa }} <span class="text-slate-400 font-bold text-xs">/ {{ $kuotaBiasa }}</span></span>
                                    </div>
                                    <div class="w-full bg-slate-100 rounded-full h-2.5 overflow-hidden">
                                        <div class="bg-gradient-to-r from-blue-500 to-indigo-600 h-2.5 rounded-full transition-all duration-1000" style="width: {{ $persenBiasa }}%"></div>
                                    </div>
                                    <p class="text-[10px] text-slate-400 text-right font-bold">{{ round($persenBiasa) }}% terisi</p>
                                </div>
                            @endif
                        </div>

                        <h4 class="text-xs font-black text-slate-400 uppercase tracking-widest border-b border-slate-100 pb-2 pt-1">Pendaftaran Offline</h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            @if($isMonday)
                                @php $persenOfflinePagi = ($kuotaOfflinePagi > 0) ? ($pendaftarOfflinePagi / $kuotaOfflinePagi) * 100 : 0; @endphp
                                <div class="space-y-2">
                                    <div class="flex justify-between items-center">
                                        <span class="text-sm font-bold text-slate-600 flex items-center gap-1.5">
                                            <i class="fas fa-sun text-amber-400 text-xs"></i> Pagi
                                        </span>
                                        <span class="text-sm font-black text-slate-800">{{ $pendaftarOfflinePagi }} <span class="text-slate-400 font-bold text-xs">/ {{ $kuotaOfflinePagi }}</span></span>
                                    </div>
                                    <div class="w-full bg-slate-100 rounded-full h-2 overflow-hidden">
                                        <div class="bg-gradient-to-r from-amber-400 to-orange-500 h-2 rounded-full" style="width: {{ min(100,$persenOfflinePagi) }}%"></div>
                                    </div>
                                </div>
                                @php $persenOfflineSiang = ($kuotaOfflineSiang > 0) ? ($pendaftarOfflineSiang / $kuotaOfflineSiang) * 100 : 0; @endphp
                                <div class="space-y-2">
                                    <div class="flex justify-between items-center">
                                        <span class="text-sm font-bold text-slate-600 flex items-center gap-1.5">
                                            <i class="fas fa-cloud-sun text-orange-400 text-xs"></i> Siang
                                        </span>
                                        <span class="text-sm font-black text-slate-800">{{ $pendaftarOfflineSiang }} <span class="text-slate-400 font-bold text-xs">/ {{ $kuotaOfflineSiang }}</span></span>
                                    </div>
                                    <div class="w-full bg-slate-100 rounded-full h-2 overflow-hidden">
                                        <div class="bg-gradient-to-r from-orange-400 to-rose-500 h-2 rounded-full" style="width: {{ min(100,$persenOfflineSiang) }}%"></div>
                                    </div>
                                </div>
                            @else
                                @php $persenOfflineBiasa = ($kuotaOfflineBiasa > 0) ? ($pendaftarOfflineBiasa / $kuotaOfflineBiasa) * 100 : 0; @endphp
                                <div class="md:col-span-2 space-y-2">
                                    <div class="flex justify-between items-center">
                                        <span class="text-sm font-bold text-slate-600 flex items-center gap-1.5">
                                            <i class="fas fa-users text-emerald-500 text-xs"></i> Kunjungan Offline
                                        </span>
                                        <span class="text-sm font-black text-slate-800">{{ $pendaftarOfflineBiasa }} <span class="text-slate-400 font-bold text-xs">/ {{ $kuotaOfflineBiasa }}</span></span>
                                    </div>
                                    <div class="w-full bg-slate-100 rounded-full h-2.5 overflow-hidden">
                                        <div class="bg-gradient-to-r from-emerald-400 to-teal-600 h-2.5 rounded-full" style="width: {{ min(100,$persenOfflineBiasa) }}%"></div>
                                    </div>
                                    <p class="text-[10px] text-slate-400 text-right font-bold">{{ round($persenOfflineBiasa) }}% terisi</p>
                                </div>
                            @endif
                        </div>
                    </div>
                @else
                    <div class="flex flex-col items-center justify-center py-10 text-center bg-slate-50 rounded-2xl border-2 border-dashed border-slate-200">
                        <i class="fas fa-door-closed text-3xl text-slate-300 mb-2"></i>
                        <p class="text-sm font-bold text-slate-500">Layanan Kunjungan Tidak Tersedia Hari Ini</p>
                    </div>
                @endif
            </div>
        </div>

        {{-- ── KOLOM KANAN ── --}}
        <div class="space-y-6">

            {{-- ★ BARU: Status Live Kunjungan Hari Ini --}}
            <div class="glass rounded-2xl shadow-sm overflow-hidden">
                <div class="px-5 py-4 bg-gradient-to-r from-blue-600 to-indigo-600 flex items-center gap-3">
                    <div class="w-8 h-8 bg-white/20 rounded-xl flex items-center justify-center">
                        <i class="fas fa-satellite-dish text-white text-sm"></i>
                    </div>
                    <div>
                        <h3 class="text-sm font-black text-white">Status Kunjungan Hari Ini</h3>
                        <p class="text-[10px] text-blue-200 font-bold uppercase tracking-widest">Live · {{ now()->translatedFormat('d M Y') }}</p>
                    </div>
                </div>
                @php
                    $todayAll = \App\Models\Kunjungan::whereDate('tanggal_kunjungan', today())->get();
                    $liveStats = [
                        ['label'=>'Menunggu',  'count'=>$todayAll->whereIn('status',['pending'])->count(),              'color'=>'bg-amber-500',  'light'=>'bg-amber-50',  'text'=>'text-amber-700',  'icon'=>'fa-hourglass-half'],
                        ['label'=>'Disetujui', 'count'=>$todayAll->whereIn('status',['approved','on_queue','called','serving'])->count(), 'color'=>'bg-blue-500',   'light'=>'bg-blue-50',   'text'=>'text-blue-700',   'icon'=>'fa-clipboard-check'],
                        ['label'=>'Berlangsung','count'=>$todayAll->whereIn('status',['serving'])->count(),              'color'=>'bg-emerald-500','light'=>'bg-emerald-50','text'=>'text-emerald-700','icon'=>'fa-handshake'],
                        ['label'=>'Selesai',   'count'=>$todayAll->where('status','completed')->count(),                 'color'=>'bg-slate-400',  'light'=>'bg-slate-50',  'text'=>'text-slate-600',  'icon'=>'fa-flag-checkered'],
                    ];
                @endphp
                <div class="p-4 grid grid-cols-2 gap-3">
                    @foreach($liveStats as $ls)
                    <div class="{{ $ls['light'] }} rounded-xl p-3 flex items-center gap-3">
                        <div class="w-9 h-9 {{ $ls['color'] }} rounded-xl flex items-center justify-center text-white flex-shrink-0">
                            <i class="fas {{ $ls['icon'] }} text-sm"></i>
                        </div>
                        <div>
                            <p class="text-xl font-black {{ $ls['text'] }}">{{ $ls['count'] }}</p>
                            <p class="text-[10px] font-black {{ $ls['text'] }} opacity-70 uppercase tracking-widest leading-none">{{ $ls['label'] }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
                <div class="px-4 pb-4">
                    <a href="{{ route('admin.antrian.kontrol') }}"
                        class="w-full flex items-center justify-center gap-2 py-2.5 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-black rounded-xl text-xs uppercase tracking-widest transition-all hover:-translate-y-0.5 shadow-md shadow-blue-500/20 active:scale-95">
                        <i class="fas fa-tachometer-alt"></i> Buka Kontrol Antrian
                    </a>
                </div>
            </div>

            {{-- Akses Cepat --}}
            <div class="glass rounded-2xl shadow-sm p-5">
                <div class="flex items-center gap-2 mb-4">
                    <div class="w-7 h-7 bg-blue-50 rounded-lg flex items-center justify-center text-blue-600">
                        <i class="fas fa-rocket text-xs"></i>
                    </div>
                    <h3 class="text-sm font-black text-slate-800">Akses Cepat</h3>
                </div>
                @php $userRole = Auth::user()->role ?? 'user'; @endphp
                <div class="grid grid-cols-3 gap-3">
                    @if(in_array($userRole, ['admin','super_admin','admin_humas']))
                    <a href="{{ route('news.create') }}" class="quick-link group flex flex-col items-center justify-center p-3 bg-slate-50 hover:bg-white border border-slate-100 hover:border-blue-200 rounded-xl text-center">
                        <div class="w-10 h-10 rounded-xl bg-blue-100 text-blue-600 flex items-center justify-center mb-2 group-hover:scale-110 transition-transform">
                            <i class="fas fa-pen-nib text-sm"></i>
                        </div>
                        <span class="text-[10px] font-black text-slate-500 group-hover:text-blue-600 uppercase tracking-widest leading-tight">Berita</span>
                    </a>
                    <a href="{{ route('announcements.create') }}" class="quick-link group flex flex-col items-center justify-center p-3 bg-slate-50 hover:bg-white border border-slate-100 hover:border-amber-200 rounded-xl text-center">
                        <div class="w-10 h-10 rounded-xl bg-amber-100 text-amber-600 flex items-center justify-center mb-2 group-hover:scale-110 transition-transform">
                            <i class="fas fa-bullhorn text-sm"></i>
                        </div>
                        <span class="text-[10px] font-black text-slate-500 group-hover:text-amber-600 uppercase tracking-widest leading-tight">Umumkan</span>
                    </a>
                    @endif
                    @if(in_array($userRole, ['admin','super_admin','admin_registrasi']))
                    <a href="{{ route('admin.kunjungan.verifikasi') }}" class="quick-link group flex flex-col items-center justify-center p-3 bg-slate-50 hover:bg-white border border-slate-100 hover:border-emerald-200 rounded-xl text-center">
                        <div class="w-10 h-10 rounded-xl bg-emerald-100 text-emerald-600 flex items-center justify-center mb-2 group-hover:scale-110 transition-transform">
                            <i class="fas fa-qrcode text-sm"></i>
                        </div>
                        <span class="text-[10px] font-black text-slate-500 group-hover:text-emerald-600 uppercase tracking-widest leading-tight">Scan QR</span>
                    </a>
                    @endif
                    @if(in_array($userRole, ['admin','super_admin','admin_registrasi','admin_umum']))
                    <a href="{{ route('admin.users.create') }}" class="quick-link group flex flex-col items-center justify-center p-3 bg-slate-50 hover:bg-white border border-slate-100 hover:border-violet-200 rounded-xl text-center">
                        <div class="w-10 h-10 rounded-xl bg-violet-100 text-violet-600 flex items-center justify-center mb-2 group-hover:scale-110 transition-transform">
                            <i class="fas fa-user-plus text-sm"></i>
                        </div>
                        <span class="text-[10px] font-black text-slate-500 group-hover:text-violet-600 uppercase tracking-widest leading-tight">Tambah User</span>
                    </a>
                    @endif
                    @if(in_array($userRole, ['admin','super_admin','admin_humas']))
                    <a href="{{ route('admin.surveys.index') }}" class="quick-link group flex flex-col items-center justify-center p-3 bg-slate-50 hover:bg-white border border-slate-100 hover:border-cyan-200 rounded-xl text-center">
                        <div class="w-10 h-10 rounded-xl bg-cyan-100 text-cyan-600 flex items-center justify-center mb-2 group-hover:scale-110 transition-transform">
                            <i class="fas fa-chart-pie text-sm"></i>
                        </div>
                        <span class="text-[10px] font-black text-slate-500 group-hover:text-cyan-600 uppercase tracking-widest leading-tight">Survey</span>
                    </a>
                    @endif
                    @if(in_array($userRole, ['admin','super_admin','admin_umum','admin_registrasi']))
                    <a href="{{ route('admin.wbp.index') }}" class="quick-link group flex flex-col items-center justify-center p-3 bg-slate-50 hover:bg-white border border-slate-100 hover:border-rose-200 rounded-xl text-center">
                        <div class="w-10 h-10 rounded-xl bg-rose-100 text-rose-600 flex items-center justify-center mb-2 group-hover:scale-110 transition-transform">
                            <i class="fas fa-users-viewfinder text-sm"></i>
                        </div>
                        <span class="text-[10px] font-black text-slate-500 group-hover:text-rose-600 uppercase tracking-widest leading-tight">Data WBP</span>
                    </a>
                    @endif
                </div>
            </div>

            {{-- Aktivitas Terbaru (Pending) --}}
            <div class="glass rounded-2xl shadow-sm overflow-hidden">
                <div class="px-5 py-4 bg-slate-50 border-b border-slate-100 flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <div class="w-7 h-7 bg-amber-100 rounded-lg flex items-center justify-center text-amber-600">
                            <i class="fas fa-hourglass-half text-xs"></i>
                        </div>
                        <h3 class="text-sm font-black text-slate-800">Menunggu Verifikasi</h3>
                    </div>
                    @if($totalPendingKunjungans > 0)
                    <span class="w-5 h-5 bg-amber-500 text-white text-[10px] font-black rounded-full flex items-center justify-center">
                        {{ min($totalPendingKunjungans, 9) }}{{ $totalPendingKunjungans > 9 ? '+' : '' }}
                    </span>
                    @endif
                </div>
                <div class="max-h-64 overflow-y-auto divide-y divide-slate-50">
                    @forelse($pendingKunjungans as $item)
                    <div class="flex items-center gap-3 px-5 py-3 hover:bg-slate-50 transition-colors">
                        <div class="w-8 h-8 bg-amber-100 text-amber-600 rounded-full flex items-center justify-center flex-shrink-0 text-xs font-black">
                            {{ strtoupper(substr($item->nama_pengunjung, 0, 1)) }}
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-xs font-black text-slate-800 truncate">{{ $item->nama_pengunjung }}</p>
                            <p class="text-[10px] text-slate-400">
                                {{ \Carbon\Carbon::parse($item->tanggal_kunjungan)->translatedFormat('d M Y') }}
                            </p>
                        </div>
                        <span class="text-[10px] font-bold text-slate-400 whitespace-nowrap bg-slate-100 px-2 py-0.5 rounded-lg">
                            {{ $item->created_at->diffForHumans(null, true) }}
                        </span>
                    </div>
                    @empty
                    <div class="flex flex-col items-center justify-center py-8 text-center">
                        <div class="w-10 h-10 bg-emerald-100 rounded-2xl flex items-center justify-center text-emerald-500 mb-2">
                            <i class="fas fa-check"></i>
                        </div>
                        <p class="text-xs font-bold text-slate-400">Semua sudah diverifikasi!</p>
                    </div>
                    @endforelse
                </div>
                <div class="px-5 py-3 bg-slate-50 border-t border-slate-100 text-center">
                    <a href="{{ route('admin.kunjungan.index') }}" class="text-xs font-black text-blue-600 hover:text-blue-800 uppercase tracking-widest">
                        Lihat Semua <i class="fas fa-arrow-right ml-1"></i>
                    </a>
                </div>
            </div>

        </div>{{-- end kolom kanan --}}
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // ── Clock ──
    (function tick() {
        const now = new Date();
        const t = now.toLocaleTimeString('id-ID',{hour:'2-digit',minute:'2-digit',second:'2-digit'}).replace(/\./g,':');
        const d = now.toLocaleDateString('id-ID',{weekday:'long',day:'numeric',month:'long',year:'numeric'});
        document.getElementById('realtime-clock').textContent = t;
        document.getElementById('realtime-date').textContent = d;
        setTimeout(tick, 1000);
    })();

    // ── Charts ──
    document.addEventListener('DOMContentLoaded', () => {
        // Line chart
        const vCtx = document.getElementById('visitsChart')?.getContext('2d');
        if (vCtx) {
            const g = vCtx.createLinearGradient(0,0,0,260);
            g.addColorStop(0,'rgba(59,130,246,0.4)');
            g.addColorStop(1,'rgba(59,130,246,0)');
            new Chart(vCtx, {
                type:'line',
                data:{ labels:@json($chartLabels), datasets:[{label:'Kunjungan',data:@json($chartData),backgroundColor:g,borderColor:'#3b82f6',borderWidth:2.5,pointBackgroundColor:'#fff',pointBorderColor:'#3b82f6',pointBorderWidth:2,pointRadius:4,pointHoverRadius:6,fill:true,tension:0.4}]},
                options:{responsive:true,maintainAspectRatio:false,plugins:{legend:{display:false},tooltip:{backgroundColor:'rgba(15,23,42,0.9)',padding:10,cornerRadius:8,bodyFont:{size:13,weight:'bold'}}},scales:{y:{beginAtZero:true,grid:{color:'rgba(226,232,240,0.5)',borderDash:[4,4]},ticks:{precision:0}},x:{grid:{display:false}}}}
            });
        }
        // Bar chart
        const mCtx = document.getElementById('monthlyVisitsChart')?.getContext('2d');
        if (mCtx) {
            new Chart(mCtx,{type:'bar',data:{labels:@json($monthlyVisitsLabels),datasets:[{label:'Kunjungan',data:@json($monthlyVisits),backgroundColor:'rgba(99,102,241,0.6)',borderColor:'#6366f1',borderWidth:1,borderRadius:4,borderSkipped:false}]},options:{responsive:true,maintainAspectRatio:false,plugins:{legend:{display:false}},scales:{y:{beginAtZero:true,ticks:{precision:0},grid:{color:'rgba(226,232,240,0.5)'}},x:{grid:{display:false}}}}});
        }
        // Doughnut chart
        const sCtx = document.getElementById('surveyRatingsChart')?.getContext('2d');
        if (sCtx) {
            new Chart(sCtx,{type:'doughnut',data:{labels:@json($surveyRatingsLabels),datasets:[{data:@json($surveyRatings),backgroundColor:['rgba(239,68,68,0.75)','rgba(245,158,11,0.75)','rgba(59,130,246,0.75)','rgba(34,197,94,0.75)'],borderColor:['#ef4444','#f59e0b','#3b82f6','#22c55e'],borderWidth:2,hoverOffset:4}]},options:{responsive:true,maintainAspectRatio:false,plugins:{legend:{position:'bottom',labels:{font:{size:11},padding:12}}}}});
        }
        // Counter
        document.querySelectorAll('[data-counter]').forEach(el => {
            const t = +el.dataset.counter, dur = 1200, inc = t / (dur/16);
            let c = 0;
            const step = () => { c += inc; if(c < t){ el.innerText=Math.ceil(c); requestAnimationFrame(step); } else el.innerText=t; };
            step();
        });
    });
</script>
@endsection