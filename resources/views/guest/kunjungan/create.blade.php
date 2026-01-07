@extends('layouts.main')

@section('content')
{{-- Style Tambahan untuk Autocomplete Dropdown --}}
<style>
    .search-results {
        position: absolute;
        background: white;
        width: 100%;
        z-index: 50;
        border-radius: 0.75rem;
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        max-height: 250px;
        overflow-y: auto;
        display: none;
        border: 1px solid #e2e8f0;
        margin-top: 0.5rem;
    }
    .search-item {
        padding: 0.75rem 1rem;
        cursor: pointer;
        border-bottom: 1px solid #f1f5f9;
        transition: all 0.2s;
    }
    .search-item:last-child { border-bottom: none; }
    .search-item:hover { background-color: #fef9c3; color: #854d0e; }
</style>

{{-- WRAPPER UTAMA DENGAN STATE ALPINE JS --}}
<div x-data="{ showForm: {{ session('errors') && $errors->any() ? 'true' : 'false' }} }" class="bg-slate-50 min-h-screen pb-20">

    {{-- ============================================================== --}}
    {{-- BAGIAN 1: INFORMASI & TATA TERTIB (Muncul Awal) --}}
    {{-- ============================================================== --}}
    <div x-show="!showForm"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 translate-y-4"
        x-transition:enter-end="opacity-100 translate-y-0">

        {{-- HEADER: JUDUL BESAR --}}
        <div class="bg-gradient-to-br from-blue-950 via-blue-900 to-blue-800 pt-16 pb-24 px-4 relative overflow-hidden">
            <div class="absolute top-0 right-0 -mr-20 -mt-20 w-80 h-80 rounded-full bg-gradient-to-br from-yellow-500 to-yellow-600 opacity-15 blur-3xl animate-pulse"></div>
            <div class="absolute bottom-0 left-0 -ml-20 -mb-20 w-80 h-80 rounded-full bg-gradient-to-br from-gray-400 to-gray-600 opacity-10 blur-3xl"></div>
            <div class="max-w-7xl mx-auto text-center relative z-10">
                <div class="inline-flex items-center gap-2 bg-yellow-500 bg-opacity-20 text-yellow-400 font-bold tracking-widest uppercase text-sm mb-4 px-4 py-2 rounded-full border border-yellow-400 border-opacity-30">
                    <i class="fa-solid fa-gavel"></i>
                    <span>Layanan Publik</span>
                </div>
                <h1 class="text-4xl md:text-6xl font-extrabold text-white mb-6 leading-tight drop-shadow-lg">
                    Pendaftaran Kunjungan <span class="animate-text-shimmer bg-gradient-to-r from-yellow-400 to-yellow-300 bg-clip-text text-transparent">Tatap Muka</span>
                </h1>
                <p class="text-gray-200 max-w-4xl mx-auto text-lg leading-relaxed drop-shadow-sm">
                    Mohon pelajari <strong class="text-yellow-300 underline decoration-yellow-400">Jadwal</strong>, <strong class="text-yellow-300 underline decoration-yellow-400">Alur Layanan</strong>, dan <strong class="text-yellow-300 underline decoration-yellow-400">Ketentuan Barang</strong> di bawah ini sebelum mengisi formulir pendaftaran demi kelancaran kunjungan Anda.
                </p>
                <div class="mt-8 flex justify-center gap-4">
                    <div class="bg-white bg-opacity-10 backdrop-blur-sm border border-white border-opacity-20 px-4 py-2 rounded-full text-white text-sm font-medium">
                        <i class="fa-solid fa-shield-alt mr-2"></i> Aman & Terpercaya
                    </div>
                    <div class="bg-white bg-opacity-10 backdrop-blur-sm border border-white border-opacity-20 px-4 py-2 rounded-full text-white text-sm font-medium">
                        <i class="fa-solid fa-clock mr-2"></i> Proses Cepat
                    </div>
                </div>
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 -mt-16 relative z-20">

            {{-- BADGE RESMI KEMENTERIAN --}}
            <div class="text-center mb-8">
                <div class="inline-flex items-center gap-3 bg-gradient-to-r from-blue-950 to-blue-900 text-yellow-400 px-6 py-3 rounded-full font-bold text-sm shadow-2xl border-2 border-yellow-500 border-opacity-50">
                    <i class="fa-solid fa-landmark text-lg"></i>
                    KEMENTERIAN IMIGRASI DAN PEMASYARAKATAN RI
                    <i class="fa-solid fa-scale-balanced text-lg"></i>
                </div>
            </div>

            {{-- 1. JADWAL & KUOTA --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">
                {{-- (Konten Card Jadwal tetap sama seperti kode asli) --}}
                <div class="bg-white rounded-2xl shadow-2xl p-6 border-t-4 border-blue-600 flex flex-col h-full card-hover-scale transition-all duration-300 hover:shadow-blue-500/20">
                    <div class="flex items-center gap-4 mb-6">
                        <div class="w-14 h-14 flex-shrink-0 flex items-center justify-center bg-gradient-to-br from-blue-100 to-blue-200 rounded-full text-blue-600 shadow-lg">
                            <i class="fa-solid fa-clock text-2xl"></i>
                        </div>
                        <div>
                            <h3 class="font-bold text-xl text-slate-800">Waktu Layanan</h3>
                            <p class="text-xs text-slate-500">Jam Operasional</p>
                        </div>
                    </div>
                    <div class="space-y-4 flex-grow">
                        <div class="bg-gradient-to-r from-blue-50 to-blue-100 p-4 rounded-lg border-l-4 border-blue-500 hover:shadow-md transition-all duration-300 hover:from-blue-100 hover:to-blue-200">
                            <span class="block font-bold text-slate-900 text-sm mb-2">SETIAP SENIN</span>
                            <div class="text-sm text-slate-600 space-y-1">
                                <div class="flex justify-between"><span>Sesi Pagi:</span> <strong class="text-blue-700">08.30 - 10.00</strong></div>
                                <div class="flex justify-between"><span>Sesi Siang:</span> <strong class="text-blue-700">13.30 - 14.30</strong></div>
                            </div>
                        </div>
                        <div class="bg-gradient-to-r from-slate-50 to-slate-100 p-4 rounded-lg border-l-4 border-slate-500 hover:shadow-md transition-all duration-300 hover:from-slate-100 hover:to-slate-200">
                            <span class="block font-bold text-slate-900 text-sm mb-2">SELASA - KAMIS</span>
                            <div class="text-sm text-slate-600">
                                <div class="flex justify-between"><span>Sesi Pagi:</span> <strong class="text-slate-700">08.30 - 10.00</strong></div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Card 2: Jadwal Kunjungan --}}
                <div class="bg-white rounded-2xl shadow-2xl p-6 border-t-4 border-yellow-500 flex flex-col h-full card-hover-scale transition-all duration-300 hover:shadow-yellow-500/20">
                    <div class="flex items-center gap-4 mb-6">
                        <div class="w-14 h-14 flex-shrink-0 flex items-center justify-center bg-gradient-to-br from-yellow-100 to-yellow-200 rounded-full text-yellow-600 shadow-lg">
                            <i class="fa-solid fa-calendar-check text-2xl"></i>
                        </div>
                        <div>
                            <h3 class="font-bold text-xl text-slate-800">Jadwal Kunjungan</h3>
                            <p class="text-xs text-slate-500">Sesuai Status WBP</p>
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-4 flex-grow">
                        <div class="flex flex-col justify-center items-center bg-gradient-to-br from-yellow-50 to-yellow-100 rounded-xl border border-yellow-200 p-4 text-center h-full hover:shadow-lg hover:from-yellow-100 hover:to-yellow-200 transition-all duration-300 transform hover:scale-105">
                            <span class="text-xs font-bold text-slate-500 uppercase mb-2">Senin & Rabu</span>
                            <span class="text-2xl font-black text-slate-900">NAPI</span>
                            <span class="text-[10px] text-slate-400 mt-1">(Narapidana)</span>
                        </div>
                        <div class="flex flex-col justify-center items-center bg-gradient-to-br from-blue-50 to-blue-100 rounded-xl border border-blue-200 p-4 text-center h-full hover:shadow-lg hover:from-blue-100 hover:to-blue-200 transition-all duration-300 transform hover:scale-105">
                            <span class="text-xs font-bold text-slate-500 uppercase mb-2">Selasa & Kamis</span>
                            <span class="text-2xl font-black text-slate-900">TAHANAN</span>
                            <span class="text-[10px] text-slate-400 mt-1">(Tahanan)</span>
                        </div>
                    </div>
                    <div class="mt-4 text-center">
                        <span class="inline-block bg-gradient-to-r from-red-500 to-red-600 text-white text-xs font-bold px-6 py-2 rounded-full shadow-lg border border-red-400">
                            <i class="fa-solid fa-calendar-xmark mr-2"></i> JUMAT, SABTU & MINGGU LIBUR
                        </span>
                    </div>
                </div>

                {{-- Card 3: Kuota Antrian --}}
                <div class="bg-white rounded-2xl shadow-2xl p-6 border-t-4 border-emerald-500 flex flex-col h-full card-hover-scale transition-all duration-300 hover:shadow-emerald-500/20">
                    <div class="flex items-center gap-4 mb-6">
                        <div class="w-14 h-14 flex-shrink-0 flex items-center justify-center bg-gradient-to-br from-emerald-100 to-emerald-200 rounded-full text-emerald-600 shadow-lg">
                            <i class="fa-solid fa-users text-2xl"></i>
                        </div>
                        <div>
                            <h3 class="font-bold text-xl text-slate-800">Kuota Antrian</h3>
                            <p class="text-xs text-slate-500">Batas Harian</p>
                        </div>
                    </div>
                    <div class="space-y-3 flex-grow">
                        <div class="flex justify-between items-center bg-gradient-to-r from-emerald-50 to-emerald-100 p-3 rounded-lg border border-emerald-200 hover:shadow-md transition-all duration-300 hover:from-emerald-100 hover:to-emerald-200">
                            <span class="text-sm font-medium text-slate-700">Senin (Pagi)</span>
                            <span class="bg-white text-emerald-700 font-bold px-3 py-1 rounded border border-emerald-200 text-sm shadow-sm">120 Orang</span>
                        </div>
                        <div class="flex justify-between items-center bg-gradient-to-r from-emerald-50 to-emerald-100 p-3 rounded-lg border border-emerald-200 hover:shadow-md transition-all duration-300 hover:from-emerald-100 hover:to-emerald-200">
                            <span class="text-sm font-medium text-slate-700">Senin (Siang)</span>
                            <span class="bg-white text-emerald-700 font-bold px-3 py-1 rounded border border-emerald-200 text-sm shadow-sm">40 Orang</span>
                        </div>
                        <div class="flex justify-between items-center bg-gradient-to-r from-slate-50 to-slate-100 p-3 rounded-lg border border-slate-200 hover:shadow-md transition-all duration-300 hover:from-slate-100 hover:to-slate-200">
                            <span class="text-sm font-medium text-slate-700">Selasa - Kamis</span>
                            <span class="bg-white text-slate-700 font-bold px-3 py-1 rounded border border-slate-200 text-sm shadow-sm">150 Orang</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- 2. ALUR LAYANAN (Code Alur Layanan Tetap) --}}
            <div class="bg-white rounded-3xl shadow-2xl p-8 mb-12 overflow-hidden relative border border-gray-100">
                <div class="absolute top-0 left-0 w-2 h-full bg-gradient-to-b from-yellow-400 to-yellow-600"></div>
                <div class="text-center mb-10">
                    <h2 class="text-3xl font-extrabold text-slate-900 mb-4">ALUR LAYANAN KUNJUNGAN</h2>
                    <p class="text-slate-500 mt-2 text-lg">Ikuti 9 langkah berikut untuk kenyamanan bersama</p>
                    <div class="w-24 h-1 bg-gradient-to-r from-yellow-400 to-yellow-600 mx-auto mt-4 rounded-full"></div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-3 gap-6 relative z-10">
                    <div class="relative flex flex-col items-center text-center p-6 bg-gradient-to-br from-slate-50 to-slate-100 rounded-xl hover:shadow-xl transition-all duration-300 border border-slate-200 group hover:border-yellow-300 card-hover-scale">
                        <div class="w-12 h-12 bg-gradient-to-br from-blue-900 to-blue-800 text-yellow-400 rounded-full flex items-center justify-center font-bold text-xl mb-4 shadow-lg group-hover:scale-110 transition-all duration-300">1</div>
                        <h4 class="font-bold text-slate-900 text-lg mb-2">Daftar Online (H-1)</h4>
                        <p class="text-sm text-slate-600">Daftar via Website atau WA: <br><strong class="text-blue-700">08573333400</strong></p>
                    </div>
                    <div class="relative flex flex-col items-center text-center p-6 bg-gradient-to-br from-slate-50 to-slate-100 rounded-xl hover:shadow-xl transition-all duration-300 border border-slate-200 group hover:border-yellow-300 card-hover-scale">
                        <div class="w-12 h-12 bg-white border-4 border-slate-200 text-slate-500 rounded-full flex items-center justify-center font-bold text-xl mb-4 shadow-lg group-hover:border-yellow-500 group-hover:text-yellow-600 transition-all duration-300">2</div>
                        <h4 class="font-bold text-slate-900 text-lg mb-2">Ruang Transit</h4>
                        <p class="text-sm text-slate-600">Menunggu panggilan petugas di ruang transit.</p>
                    </div>
                    <div class="relative flex flex-col items-center text-center p-6 bg-gradient-to-br from-slate-50 to-slate-100 rounded-xl hover:shadow-xl transition-all duration-300 border border-slate-200 group hover:border-yellow-300 card-hover-scale">
                        <div class="w-12 h-12 bg-white border-4 border-slate-200 text-slate-500 rounded-full flex items-center justify-center font-bold text-xl mb-4 shadow-lg group-hover:border-yellow-500 group-hover:text-yellow-600 transition-all duration-300">3</div>
                        <h4 class="font-bold text-slate-900 text-lg mb-2">Loket Pelayanan</h4>
                        <p class="text-sm text-slate-600">Verifikasi data & ambil nomor antrian.</p>
                    </div>
                    <div class="relative flex flex-col items-center text-center p-6 bg-gradient-to-br from-slate-50 to-slate-100 rounded-xl hover:shadow-xl transition-all duration-300 border border-slate-200 group hover:border-yellow-300 card-hover-scale">
                        <div class="w-12 h-12 bg-white border-4 border-slate-200 text-slate-500 rounded-full flex items-center justify-center font-bold text-xl mb-4 shadow-lg group-hover:border-yellow-500 group-hover:text-yellow-600 transition-all duration-300">4</div>
                        <h4 class="font-bold text-slate-900 text-lg mb-2">Penggeledahan</h4>
                        <p class="text-sm text-slate-600">Pemeriksaan badan & barang bawaan.</p>
                    </div>
                    <div class="relative flex flex-col items-center text-center p-6 bg-gradient-to-br from-slate-50 to-slate-100 rounded-xl hover:shadow-xl transition-all duration-300 border border-slate-200 group hover:border-yellow-300 card-hover-scale">
                        <div class="w-12 h-12 bg-white border-4 border-slate-200 text-slate-500 rounded-full flex items-center justify-center font-bold text-xl mb-4 shadow-lg group-hover:border-yellow-500 group-hover:text-yellow-600 transition-all duration-300">5</div>
                        <h4 class="font-bold text-slate-900 text-lg mb-2">P2U (Identitas)</h4>
                        <p class="text-sm text-slate-600">Tukar KTP dengan ID Card Kunjungan.</p>
                    </div>
                    <div class="relative flex flex-col items-center text-center p-6 bg-gradient-to-br from-slate-50 to-slate-100 rounded-xl hover:shadow-xl transition-all duration-300 border border-slate-200 group hover:border-yellow-300 card-hover-scale">
                        <div class="w-12 h-12 bg-white border-4 border-slate-200 text-slate-500 rounded-full flex items-center justify-center font-bold text-xl mb-4 shadow-lg group-hover:border-yellow-500 group-hover:text-yellow-600 transition-all duration-300">6</div>
                        <h4 class="font-bold text-slate-900 text-lg mb-2">Ganti Alas Kaki</h4>
                        <p class="text-sm text-slate-600">Wajib pakai sandal inventaris Lapas.</p>
                    </div>
                    <div class="relative flex flex-col items-center text-center p-6 bg-gradient-to-br from-green-50 to-green-100 border border-green-200 rounded-xl hover:shadow-xl transition-all duration-300 group card-hover-scale hover:border-green-400">
                        <div class="w-12 h-12 bg-gradient-to-br from-green-600 to-green-700 text-white rounded-full flex items-center justify-center font-bold text-xl mb-4 shadow-lg group-hover:scale-110 transition-all duration-300">7</div>
                        <h4 class="font-bold text-green-800 text-lg mb-2">PELAKSANAAN</h4>
                        <p class="text-sm text-green-700">Masuk ruang kunjungan & bertemu WBP.</p>
                    </div>
                    <div class="relative flex flex-col items-center text-center p-6 bg-gradient-to-br from-slate-50 to-slate-100 rounded-xl hover:shadow-xl transition-all duration-300 border border-slate-200 group hover:border-yellow-300 card-hover-scale">
                        <div class="w-12 h-12 bg-white border-4 border-slate-200 text-slate-500 rounded-full flex items-center justify-center font-bold text-xl mb-4 shadow-lg group-hover:border-yellow-500 group-hover:text-yellow-600 transition-all duration-300">8</div>
                        <h4 class="font-bold text-slate-900 text-lg mb-2">Selesai</h4>
                        <p class="text-sm text-slate-600">Ambil KTP & kembalikan ID Card.</p>
                    </div>
                    <div class="relative flex flex-col items-center text-center p-6 bg-gradient-to-br from-slate-50 to-slate-100 rounded-xl hover:shadow-xl transition-all duration-300 border border-slate-200 group hover:border-yellow-300 card-hover-scale">
                        <div class="w-12 h-12 bg-white border-4 border-slate-200 text-slate-500 rounded-full flex items-center justify-center font-bold text-xl mb-4 shadow-lg group-hover:border-yellow-500 group-hover:text-yellow-600 transition-all duration-300">9</div>
                        <h4 class="font-bold text-slate-900 text-lg mb-2">Pulang</h4>
                        <p class="text-sm text-slate-600">Cek stempel & tinggalkan area Lapas.</p>
                    </div>
                </div>
            </div>

            {{-- 3. KETENTUAN BARANG BAWAAN (Tetap) --}}
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-12">
                {{-- A. DIPERBOLEHKAN --}}
                <div class="bg-white rounded-2xl shadow-2xl overflow-hidden border border-slate-100 h-full">
                    <div class="bg-gradient-to-r from-yellow-400 to-yellow-600 px-6 py-4 flex items-center justify-between">
                        <h3 class="font-extrabold text-slate-900 text-lg flex items-center gap-2">
                            <i class="fa-solid fa-check-circle text-green-600"></i> DIPERBOLEHKAN
                        </h3>
                        <div class="w-8 h-8 bg-white bg-opacity-20 rounded-full flex items-center justify-center">
                            <i class="fa-solid fa-plus text-yellow-800"></i>
                        </div>
                    </div>
                    <div class="p-6 space-y-5">
                        <div class="flex gap-4 items-start p-4 bg-gradient-to-r from-yellow-50 to-yellow-100 rounded-lg border border-yellow-200 hover:shadow-md transition-all duration-300 card-hover-scale">
                            <div class="w-12 h-12 flex-shrink-0 bg-yellow-200 rounded-full flex items-center justify-center text-2xl shadow-sm">🍇</div>
                            <div>
                                <h4 class="font-bold text-slate-800">Buah-buahan</h4>
                                <p class="text-sm text-slate-600 mt-1">Wajib <strong>dikupas, potong, tanpa biji</strong>. (Salak/Durian dilarang).</p>
                            </div>
                        </div>
                        <div class="flex gap-4 items-start p-4 bg-gradient-to-r from-yellow-50 to-yellow-100 rounded-lg border border-yellow-200 hover:shadow-md transition-all duration-300 card-hover-scale">
                            <div class="w-12 h-12 flex-shrink-0 bg-yellow-200 rounded-full flex items-center justify-center text-2xl shadow-sm">🍜</div>
                            <div>
                                <h4 class="font-bold text-slate-800">Makanan Berkuah</h4>
                                <p class="text-sm text-slate-600 mt-1">Harus <strong>BENING & POLOS</strong>. Tanpa kecap/sambal campur.</p>
                            </div>
                        </div>
                        <div class="flex gap-4 items-start p-4 bg-gradient-to-r from-yellow-50 to-yellow-100 rounded-lg border border-yellow-200 hover:shadow-md transition-all duration-300 card-hover-scale">
                            <div class="w-12 h-12 flex-shrink-0 bg-yellow-200 rounded-full flex items-center justify-center text-2xl shadow-sm">🍗</div>
                            <div>
                                <h4 class="font-bold text-slate-800">Lauk Pauk</h4>
                                <p class="text-sm text-slate-600 mt-1">Terlihat jelas isinya. Telur wajib dibelah. (Jeroan dilarang).</p>
                            </div>
                        </div>
                        <div class="flex gap-4 items-start p-4 bg-gradient-to-r from-yellow-50 to-yellow-100 rounded-lg border border-yellow-200 hover:shadow-md transition-all duration-300 card-hover-scale">
                            <div class="w-12 h-12 flex-shrink-0 bg-yellow-200 rounded-full flex items-center justify-center text-2xl shadow-sm">🛍️</div>
                            <div>
                                <h4 class="font-bold text-slate-800">Kemasan</h4>
                                <p class="text-sm text-slate-600 mt-1">Wajib <strong>Plastik Bening</strong> (Ukuran 45). 1 Plastik per rombongan.</p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- B. DILARANG --}}
                <div class="bg-white rounded-2xl shadow-2xl overflow-hidden border border-slate-100 h-full">
                    <div class="bg-gradient-to-r from-red-600 to-red-700 px-6 py-4 flex items-center justify-between">
                        <h3 class="font-extrabold text-white text-lg flex items-center gap-2">
                            <i class="fa-solid fa-ban"></i> DILARANG KERAS
                        </h3>
                        <div class="w-8 h-8 bg-white bg-opacity-20 rounded-full flex items-center justify-center">
                            <i class="fa-solid fa-xmark text-red-800"></i>
                        </div>
                    </div>
                    <div class="p-6">
                        <div class="grid grid-cols-2 sm:grid-cols-3 gap-4 text-center">
                            <div class="bg-gradient-to-br from-red-50 to-red-100 p-4 rounded-lg flex flex-col items-center justify-center h-24 hover:shadow-lg transition-all duration-300 card-hover-scale border border-red-200">
                                <span class="text-2xl mb-2">🍢</span>
                                <span class="text-xs font-bold text-red-800 leading-tight">Makanan Berongga</span>
                            </div>
                            <div class="bg-gradient-to-br from-red-50 to-red-100 p-4 rounded-lg flex flex-col items-center justify-center h-24 hover:shadow-lg transition-all duration-300 card-hover-scale border border-red-200">
                                <span class="text-2xl mb-2">🥤</span>
                                <span class="text-xs font-bold text-red-800 leading-tight">Minuman / Cairan</span>
                            </div>
                            <div class="bg-gradient-to-br from-red-50 to-red-100 p-4 rounded-lg flex flex-col items-center justify-center h-24 hover:shadow-lg transition-all duration-300 card-hover-scale border border-red-200">
                                <span class="text-2xl mb-2">🍞</span>
                                <span class="text-xs font-bold text-red-800 leading-tight">Kemasan Pabrik</span>
                            </div>
                            <div class="bg-gradient-to-br from-red-50 to-red-100 p-4 rounded-lg flex flex-col items-center justify-center h-24 hover:shadow-lg transition-all duration-300 card-hover-scale border border-red-200">
                                <span class="text-2xl mb-2">🦀</span>
                                <span class="text-xs font-bold text-red-800 leading-tight">Makanan Bercangkang</span>
                            </div>
                            <div class="bg-gradient-to-br from-red-50 to-red-100 p-4 rounded-lg flex flex-col items-center justify-center h-24 hover:shadow-lg transition-all duration-300 card-hover-scale border border-red-200">
                                <span class="text-2xl mb-2">🧂</span>
                                <span class="text-xs font-bold text-red-800 leading-tight">Saos Sachet</span>
                            </div>
                            <div class="bg-gradient-to-br from-red-50 to-red-100 p-4 rounded-lg flex flex-col items-center justify-center h-24 hover:shadow-lg transition-all duration-300 card-hover-scale border border-red-200">
                                <span class="text-2xl mb-2">🚬</span>
                                <span class="text-xs font-bold text-red-800 leading-tight">Rokok / Korek</span>
                            </div>
                            <div class="bg-gradient-to-br from-red-50 to-red-100 p-4 rounded-lg flex flex-col items-center justify-center h-24 hover:shadow-lg transition-all duration-300 card-hover-scale border border-red-200">
                                <span class="text-2xl mb-2">📱</span>
                                <span class="text-xs font-bold text-red-800 leading-tight">HP / Elektronik</span>
                            </div>
                            <div class="bg-gradient-to-br from-red-50 to-red-100 p-4 rounded-lg flex flex-col items-center justify-center h-24 hover:shadow-lg transition-all duration-300 card-hover-scale border border-red-200">
                                <span class="text-2xl mb-2">💊</span>
                                <span class="text-xs font-bold text-red-800 leading-tight">Obat / Narkoba</span>
                            </div>
                            <div class="bg-gradient-to-br from-red-50 to-red-100 p-4 rounded-lg flex flex-col items-center justify-center h-24 hover:shadow-lg transition-all duration-300 card-hover-scale border border-red-200">
                                <span class="text-2xl mb-2">🤢</span>
                                <span class="text-xs font-bold text-red-800 leading-tight">Bau Menyengat</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- TOMBOL ACTION --}}
            <div class="flex flex-col items-center justify-center space-y-6 pb-12">
                <div class="bg-gradient-to-r from-blue-50 to-gray-50 p-6 rounded-2xl border border-blue-200 shadow-lg max-w-2xl">
                    <div class="flex items-center justify-center gap-3 mb-3">
                        <i class="fa-solid fa-info-circle text-blue-600 text-xl"></i>
                        <span class="font-bold text-slate-800">PENTING</span>
                    </div>
                    <p class="text-slate-600 text-center italic text-sm leading-relaxed">
                        "Dengan menekan tombol di bawah, saya menyatakan telah membaca dan memahami seluruh tata tertib serta ketentuan yang berlaku untuk kunjungan ke Lapas Kelas IIB Jombang."
                    </p>
                </div>

                <button @click="showForm = true; window.scrollTo({top: 0, behavior: 'smooth'})"
                    class="group relative inline-flex items-center justify-start overflow-hidden rounded-full bg-gradient-to-r from-blue-950 to-black px-12 py-6 font-bold text-white transition-all duration-300 hover:from-black hover:to-blue-950 hover:scale-105 shadow-2xl hover:shadow-blue-900/50 border-2 border-yellow-500 border-opacity-50">
                    <span class="absolute right-0 -mt-12 h-32 w-8 translate-x-12 rotate-12 bg-gradient-to-b from-yellow-500 to-yellow-600 opacity-30 transition-all duration-1000 ease-out group-hover:-translate-x-40"></span>
                    <span class="relative flex items-center gap-3 text-lg tracking-wide">
                        <i class="fa-solid fa-file-signature text-yellow-400"></i>
                        ISI FORMULIR PENDAFTARAN
                        <i class="fa-solid fa-arrow-right group-hover:translate-x-1 transition"></i>
                    </span>
                </button>

                <div class="flex gap-4 text-xs text-slate-500">
                    <span class="flex items-center gap-1">
                        <i class="fa-solid fa-shield-alt text-green-500"></i> Data Aman
                    </span>
                    <span class="flex items-center gap-1">
                        <i class="fa-solid fa-clock text-blue-500"></i> Proses Cepat
                    </span>
                    <span class="flex items-center gap-1">
                        <i class="fa-solid fa-users text-purple-500"></i> Layanan Publik
                    </span>
                </div>
            </div>
        </div>
    </div>

    {{-- ============================================================== --}}
    {{-- BAGIAN 2: FORMULIR PENDAFTARAN (Muncul setelah klik tombol) --}}
    {{-- ============================================================== --}}
    <div x-show="showForm"
        style="display: none;"
        x-transition:enter="transition ease-out duration-500"
        x-transition:enter-start="opacity-0 translate-y-10"
        x-transition:enter-end="opacity-100 translate-y-0"
        class="pt-10 px-4 sm:px-6">

        <div class="max-w-4xl mx-auto bg-gradient-to-br from-white via-gray-50 to-white rounded-3xl shadow-2xl overflow-hidden border-2 border-gray-200">
            <div class="bg-gradient-to-r from-blue-950 via-blue-900 to-blue-800 px-8 py-6 flex justify-between items-center relative overflow-hidden">
                <div class="absolute top-0 right-0 w-32 h-32 bg-yellow-500 opacity-10 rounded-full -mr-16 -mt-16"></div>
                <div class="relative z-10">
                    <h2 class="text-2xl font-bold text-yellow-400 flex items-center gap-2">
                        <i class="fa-solid fa-clipboard-list"></i>
                        Formulir Kunjungan
                    </h2>
                    <p class="text-gray-200 text-sm mt-1">Lengkapi data di bawah ini dengan benar dan lengkap.</p>
                </div>
                {{-- Tombol Batal diperbesar --}}
                <button @click="showForm = false" class="relative z-10 text-gray-300 hover:text-white transition flex items-center gap-2 text-sm font-semibold bg-blue-800 bg-opacity-50 hover:bg-opacity-70 px-4 py-2 rounded-lg shadow-md backdrop-blur-sm">
                    <i class="fa-solid fa-xmark text-lg"></i> Batal
                </button>
            </div>

            <div class="p-10"> {{-- Padding diperbesar agar lebih lega --}}

                {{-- PESAN SUKSES --}}
                @if (session('success'))
                    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded-lg mb-8" role="alert">
                        <p class="font-bold">Berhasil!</p>
                        <p>{{ session('success') }}</p>
                    </div>
                @endif

                <form method="POST" action="{{ route('kunjungan.store') }}" class="space-y-8 animate-fade-in">
                    @csrf

                    {{-- Data Pengunjung --}}
                    <div class="bg-gradient-to-r from-blue-50 to-gray-50 p-6 rounded-2xl border border-blue-100 animate-slide-up">
                        <h3 class="text-lg font-bold text-slate-800 border-b-2 border-blue-200 pb-3 mb-6 flex items-center gap-3">
                            <span class="bg-gradient-to-r from-blue-600 to-blue-700 text-white text-xs font-extrabold px-3 py-1.5 rounded-full shadow-md flex items-center gap-1 animate-pulse">
                                <i class="fa-solid fa-user"></i> 1
                            </span> 
                            <span class="text-blue-800">Data Pengunjung</span>
                        </h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="group">
                                <label for="nama_pengunjung" class="block text-sm font-semibold text-slate-700 mb-2 flex items-center gap-2">
                                    <i class="fa-solid fa-id-card text-blue-500"></i>
                                    Nama Lengkap (Sesuai KTP)
                                </label>
                                <input type="text" id="nama_pengunjung" name="nama_pengunjung" value="{{ old('nama_pengunjung') }}" class="w-full rounded-xl border-2 border-gray-200 focus:ring-2 focus:ring-yellow-400 focus:border-yellow-500 transition-all duration-300 shadow-sm py-3 px-4 bg-white hover:border-blue-300 @error('nama_pengunjung') border-red-500 @enderror" placeholder="Masukkan nama lengkap Anda">
                                <p class="mt-2 text-sm text-red-600 hidden" id="error_nama_pengunjung"></p>
                            </div>
                            <div class="group">
                                <label for="nik_pengunjung" class="block text-sm font-semibold text-slate-700 mb-2 flex items-center gap-2">
                                    <i class="fa-solid fa-hashtag text-blue-500"></i>
                                    NIK (Nomor Induk Kependudukan)
                                </label>
                                <input type="text" id="nik_pengunjung" name="nik_pengunjung" value="{{ old('nik_pengunjung') }}" class="w-full rounded-xl border-2 border-gray-200 focus:ring-2 focus:ring-yellow-400 focus:border-yellow-500 transition-all duration-300 shadow-sm py-3 px-4 bg-white hover:border-blue-300 @error('nik_pengunjung') border-red-500 @enderror" placeholder="Masukkan 16 digit NIK Anda" maxlength="16">
                                <p class="mt-2 text-sm text-red-600 hidden" id="error_nik_pengunjung"></p>
                            </div>
                            <div class="group">
                                <label for="no_wa_pengunjung" class="block text-sm font-semibold text-slate-700 mb-2 flex items-center gap-2">
                                    <i class="fa-brands fa-whatsapp text-green-500"></i>
                                    Nomor WhatsApp Aktif
                                </label>
                                <input type="text" id="no_wa_pengunjung" name="no_wa_pengunjung" value="{{ old('no_wa_pengunjung') }}" class="w-full rounded-xl border-2 border-gray-200 focus:ring-2 focus:ring-yellow-400 focus:border-yellow-500 transition-all duration-300 shadow-sm py-3 px-4 bg-white hover:border-blue-300 @error('no_wa_pengunjung') border-red-500 @enderror" placeholder="Contoh: 081234567890">
                                <p class="mt-2 text-sm text-red-600 hidden" id="error_no_wa_pengunjung"></p>
                            </div>
                            <div class="group">
                                <label for="email_pengunjung" class="block text-sm font-semibold text-slate-700 mb-2 flex items-center gap-2">
                                    <i class="fa-solid fa-envelope text-blue-500"></i>
                                    Alamat Email Aktif
                                </label>
                                <input type="email" id="email_pengunjung" name="email_pengunjung" value="{{ old('email_pengunjung') }}" class="w-full rounded-xl border-2 border-gray-200 focus:ring-2 focus:ring-yellow-400 focus:border-yellow-500 transition-all duration-300 shadow-sm py-3 px-4 bg-white hover:border-blue-300 @error('email_pengunjung') border-red-500 @enderror" placeholder="Contoh: budi@email.com" required>
                                <p class="mt-2 text-sm text-red-600 hidden" id="error_email_pengunjung"></p>
                            </div>
                            <div class="md:col-span-2 group">
                                <label for="alamat_pengunjung" class="block text-sm font-semibold text-slate-700 mb-2 flex items-center gap-2">
                                    <i class="fa-solid fa-map-marker-alt text-red-500"></i>
                                    Alamat Lengkap
                                </label>
                                <input type="text" id="alamat_pengunjung" name="alamat_pengunjung" value="{{ old('alamat_pengunjung') }}" class="w-full rounded-xl border-2 border-gray-200 focus:ring-2 focus:ring-yellow-400 focus:border-yellow-500 transition-all duration-300 shadow-sm py-3 px-4 bg-white hover:border-blue-300 @error('alamat_pengunjung') border-red-500 @enderror" placeholder="Masukkan alamat lengkap Anda (Desa/Kelurahan, Kecamatan, Kota/Kabupaten)">
                                <p class="mt-2 text-sm text-red-600 hidden" id="error_alamat_pengunjung"></p>
                            </div>
                        </div>
                    </div>

                    {{-- Data WBP (DENGAN AUTOCOMPLETE) --}}
                    <div class="mt-8 bg-gradient-to-r from-yellow-50 to-orange-50 p-6 rounded-2xl border border-yellow-100 animate-slide-up-delay">
                        <h3 class="text-lg font-bold text-slate-800 border-b-2 border-yellow-200 pb-3 mb-6 flex items-center gap-3">
                            <span class="bg-gradient-to-r from-yellow-500 to-yellow-600 text-slate-900 text-xs font-extrabold px-3 py-1.5 rounded-full shadow-md flex items-center gap-1 animate-pulse">
                                <i class="fa-solid fa-users"></i> 2
                            </span> 
                            <span class="text-yellow-800">Data Tujuan Kunjungan</span>
                        </h3>
                        <div 
                            class="grid grid-cols-1 md:grid-cols-2 gap-6"
                            x-data="{
                                // Data & State untuk Calendar
                                datesByDay: {{ json_encode($datesByDay) }},
                                selectedDay: '{{ old('selected_day', '') }}',
                                selectedDate: '{{ old('tanggal_kunjungan', '') }}',
                                selectedSesi: '{{ old('sesi', '') }}',
                                availableDates: [],
                                isMonday: false,
                                quotaInfo: '',
                                isLoading: false,
                                
                                // Methods
                                init() {
                                    if (this.selectedDay) { this.updateAvailableDates(); }
                                    if (this.selectedDate) { this.getQuota(); }
                                    this.$watch('selectedDate', () => this.getQuota());
                                    this.$watch('selectedSesi', () => this.getQuota());
                                },
                                handleDayChange() {
                                    this.updateAvailableDates();
                                    this.selectedDate = ''; 
                                    this.quotaInfo = ''; 
                                },
                                updateAvailableDates() {
                                    this.availableDates = this.datesByDay[this.selectedDay] || [];
                                    this.isMonday = (this.selectedDay === 'Senin');
                                },
                                async getQuota() {
                                    if (!this.selectedDate || (this.isMonday && !this.selectedSesi)) {
                                        this.quotaInfo = '';
                                        return;
                                    }
                                    this.isLoading = true;
                                    this.quotaInfo = 'Memeriksa kuota...';
                                    try {
                                        const params = new URLSearchParams({
                                            tanggal_kunjungan: this.selectedDate,
                                            sesi: this.isMonday ? this.selectedSesi : '',
                                        });
                                        const response = await fetch(`{{ route('kunjungan.quota.api') }}?${params}`);
                                        if (!response.ok) {
                                            const errorData = await response.json();
                                            throw new Error(errorData.message || 'Gagal mengambil data kuota.');
                                        }
                                        const data = await response.json();
                                        if (data.sisa_kuota > 0) {
                                            this.quotaInfo = `<span class='text-green-600 font-semibold'><i class='fa-solid fa-check-circle mr-1'></i>Sisa Kuota: ${data.sisa_kuota}</span>`;
                                        } else {
                                            this.quotaInfo = `<span class='text-red-600 font-semibold'><i class='fa-solid fa-times-circle mr-1'></i>Kuota Penuh</span>`;
                                        }
                                    } catch (error) {
                                        this.quotaInfo = `<span class='text-red-600 font-semibold'>Gagal memeriksa kuota.</span>`;
                                    } finally {
                                        this.isLoading = false;
                                    }
                                }
                            }"
                        >
                            {{-- NAMA WBP SEARCH --}}
                            <div class="group relative">
                                <label for="nama_wbp" class="block text-sm font-semibold text-slate-700 mb-2 flex items-center gap-2">
                                    <i class="fa-solid fa-user-tie text-yellow-600"></i>
                                    Cari Nama Warga Binaan (WBP)
                                </label>
                                <input type="text" id="wbp_search_input" name="nama_wbp" value="{{ old('nama_wbp') }}" class="w-full rounded-xl border-2 border-gray-200 focus:ring-2 focus:ring-yellow-400 focus:border-yellow-500 transition-all duration-300 shadow-sm py-3 px-4 bg-white hover:border-yellow-300 @error('nama_wbp') border-red-500 @enderror" placeholder="Ketik nama atau nomor registrasi..." autocomplete="off">
                                
                                {{-- Hidden Input untuk ID WBP yang sebenarnya --}}
                                <input type="hidden" name="wbp_id" id="wbp_id_hidden">
                                
                                <p class="mt-2 text-sm text-red-600 hidden" id="error_nama_wbp"></p>

                                {{-- Hasil Pencarian Container --}}
                                <div id="wbp_results" class="search-results"></div>

                                {{-- Info WBP Terpilih --}}
                                <div id="selected_wbp_info" class="hidden mt-2 p-3 bg-yellow-100 rounded-lg border border-yellow-300 text-sm text-yellow-800">
                                    <strong>Terpilih:</strong> <span id="display_wbp_nama"></span> <br>
                                    <span class="text-xs">No. Reg: <span id="display_wbp_noreg"></span> | Blok: <span id="display_wbp_blok"></span></span>
                                </div>
                            </div>

                            {{-- HUBUNGAN --}}
                            <div class="group">
                                <label for="hubungan" class="block text-sm font-semibold text-slate-700 mb-2 flex items-center gap-2">
                                    <i class="fa-solid fa-heart text-red-500"></i>
                                    Hubungan dengan WBP
                                </label>
                                <select id="hubungan" name="hubungan" class="w-full rounded-xl border-2 border-gray-200 focus:ring-2 focus:ring-yellow-400 focus:border-yellow-500 transition-all duration-300 shadow-sm py-3 px-4 bg-white hover:border-yellow-300 @error('hubungan') border-red-500 @enderror">
                                    <option value="" disabled selected>Pilih hubungan Anda dengan WBP...</option>
                                    <option value="Orang Tua" @if(old('hubungan') == 'Orang Tua') selected @endif>Orang Tua</option>
                                    <option value="Suami / Istri" @if(old('hubungan') == 'Suami / Istri') selected @endif>Suami / Istri</option>
                                    <option value="Anak" @if(old('hubungan') == 'Anak') selected @endif>Anak</option>
                                    <option value="Saudara" @if(old('hubungan') == 'Saudara') selected @endif>Saudara</option>
                                    <option value="Teman" @if(old('hubungan') == 'Teman') selected @endif>Teman</option>
                                    <option value="Kuasa Hukum" @if(old('hubungan') == 'Kuasa Hukum') selected @endif>Kuasa Hukum</option>
                                    <option value="Lainnya" @if(old('hubungan') == 'Lainnya') selected @endif>Lainnya</option>
                                </select>
                                <p class="mt-2 text-sm text-red-600 hidden" id="error_hubungan"></p>
                            </div>

                            {{-- HARI --}}
                            <div class="group">
                                <label for="hari" class="block text-sm font-semibold text-slate-700 mb-2 flex items-center gap-2">
                                    <i class="fa-solid fa-calendar-day text-blue-500"></i>
                                    Pilih Hari Kunjungan
                                </label>
                                <select id="hari" name="selected_day" @change="handleDayChange()" x-model="selectedDay" class="w-full rounded-xl border-2 border-gray-200 focus:ring-2 focus:ring-yellow-400 focus:border-yellow-500 transition-all duration-300 shadow-sm py-3 px-4 bg-white hover:border-yellow-300">
                                    <option value="" disabled>Pilih hari kunjungan...</option>
                                    @foreach (array_keys($datesByDay) as $day)
                                        <option value="{{ $day }}">{{ $day }}</option>
                                    @endforeach
                                </select>
                                <p class="mt-2 text-sm text-red-600 hidden" id="error_hari"></p>
                            </div>

                            {{-- TANGGAL --}}
                            <div class="group">
                                <label for="tanggal_kunjungan" class="block text-sm font-semibold text-slate-700 mb-2 flex items-center gap-2">
                                    <i class="fa-solid fa-calendar-alt text-green-500"></i>
                                    Pilih Tanggal Kunjungan
                                </label>
                                <select id="tanggal_kunjungan" name="tanggal_kunjungan" x-model="selectedDate" :disabled="!selectedDay || availableDates.length === 0" class="w-full rounded-xl border-2 border-gray-200 focus:ring-2 focus:ring-yellow-400 focus:border-yellow-500 transition-all duration-300 shadow-sm py-3 px-4 bg-white hover:border-yellow-300 disabled:bg-gray-50 disabled:cursor-not-allowed @error('tanggal_kunjungan') border-red-500 @enderror">
                                    <option value="" disabled>-- Pilih hari terlebih dahulu --</option>
                                    <template x-for="date in availableDates" :key="date.value">
                                        <option :value="date.value" x-text="date.label"></option>
                                    </template>
                                </select>
                                <p class="mt-2 text-sm text-red-600 hidden" id="error_tanggal_kunjungan"></p>
                                <div class="mt-3 p-3 bg-white rounded-lg border border-gray-200 shadow-sm">
                                    <div class="text-sm font-semibold h-5">
                                        <span x-show="isLoading" class="text-slate-500 flex items-center gap-1">
                                            <i class="fa-solid fa-spinner fa-spin"></i> Memeriksa kuota...
                                        </span>
                                        <span x-show="!isLoading" x-html="quotaInfo"></span>
                                    </div>
                                </div>
                            </div>

                            {{-- Dropdown Sesi Dinamis --}}
                            <div x-show="isMonday" x-transition class="md:col-span-2 bg-gradient-to-r from-blue-50 to-blue-100 p-4 rounded-xl border border-blue-200">
                                <label for="sesi" class="block text-sm font-semibold text-slate-700 mb-2 flex items-center gap-2">
                                    <i class="fa-solid fa-clock text-blue-600"></i>
                                    Sesi Kunjungan (Khusus Hari Senin)
                                </label>
                                <select id="sesi" name="sesi" x-model="selectedSesi" class="w-full rounded-xl border-2 border-gray-200 focus:ring-2 focus:ring-yellow-400 focus:border-yellow-500 transition-all duration-300 shadow-sm py-3 px-4 bg-white hover:border-yellow-300 @error('sesi') border-red-500 @enderror">
                                    <option value="" disabled>Pilih sesi kunjungan...</option>
                                    <option value="pagi" @if(old('sesi') == 'pagi') selected @endif>Sesi Pagi (08:30 - 10:00)</option>
                                    <option value="siang" @if(old('sesi') == 'siang') selected @endif>Sesi Siang (13:30 - 14:30)</option>
                                </select>
                                <p class="mt-2 text-sm text-red-600 hidden" id="error_sesi"></p>
                            </div>
                        </div>
                    </div>

                    {{-- Data Pengikut (BARU - Section 3) --}}
                    <div class="mt-8 bg-gradient-to-r from-emerald-50 to-green-50 p-6 rounded-2xl border border-emerald-100 animate-slide-up-delay" x-data="{ count: 0 }">
                        <div class="flex justify-between items-center border-b-2 border-emerald-200 pb-3 mb-6">
                            <h3 class="text-lg font-bold text-slate-800 flex items-center gap-3">
                                <span class="bg-gradient-to-r from-emerald-500 to-green-600 text-white text-xs font-extrabold px-3 py-1.5 rounded-full shadow-md flex items-center gap-1 animate-pulse">
                                    <i class="fa-solid fa-users"></i> 3
                                </span> 
                                <span class="text-emerald-800">Detail Pengikut</span>
                            </h3>
                            <div class="flex items-center gap-2">
                                <label for="total_pengikut" class="text-sm font-semibold text-slate-700">Jumlah:</label>
                                <select id="total_pengikut" name="total_pengikut" x-model="count" class="rounded-lg border-emerald-300 text-sm focus:ring-emerald-500 focus:border-emerald-500 shadow-sm">
                                    <option value="0">Sendirian (0)</option>
                                    <option value="1">1 Orang</option>
                                    <option value="2">2 Orang</option>
                                    <option value="3">3 Orang</option>
                                    <option value="4">4 Orang (Max)</option>
                                </select>
                            </div>
                        </div>

                        <div class="space-y-4">
                            <template x-for="i in parseInt(count)" :key="i">
                                <div class="bg-white p-4 rounded-xl shadow-sm border border-emerald-100 transition-all duration-300 hover:shadow-md">
                                    <p class="text-xs font-bold text-emerald-600 mb-2 uppercase tracking-wide flex items-center gap-2">
                                        <i class="fa-solid fa-user-group"></i> Pengikut ke-<span x-text="i"></span>
                                    </p>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div>
                                            <input type="text" name="pengikut_nama[]" class="w-full rounded-xl border-2 border-gray-200 focus:ring-2 focus:ring-emerald-400 focus:border-emerald-500 transition-all duration-300 shadow-sm py-2 px-4 bg-white text-sm" placeholder="Nama Lengkap Pengikut" required>
                                        </div>
                                        <div>
                                            <input type="text" name="pengikut_barang[]" class="w-full rounded-xl border-2 border-gray-200 focus:ring-2 focus:ring-emerald-400 focus:border-emerald-500 transition-all duration-300 shadow-sm py-2 px-4 bg-white text-sm" placeholder="Detail Barang Bawaan (Baju, Makanan, dll)">
                                        </div>
                                    </div>
                                </div>
                            </template>
                            <div x-show="count == 0" class="text-center text-slate-400 italic text-sm py-4">
                                Tidak ada pengikut tambahan.
                            </div>
                        </div>
                    </div>

                    {{-- Tombol Kirim --}}
                    <div class="pt-8 border-t-2 border-gray-200 flex items-center justify-between gap-4 bg-gradient-to-r from-gray-50 to-blue-50 p-6 rounded-2xl">
                        <button type="button" @click="showForm = false" class="px-8 py-3 text-slate-600 font-bold hover:text-slate-900 transition-all duration-300 bg-gradient-to-r from-gray-100 to-gray-200 hover:from-gray-200 hover:to-gray-300 rounded-xl shadow-md hover:shadow-lg transform hover:scale-105 flex items-center gap-2">
                            <i class="fa-solid fa-arrow-left"></i> Kembali
                        </button>
                        <button type="submit" class="bg-gradient-to-r from-yellow-500 via-yellow-600 to-yellow-700 hover:from-yellow-600 hover:via-yellow-700 hover:to-yellow-800 text-slate-900 font-bold px-12 py-4 rounded-xl shadow-xl hover:shadow-yellow-500/50 transition-all duration-300 transform hover:-translate-y-1 hover:scale-105 flex items-center gap-3 text-lg">
                            <i class="fa-solid fa-paper-plane text-xl"></i> 
                            <span>KIRIM PENDAFTARAN</span>
                            <i class="fa-solid fa-check-circle text-xl"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>
