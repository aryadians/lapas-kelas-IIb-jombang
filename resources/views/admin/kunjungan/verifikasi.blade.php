@extends('layouts.admin')

@section('title', 'Verifikasi Kunjungan')

@section('content')
{{-- Load Libraries --}}
<script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>

<style>
    /* 3D Card Effect */
    .card-3d {
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        transform-style: preserve-3d;
        backface-visibility: hidden;
    }
    .card-3d:hover {
        transform: translateY(-5px) scale(1.01);
        box-shadow: 0 20px 30px -10px rgba(0, 0, 0, 0.15);
        z-index: 10;
    }
    
    .text-gradient {
        background-clip: text;
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-image: linear-gradient(to right, #1e293b, #2563eb);
    }

    .glass-panel {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(12px);
        border: 1px solid rgba(255, 255, 255, 0.6);
        box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.05);
    }

    /* Laser Scanner Animation */
    .scanner-laser {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 3px;
        background: #ef4444;
        box-shadow: 0 0 15px #ef4444;
        animation: scanning 2s infinite ease-in-out;
        opacity: 0.8;
        z-index: 50;
    }
    @keyframes scanning {
        0% { top: 10%; opacity: 0; }
        50% { opacity: 1; }
        100% { top: 90%; opacity: 0; }
    }

    /* FIX: Mencegah Kamera Mirror */
    #qr-reader video {
        transform: scaleX(1) !important; 
        object-fit: cover !important;
        border-radius: 1rem;
    }
</style>

