@extends('layouts.main')

@php
    use App\Enums\KunjunganStatus;
@endphp

@section('content')
<div class="min-h-screen bg-slate-50 pt-24 pb-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-4xl mx-auto">
        
        {{-- TOMBOL KEMBALI --}}
        <div class="mb-6">
            <a href="/" class="inline-flex items-center text-sm font-medium text-slate-500 hover:text-blue-600 transition-colors">
                <i class="fa-solid fa-arrow-left mr-2"></i> Kembali ke Beranda
            </a>
        </div>

        {{-- KARTU TIKET UTAMA --}}
        <div class="bg-white rounded-3xl shadow-2xl overflow-hidden border border-slate-200">
            
            {{-- 1. HEADER: STATUS & KODE --}}
            <div class="bg-gradient-to-r from-slate-900 to-blue-900 px-6 py-8 text-center relative overflow-hidden">
                {{-- Background Pattern --}}
                <div class="absolute top-0 left-0 w-full h-full opacity-10 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')]"></div>
                
                <div class="relative z-10">
                    <p class="text-blue-200 text-xs font-bold tracking-widest uppercase mb-2">Status Pendaftaran</p>
                    
                    {{-- LOGIC STATUS BADGE --}}
                    <div class="inline-block">
                        @if($kunjungan->status == KunjunganStatus::PENDING)
                            <span class="bg-yellow-400 text-yellow-900 text-sm md:text-base font-bold px-6 py-2 rounded-full shadow-lg flex items-center gap-2 animate-pulse">
                                <i class="fa-solid fa-clock"></i> MENUNGGU VERIFIKASI
                            </span>
                        @elseif($kunjungan->status == KunjunganStatus::APPROVED)
                            <span class="bg-green-500 text-white text-sm md:text-base font-bold px-6 py-2 rounded-full shadow-lg flex items-center gap-2">
                                <i class="fa-solid fa-check-circle"></i> DISETUJUI / SIAP DATANG
                            </span>
                        @elseif($kunjungan->status == KunjunganStatus::REJECTED)
                            <span class="bg-red-500 text-white text-sm md:text-base font-bold px-6 py-2 rounded-full shadow-lg flex items-center gap-2">
                                <i class="fa-solid fa-circle-xmark"></i> DITOLAK
                            </span>
                        @endif
                    </div>

                    <div class="mt-6">
                        <p class="text-slate-400 text-xs uppercase tracking-wider">Kode Registrasi</p>
                        <h1 class="text-3xl md:text-5xl font-mono font-black text-white tracking-widest mt-1">{{ $kunjungan->kode_kunjungan }}</h1>
                    </div>
                </div>
            </div>

            {{-- 2. BODY: INFORMASI DETAIL --}}
            <div class="p-6 md:p-10">
                
                {{-- Alert Sukses (Hanya muncul sekali setelah submit) --}}
                @if(session('success'))
                <div class="mb-8 bg-green-50 border-l-4 border-green-500 p-4 rounded shadow-sm">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <i class="fa-solid fa-check-circle text-green-500 text-xl"></i>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-bold text-green-800">Berhasil Dikirim!</h3>
                            <div class="mt-1 text-sm text-green-700">
                                {{ session('success') }}
                            </div>
                        </div>
                    </div>
                </div>
                @endif

                <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                    
                    {{-- KOLOM KIRI: DATA PENGUNJUNG --}}
                    <div>
                        <div class="flex items-center gap-2 mb-4 border-b pb-2 border-slate-100">
                            <div class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center text-blue-600">
                                <i class="fa-solid fa-user"></i>
                            </div>
                            <h3 class="text-slate-800 font-bold text-lg">Data Pengunjung</h3>
                        </div>

                        <div class="space-y-5">
                            <div>
                                <label class="text-xs font-bold text-slate-400 uppercase block">Nama Lengkap</label>
                                <p class="text-slate-900 font-semibold text-lg">{{ $kunjungan->nama_pengunjung }}</p>
                            </div>
                            
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="text-xs font-bold text-slate-400 uppercase block">NIK (KTP)</label>
                                    <p class="text-slate-700 font-mono">{{ $kunjungan->nik_ktp }}</p>
                                </div>
                                <div>
                                    <label class="text-xs font-bold text-slate-400 uppercase block">Jenis Kelamin</label>
                                    <p class="text-slate-700">{{ $kunjungan->jenis_kelamin }}</p>
                                </div>
                            </div>

                            <div>
                                <label class="text-xs font-bold text-slate-400 uppercase block">Kontak WhatsApp</label>
                                <p class="text-slate-700 flex items-center gap-2">
                                    <i class="fa-brands fa-whatsapp text-green-500"></i> {{ $kunjungan->no_wa_pengunjung }}
                                </p>
                            </div>

                            <div>
                                <label class="text-xs font-bold text-slate-400 uppercase block">Alamat</label>
                                <p class="text-slate-600 text-sm leading-relaxed">{{ $kunjungan->alamat_pengunjung }}</p>
                            </div>

                            {{-- Foto KTP Preview --}}
                            <div>
                                <label class="text-xs font-bold text-slate-400 uppercase block mb-2">Foto KTP</label>
                                <div class="w-32 h-20 bg-slate-100 rounded-lg overflow-hidden border border-slate-200 relative group">
                                    <img src="{{ asset('storage/' . $kunjungan->foto_ktp) }}" alt="KTP" class="w-full h-full object-cover">
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- KOLOM KANAN: DETAIL KUNJUNGAN (TIKET) --}}
                    <div class="bg-slate-50 rounded-2xl p-6 border border-slate-200 relative">
                        {{-- Hiasan Bolongan Tiket --}}
                        <div class="absolute top-1/2 -left-3 w-6 h-6 bg-white rounded-full border-r border-slate-200"></div>
                        <div class="absolute top-1/2 -right-3 w-6 h-6 bg-white rounded-full border-l border-slate-200"></div>

                        <div class="flex items-center gap-2 mb-4 border-b pb-2 border-slate-200">
                            <div class="w-8 h-8 rounded-full bg-yellow-100 flex items-center justify-center text-yellow-600">
                                <i class="fa-solid fa-ticket"></i>
                            </div>
                            <h3 class="text-slate-800 font-bold text-lg">Detail Tiket</h3>
                        </div>

                        {{-- INFO WBP --}}
                        <div class="bg-white p-4 rounded-xl border border-slate-200 shadow-sm mb-6">
                            <label class="text-[10px] font-bold text-yellow-600 uppercase tracking-wider mb-1 block">Mengunjungi WBP:</label>
                            <h4 class="text-slate-900 font-bold text-xl mb-1">{{ $kunjungan->wbp->nama ?? 'Nama WBP Tidak Ditemukan' }}</h4>
                            <div class="flex gap-2 text-xs text-slate-500">
                                <span class="bg-slate-100 px-2 py-1 rounded">Blok: <strong>{{ $kunjungan->wbp->blok ?? '-' }}</strong></span>
                                <span class="bg-slate-100 px-2 py-1 rounded">Kamar: <strong>{{ $kunjungan->wbp->kamar ?? '-' }}</strong></span>
                            </div>
                        </div>

                        {{-- JADWAL --}}
                        <div class="grid grid-cols-2 gap-y-6">
                            <div>
                                <label class="text-xs font-bold text-slate-400 uppercase block">Tanggal Kunjungan</label>
                                <p class="text-slate-900 font-bold">
                                    {{ \Carbon\Carbon::parse($kunjungan->tanggal_kunjungan)->translatedFormat('d F Y') }}
                                </p>
                                <p class="text-sm text-slate-500">{{ \Carbon\Carbon::parse($kunjungan->tanggal_kunjungan)->translatedFormat('l') }}</p>
                            </div>
                            <div>
                                <label class="text-xs font-bold text-slate-400 uppercase block">Sesi / Jam</label>
                                @if($kunjungan->sesi)
                                    <p class="text-slate-900 font-bold capitalize">{{ $kunjungan->sesi }}</p>
                                    <p class="text-xs text-slate-500">
                                        {{ $kunjungan->sesi == 'pagi' ? '08.30 - 11.30' : '13.00 - 14.30' }} WIB
                                    </p>
                                @else
                                    <p class="text-slate-900 font-bold">Sesuai Jadwal</p>
                                @endif
                            </div>
                            <div>
                                <label class="text-xs font-bold text-slate-400 uppercase block">Hubungan</label>
                                <p class="text-slate-900 font-medium">{{ $kunjungan->hubungan }}</p>
                            </div>
                            <div>
                                <label class="text-xs font-bold text-slate-400 uppercase block">Pengikut</label>
                                <p class="text-slate-900 font-medium">
                                   {{ $kunjungan->pengikuts->count() }} Orang
                                </p>
                            </div>
                        </div>

                        {{-- NOMOR ANTRIAN --}}
                        <div class="mt-8 pt-6 border-t border-dashed border-slate-300 text-center">
                            <label class="text-xs font-bold text-slate-400 uppercase tracking-widest block mb-2">Nomor Antrian Anda</label>
                            <div class="text-6xl font-black text-slate-800 tracking-tighter">{{ $kunjungan->nomor_antrian_harian }}</div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- 3. FOOTER: TOMBOL AKSI --}}
            <div class="bg-slate-50 px-6 md:px-10 py-6 border-t border-slate-200 flex flex-col sm:flex-row justify-between items-center gap-4">
                <div class="text-sm text-slate-500 italic flex items-center gap-2">
                    <i class="fa-solid fa-circle-info text-blue-500"></i>
                    <span>Simpan halaman ini untuk cek status atau cetak tiket.</span>
                </div>

                <div class="w-full sm:w-auto flex items-center gap-3">
                    <a href="{{ route('kunjungan.status', $kunjungan->id) }}" class="w-full sm:w-auto bg-white text-slate-700 px-6 py-3 rounded-xl font-bold hover:bg-slate-100 transition flex items-center justify-center gap-2 border border-slate-300">
                        <i class="fa-solid fa-arrows-rotate"></i> Cek Status
                    </a>
                    @if($kunjungan->status == KunjunganStatus::APPROVED)
                        {{-- TOMBOL AKTIF (HIJAU/BIRU) --}}
                        <a href="{{ route('kunjungan.print', $kunjungan->id) }}" target="_blank" class="w-full sm:w-auto bg-gradient-to-r from-blue-600 to-blue-700 text-white px-8 py-3 rounded-xl font-bold hover:shadow-lg hover:scale-105 transition flex items-center justify-center gap-2">
                            <i class="fa-solid fa-print"></i> CETAK TIKET
                        </a>
                    @else
                        {{-- TOMBOL MATI (ABU-ABU) --}}
                        <button disabled class="w-full sm:w-auto bg-slate-200 text-slate-400 px-8 py-3 rounded-xl font-bold cursor-not-allowed flex items-center justify-center gap-2 border border-slate-300">
                            <i class="fa-solid fa-lock"></i> TIKET BELUM TERSEDIA
                        </button>
                    @endif
                </div>
            </div>

        </div>
    </div>
</div>
@endsection