@endsection

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // --- 1. LOGIC SEARCH WBP (AUTOCOMPLETE) ---
        const searchInput = document.getElementById('wbp_search_input');
        const resultsDiv = document.getElementById('wbp_results');
        const hiddenId = document.getElementById('wbp_id');
        const hiddenNama = document.getElementById('nama_wbp_text');
        const infoDiv = document.getElementById('selected_wbp_info');

        searchInput.addEventListener('keyup', function() {
            let query = this.value;
            // Reset hidden ID jika user mengetik ulang (mencegah nama tidak sesuai ID)
            hiddenId.value = ''; 
            
            if(query.length > 2) {
                fetch(`{{ route('api.search.wbp') }}?q=${query}`)
                    .then(res => res.json())
                    .then(data => {
                        resultsDiv.innerHTML = '';
                        resultsDiv.style.display = 'block';
                        
                        if(data.length === 0) {
                            resultsDiv.innerHTML = '<div class="p-3 text-sm text-gray-500 italic">Data tidak ditemukan. Pastikan Admin sudah import data WBP.</div>';
                        }
                        
                        data.forEach(item => {
                            let div = document.createElement('div');
                            div.className = 'wbp-item';
                            div.innerHTML = `<strong>${item.nama}</strong> <span class="text-xs text-gray-500">(${item.no_registrasi})</span>`;
                            div.onclick = () => {
                                // Populate Inputs
                                searchInput.value = item.nama;
                                hiddenId.value = item.id; // INI PENTING
                                hiddenNama.value = item.nama;
                                
                                // Show Info Box
                                infoDiv.classList.remove('hidden');
                                document.getElementById('disp_nama').innerText = item.nama;
                                document.getElementById('disp_blok').innerText = item.blok_kamar || '-';
                                document.getElementById('disp_noreg').innerText = item.no_registrasi;
                                
                                // Hide Results
                                resultsDiv.style.display = 'none';
                            };
                            resultsDiv.appendChild(div);
                        });
                    })
                    .catch(err => {
                        console.error('Error fetching WBP:', err);
                    });
            } else {
                resultsDiv.style.display = 'none';
            }
        });

        // Close search when clicking outside
        document.addEventListener('click', function(e) {
            if (!searchInput.contains(e.target) && !resultsDiv.contains(e.target)) {
                resultsDiv.style.display = 'none';
            }
        });

        // --- 2. VALIDASI SAAT SUBMIT ---
        const form = document.querySelector('form');
        
        form.addEventListener('submit', function(event) {
            let isValid = true;
            let errorMessage = '';

            // Cek WBP ID (Wajib Klik Autocomplete)
            if (!hiddenId.value) {
                isValid = false;
                errorMessage = 'Anda wajib memilih Nama WBP dari daftar pencarian yang muncul!';
                searchInput.focus();
                searchInput.style.border = "1px solid red";
            }

            // Cek Nama Pengunjung
            if (document.getElementById('nama_pengunjung').value.trim() === '') {
                isValid = false;
                errorMessage = 'Nama Pengunjung wajib diisi.';
            }

            // Cek Tanggal
            if (document.getElementById('tanggal_kunjungan').value === '') {
                isValid = false;
                errorMessage = 'Silahkan pilih tanggal kunjungan terlebih dahulu.';
            }

            if (!isValid) {
                event.preventDefault(); // Stop form submission
                Swal.fire({
                    icon: 'error',
                    title: 'Data Belum Lengkap',
                    text: errorMessage,
                    confirmButtonColor: '#1e3a8a'
                });
            }
        });
    });
</script>