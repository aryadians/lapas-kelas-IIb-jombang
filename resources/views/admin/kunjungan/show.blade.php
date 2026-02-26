@extends('layouts.admin')

@php
    use App\Enums\KunjunganStatus;
@endphp

@section('title', 'Detail Kunjungan')

@section('content')
{{-- Load Animate.css --}}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>

<style>
    /* 3D Card Effect */
    .card-3d {
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        transform-style: preserve-3d;
        backface-visibility: hidden;
    }
    .card-3d:hover {
        transform: translateY(-8px) rotateX(1deg);
        box-shadow: 0 25px 35px -10px rgba(0, 0, 0, 0.15), 0 15px 15px -10px rgba(0, 0, 0, 0.05);
        z-index: 10;
    }

    /* Glassmorphism Header */
    .glass-header {
        background: rgba(255, 255, 255, 0.85);
        backdrop-filter: blur(12px);
        border-bottom: 1px solid rgba(226, 232, 240, 0.8);
    }

    /* Text Gradient */
    .text-gradient {
        background-clip: text;
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-image: linear-gradient(to right, #1e293b, #3b82f6);
    }
    
    .data-label {
        font-size: 0.7rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.08em;
        color: #64748b; 
        margin-bottom: 0.35rem;
    }
    
    .data-value {
        font-size: 1.05rem;
        font-weight: 700;
        color: #1e293b; 
        line-height: 1.5;
    }

    /* Print Styles */
    @media print {
        body * { visibility: hidden; }
        #printableArea, #printableArea * { visibility: visible; }
        #printableArea { position: absolute; left: 0; top: 0; width: 100%; }
        .no-print { display: none !important; }
    }
</style>

<div class="space-y-8 pb-12 perspective-1000">

    {{-- HEADER --}}
    <header class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6 animate__animated animate__fadeInDown">
        <div>
            <h1 class="text-3xl sm:text-4xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-slate-800 to-blue-600">
                Detail Kunjungan
            </h1>
            <p class="text-slate-500 mt-2 font-medium">Tinjau informasi lengkap, histori kunjungan, dan tiket antrian.</p>
        </div>
        <div class="flex gap-3">
            <a href="{{ route('admin.kunjungan.index') }}" class="group inline-flex items-center gap-2 bg-white text-slate-700 font-bold py-3 px-6 rounded-xl shadow-sm border border-slate-200 hover:border-blue-300 hover:bg-blue-50 transition-all active:scale-95">
                <i class="fas fa-arrow-left text-slate-400 group-hover:text-blue-500 transition-colors"></i>
                <span>Kembali</span>
            </a>
        </div>
    </header>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 animate__animated animate__fadeInUp delay-100">

        {{-- KOLOM KIRI: STATUS & TIKET --}}
        <div class="lg:col-span-1 space-y-8">
            
            {{-- CARD STATUS (Highlight) --}}
            <div class="card-3d relative overflow-hidden rounded-3xl shadow-2xl animate__animated animate__fadeInLeft border border-white/20">
                {{-- Background Gradient --}}
                <div class="absolute inset-0 
                    @if($kunjungan->status == KunjunganStatus::APPROVED) bg-gradient-to-br from-emerald-400 via-emerald-500 to-teal-600
                    @elseif($kunjungan->status == KunjunganStatus::REJECTED) bg-gradient-to-br from-red-500 via-rose-500 to-rose-700
                    @elseif($kunjungan->status == KunjunganStatus::COMPLETED) bg-gradient-to-br from-slate-600 via-slate-700 to-slate-800
                    @elseif(in_array($kunjungan->status, [KunjunganStatus::CALLED, KunjunganStatus::IN_PROGRESS])) bg-gradient-to-br from-blue-500 via-indigo-500 to-indigo-700
                    @else bg-gradient-to-br from-amber-400 via-amber-500 to-orange-500
                    @endif opacity-100"></div>
                
                {{-- Decorative Patterns --}}
                <div class="absolute top-0 right-0 w-64 h-64 bg-white opacity-10 rounded-full blur-3xl -mr-16 -mt-16"></div>
                <div class="absolute bottom-0 left-0 w-48 h-48 bg-black opacity-10 rounded-full blur-2xl -ml-10 -mb-10"></div>

                <div class="relative z-10 p-10 text-center text-white flex flex-col items-center justify-center min-h-[300px]">
                    {{-- Status Icon --}}
                    <div class="w-24 h-24 mx-auto bg-white/20 backdrop-blur-md rounded-2xl flex items-center justify-center mb-6 shadow-xl border border-white/30 animate__animated animate__zoomIn transform rotate-3 hover:rotate-0 transition-transform cursor-pointer">
                        @if($kunjungan->status == KunjunganStatus::APPROVED)
                            <i class="fas fa-check-circle text-6xl drop-shadow-md text-white"></i>
                        @elseif($kunjungan->status == KunjunganStatus::REJECTED)
                            <i class="fas fa-times-circle text-6xl drop-shadow-md text-white"></i>
                        @elseif($kunjungan->status == KunjunganStatus::COMPLETED)
                            <i class="fas fa-flag-checkered text-6xl drop-shadow-md text-white"></i>
                        @elseif($kunjungan->status == KunjunganStatus::IN_PROGRESS)
                            <i class="fas fa-comments text-6xl drop-shadow-md text-white"></i>
                        @elseif($kunjungan->status == KunjunganStatus::CALLED)
                            <i class="fas fa-bullhorn text-6xl drop-shadow-md text-white"></i>
                        @else
                            <i class="fas fa-clock text-6xl drop-shadow-md text-white"></i>
                        @endif
                    </div>
                    
                    <h2 class="text-xs font-bold uppercase tracking-[0.2em] text-white/80 mb-2">Status Saat Ini</h2>
                    <h3 class="text-3xl font-black tracking-tight mb-4 drop-shadow-sm">
                        @if($kunjungan->status == KunjunganStatus::APPROVED) DISETUJUI
                        @elseif($kunjungan->status == KunjunganStatus::REJECTED) DITOLAK
                        @elseif($kunjungan->status == KunjunganStatus::COMPLETED) SELESAI
                        @elseif($kunjungan->status == KunjunganStatus::IN_PROGRESS) SEDANG BERKUNJUNG
                        @elseif($kunjungan->status == KunjunganStatus::CALLED) DIPANGGIL
                        @else MENUNGGU
                        @endif
                    </h3>
                    <p class="text-sm font-medium opacity-90 bg-black/20 backdrop-blur-sm inline-block px-4 py-1.5 rounded-full border border-white/10 shadow-inner">
                        <i class="fa-solid fa-clock-rotate-left mr-1"></i> Update: {{ $kunjungan->updated_at->diffForHumans() }}
                    </p>
                </div>

                {{-- Action Buttons (Pending) --}}
                @if($kunjungan->status == KunjunganStatus::PENDING)
                <div class="relative z-10 bg-white/95 backdrop-blur-xl p-5 flex gap-4 justify-center border-t border-white/20 shadow-inner">
                    <button onclick="confirmSingleAction('{{ route('admin.kunjungan.update', $kunjungan->id) }}', 'PATCH', 'approved', '{{ $kunjungan->nama_pengunjung }}')" 
                        class="flex-1 inline-flex justify-center items-center gap-2 px-5 py-3.5 bg-gradient-to-r from-emerald-500 to-emerald-600 hover:from-emerald-600 hover:to-emerald-700 text-white font-bold rounded-xl transition-all shadow-md hover:shadow-lg active:scale-95 group">
                        <i class="fas fa-check-circle group-hover:scale-110 transition-transform"></i> Terima
                    </button>
                    <button onclick="confirmSingleAction('{{ route('admin.kunjungan.update', $kunjungan->id) }}', 'PATCH', 'rejected', '{{ $kunjungan->nama_pengunjung }}')" 
                        class="flex-1 inline-flex justify-center items-center gap-2 px-5 py-3.5 bg-gradient-to-r from-red-500 to-rose-600 hover:from-red-600 hover:to-rose-700 text-white font-bold rounded-xl transition-all shadow-md hover:shadow-lg active:scale-95 group">
                        <i class="fas fa-times-circle group-hover:scale-110 transition-transform"></i> Tolak
                    </button>
                </div>
                @endif
            </div>

            {{-- CARD QR CODE & TIKET --}}
            @if($kunjungan->status == KunjunganStatus::APPROVED && $kunjungan->qr_token)
            <div id="ticketCard" class="card-3d bg-white rounded-3xl shadow-xl border border-slate-200 overflow-hidden animate__animated animate__fadeInUp delay-200 group">
                <div class="glass-header p-5 flex items-center gap-4 bg-gradient-to-r from-slate-50 to-white">
                    <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-slate-800 to-slate-900 flex items-center justify-center text-white shadow-lg group-hover:scale-110 transition-transform">
                        <i class="fas fa-qrcode text-xl"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-slate-800">Tiket Kunjungan</h3>
                        <p class="text-slate-500 text-xs font-medium">Scan QR untuk verifikasi masuk.</p>
                    </div>
                </div>
                
                <div class="p-8 flex flex-col items-center">
                    {{-- QR Code Image --}}
                    <div class="bg-white p-5 rounded-3xl border-2 border-dashed border-blue-200 shadow-md mb-6 relative hover:border-blue-400 transition-colors">
                        <img src="{{ $kunjungan->qr_code_url }}" 
                             alt="QR Code" 
                             class="w-48 h-48 object-contain transition-transform group-hover:scale-105 duration-300">
                    </div>

                    <div class="text-center mb-8 w-full">
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-[0.15em] mb-2">Kode Token Registrasi</p>
                        <code class="block text-2xl font-mono font-black text-slate-800 tracking-wider bg-slate-100 px-6 py-3 rounded-xl border border-slate-200 select-all shadow-inner">
                            {{ $kunjungan->qr_token }}
                        </code>
                    </div>

                    <button onclick="printTicket()" class="w-full py-4 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-bold rounded-xl shadow-lg shadow-blue-200/50 transition-all active:scale-95 flex items-center justify-center gap-2 border border-blue-500">
                        <i class="fas fa-print"></i> Cetak Lembar Antrian
                    </button>
                </div>
            </div>
            @endif
        </div>

        {{-- KOLOM TENGAH & KANAN: DETAIL DATA --}}
        <div class="lg:col-span-2 space-y-8 animate__animated animate__fadeInRight delay-200">
            
            {{-- CARD 1: INFORMASI JADWAL --}}
            <div class="card-3d bg-white rounded-3xl shadow-xl border border-slate-200 overflow-hidden relative">
                <div class="glass-header p-6 relative z-10 bg-gradient-to-b from-slate-50/80 to-white/90 border-b border-slate-100">
                    <div class="flex items-center gap-4">
                        <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-indigo-500 to-blue-600 flex items-center justify-center text-white shadow-lg shadow-blue-200 transform -rotate-3">
                            <i class="fas fa-calendar-alt text-2xl hover:rotate-12 transition-transform duration-300"></i>
                        </div>
                        <div>
                            <h3 class="text-xl font-extrabold text-slate-800">Jadwal & Antrian</h3>
                            <p class="text-slate-500 text-sm font-medium">Informasi pelaksanaan kunjungan.</p>
                        </div>
                    </div>
                </div>

                <div class="p-8 relative z-10">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        {{-- Tanggal --}}
                        <div class="bg-gradient-to-br from-slate-50 to-white p-6 rounded-2xl border border-slate-200 shadow-sm hover:shadow-md transition-shadow group">
                            <p class="text-[10px] font-bold uppercase tracking-[0.1em] text-slate-500 mb-2 flex items-center gap-2"><i class="far fa-calendar text-blue-500"></i> Tanggal Kunjungan</p>
                            <p class="text-2xl font-black text-slate-800 tracking-tight group-hover:text-blue-600 transition-colors">
                                {{ \Carbon\Carbon::parse($kunjungan->tanggal_kunjungan)->translatedFormat('l, d F Y') }}
                            </p>
                        </div>

                        {{-- Sesi & Antrian --}}
                        <div class="bg-gradient-to-br from-slate-50 to-white p-6 rounded-2xl border border-slate-200 shadow-sm hover:shadow-md transition-shadow flex flex-col justify-center">
                            <p class="text-[10px] font-bold uppercase tracking-[0.1em] text-slate-500 mb-2 flex items-center gap-2"><i class="far fa-clock text-purple-500"></i> Sesi & Nomor Antrian</p>
                            <div class="flex items-center gap-3">
                                {{-- Badge Sesi --}}
                                <div class="px-4 py-2.5 rounded-xl bg-white border border-purple-200 shadow-sm flex items-center gap-2 border-l-4 border-l-purple-500">
                                    <span class="text-sm font-bold text-slate-700 uppercase tracking-wide">{{ $kunjungan->sesi ?? '-' }}</span>
                                </div>
                                
                                {{-- Badge Antrian --}}
                                @if($kunjungan->nomor_antrian_harian)
                                <div class="px-5 py-2.5 rounded-xl bg-gradient-to-r from-blue-600 to-indigo-600 text-white shadow-md shadow-blue-200/50 flex items-center gap-2">
                                    <i class="fas fa-list-ol text-xs opacity-80"></i>
                                    <span class="text-lg font-black tracking-tight drop-shadow-sm">
                                        {{ $kunjungan->registration_type === 'offline' ? 'B' : 'A' }}-{{ str_pad($kunjungan->nomor_antrian_harian, 3, '0', STR_PAD_LEFT) }}
                                    </span>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- CARD 2: DATA PENGUNJUNG & WBP --}}
            <div class="card-3d bg-white rounded-3xl shadow-xl border border-slate-200 overflow-hidden">
                <div class="glass-header p-6 flex items-center gap-4 bg-gradient-to-b from-slate-50/80 to-white/90 border-b border-slate-100">
                    <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-amber-400 to-orange-500 flex items-center justify-center text-white shadow-lg shadow-amber-200">
                        <i class="fas fa-address-card text-xl"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-slate-800">Identitas Lengkap</h3>
                        <p class="text-slate-500 text-xs font-medium">Informasi pengunjung dan warga binaan.</p>
                    </div>
                </div>

                <div class="p-8 grid grid-cols-1 md:grid-cols-2 gap-x-12 gap-y-10">
                    {{-- Pengunjung --}}
                    <div class="space-y-6 relative">
                        {{-- Decorative border right for large screens --}}
                        <div class="hidden md:block absolute right-[-1.5rem] top-0 bottom-0 w-px bg-slate-200"></div>

                        <div class="border-b-2 border-blue-500 inline-block pb-2 mb-2">
                            <h4 class="text-sm font-black text-slate-800 uppercase tracking-widest flex items-center gap-2">
                                <i class="fas fa-user-tag text-blue-500"></i> Pengunjung Utama
                            </h4>
                        </div>
                        
                        <div><p class="data-label">Nama Lengkap</p><p class="text-lg font-bold text-slate-800">{{ $kunjungan->nama_pengunjung }}</p></div>
                        
                        <div><p class="data-label">NIK / Identitas</p><p class="data-value font-mono bg-slate-100 text-slate-600 px-3 py-1 rounded-md inline-block text-sm border border-slate-200">{{ $kunjungan->nik_ktp }}</p></div>
                        
                        <div>
                            <p class="data-label">Kontak WhatsApp</p>
                            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $kunjungan->no_wa_pengunjung) }}" target="_blank" class="inline-flex items-center gap-2 bg-green-50 hover:bg-green-100 text-green-700 font-bold text-sm px-3 py-1.5 rounded-lg border border-green-200 transition-colors">
                                <i class="fab fa-whatsapp text-lg"></i> {{ $kunjungan->no_wa_pengunjung }}
                            </a>
                        </div>
                        
                        <div><p class="data-label">Alamat Domisili</p><p class="data-value text-sm text-slate-600 leading-relaxed bg-slate-50 p-3 rounded-lg border border-slate-100">{{ $kunjungan->alamat_pengunjung }}</p></div>
                        
                        {{-- FOTO KTP Logic --}}
                        @if(!empty($kunjungan->foto_ktp_url))
                        <div class="pt-2">
                            <p class="data-label">Dokumen Identitas (KTP)</p>
                            <div class="relative group mt-2 max-w-sm rounded-xl overflow-hidden border-2 border-slate-200 shadow-sm hover:shadow-md transition-shadow">
                                <a href="{{ $kunjungan->foto_ktp_url }}" target="_blank" class="block">
                                    <div class="absolute inset-0 bg-slate-900/50 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center z-10">
                                        <i class="fas fa-external-link-alt text-white text-2xl drop-shadow-md"></i>
                                    </div>
                                    <img src="{{ $kunjungan->foto_ktp_url }}" loading="lazy" class="w-full h-40 object-cover transform group-hover:scale-105 transition-transform duration-500">
                                </a>
                            </div>
                            <div class="mt-3">
                                <a href="{{ $kunjungan->foto_ktp_url }}" download="KTP_{{ $kunjungan->nama_pengunjung }}.png" class="inline-flex items-center gap-2 px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold rounded-lg transition-colors border border-slate-200">
                                    <i class="fas fa-download"></i> Unduh Foto KTP
                                </a>
                            </div>
                        </div>
                        @else
                        <div class="pt-2">
                            <p class="data-label">Dokumen Identitas (KTP)</p>
                            <div class="bg-slate-50 border border-slate-200 border-dashed rounded-xl p-6 text-center text-slate-400">
                                <i class="fas fa-id-card-clip text-3xl mb-2"></i>
                                <p class="text-xs font-medium">KTP Tidak Dilampirkan</p>
                            </div>
                        </div>
                        @endif
                    </div>

                    {{-- WBP --}}
                    <div class="space-y-6">
                        <div class="border-b-2 border-emerald-500 inline-block pb-2 mb-2">
                            <h4 class="text-sm font-black text-slate-800 uppercase tracking-widest flex items-center gap-2">
                                <i class="fas fa-user-lock text-emerald-500"></i> Warga Binaan
                            </h4>
                        </div>
                        
                        <div><p class="data-label">Nama WBP Dituju</p><p class="text-xl font-bold text-slate-800">{{ $kunjungan->wbp->nama ?? 'Data Terhapus' }}</p></div>
                        
                        <div>
                            <p class="data-label">Hubungan dengan WBP</p>
                            <span class="inline-flex items-center px-4 py-1.5 rounded-lg bg-emerald-50 text-emerald-700 text-sm font-bold border border-emerald-200 shadow-sm">
                                <i class="fas fa-link mr-2 opacity-50"></i> {{ $kunjungan->hubungan }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- CARD: LOG NOTIFIKASI --}}
            <div class="card-3d bg-white rounded-3xl shadow-xl border border-slate-200 overflow-hidden">
                <div class="glass-header p-6 flex items-center gap-4 bg-gradient-to-b from-slate-50/80 to-white/90 border-b border-slate-100">
                    <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-blue-500 to-blue-600 flex items-center justify-center text-white shadow-lg shadow-blue-200">
                        <i class="fas fa-bell text-xl animate-bounce-slow"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-slate-800">Log Notifikasi WhatsApp & Email</h3>
                        <p class="text-slate-500 text-xs font-medium">Histori pengiriman tiket kepada pengunjung.</p>
                    </div>
                </div>

                <div class="p-8">
                    @if($kunjungan->notification_logs && count($kunjungan->notification_logs) > 0)
                        <div class="space-y-6 relative border-l-2 border-slate-100 pl-6 ml-2">
                            @foreach(array_reverse($kunjungan->notification_logs) as $log)
                            <div class="relative pb-6 last:pb-0 group">
                                <div class="absolute left-[-33px] top-0 w-4 h-4 rounded-full bg-blue-500 border-4 border-white shadow-sm group-hover:bg-blue-600 transition-colors"></div>
                                
                                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 mb-4 bg-slate-50 px-4 py-2 rounded-lg border border-slate-100">
                                    <h4 class="font-bold text-slate-700 uppercase text-xs tracking-wider flex items-center gap-2">
                                        <i class="fas fa-random text-slate-400"></i> Trigger: <span class="bg-blue-100 text-blue-700 px-2 py-0.5 rounded">{{ $log['status_at_time'] }}</span>
                                    </h4>
                                    <span class="text-[10px] font-bold text-slate-500 flex items-center gap-1 bg-white px-2 py-1 rounded-md border border-slate-200 shadow-sm">
                                        <i class="far fa-clock"></i> {{ \Carbon\Carbon::parse($log['timestamp'])->format('d M Y, H:i') }}
                                    </span>
                                </div>
                                
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mt-2">
                                    {{-- Email Status --}}
                                    <div class="flex items-center gap-3 p-4 rounded-xl border border-slate-100 bg-white hover:shadow-md transition-shadow relative overflow-hidden group/item">
                                        <div class="absolute right-0 top-0 bottom-0 w-1 bg-gradient-to-b 
                                            @if($log['email'] == 'sent') from-emerald-400 to-emerald-500
                                            @elseif($log['email'] == 'failed') from-rose-400 to-rose-500
                                            @elseif($log['email'] == 'pending') from-amber-400 to-amber-500
                                            @else from-slate-300 to-slate-400 @endif"></div>
                                        <div class="w-12 h-12 rounded-xl flex items-center justify-center shadow-sm
                                            @if($log['email'] == 'sent') bg-emerald-50 text-emerald-600 border border-emerald-100
                                            @elseif($log['email'] == 'failed') bg-rose-50 text-rose-600 border border-rose-100
                                            @elseif($log['email'] == 'pending') bg-amber-50 text-amber-600 border border-amber-100
                                            @else bg-slate-50 text-slate-400 border border-slate-100 @endif group-hover/item:scale-110 transition-transform">
                                            <i class="fas fa-envelope text-xl"></i>
                                        </div>
                                        <div class="flex-grow">
                                            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest leading-none mb-1.5">Email Delivery</p>
                                            <p class="text-sm font-bold text-slate-800 capitalize flex items-center gap-1">
                                                {{ $log['email'] }}
                                                @if($log['email'] == 'sent') <i class="fas fa-check-circle text-emerald-500 text-[10px]"></i> @endif
                                            </p>
                                            @if(isset($log['email_reason']))
                                                <p class="text-[10px] text-rose-500 mt-1 italic w-full truncate" title="{{ $log['email_reason'] }}">{{ $log['email_reason'] }}</p>
                                            @endif
                                        </div>
                                    </div>

                                    {{-- WhatsApp Status --}}
                                    <div class="flex items-center gap-3 p-4 rounded-xl border border-slate-100 bg-white hover:shadow-md transition-shadow relative overflow-hidden group/item">
                                        <div class="absolute right-0 top-0 bottom-0 w-1 bg-gradient-to-b 
                                            @if($log['whatsapp'] == 'sent') from-emerald-400 to-emerald-500
                                            @elseif($log['whatsapp'] == 'failed') from-rose-400 to-rose-500
                                            @elseif($log['whatsapp'] == 'pending') from-amber-400 to-amber-500
                                            @else from-slate-300 to-slate-400 @endif"></div>
                                        <div class="w-12 h-12 rounded-xl flex items-center justify-center shadow-sm
                                            @if($log['whatsapp'] == 'sent') bg-emerald-50 text-emerald-600 border border-emerald-100
                                            @elseif($log['whatsapp'] == 'failed') bg-rose-50 text-rose-600 border border-rose-100
                                            @elseif($log['whatsapp'] == 'pending') bg-amber-50 text-amber-600 border border-amber-100
                                            @else bg-slate-50 text-slate-400 border border-slate-100 @endif group-hover/item:scale-110 transition-transform">
                                            <i class="fab fa-whatsapp text-2xl"></i>
                                        </div>
                                        <div class="flex-grow">
                                            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest leading-none mb-1.5">WhatsApp Delivery</p>
                                            <p class="text-sm font-bold text-slate-800 capitalize flex items-center gap-1">
                                                {{ $log['whatsapp'] }}
                                                @if($log['whatsapp'] == 'sent') <i class="fas fa-check-circle text-emerald-500 text-[10px]"></i> @endif
                                            </p>
                                            @if(isset($log['whatsapp_reason']))
                                                <p class="text-[10px] text-rose-500 mt-1 italic w-full truncate" title="{{ $log['whatsapp_reason'] }}">{{ $log['whatsapp_reason'] }}</p>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-10 bg-slate-50 rounded-2xl border-2 border-dashed border-slate-200">
                            <i class="fas fa-paper-plane text-4xl text-slate-300 mb-4 opacity-50"></i>
                            <p class="text-slate-500 font-medium">Sistem Notifikasi Belum Terpicu</p>
                            <p class="text-slate-400 text-xs mt-1">Log WhatsApp & Email akan muncul di sini setelah status kunjungan disetujui/ditolak.</p>
                        </div>
                    @endif
                </div>
            </div>

            {{-- CARD: TIMELINE AUDIT TRAIL --}}
            <div class="card-3d bg-white rounded-3xl shadow-xl border border-slate-200 overflow-hidden">
                <div class="glass-header p-6 flex items-center gap-4 bg-gradient-to-b from-slate-50/80 to-white/90 border-b border-slate-100">
                    <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-slate-700 to-slate-800 flex items-center justify-center text-white shadow-lg shadow-slate-300">
                        <i class="fas fa-user-shield text-xl"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-slate-800">Sistem Pelacakan Keamanan</h3>
                        <p class="text-slate-500 text-xs font-medium">Jejak rekaman dan aktivitas petugas terhadap data ini.</p>
                    </div>
                </div>

                <div class="p-8">
                    @if($kunjungan->activities && $kunjungan->activities->count() > 0)
                        <div class="space-y-6 relative border-l-2 border-slate-200 pl-6 ml-2">
                            @foreach($kunjungan->activities->sortByDesc('created_at') as $activity)
                            <div class="relative pb-6 last:pb-0 group">
                                <div class="absolute left-[-33px] top-1 w-4 h-4 rounded-full bg-slate-300 border-4 border-white shadow-sm group-hover:bg-slate-500 transition-colors"></div>
                                
                                <div class="flex flex-col sm:flex-row sm:items-start justify-between gap-2 mb-2">
                                    <h4 class="font-bold text-slate-800 text-sm">
                                        {{ $activity->description }}
                                    </h4>
                                    <span class="text-xs font-bold text-slate-500 bg-slate-100 px-3 py-1 rounded-full border border-slate-200">
                                        {{ $activity->created_at->format('d M Y, H:i') }}
                                    </span>
                                </div>

                                <div class="flex items-center gap-2 text-xs text-slate-500 mb-3 bg-slate-50 inline-flex px-3 py-1.5 rounded-lg border border-slate-100">
                                    <div class="w-5 h-5 rounded-full bg-slate-200 flex items-center justify-center text-slate-600"><i class="fas fa-user"></i></div>
                                    <span>Petugas: <strong class="text-slate-700">{{ $activity->causer->name ?? 'Sistem Otomatis' }}</strong></span>
                                </div>

                                @if(isset($activity->changes['attributes']['status']))
                                    <div class="flex items-center gap-3 mt-1 bg-white border border-slate-200 p-3 rounded-xl shadow-sm inline-block w-full sm:w-auto">
                                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mr-2">Transisi Status:</p>
                                        <span class="text-[10px] px-3 py-1 rounded-md bg-slate-100 text-slate-500 line-through border border-slate-200 font-mono">
                                            {{ $activity->changes['old']['status'] ?? 'N/A' }}
                                        </span>
                                        <i class="fas fa-arrow-right text-[10px] text-blue-500 animate-pulse"></i>
                                        <span class="text-xs px-3 py-1 rounded-md bg-blue-50 text-blue-600 font-bold uppercase border border-blue-100 font-mono shadow-sm">
                                            {{ $activity->changes['attributes']['status'] }}
                                        </span>
                                    </div>
                                @endif
                            </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-10 bg-slate-50 rounded-2xl border-2 border-dashed border-slate-200">
                            <i class="fas fa-shield-alt text-4xl text-slate-300 mb-4 opacity-50"></i>
                            <p class="text-slate-500 font-medium">Belum Ada Rekam Jejak Sistem</p>
                            <p class="text-slate-400 text-xs mt-1">Sistem belum mencatat intervensi petugas pada permohonan kunjungan ini.</p>
                        </div>
                    @endif
                </div>
            </div>

            {{-- CARD 3: DATA PENGIKUT --}}
            <div class="card-3d bg-white rounded-3xl shadow-xl border border-slate-200 overflow-hidden">
                <div class="glass-header p-6 flex items-center gap-4 bg-gradient-to-b from-slate-50/80 to-white/90 border-b border-slate-100">
                    <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-purple-500 to-fuchsia-600 flex items-center justify-center text-white shadow-lg shadow-purple-200">
                        <i class="fas fa-users text-xl"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-slate-800">Daftar Pengikut Tambahan</h3>
                        <p class="text-slate-500 text-xs font-medium">Orang yang menyertai pendaftar utama masuk ke ruang kunjungan.</p>
                    </div>
                </div>

                <div class="p-8">
                    @if($kunjungan->pengikuts && $kunjungan->pengikuts->count() > 0)
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            @foreach($kunjungan->pengikuts as $pengikut)
                            <div class="flex items-start gap-4 p-5 bg-white rounded-2xl border border-slate-200 shadow-sm hover:shadow-md transition-shadow group">
                                {{-- Foto Pengikut --}}
                                <div class="flex-shrink-0">
                                    @if(!empty($pengikut->foto_ktp_url))
                                        <a href="{{ $pengikut->foto_ktp_url }}" target="_blank" class="block relative">
                                            <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity rounded-full flex items-center justify-center text-white text-xs">
                                                <i class="fas fa-search-plus"></i>
                                            </div>
                                            <img src="{{ $pengikut->foto_ktp_url }}" loading="lazy" class="w-14 h-14 rounded-full object-cover border-2 border-slate-200 shadow-sm">
                                        </a>
                                    @else
                                        <div class="w-14 h-14 rounded-full bg-slate-100 flex items-center justify-center text-slate-400 border border-slate-200">
                                            <i class="fas fa-user-secret text-xl"></i>
                                        </div>
                                    @endif
                                </div>
                                <div class="flex-grow">
                                    <h4 class="font-bold text-slate-800 leading-tight">{{ $pengikut->nama }}</h4>
                                    <p class="text-[11px] font-mono text-slate-500 tracking-wider mb-2 mt-0.5">ID: {{ $pengikut->nik ?? '-' }}</p>
                                    
                                    <div class="flex flex-wrap gap-2">
                                        <span class="text-[10px] bg-indigo-50 text-indigo-700 px-2 py-1 rounded border border-indigo-100 font-bold uppercase tracking-widest"><i class="fas fa-link mr-1 opacity-50"></i> {{ $pengikut->hubungan }}</span>
                                        @if($pengikut->barang_bawaan)
                                        <span class="text-[10px] bg-emerald-50 text-emerald-700 px-2 py-1 rounded border border-emerald-100 font-bold tracking-wide mt-1 w-full block">
                                            <i class="fas fa-shopping-bag mr-1 opacity-70"></i> Membawa: {{ $pengikut->barang_bawaan }}
                                        </span>
                                        @endif
                                    </div>

                                    @if(!empty($pengikut->foto_ktp_url))
                                    <a href="{{ $pengikut->foto_ktp_url }}" download="Pengikut_{{ $pengikut->nama }}.png" class="text-[10px] text-blue-600 font-bold hover:text-blue-800 transition-colors mt-3 inline-flex items-center gap-1 bg-blue-50 px-2 py-1 rounded-md">
                                        <i class="fas fa-cloud-download-alt"></i> Unduh KTP
                                    </a>
                                    @endif
                                </div>
                            </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-10 bg-slate-50 rounded-2xl border-2 border-dashed border-slate-200">
                            <i class="fas fa-users-slash text-4xl text-slate-300 mb-4 opacity-50"></i>
                            <p class="text-slate-500 font-medium">Bebas Pengikut Tambahan</p>
                            <p class="text-slate-400 text-xs mt-1">Pendaftar mengajukan permohonan kunjungan untuk dirinya sendiri tanpa menyertakan anggota keluarga/teman lainnya.</p>
                        </div>
                    @endif
                </div>
                
                <div class="bg-rose-50/50 p-6 flex justify-end border-t border-rose-100">
                    <button onclick="confirmSingleAction('{{ route('admin.kunjungan.destroy', $kunjungan->id) }}', 'DELETE', null, '{{ $kunjungan->nama_pengunjung }}')" 
                        class="inline-flex items-center gap-2 px-6 py-3 bg-white text-red-600 border border-red-200 hover:text-white hover:bg-red-600 hover:border-red-600 rounded-xl transition-all shadow-sm font-bold active:scale-95">
                        <i class="fas fa-trash-alt"></i> Hapus Permanen Data Kunjungan Ini
                    </button>
                </div>
            </div>

        </div>
    </div>
