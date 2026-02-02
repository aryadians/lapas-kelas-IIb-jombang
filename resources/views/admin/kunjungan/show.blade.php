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
    <header class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 animate__animated animate__fadeInDown">
        <div>
            <h1 class="text-3xl sm:text-4xl font-extrabold text-gradient">
                Detail Kunjungan
            </h1>
            <p class="text-slate-500 mt-2 font-medium">Informasi lengkap & tiket antrian.</p>
        </div>
        <div class="flex gap-3">
            <a href="{{ route('admin.kunjungan.index') }}" class="group inline-flex items-center gap-2 bg-white text-slate-600 font-bold py-3 px-6 rounded-2xl shadow-sm border border-slate-200 hover:border-slate-300 hover:bg-slate-50 transition-all active:scale-95">
                <i class="fas fa-arrow-left text-slate-400 group-hover:text-slate-600 transition-colors"></i>
                <span>Kembali</span>
            </a>
        </div>
    </header>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 animate__animated animate__fadeInUp delay-100">

        {{-- KOLOM KIRI: STATUS & TIKET --}}
        <div class="lg:col-span-1 space-y-8">
            
            {{-- CARD STATUS (Highlight) --}}
            <div class="card-3d relative overflow-hidden rounded-[2rem] shadow-xl animate__animated animate__fadeInLeft">
                {{-- Background Gradient --}}
                <div class="absolute inset-0 
                    @if($kunjungan->status == KunjunganStatus::APPROVED) bg-gradient-to-br from-emerald-500 to-teal-600
                    @elseif($kunjungan->status == KunjunganStatus::REJECTED) bg-gradient-to-br from-red-500 to-rose-600
                    @else bg-gradient-to-br from-amber-400 to-orange-500
                    @endif opacity-100"></div>
                
                {{-- Decorative Patterns --}}
                <div class="absolute top-0 right-0 w-64 h-64 bg-white opacity-10 rounded-full blur-3xl -mr-16 -mt-16"></div>

                <div class="relative z-10 p-8 text-center text-white">
                    {{-- Status Icon --}}
                    <div class="w-24 h-24 mx-auto bg-white/20 backdrop-blur-md rounded-full flex items-center justify-center mb-6 shadow-lg border border-white/30 animate__animated animate__zoomIn">
                        @if($kunjungan->status == KunjunganStatus::APPROVED)
                            <i class="fas fa-check text-5xl drop-shadow-md"></i>
                        @elseif($kunjungan->status == KunjunganStatus::REJECTED)
                            <i class="fas fa-times text-5xl drop-shadow-md"></i>
                        @else
                            <i class="fas fa-hourglass-half text-5xl drop-shadow-md"></i>
                        @endif
                    </div>
                    
                    <h2 class="text-xs font-bold uppercase tracking-[0.2em] opacity-80 mb-2">Status Saat Ini</h2>
                    <h3 class="text-3xl font-black tracking-tight mb-2 drop-shadow-sm">
                        @if($kunjungan->status == KunjunganStatus::APPROVED) DISETUJUI
                        @elseif($kunjungan->status == KunjunganStatus::REJECTED) DITOLAK
                        @else MENUNGGU
                        @endif
                    </h3>
                    <p class="text-sm font-medium opacity-90 bg-black/10 inline-block px-3 py-1 rounded-full">
                        Update: {{ $kunjungan->updated_at->diffForHumans() }}
                    </p>
                </div>

                {{-- Action Buttons (Pending) --}}
                @if($kunjungan->status == KunjunganStatus::PENDING)
                <div class="relative z-10 bg-white/95 backdrop-blur-xl p-4 flex gap-3 justify-center border-t border-white/20">
                    <button onclick="confirmSingleAction('{{ route('admin.kunjungan.update', $kunjungan->id) }}', 'PATCH', 'approved', '{{ $kunjungan->nama_pengunjung }}')" 
                        class="flex-1 inline-flex justify-center items-center gap-2 px-4 py-3 bg-emerald-500 hover:bg-emerald-600 text-white font-bold rounded-xl transition-all shadow-lg active:scale-95">
                        <i class="fas fa-check"></i> Terima
                    </button>
                    <button onclick="confirmSingleAction('{{ route('admin.kunjungan.update', $kunjungan->id) }}', 'PATCH', 'rejected', '{{ $kunjungan->nama_pengunjung }}')" 
                        class="flex-1 inline-flex justify-center items-center gap-2 px-4 py-3 bg-red-500 hover:bg-red-600 text-white font-bold rounded-xl transition-all shadow-lg active:scale-95">
                        <i class="fas fa-times"></i> Tolak
                    </button>
                </div>
                @endif
            </div>

            {{-- CARD QR CODE & TIKET --}}
            @if($kunjungan->status == KunjunganStatus::APPROVED && $kunjungan->qr_token)
            <div id="ticketCard" class="card-3d bg-white rounded-[2rem] shadow-lg border border-slate-100 overflow-hidden animate__animated animate__fadeInUp delay-200">
                <div class="glass-header p-5 flex items-center gap-4 bg-slate-50/50">
                    <div class="w-12 h-12 rounded-xl bg-slate-900 flex items-center justify-center text-white shadow-md">
                        <i class="fas fa-qrcode text-xl"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-slate-800">Tiket Kunjungan</h3>
                        <p class="text-slate-500 text-xs font-medium">Scan untuk verifikasi masuk.</p>
                    </div>
                </div>
                
                <div class="p-8 flex flex-col items-center">
                    {{-- QR Code Image --}}
                    <div class="bg-white p-4 rounded-2xl border-2 border-dashed border-slate-300 shadow-sm mb-6 relative group">
                        <img src="https://api.qrserver.com/v1/create-qr-code/?size=200x200&data={{ $kunjungan->qr_token }}&bgcolor=ffffff" 
                             alt="QR Code" 
                             class="w-48 h-48 object-contain transition-transform group-hover:scale-105 duration-300">
                    </div>

                    <div class="text-center mb-6">
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-1">Kode Token</p>
                        <code class="text-2xl font-mono font-black text-slate-800 tracking-wider bg-slate-100 px-4 py-2 rounded-lg border border-slate-200 select-all">
                            {{ $kunjungan->qr_token }}
                        </code>
                    </div>

                    <button onclick="printTicket()" class="w-full py-4 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-xl shadow-lg shadow-blue-200 transition-all active:scale-95 flex items-center justify-center gap-2">
                        <i class="fas fa-print"></i> Cetak Tiket Antrian
                    </button>
                </div>
            </div>
            @endif
        </div>

        {{-- KOLOM TENGAH & KANAN: DETAIL DATA --}}
        <div class="lg:col-span-2 space-y-8 animate__animated animate__fadeInRight delay-200">
            
            {{-- CARD 1: INFORMASI JADWAL --}}
            <div class="card-3d bg-white rounded-[2rem] shadow-lg border border-slate-100 overflow-hidden relative">
                <div class="glass-header p-6 relative z-10">
                    <div class="flex items-center gap-4">
                        <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center text-white shadow-lg shadow-blue-200">
                            <i class="fas fa-calendar-check text-2xl"></i>
                        </div>
                        <div>
                            <h3 class="text-xl font-extrabold text-slate-800">Jadwal & Antrian</h3>
                            <p class="text-slate-500 text-sm font-medium">Detail waktu pelaksanaan kunjungan.</p>
                        </div>
                    </div>
                </div>

                <div class="p-8 relative z-10">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        {{-- Tanggal --}}
                        <div class="bg-slate-50 p-6 rounded-2xl border border-slate-200 shadow-sm">
                            <p class="data-label"><i class="far fa-calendar-alt mr-1.5 text-blue-500"></i> Tanggal Kunjungan</p>
                            <p class="text-2xl font-black text-slate-800 tracking-tight">
                                {{ \Carbon\Carbon::parse($kunjungan->tanggal_kunjungan)->translatedFormat('l, d F Y') }}
                            </p>
                        </div>

                        {{-- Sesi & Antrian --}}
                        <div class="bg-slate-50 p-6 rounded-2xl border border-slate-200 shadow-sm flex flex-col justify-center">
                            <p class="data-label mb-3"><i class="far fa-clock mr-1.5 text-purple-500"></i> Sesi & Nomor Antrian</p>
                            <div class="flex items-center gap-3">
                                {{-- Badge Sesi --}}
                                <div class="px-4 py-2 rounded-xl bg-white border border-purple-200 shadow-sm flex items-center gap-2">
                                    <div class="w-2 h-2 rounded-full bg-purple-500 animate-pulse"></div>
                                    <span class="text-sm font-bold text-slate-700 uppercase tracking-wide">{{ $kunjungan->sesi ?? '-' }}</span>
                                </div>
                                
                                {{-- Badge Antrian --}}
                                @if($kunjungan->nomor_antrian_harian)
                                <div class="px-5 py-2 rounded-xl bg-gradient-to-r from-blue-600 to-indigo-600 text-white shadow-md flex items-center gap-2">
                                    <i class="fas fa-list-ol text-xs opacity-80"></i>
                                    <span class="text-lg font-black tracking-tight">No. {{ $kunjungan->nomor_antrian_harian }}</span>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- CARD 2: DATA PENGUNJUNG & WBP --}}
            <div class="card-3d bg-white rounded-[2rem] shadow-lg border border-slate-100 overflow-hidden">
                <div class="glass-header p-6 flex items-center gap-4 bg-slate-50/50">
                    <div class="w-12 h-12 rounded-xl bg-white border border-slate-200 flex items-center justify-center text-slate-700 shadow-sm">
                        <i class="fas fa-address-card text-xl"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-slate-800">Identitas Lengkap</h3>
                        <p class="text-slate-500 text-xs">Data pengunjung dan warga binaan.</p>
                    </div>
                </div>

                <div class="p-8 grid grid-cols-1 md:grid-cols-2 gap-x-10 gap-y-8">
                    {{-- Pengunjung --}}
                    <div class="space-y-6">
                        <div class="border-b border-slate-100 pb-2 mb-4">
                            <h4 class="text-sm font-bold text-blue-600 uppercase tracking-widest">Data Pengunjung</h4>
                        </div>
                        <div><p class="data-label">Nama Lengkap</p><p class="data-value">{{ $kunjungan->nama_pengunjung }}</p></div>
                        
                        <div><p class="data-label">NIK</p><p class="data-value font-mono bg-slate-100 px-2 rounded inline-block text-sm">{{ $kunjungan->nik_ktp }}</p></div>
                        <div>
                            <p class="data-label">Kontak</p>
                            <div class="flex flex-col gap-1">
                                <span class="data-value text-sm flex items-center gap-2"><i class="fab fa-whatsapp text-green-500"></i> {{ $kunjungan->no_wa_pengunjung }}</span>
                            </div>
                        </div>
                        
                        <div><p class="data-label">Alamat</p><p class="data-value text-sm text-slate-600 leading-relaxed">{{ $kunjungan->alamat_pengunjung }}</p></div>
                        
                        {{-- FOTO KTP (Base64 Logic) --}}
                        @if(!empty($kunjungan->foto_ktp))
                        <div>
                            <p class="data-label">Foto KTP</p>
                            <div class="relative group">
                                <a href="{{ $kunjungan->foto_ktp }}" target="_blank" class="block w-full">
                                    <img src="{{ $kunjungan->foto_ktp }}" loading="lazy" class="w-full h-32 object-cover rounded-lg border border-slate-200 hover:opacity-90 transition shadow-sm">
                                </a>
                                <div class="mt-2 text-center">
                                    <a href="{{ $kunjungan->foto_ktp }}" download="KTP_{{ $kunjungan->nama_pengunjung }}.png" class="text-xs text-blue-600 font-bold hover:underline flex items-center justify-center gap-1">
                                        <i class="fas fa-download"></i> Download KTP
                                    </a>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>

                    {{-- WBP --}}
                    <div class="space-y-6">
                        <div class="border-b border-slate-100 pb-2 mb-4">
                            <h4 class="text-sm font-bold text-purple-600 uppercase tracking-widest">Data Warga Binaan</h4>
                        </div>
                        <div><p class="data-label">Nama WBP Dituju</p><p class="data-value text-lg">{{ $kunjungan->wbp->nama ?? 'Data Terhapus' }}</p></div>
                        <div><p class="data-label">Hubungan</p><span class="inline-flex items-center px-3 py-1 rounded-lg bg-slate-100 text-slate-700 text-sm font-bold border border-slate-200">{{ $kunjungan->hubungan }}</span></div>
                    </div>
                </div>
            </div>

            {{-- CARD 3: DATA PENGIKUT --}}
            <div class="card-3d bg-white rounded-[2rem] shadow-lg border border-slate-100 overflow-hidden">
                <div class="glass-header p-6 flex items-center gap-4 bg-slate-50/50">
                    <div class="w-12 h-12 rounded-xl bg-white border border-slate-200 flex items-center justify-center text-slate-700 shadow-sm">
                        <i class="fas fa-users text-xl"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-slate-800">Daftar Pengikut</h3>
                        <p class="text-slate-500 text-xs">Orang yang menyertai kunjungan.</p>
                    </div>
                </div>

                <div class="p-8">
                    @if($kunjungan->pengikuts && $kunjungan->pengikuts->count() > 0)
                        <div class="space-y-4">
                            @foreach($kunjungan->pengikuts as $pengikut)
                            <div class="flex items-start gap-4 p-4 bg-slate-50 rounded-xl border border-slate-200">
                                {{-- Foto Pengikut --}}
                                <div class="flex-shrink-0">
                                    @if(!empty($pengikut->foto_ktp))
                                        <a href="{{ $pengikut->foto_ktp }}" target="_blank">
                                            <img src="{{ $pengikut->foto_ktp }}" loading="lazy" class="w-12 h-12 rounded-full object-cover border border-slate-300 shadow-sm hover:scale-110 transition-transform">
                                        </a>
                                    @else
                                        <div class="w-12 h-12 rounded-full bg-slate-200 flex items-center justify-center text-slate-400">
                                            <i class="fas fa-user"></i>
                                        </div>
                                    @endif
                                </div>
                                <div class="flex-grow">
                                    <h4 class="font-bold text-slate-800">{{ $pengikut->nama }}</h4>
                                    <p class="text-xs text-slate-500">NIK: {{ $pengikut->nik ?? '-' }}</p>
                                    <div class="flex gap-2 mt-1">
                                        <span class="text-[10px] bg-blue-100 text-blue-700 px-2 py-0.5 rounded font-bold">{{ $pengikut->hubungan }}</span>
                                        @if($pengikut->barang_bawaan)
                                        <span class="text-[10px] bg-emerald-100 text-emerald-700 px-2 py-0.5 rounded font-bold">
                                            <i class="fas fa-shopping-bag mr-1"></i> {{ $pengikut->barang_bawaan }}
                                        </span>
                                        @endif
                                    </div>
                                    @if(!empty($pengikut->foto_ktp))
                                    <a href="{{ $pengikut->foto_ktp }}" download="Pengikut_{{ $pengikut->nama }}.png" class="text-[10px] text-blue-600 hover:underline mt-1 block">
                                        Download KTP
                                    </a>
                                    @endif
                                </div>
                            </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-6">
                            <p class="text-slate-400 text-sm italic">Tidak ada pengikut tambahan.</p>
                        </div>
                    @endif
                </div>
                
                <div class="bg-slate-50 p-4 text-right border-t border-slate-100">
                    <button onclick="confirmSingleAction('{{ route('admin.kunjungan.destroy', $kunjungan->id) }}', 'DELETE', null, '{{ $kunjungan->nama_pengunjung }}')" 
                        class="inline-flex items-center gap-2 px-4 py-2 text-red-600 hover:text-red-700 hover:bg-red-50 rounded-lg transition-all font-bold text-sm">
                        <i class="fas fa-trash-alt"></i> Hapus Data Kunjungan
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
        <h1 style="font-size: 48px; margin: 10px 0;">#{{ $kunjungan->nomor_antrian_harian }}</h1>
        <p style="font-size: 18px; font-weight: bold; margin-bottom: 20px;">SESI: {{ strtoupper($kunjungan->sesi) }}</p>
        <div style="margin: 20px 0;">
            <img src="https://api.qrserver.com/v1/create-qr-code/?size=250x250&data={{ $kunjungan->qr_token }}" style="width: 200px; height: 200px;">
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
        const original = document.body.innerHTML;
        const printContent = document.getElementById('printableArea').innerHTML;
        document.body.innerHTML = printContent;
        window.print();
        document.body.innerHTML = original;
        window.location.reload(); 
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