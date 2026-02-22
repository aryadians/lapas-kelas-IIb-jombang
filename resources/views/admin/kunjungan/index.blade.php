@extends('layouts.admin')

@php
    use App\Enums\KunjunganStatus;
    use App\Models\VisitSetting;

    $visitDuration = (int) VisitSetting::where('key', 'visit_duration_minutes')->value('value') ?? 30;
    $arrivalTolerance = (int) VisitSetting::where('key', 'arrival_tolerance_minutes')->value('value') ?? 15;
@endphp

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>

<style>
    /* PREMIUM 3D & GLASSMORPHISM UI */
    .glass-card {
        background: linear-gradient(135deg, rgba(255, 255, 255, 0.95) 0%, rgba(248, 250, 252, 0.9) 100%);
        backdrop-filter: blur(20px);
        -webkit-backdrop-filter: blur(20px);
        border: 1px solid rgba(255, 255, 255, 0.8);
        box-shadow: 0 20px 40px -10px rgba(0,0,0,0.05), inset 0 1px 0 rgba(255,255,255,1);
    }
    
    .table-container th {
        @apply bg-slate-800 text-white font-bold uppercase tracking-widest text-[10px] whitespace-nowrap border-b-4 border-blue-500 shadow-md;
    }

    .table-container td {
        @apply border-b border-slate-100/80 bg-white/50 backdrop-blur-sm transition-all duration-300;
    }

    .table-container tr:hover td {
        @apply bg-white shadow-sm z-10 relative scale-[1.002];
    }

    .badge-status-3d {
        @apply px-4 py-1.5 rounded-full text-xs font-black uppercase tracking-wider flex items-center justify-center gap-2 w-max transition-all shadow-lg border border-white/20;
    }

    /* Premium Action Buttons - Outlined/Bungkusan Style */
    .btn-action-3d {
        @apply w-9 h-9 rounded-xl flex items-center justify-center transition-all bg-white border-2 hover:-translate-y-1 shadow-sm;
    }
    
    .btn-view { @apply border-blue-200 text-blue-600 hover:bg-blue-600 hover:text-white hover:border-blue-600 hover:shadow-blue-500/30; }
    .btn-edit { @apply border-emerald-200 text-emerald-600 hover:bg-emerald-600 hover:text-white hover:border-emerald-600 hover:shadow-emerald-500/30; }
    .btn-done { @apply border-indigo-200 text-indigo-600 hover:bg-indigo-600 hover:text-white hover:border-indigo-600 hover:shadow-indigo-500/30; }
    .btn-delete { @apply border-rose-200 text-rose-600 hover:bg-rose-600 hover:text-white hover:border-rose-600 hover:shadow-rose-500/30; }

    .btn-action-3d i { 
        @apply transition-transform duration-300 drop-shadow-md text-lg; 
    }
    .btn-action-3d:hover i {
        @apply scale-125 rotate-6 text-white;
    }

    .custom-scrollbar::-webkit-scrollbar { height: 8px; }
    .custom-scrollbar::-webkit-scrollbar-track { background: #f1f5f9; border-radius: 10px; }
    .custom-scrollbar::-webkit-scrollbar-thumb { background: linear-gradient(to right, #94a3b8, #64748b); border-radius: 10px; }
    
    .antrian-pill-3d {
        @apply bg-gradient-to-br from-slate-800 to-black text-white font-black px-4 py-2 rounded-xl text-sm shadow-[0_8px_15px_-5px_rgba(0,0,0,0.4)] border border-slate-700/50 transform transition-transform hover:scale-110;
    }
</style>

<div class="space-y-8 pb-16">

    {{-- HEADER 3D --}}
    <div class="bg-gradient-to-br from-blue-900 via-slate-900 to-blue-950 rounded-[2.5rem] shadow-[0_20px_40px_-10px_rgba(30,58,138,0.5)] overflow-hidden border border-white/10 relative animate__animated animate__zoomIn px-10 py-10 flex flex-col xl:flex-row justify-between items-center gap-8 group">
        <div class="absolute -top-24 -right-24 w-64 h-64 bg-blue-500 blur-[80px] opacity-30 rounded-full group-hover:opacity-50 transition-opacity duration-700"></div>
        <div class="absolute -bottom-24 -left-24 w-64 h-64 bg-emerald-500 blur-[80px] opacity-20 rounded-full group-hover:opacity-40 transition-opacity duration-700"></div>
        
        <div class="relative z-10 text-center xl:text-left">
            <h2 class="text-4xl sm:text-5xl font-black text-transparent bg-clip-text bg-gradient-to-r from-blue-200 to-white flex items-center justify-center xl:justify-start gap-4 drop-shadow-2xl">
                <i class="fas fa-layer-group text-blue-400 rotate-12 transform group-hover:rotate-0 transition-transform duration-500"></i>
                Data Kunjungan
            </h2>
            <div class="mt-3 flex justify-center xl:justify-start items-center gap-3">
                <span class="w-3 h-3 rounded-full bg-emerald-400 animate-ping shadow-[0_0_15px_rgba(52,211,153,1)]"></span>
                <p class="text-blue-100/80 font-medium text-sm tracking-wide">Monitoring Antrian & Pelayanan WBP Real-time</p>
            </div>
        </div>
        
        <div class="relative z-10 flex flex-wrap justify-center gap-4">
            <button type="button" id="openExportModal" class="flex items-center gap-3 px-6 py-3.5 bg-white/10 hover:bg-white/20 backdrop-blur-md text-white rounded-2xl border border-white/20 transition-all font-bold text-sm hover:-translate-y-1 shadow-lg">
                <i class="fas fa-file-excel text-emerald-400 text-lg group-hover:animate-bounce"></i> Export
            </button>
            <a href="{{ route('admin.kunjungan.verifikasi') }}" class="flex items-center gap-3 px-6 py-3.5 bg-blue-600 hover:bg-blue-500 text-white rounded-2xl shadow-[0_10px_20px_-10px_rgba(37,99,235,0.8)] border border-blue-400 font-bold text-sm transition-all hover:-translate-y-1">
                <i class="fas fa-qrcode text-xl text-blue-200"></i> Scan QR
            </a>
            <a href="{{ route('admin.kunjungan.createOffline') }}" class="flex items-center gap-3 px-6 py-3.5 bg-gradient-to-r from-emerald-500 to-teal-500 hover:from-emerald-400 hover:to-teal-400 text-white rounded-2xl shadow-[0_10px_20px_-10px_rgba(16,185,129,0.8)] font-bold text-sm transition-all hover:-translate-y-1 border border-emerald-300">
                <i class="fas fa-plus text-xl"></i> Pendaftaran Offline
            </a>
        </div>
    </div>

    {{-- 3D STATS CARDS --}}
    <div x-data="dashboardStats()" x-init="init()" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 no-print">
        @php
            $hariBuka = $statsToday['hari_buka'] ?? true;
            $sisaKuota = $statsToday['sisa_kuota_total'] ?? 0;
            $statCards = [
                ['title' => 'Hari Ini',    'key' => 'total',    'color' => 'blue',   'icon' => 'calendar-day',  'val' => $statsToday['total']   ?? 0, 'delay' => '0s'],
                ['title' => 'Antrean',     'key' => 'pending',  'color' => 'amber',  'icon' => 'clock',         'val' => $statsToday['pending']  ?? 0, 'delay' => '0.1s'],
                ['title' => 'Dilayani',    'key' => 'serving',  'color' => 'indigo', 'icon' => 'user-friends',  'val' => $statsToday['serving']  ?? 0, 'delay' => '0.2s'],
                ['title' => 'Sisa Kuota',  'key' => 'sisa_kuota_total', 'color' => $hariBuka ? 'emerald' : 'rose', 'icon' => $hariBuka ? 'ticket-alt' : 'ban', 'val' => $sisaKuota, 'delay' => '0.3s'],
            ];
        @endphp


        @foreach($statCards as $stat)
        <div class="bg-white rounded-[2rem] p-6 flex flex-col gap-4 border border-slate-100 shadow-[0_15px_30px_-15px_rgba(0,0,0,0.1)] hover:-translate-y-2 hover:shadow-[0_20px_40px_-15px_rgba(0,0,0,0.15)] transition-all duration-300 animate__animated animate__fadeInUp group relative overflow-hidden text-center sm:text-left" style="animation-delay: {{ $stat['delay'] }};">
            <div class="absolute -right-6 -top-6 w-24 h-24 bg-{{ $stat['color'] }}-50 rounded-full group-hover:scale-150 transition-transform duration-500 z-0"></div>
            
            <div class="relative z-10 flex items-center justify-center sm:justify-start gap-4">
                <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-{{ $stat['color'] }}-400 to-{{ $stat['color'] }}-600 text-white flex items-center justify-center text-2xl shadow-[0_10px_20px_-10px_shadowColor] group-hover:rotate-12 transition-transform duration-300">
                    <i class="fas fa-{{ $stat['icon'] }} drop-shadow-md"></i>
                </div>
                <div>
                    <p class="text-[11px] font-black text-slate-400 uppercase tracking-widest">{{ $stat['title'] }}</p>
                    <p class="text-4xl font-black text-slate-800 drop-shadow-sm" x-text="stats.{{ $stat['key'] }}">{{ $stat['val'] }}</p>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    {{-- INFO DURASI & TOLERANSI --}}
    <div class="flex flex-col sm:flex-row gap-4 mb-2 animate__animated animate__fadeInUp" style="animation-delay: 0.35s;">
        <div class="flex-1 bg-gradient-to-r from-blue-50 to-indigo-50 border border-blue-100/50 p-4 rounded-2xl flex items-center gap-4 shadow-sm">
            <div class="w-10 h-10 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center text-lg">
                <i class="fas fa-hourglass-half"></i>
            </div>
            <div>
                <p class="text-xs font-bold text-slate-500 uppercase tracking-widest mb-0.5">Durasi Kunjungan</p>
                <p class="text-lg font-black text-blue-900">{{ $visitDuration }} Menit / Sesi</p>
            </div>
        </div>
        <div class="flex-1 bg-gradient-to-r from-rose-50 to-orange-50 border border-rose-100/50 p-4 rounded-2xl flex items-center gap-4 shadow-sm">
            <div class="w-10 h-10 rounded-full bg-rose-100 text-rose-600 flex items-center justify-center text-lg">
                <i class="fas fa-user-clock"></i>
            </div>
            <div>
                <p class="text-xs font-bold text-slate-500 uppercase tracking-widest mb-0.5">Toleransi Kedatangan</p>
                <p class="text-lg font-black text-rose-900">{{ $arrivalTolerance }} Menit (Auto-Batal)</p>
            </div>
        </div>
    </div>

    {{-- FILTER GLASS --}}
    <div class="glass-card rounded-[2rem] p-8 animate__animated animate__fadeInUp" style="animation-delay: 0.4s;">
        <form action="{{ route('admin.kunjungan.index') }}" method="GET" class="space-y-6">
            <div class="flex flex-col lg:flex-row gap-6">
                <div class="flex-grow">
                    <label class="text-xs font-bold text-slate-600 mb-2 flex items-center gap-2"><i class="fas fa-search text-blue-500"></i> Cari Data</label>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <i class="fas fa-search text-slate-400 group-hover:text-blue-500 transition-colors"></i>
                        </div>
                        <input type="text" name="search" value="{{ request('search') }}" 
                            class="w-full pl-12 pr-4 py-3.5 bg-white border-2 border-slate-100 rounded-2xl focus:border-blue-500 focus:ring-4 focus:ring-blue-500/20 transition-all font-bold text-slate-700 shadow-sm" 
                            placeholder="Ketik Nama, NIK, WBP...">
                    </div>
                </div>
                
                <div class="lg:w-48">
                    <label class="text-xs font-bold text-slate-600 mb-2 flex items-center gap-2"><i class="fas fa-calendar-alt text-emerald-500"></i> Tanggal</label>
                    <input type="date" name="tanggal_kunjungan" value="{{ request('tanggal_kunjungan') }}" 
                        class="w-full px-4 py-3.5 bg-white border-2 border-slate-100 rounded-2xl focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/20 font-bold text-slate-700 shadow-sm transition-all">
                </div>

                <div class="lg:w-48">
                    <label class="text-xs font-bold text-slate-600 mb-2 flex items-center gap-2"><i class="fas fa-tasks text-purple-500"></i> Status</label>
                    <select name="status" class="w-full px-4 py-3.5 bg-white border-2 border-slate-100 rounded-2xl focus:border-purple-500 focus:ring-4 focus:ring-purple-500/20 font-bold text-slate-700 shadow-sm transition-all">
                        <option value="">Semua Status</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>⏳ Menunggu</option>
                        <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>✅ Disetujui</option>
                        <option value="in_progress" {{ request('status') == 'in_progress' ? 'selected' : '' }}>▶️ Dilayani</option>
                        <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>🏁 Selesai</option>
                    </select>
                </div>

                <div class="flex items-end gap-3 lg:w-48">
                    <button type="submit" class="flex-grow bg-slate-900 hover:bg-slate-800 text-white font-bold py-3.5 rounded-2xl shadow-[0_10px_20px_-10px_rgba(0,0,0,0.5)] transition-all hover:-translate-y-1 active:translate-y-0 text-sm flex justify-center items-center gap-2">
                        <i class="fas fa-filter text-blue-400"></i> Filter
                    </button>
                    @if(request()->hasAny(['search', 'tanggal_kunjungan', 'status']))
                        <a href="{{ route('admin.kunjungan.index') }}" class="px-5 py-3.5 bg-rose-50 border-2 border-rose-100 text-rose-500 hover:bg-rose-500 hover:text-white font-bold rounded-2xl transition-all shadow-sm hover:shadow-rose-500/30 flex items-center justify-center" title="Reset">
                            <i class="fas fa-undo"></i>
                        </a>
                    @endif
                </div>
            </div>
        </form>
    </div>

    {{-- TABLE SECTION 3D --}}
    <form id="bulk-action-form" method="POST" class="space-y-4 animate__animated animate__fadeInUp bg-white p-6 rounded-[2.5rem] shadow-[0_20px_50px_-20px_rgba(0,0,0,0.1)] border border-slate-100" style="animation-delay: 0.5s;">
        @csrf
        
        <div class="flex flex-wrap lg:flex-nowrap justify-between gap-4 py-2 px-2">
            <div class="flex items-center gap-3 bg-slate-50 px-5 py-3 rounded-2xl border-2 border-slate-100">
                <input type="checkbox" id="selectAll" class="w-5 h-5 rounded-md border-slate-300 text-blue-600 focus:ring-blue-500 cursor-pointer transition-all shadow-inner">
                <label for="selectAll" class="font-extrabold text-slate-700 text-xs uppercase tracking-widest cursor-pointer mt-0.5 select-none">Tandai Semua</label>
            </div>

            <div id="bulkActionBar" class="hidden flex-wrap items-center gap-3 bg-slate-900 px-3 py-2 rounded-2xl shadow-[0_15px_30px_-10px_rgba(0,0,0,0.5)] border border-slate-700 animate__animated animate__pulse">
                <div class="px-4 py-1.5 border-r border-slate-700">
                    <span class="text-xs font-black text-white bg-blue-500/20 text-blue-400 px-3 py-1 rounded-lg"><span id="selectedCount">0</span> DIPILIH</span>
                </div>
                
                @foreach([
                    ['type' => 'approved', 'color' => 'emerald', 'icon' => 'check-double', 'label' => 'Setujui'],
                    ['type' => 'completed', 'color' => 'blue', 'icon' => 'flag-checkered', 'label' => 'Selesai'],
                    ['type' => 'delete', 'color' => 'rose', 'icon' => 'trash-alt', 'label' => 'Hapus']
                ] as $btn)
                    <button type="button" onclick="submitBulkAction('{{ $btn['type'] }}')" 
                        class="flex items-center gap-2 px-4 py-2 hover:bg-slate-800 text-{{ $btn['color'] }}-400 hover:text-white text-xs font-bold rounded-xl transition-all border border-transparent hover:border-{{ $btn['color'] }}-500 hover:shadow-[0_0_15px_rgba(color,0.3)]">
                        <i class="fas fa-{{ $btn['icon'] }}"></i> <span class="hidden sm:inline uppercase tracking-wider">{{ $btn['label'] }}</span>
                    </button>
                @endforeach
            </div>
        </div>

        <div class="table-container rounded-3xl overflow-hidden border border-slate-100 mt-4 relative">
            <div class="overflow-x-auto custom-scrollbar">
                <table class="w-full text-sm text-left whitespace-nowrap">
                    <thead>
                        <tr>
                            <th class="px-6 py-5 w-12 text-center rounded-tl-xl"><i class="fas fa-check text-blue-300"></i></th>
                            <th class="px-5 py-5"><i class="fas fa-hashtag text-blue-300 mr-2"></i>Antrian</th>
                            <th class="px-5 py-5"><i class="fas fa-id-card text-blue-300 mr-2"></i>Pengunjung</th>
                            <th class="px-5 py-5"><i class="fas fa-user-lock text-blue-300 mr-2"></i>WBP (Tujuan)</th>
                            <th class="px-5 py-5"><i class="fas fa-calendar-alt text-blue-300 mr-2"></i>Jadwal</th>
                            <th class="px-5 py-5"><i class="fas fa-signal text-blue-300 mr-2"></i>Status</th>
                            <th class="px-5 py-5 text-center rounded-tr-xl min-w-[160px]"><i class="fas fa-cogs text-blue-300 mr-2"></i>Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100/50">
                        @forelse ($kunjungans as $kunjungan)
                        <tr class="group hover:bg-slate-50/50">
                            <td class="px-6 py-5 text-center align-middle">
                                <input type="checkbox" name="ids[]" class="kunjungan-checkbox w-5 h-5 rounded-md border-slate-300 text-blue-600 focus:ring-blue-500 cursor-pointer shadow-sm" value="{{ $kunjungan->id }}">
                            </td>
                            <td class="px-5 py-5 align-middle">
                                @if($kunjungan->nomor_antrian_harian)
                                    <div class="antrian-pill-3d group-hover:scale-110 group-hover:-rotate-3 inline-block">
                                        {{ $kunjungan->registration_type === 'offline' ? 'B' : 'A' }}-{{ str_pad($kunjungan->nomor_antrian_harian, 3, '0', STR_PAD_LEFT) }}
                                    </div>
                                    <div class="text-[10px] text-slate-400 font-bold mt-2 uppercase tracking-widest px-1 flex items-center gap-1">
                                        <i class="fas fa-laptop-house"></i> {{ $kunjungan->registration_type }}
                                    </div>
                                @else
                                    <span class="text-xs text-slate-300 bg-slate-50 px-3 py-1.5 rounded-lg border border-slate-100 font-bold">N/A</span>
                                @endif
                            </td>
                            <td class="px-5 py-5 align-middle">
                                <div class="flex flex-col gap-1.5">
                                    <span class="font-black text-slate-800 text-base drop-shadow-sm">{{ $kunjungan->nama_pengunjung }}</span>
                                    <div class="flex flex-wrap gap-2 text-xs">
                                        <span class="bg-blue-50/80 text-blue-600 px-2 py-1 rounded-md font-mono font-bold border border-blue-100/50 shadow-sm flex items-center gap-1.5">
                                            <i class="far fa-id-badge"></i> {{ $kunjungan->nik_ktp }}
                                        </span>
                                        @if(!empty($kunjungan->foto_ktp_url))
                                            <a data-fslightbox="gallery" href="{{ $kunjungan->foto_ktp_url }}" class="bg-indigo-50/80 text-indigo-600 px-2 py-1 rounded-md font-bold border border-indigo-100/50 shadow-sm flex items-center gap-1.5 hover:bg-indigo-600 hover:text-white transition-colors" title="Lihat KTP">
                                                <i class="fas fa-camera-retro"></i> KTP
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td class="px-5 py-5 align-middle">
                                <div class="flex flex-col gap-1.5">
                                    <span class="font-bold text-slate-700 text-sm"><i class="fas fa-user-circle text-slate-400 mr-1.5"></i> {{ $kunjungan->wbp->nama ?? 'N/A' }}</span>
                                    <span class="text-[10px] font-black text-rose-500 bg-rose-50 border border-rose-100 px-2.5 py-1 rounded-full w-max uppercase tracking-widest shadow-sm">
                                        {{ $kunjungan->hubungan }}
                                    </span>
                                </div>
                            </td>
                            <td class="px-5 py-5 align-middle">
                                <div class="flex flex-col gap-1.5">
                                    <span class="font-bold text-slate-700 text-sm">
                                        <i class="far fa-calendar-check text-blue-400 mr-2"></i>{{ \Carbon\Carbon::parse($kunjungan->tanggal_kunjungan)->translatedFormat('d M Y') }}
                                    </span>
                                    @if($kunjungan->sesi == 'pagi')
                                        <span class="text-[10px] bg-gradient-to-r from-orange-400 to-amber-500 text-white font-black px-2.5 py-1 rounded-lg shadow-md w-fit flex items-center gap-1.5 transform group-hover:-translate-y-0.5 transition-transform"><i class="fas fa-sun text-yellow-200"></i> Sesi Pagi</span>
                                    @else
                                        <span class="text-[10px] bg-gradient-to-r from-blue-400 to-sky-500 text-white font-black px-2.5 py-1 rounded-lg shadow-md w-fit flex items-center gap-1.5 transform group-hover:-translate-y-0.5 transition-transform"><i class="fas fa-cloud-sun text-blue-100"></i> Sesi Siang</span>
                                    @endif
                                </div>
                            </td>
                            <td class="px-5 py-5 align-middle">
                                @php
                                    $mapStatus = [
                                        KunjunganStatus::APPROVED->value => ['border'=>'emerald-500', 'bg'=>'emerald-50', 'text'=>'emerald-600', 'icon'=>'check-circle', 'label'=>'Disetujui'],
                                        KunjunganStatus::CALLED->value => ['border'=>'amber-500', 'bg'=>'amber-50', 'text'=>'amber-600', 'icon'=>'bullhorn', 'label'=>'Dipanggil'],
                                        KunjunganStatus::IN_PROGRESS->value => ['border'=>'blue-500', 'bg'=>'blue-50', 'text'=>'blue-600', 'icon'=>'users-cog', 'label'=>'Melayani'],
                                        KunjunganStatus::REJECTED->value => ['border'=>'rose-500', 'bg'=>'rose-50', 'text'=>'rose-600', 'icon'=>'times-circle', 'label'=>'Ditolak'],
                                        KunjunganStatus::COMPLETED->value => ['border'=>'slate-700', 'bg'=>'slate-50', 'text'=>'slate-700', 'icon'=>'flag-checkered', 'label'=>'Selesai'],
                                        KunjunganStatus::PENDING->value => ['border'=>'orange-400', 'bg'=>'orange-50', 'text'=>'orange-600', 'icon'=>'hourglass-half', 'label'=>'Menunggu']
                                    ];
                                    $st = $mapStatus[$kunjungan->status->value] ?? $mapStatus['pending'];
                                @endphp
                                <div class="px-3 py-1.5 rounded-xl border-2 border-{{ $st['border'] }} bg-{{ $st['bg'] }} text-{{ $st['text'] }} text-[11px] font-black uppercase tracking-widest w-fit flex items-center gap-2 shadow-sm transform group-hover:-translate-y-0.5 transition-transform">
                                    <i class="fas fa-{{ $st['icon'] }} {{ $kunjungan->status->value === 'pending' ? 'animate-spin-slow' : 'animate-bounce-hover' }}"></i>
                                    {{ $st['label'] }}
                                </div>
                            </td>
                            <td class="px-4 py-5 text-center align-middle whitespace-nowrap">
                                <div class="inline-flex items-center justify-center gap-1.5 flex-nowrap">
                                    {{-- LIHAT DETAIL --}}
                                    <a href="{{ route('admin.kunjungan.show', $kunjungan->id) }}"
                                        class="inline-flex items-center justify-center w-9 h-9 rounded-xl bg-sky-50 hover:bg-sky-500 border-2 border-sky-200 hover:border-sky-500 text-sky-600 hover:text-white transition-all duration-200 hover:shadow-lg hover:shadow-sky-500/30 hover:-translate-y-0.5 active:scale-95"
                                        title="Lihat Detail">
                                        <i class="fas fa-eye text-sm"></i>
                                    </a>

                                    @if($kunjungan->status == KunjunganStatus::PENDING)
                                        {{-- SETUJUI --}}
                                        <a href="{{ route('admin.kunjungan.edit', $kunjungan->id) }}"
                                            class="inline-flex items-center justify-center w-9 h-9 rounded-xl bg-emerald-50 hover:bg-emerald-500 border-2 border-emerald-200 hover:border-emerald-500 text-emerald-600 hover:text-white transition-all duration-200 hover:shadow-lg hover:shadow-emerald-500/30 hover:-translate-y-0.5 active:scale-95"
                                            title="Verifikasi & Setujui">
                                            <i class="fas fa-user-check text-sm"></i>
                                        </a>
                                        {{-- TOLAK --}}
                                        <button type="button"
                                            onclick="submitSingleAction('{{ route('admin.kunjungan.update', $kunjungan->id) }}', 'rejected', 'PATCH')"
                                            class="inline-flex items-center justify-center w-9 h-9 rounded-xl bg-rose-50 hover:bg-rose-500 border-2 border-rose-200 hover:border-rose-500 text-rose-600 hover:text-white transition-all duration-200 hover:shadow-lg hover:shadow-rose-500/30 hover:-translate-y-0.5 active:scale-95"
                                            title="Tolak Kunjungan">
                                            <i class="fas fa-user-times text-sm"></i>
                                        </button>

                                    @elseif(in_array($kunjungan->status, [KunjunganStatus::APPROVED, KunjunganStatus::CALLED, KunjunganStatus::IN_PROGRESS]))
                                        {{-- SELESAI --}}
                                        <button type="button"
                                            onclick="submitSingleAction('{{ route('admin.kunjungan.update', $kunjungan->id) }}', 'completed', 'PATCH')"
                                            class="inline-flex items-center justify-center w-9 h-9 rounded-xl bg-slate-50 hover:bg-slate-700 border-2 border-slate-200 hover:border-slate-700 text-slate-600 hover:text-white transition-all duration-200 hover:shadow-lg hover:shadow-slate-500/30 hover:-translate-y-0.5 active:scale-95"
                                            title="Tandai Selesai">
                                            <i class="fas fa-check-double text-sm"></i>
                                        </button>
                                    @endif

                                    {{-- HAPUS --}}
                                    <button type="button"
                                        onclick="submitSingleAction('{{ route('admin.kunjungan.destroy', $kunjungan->id) }}', 'delete', 'DELETE')"
                                        class="inline-flex items-center justify-center w-9 h-9 rounded-xl bg-red-50 hover:bg-red-500 border-2 border-red-200 hover:border-red-500 text-red-600 hover:text-white transition-all duration-200 hover:shadow-lg hover:shadow-red-500/30 hover:-translate-y-0.5 active:scale-95"
                                        title="Hapus Data">
                                        <i class="fas fa-trash-alt text-sm"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="py-20 text-center bg-slate-50/50">
                                <div class="w-28 h-28 bg-white rounded-full flex items-center justify-center mx-auto border-[6px] border-slate-100 mb-6 shadow-inner text-slate-300">
                                    <i class="fas fa-folder-open text-5xl"></i>
                                </div>
                                <h3 class="text-2xl font-black text-slate-800 tracking-tight">Data Kosong</h3>
                                <p class="text-slate-500 mt-2 font-medium">Ups! Tidak ada kunjungan yang cocok dengan pencarian.</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </form>

    {{-- PAGINATION --}}
    @if ($kunjungans->hasPages())
    <div class="mt-8 flex justify-center animate__animated animate__fadeInUp" style="animation-delay: 0.6s;">
        <div class="glass-card p-3 rounded-2xl shadow-xl border border-white/40 inline-block pointer-events-auto">
            {{ $kunjungans->links() }}
        </div>
    </div>
    @endif

</div>

{{-- MODALS & SCRIPTS (kept efficient) --}}
@include('admin.kunjungan.partials.export_modal') 

<form id="single-action-form" method="POST" class="hidden">
    @csrf
    <input type="hidden" name="_method" id="single_method">
    <input type="hidden" name="status" id="single_status">
</form>

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/fslightbox/3.4.1/index.min.js"></script>
<style>
    .animate-spin-slow { animation: spin 3s linear infinite; }
    @keyframes spin { 100% {transform:rotate(360deg);} }
    .animate-bounce-hover { transition: transform 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275); }
    tr:hover .animate-bounce-hover { transform: translateY(-3px) scale(1.1); }
</style>
<script>
const swalTheme3D = {
    customClass: {
        popup: 'rounded-[2rem] shadow-[0_20px_50px_rgba(0,0,0,0.3)] border border-slate-100',
        title: 'text-2xl font-black text-slate-800 tracking-tight',
        htmlContainer: 'text-slate-500 font-medium',
        confirmButton: 'px-8 py-3 bg-gradient-to-r text-white font-black rounded-2xl shadow-lg hover:-translate-y-1 transition-all mx-2',
        cancelButton: 'px-8 py-3 bg-slate-100 text-slate-600 font-black rounded-2xl border-2 border-slate-200 hover:bg-slate-200 hover:-translate-y-1 transition-all mx-2'
    },
    buttonsStyling: false
};

function submitSingleAction(url, actionType, method) {
    const form = document.getElementById('single-action-form');
    document.getElementById('single_method').value = method;
    document.getElementById('single_status').value = actionType === 'delete' ? '' : actionType;

    let props = {
        delete: { t: 'Hapus Data?', icon: 'warning', c: 'from-rose-500 to-red-600 shadow-red-500/50', btn: '<i class="fas fa-trash-alt mr-2"></i>Ya, Hapus' },
        completed: { t: 'Tandai Selesai?', icon: 'info', c: 'from-indigo-500 to-blue-600 shadow-indigo-500/50', btn: '<i class="fas fa-check-double mr-2"></i>Selesai!' },
        approved: { t: 'Setujui?', icon: 'question', c: 'from-emerald-500 to-teal-600 shadow-emerald-500/50', btn: '<i class="fas fa-check mr-2"></i>Ya, Setuju' },
        rejected: { t: 'Tolak?', icon: 'question', c: 'from-amber-400 to-orange-500 shadow-amber-500/50', btn: '<i class="fas fa-times mr-2"></i>Tolak' }
    }[actionType || 'approved'];

    Swal.fire({
        ...swalTheme3D, title: props.t, text: "Yakin melakukan aksi ini?", icon: props.icon,
        showCancelButton: true, confirmButtonText: props.btn,
        customClass: { ...swalTheme3D.customClass, confirmButton: swalTheme3D.customClass.confirmButton + ' ' + props.c }
    }).then(r => { if(r.isConfirmed) { form.action = url; form.submit(); } });
}

function submitBulkAction(actionType) {
    const form = document.getElementById('bulk-action-form');
    if(!document.querySelectorAll('.kunjungan-checkbox:checked').length) return;

    Swal.fire({
        ...swalTheme3D, title: 'Proses Data Masal?', text: `Semua data terpilih akan diproses.`, icon: 'warning',
        showCancelButton: true, confirmButtonText: "Ya, Proses!",
        customClass: { ...swalTheme3D.customClass, confirmButton: swalTheme3D.customClass.confirmButton + ' from-slate-800 to-black shadow-slate-900/50' }
    }).then(r => { 
        if(r.isConfirmed) { 
            form.action = actionType === 'delete' ? "{{ route('admin.kunjungan.bulk-delete') }}" : "{{ route('admin.kunjungan.bulk-update') }}";
            let inp = document.createElement('input'); inp.type = 'hidden'; inp.name = 'status'; inp.value = actionType; form.appendChild(inp);
            form.submit(); 
        } 
    });
}

document.addEventListener('DOMContentLoaded', () => {
    const cbs = document.querySelectorAll('.kunjungan-checkbox'), selAll = document.getElementById('selectAll'), bar = document.getElementById('bulkActionBar');
    const tog = () => {
        let cnt = document.querySelectorAll('.kunjungan-checkbox:checked').length;
        if(document.getElementById('selectedCount')) document.getElementById('selectedCount').innerText = cnt;
        if(bar) bar.className = cnt > 0 ? "flex flex-wrap items-center gap-3 bg-slate-900 px-3 py-2 rounded-2xl shadow-[0_15px_30px_-10px_rgba(0,0,0,0.5)] border border-slate-700 animate__animated animate__zoomIn" : "hidden";
    };
    if(selAll) selAll.addEventListener('change', e => { cbs.forEach(cb => cb.checked = e.target.checked); tog(); });
    cbs.forEach(cb => cb.addEventListener('change', () => { if(!cb.checked && selAll) selAll.checked = false; tog(); }));
    
    // Export Modal Logic
    const btnOp = document.getElementById('openExportModal'), btnCl = document.getElementById('closeExportModal'), mod = document.getElementById('exportModal');
    if(btnOp && mod) btnOp.onclick = () => mod.classList.remove('hidden');
    if(btnCl && mod) btnCl.onclick = () => mod.classList.add('hidden');
    const perSel = document.getElementById('modal_export_period'), datCon = document.getElementById('modal_export_date_container');
    if(perSel) perSel.onchange = () => datCon.classList.toggle('hidden', perSel.value === 'all');
});

function dashboardStats() {
    return {
        stats: { total: {{ $statsToday['total'] ?? 0 }}, pending: {{ $statsToday['pending'] ?? 0 }}, serving: {{ $statsToday['serving'] ?? 0 }} },
        init() { setInterval(() => this.updateStats(), 15000); fetch('{{ route('admin.kunjungan.stats') }}').then(r=>r.json()).then(d=>this.stats=d); },
        updateStats() { fetch('{{ route('admin.kunjungan.stats') }}').then(r=>r.json()).then(d=>this.stats=d); }
    }
}
</script>
@endpush
@endsection