</div>

{{-- AREA CETAK (PRINT) --}}
<div id="printableArea" class="hidden">
    <div style="text-align: center; font-family: sans-serif; padding: 20px; border: 2px solid #000; margin: 20px;">
        <h2 style="margin-bottom: 5px; text-transform: uppercase;">Lapas Kelas IIB Jombang</h2>
        <p style="margin-top: 0; font-size: 14px;">Tiket Antrian Kunjungan Tatap Muka</p>
        <hr style="margin: 20px 0;">
        <h1 style="font-size: 48px; margin: 10px 0;">
            {{ $kunjungan->registration_type === 'offline' ? 'B' : 'A' }}-{{ str_pad($kunjungan->nomor_antrian_harian, 3, '0', STR_PAD_LEFT) }}
        </h1>
        <p style="font-size: 18px; font-weight: bold; margin-bottom: 20px;">SESI: {{ strtoupper($kunjungan->sesi) }}</p>
        <div style="margin: 20px 0;">
            <img id="qrCodePrint" src="{{ $kunjungan->qr_code_url }}" style="width: 200px; height: 200px;">
        </div>
        <p style="font-family: monospace; font-size: 16px; letter-spacing: 2px;">{{ $kunjungan->qr_token }}</p>
        <div style="text-align: left; margin-top: 30px;">
            <p><strong>Nama Pengunjung:</strong> {{ $kunjungan->nama_pengunjung }}</p>
            <p><strong>Mengunjungi:</strong> {{ $kunjungan->wbp->nama ?? '-' }}</p> 
            <p><strong>Tanggal:</strong> {{ \Carbon\Carbon::parse($kunjungan->tanggal_kunjungan)->translatedFormat('l, d F Y') }}</p>
        </div>
    </div>