<div class="space-y-8 pb-12 perspective-1000">

    {{-- HEADER --}}
    <header class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 animate__animated animate__fadeInDown">
        <div>
            <h1 class="text-4xl font-extrabold text-gradient">
                Verifikasi Kunjungan
            </h1>
            <p class="text-slate-500 mt-2 font-medium">Validasi data pengunjung melalui Token atau QR Code.</p>
        </div>
        <a href="{{ route('admin.kunjungan.index') }}" class="group inline-flex items-center gap-2 bg-white text-slate-600 font-bold py-3 px-6 rounded-xl shadow-sm border border-slate-200 hover:border-slate-300 hover:bg-slate-50 transition-all active:scale-95">
            <i class="fas fa-arrow-left text-slate-400 group-hover:text-slate-600 transition-colors"></i>
            <span>Kembali</span>
        </a>
    </header>

    {{-- VERIFICATION FORM AND SCANNER --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        
        {{-- Manual Token Input --}}
        <div class="card-3d bg-white rounded-3xl shadow-xl border border-slate-100 p-8 flex flex-col justify-center animate__animated animate__fadeInLeft">
            <div class="flex items-center gap-4 mb-6">
                <div class="w-12 h-12 bg-blue-100 rounded-2xl flex items-center justify-center text-blue-600 shadow-inner">
                    <i class="fas fa-keyboard text-xl"></i>
                </div>
                <div>
                    <h2 class="text-2xl font-bold text-slate-800">Input Token Manual</h2>
                    <p class="text-slate-500 text-sm">Masukkan kode unik yang tertera pada bukti pendaftaran.</p>
                </div>
            </div>

            {{-- FORM MANUAL (Digunakan juga oleh scanner) --}}
            <form id="verification-form" action="{{ route('admin.kunjungan.verifikasi.submit') }}" method="POST">
                @csrf
                <div class="space-y-5">
                    <div>
                        <label for="qr_token" class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-2 block">Token Kode QR</label>
                        <div class="relative group">
                            <i class="fas fa-ticket-alt absolute left-4 top-4 text-slate-400 group-focus-within:text-blue-500 transition-colors"></i>
                            <input type="text" name="qr_token" id="qr_token" class="w-full pl-12 pr-4 py-3.5 border-2 border-slate-200 rounded-xl bg-slate-50 focus:bg-white focus:outline-none focus:border-blue-500 focus:ring-4 focus:ring-blue-100 transition-all text-lg font-mono font-bold tracking-widest text-slate-700 placeholder-slate-300 uppercase" placeholder="CONTOH: ABC-123" value="{{ request('qr_token') }}" required autofocus>
                        </div>
                    </div>
                    <button type="submit" class="w-full inline-flex items-center justify-center gap-2 px-6 py-4 font-bold rounded-xl text-white bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 focus:outline-none focus:ring-4 focus:ring-blue-200 transition-all shadow-lg hover:shadow-xl active:scale-95">
                        <i class="fas fa-search"></i>
                        <span>Cek Validitas Token</span>
                    </button>
                </div>
            </form>
        </div>

        {{-- QR Code Scanner --}}
        <div class="card-3d bg-slate-900 rounded-3xl shadow-2xl border border-slate-800 p-8 flex flex-col items-center justify-center text-center relative overflow-hidden animate__animated animate__fadeInRight">
            
            {{-- Background Decoration --}}
            <div class="absolute top-0 right-0 w-64 h-64 bg-blue-500 rounded-full mix-blend-overlay filter blur-3xl opacity-10 -mr-16 -mt-16"></div>
            <div class="absolute bottom-0 left-0 w-64 h-64 bg-purple-500 rounded-full mix-blend-overlay filter blur-3xl opacity-10 -ml-16 -mb-16"></div>

            <h2 class="text-2xl font-bold text-white mb-2 relative z-10">Pindai QR Code</h2>
            <p class="text-slate-400 mb-6 text-sm relative z-10">Arahkan kamera ke kode QR pengunjung.</p>
            
            {{-- Scanner Area --}}
            <div class="relative w-full max-w-sm rounded-2xl overflow-hidden border-4 border-slate-700 bg-black shadow-2xl">
                {{-- Container for Library --}}
                <div id="qr-reader" class="w-full h-full min-h-[300px] bg-black"></div>

                {{-- Placeholder Image (Initial State) --}}
                <div id="scanner-placeholder" class="absolute inset-0 flex flex-col items-center justify-center bg-slate-800 z-30">
                    <i class="fas fa-camera text-5xl text-slate-600 mb-4 animate-pulse"></i>
                    <button type="button" id="start-scan-btn" class="px-6 py-3 bg-blue-600 hover:bg-blue-500 text-white rounded-xl font-bold text-sm transition-all shadow-lg hover:shadow-blue-500/50 flex items-center gap-2">
                        <i class="fas fa-power-off"></i> Aktifkan Kamera
                    </button>
                </div>
                
                {{-- Laser Animation --}}
                <div id="scanner-laser" class="hidden scanner-laser"></div>
            </div>
        </div>
    </div>

    {{-- HASIL VERIFIKASI (LOGIKA DIPERBAIKI) --}}
    @if(isset($status_verifikasi))
        <div class="mt-12 animate__animated animate__bounceInUp">
            
            @if($status_verifikasi == 'success' && $kunjungan)
                {{-- ✅ HASIL: DATA DITEMUKAN --}}
                <div class="glass-panel rounded-3xl p-8 border-l-8 border-emerald-500 relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-40 h-40 bg-emerald-100 rounded-full mix-blend-multiply filter blur-2xl opacity-50 -mr-10 -mt-10"></div>
                    
                    <div class="flex flex-col md:flex-row items-start gap-8 relative z-10">
                        <div class="flex-shrink-0 bg-emerald-100 w-24 h-24 rounded-full flex items-center justify-center border-4 border-white shadow-xl">
                            <i class="fas fa-check text-5xl text-emerald-600"></i>
                        </div>
                        
                        <div class="flex-grow w-full">
                            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-6">
                                <div>
                                    <h3 class="text-3xl font-black text-slate-800">Data Valid & Ditemukan</h3>
                                    <p class="text-emerald-600 font-bold mt-1">Kode QR Terverifikasi</p>
                                </div>
                                <div class="flex flex-col items-end">
                                    @if($kunjungan->status == 'approved')
                                        <span class="px-5 py-2 rounded-xl bg-emerald-500 text-white font-bold shadow-lg shadow-emerald-500/30 flex items-center gap-2">
                                            <i class="fas fa-check-circle"></i> DISETUJUI
                                        </span>
                                    @elseif($kunjungan->status == 'rejected')
                                        <span class="px-5 py-2 rounded-xl bg-red-500 text-white font-bold shadow-lg shadow-red-500/30 flex items-center gap-2">
                                            <i class="fas fa-times-circle"></i> DITOLAK
                                        </span>
                                    @else
                                        <span class="px-5 py-2 rounded-xl bg-amber-500 text-white font-bold shadow-lg shadow-amber-500/30 flex items-center gap-2">
                                            <i class="fas fa-clock"></i> MENUNGGU
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="bg-white/60 rounded-2xl p-6 border border-slate-200 shadow-inner grid grid-cols-1 md:grid-cols-2 gap-x-12 gap-y-6">
                                <div class="space-y-4">
                                    <div class="flex justify-between border-b border-slate-200 pb-2">
                                        <span class="text-slate-500 font-medium">Nama Pengunjung</span>
                                        <span class="font-bold text-slate-800 text-lg">{{ $kunjungan->nama_pengunjung }}</span>
                                    </div>
                                    <div class="flex justify-between border-b border-slate-200 pb-2">
                                        <span class="text-slate-500 font-medium">NIK</span>
                                        {{-- UPDATED --}}
                                        <span class="font-mono font-bold text-slate-700">{{ $kunjungan->nik_ktp }}</span>
                                    </div>
                                </div>
                                <div class="space-y-4">
                                    <div class="flex justify-between border-b border-slate-200 pb-2">
                                        <span class="text-slate-500 font-medium">Mengunjungi WBP</span>
                                        {{-- UPDATED --}}
                                        <span class="font-bold text-slate-800 text-lg">{{ $kunjungan->wbp->nama ?? '-' }}</span>
                                    </div>
                                    <div class="flex justify-between border-b border-slate-200 pb-2">
                                        <span class="text-slate-500 font-medium">Jadwal</span>
                                        <span class="font-bold text-blue-600">{{ \Carbon\Carbon::parse($kunjungan->tanggal_kunjungan)->translatedFormat('l, d F Y') }}</span>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="mt-6 flex justify-end">
                                <a href="{{ route('admin.kunjungan.show', $kunjungan->id) }}" class="inline-flex items-center gap-2 px-6 py-3 bg-slate-800 hover:bg-slate-900 text-white rounded-xl font-bold shadow-lg transition-all">
                                    Lihat Detail & Cetak Tiket <i class="fas fa-arrow-right"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

            @else
                {{-- ❌ HASIL: DATA TIDAK DITEMUKAN --}}
                <div class="glass-panel rounded-3xl p-8 border-l-8 border-red-500 relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-40 h-40 bg-red-100 rounded-full mix-blend-multiply filter blur-2xl opacity-50 -mr-10 -mt-10"></div>
                    
                    <div class="flex items-center gap-8 relative z-10">
                        <div class="flex-shrink-0 bg-red-100 w-24 h-24 rounded-full flex items-center justify-center border-4 border-white shadow-xl animate__animated animate__shakeX">
                            <i class="fas fa-times text-5xl text-red-500"></i>
                        </div>
                        <div>
                            <h3 class="text-3xl font-black text-slate-800">Token Tidak Valid</h3>
                            <p class="text-red-600 font-medium mt-1">Data tidak ditemukan di database.</p>
                            <p class="text-slate-500 mt-2 max-w-xl">
                                Token: <span class="font-mono font-bold bg-red-50 px-2 rounded">{{ request('qr_token') }}</span><br>
                                Mohon pastikan kode QR yang dipindai adalah kode resmi dari tiket pendaftaran.
                            </p>
                            
                            <a href="{{ route('admin.kunjungan.verifikasi') }}" class="mt-6 inline-flex items-center gap-2 px-6 py-3 bg-slate-800 text-white rounded-xl font-bold hover:bg-slate-900 transition-all shadow-lg">
                                <i class="fas fa-redo"></i> Reset Pencarian
                            </a>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    @endif
</div>

{{-- QR SCANNER SCRIPT --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const startBtn = document.getElementById('start-scan-btn');
        const scannerPlaceholder = document.getElementById('scanner-placeholder');
        const scannerLaser = document.getElementById('scanner-laser');
        const tokenInput = document.getElementById('qr_token'); // Mengarah ke input form manual
        const verificationForm = document.getElementById('verification-form'); // Mengarah ke form manual
        let html5QrcodeScanner = null;

        // Cek Keamanan
        function isSecureOrigin() {
            return window.location.protocol === 'https:' || 
                   window.location.hostname === 'localhost' || 
                   window.location.hostname === '127.0.0.1';
        }

        if (startBtn) {
            startBtn.addEventListener('click', function() {
                if (!isSecureOrigin()) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Koneksi Tidak Aman',
                        text: 'Kamera memerlukan HTTPS atau Localhost.',
                        customClass: { confirmButton: 'bg-blue-600 text-white px-6 py-2 rounded-lg' }
                    });
                    return;
                }

                // UI Updates
                scannerPlaceholder.classList.add('hidden');
                scannerLaser.classList.remove('hidden');

                // Init Library
                html5QrcodeScanner = new Html5Qrcode("qr-reader");

                // Cek Kamera
                Html5Qrcode.getCameras().then(devices => {
                    if (devices && devices.length) {
                        let cameraId = devices[0].id;
                        // Prioritaskan kamera belakang
                        const backCamera = devices.find(d => d.label.toLowerCase().includes('back') || d.label.toLowerCase().includes('environment') || d.label.toLowerCase().includes('belakang'));
                        if(backCamera) cameraId = backCamera.id;

                        // Start Scanning
                        html5QrcodeScanner.start(
                            cameraId, 
                            { 
                                fps: 15, 
                                qrbox: { width: 250, height: 250 },
                                aspectRatio: 1.0 
                            },
                            onScanSuccess,
                            onScanFailure
                        ).catch(err => {
                            console.error("Error start:", err);
                            showError("Gagal Membuka Kamera", "Izin kamera diperlukan.");
                        });
                    } else {
                        showError("Kamera Tidak Ditemukan", "Tidak ada perangkat kamera terdeteksi.");
                    }
                }).catch(err => {
                    showError("Izin Ditolak", "Izinkan akses kamera di browser Anda.");
                });
            });
        }

        function showError(title, text) {
            Swal.fire({ icon: 'error', title: title, text: text });
            scannerPlaceholder.classList.remove('hidden');
            scannerLaser.classList.add('hidden');
        }

        function onScanSuccess(decodedText, decodedResult) {
            console.log("QR Terbaca:", decodedText);
            
            // 1. Masukkan hasil ke input manual (Agar user bisa lihat apa yang terscan)
            tokenInput.value = decodedText.trim(); // Trim spasi
            
            // 2. Beri efek visual pada input
            tokenInput.style.backgroundColor = "#d1fae5"; // Hijau muda
            tokenInput.style.borderColor = "#10b981"; // Hijau

            // 3. Stop Scanner
            html5QrcodeScanner.stop().then(() => {
                // 4. Tampilkan Loading & Submit
                Swal.fire({
                    title: 'QR Code Terbaca!',
                    text: 'Memverifikasi data...',
                    timer: 800,
                    showConfirmButton: false,
                    didOpen: () => {
                        Swal.showLoading();
                        // 5. Submit Form Manual (Cara paling aman)
                        setTimeout(() => { verificationForm.submit(); }, 300);
                    }
                });
            }).catch(err => {
                // Jika gagal stop, paksa submit saja
                verificationForm.submit();
            });
        }

        function onScanFailure(error) {
            // Biarkan scanning berjalan terus
        }
    });
</script>
@endsection