</div>

{{-- Hidden Form for Actions --}}
<form id="single-action-form" method="POST" style="display: none;">
    @csrf
    <input type="hidden" name="_method" id="single-action-method">
    <input type="hidden" name="status" id="single-action-status">
    
    {{-- Required For Validation on Controller --}}
    <input type="hidden" name="nama_pengunjung" value="{{ $kunjungan->nama_pengunjung }}">
    <input type="hidden" name="nik_ktp" value="{{ $kunjungan->nik_ktp }}">
    <input type="hidden" name="no_wa_pengunjung" value="{{ $kunjungan->no_wa_pengunjung }}">
    <input type="hidden" name="alamat_pengunjung" value="{{ $kunjungan->alamat_pengunjung }}">
    <input type="hidden" name="hubungan" value="{{ $kunjungan->hubungan }}">
    <input type="hidden" name="wbp_id" value="{{ $kunjungan->wbp_id }}">
</form>

{{-- SCRIPT --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    const swal3DConfig = {
        showClass: { popup: 'animate__animated animate__zoomInDown animate__faster' },
        hideClass: { popup: 'animate__animated animate__zoomOutUp animate__faster' },
        customClass: {
            popup: 'rounded-3xl shadow-2xl border-4 border-white/50 backdrop-blur-xl',
            title: 'text-2xl font-black text-slate-800',
            confirmButton: 'rounded-xl px-6 py-3 font-bold shadow-lg',
            cancelButton: 'rounded-xl px-6 py-3 font-bold shadow-lg bg-slate-200 text-slate-600 hover:bg-slate-300'
        },
        buttonsStyling: false
    };

    function printTicket() {
        const qrImg = document.getElementById('qrCodePrint');
        
        const doPrint = () => {
            const original = document.body.innerHTML;
            const printContent = document.getElementById('printableArea').innerHTML;
            document.body.innerHTML = printContent;
            window.print();
            document.body.innerHTML = original;
            window.location.reload(); 
        };

        if (qrImg.complete) {
            doPrint();
        } else {
            qrImg.onload = doPrint;
            qrImg.onerror = () => {
                console.error('Failed to load QR code for printing');
                doPrint(); // Try anyway
            };
        }
    }

    function confirmSingleAction(url, method, status, name) {
        let title, text, confirmBtnClass;
        if (method === 'DELETE') {
            title = 'Hapus Permanen?';
            text = `Data <b>${name}</b> akan dihapus.`;
            confirmBtnClass = 'bg-red-500 text-white mr-4';
        } else {
            title = status === 'approved' ? 'Setujui Kunjungan?' : 'Tolak Kunjungan?';
            text = `Ubah status kunjungan <b>${name}</b>?`;
            confirmBtnClass = status === 'approved' ? 'bg-emerald-500 text-white mr-4' : 'bg-amber-500 text-white mr-4';
        }

        Swal.fire({
            ...swal3DConfig,
            title: title,
            html: text,
            showCancelButton: true,
            confirmButtonText: 'Ya, Proses',
            cancelButtonText: 'Batal',
            customClass: {
                ...swal3DConfig.customClass,
                confirmButton: swal3DConfig.customClass.confirmButton + ' ' + confirmBtnClass
            }
        }).then((result) => {
            if (result.isConfirmed) {
                const form = document.getElementById('single-action-form');
                form.action = url;
                document.getElementById('single-action-method').value = method;
                document.getElementById('single-action-status').value = status || '';
                form.submit();
            }
        });
    }
</script>
@endsection