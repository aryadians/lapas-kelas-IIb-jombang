@extends('layouts.main')

@section('content')
{{-- Style Tambahan untuk Autocomplete Dropdown Custom --}}
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
    .wbp-item {
        padding: 0.75rem 1rem;
        cursor: pointer;
        border-bottom: 1px solid #f1f5f9;
        transition: all 0.2s;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .wbp-item:last-child { border-bottom: none; }
    .wbp-item:hover { background-color: #fef9c3; color: #854d0e; }
    
    /* Custom Scrollbar */
    .search-results::-webkit-scrollbar { width: 6px; }
    .search-results::-webkit-scrollbar-track { background: #f1f1f1; }
    .search-results::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 3px; }
</style>

{{-- WRAPPER UTAMA DENGAN STATE ALPINE JS --}}
<div x-data="{ showForm: {{ session('errors') || session('error') ? 'true' : 'false' }} }" class="bg-slate-50 min-h-screen pb-20">

    {{-- ============================================================== --}}
    {{-- BAGIAN 1: INFORMASI & TATA TERTIB (FULL UI) --}}
    {{-- ============================================================== --}}
    <div x-show="!showForm"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 translate-y-4"
        x-transition:enter-end="opacity-100 translate-y-0">

        {{-- HERO HEADER --}}
        <div class="bg-gradient-to-br from-blue-950 via-blue-900 to-blue-800 pt-8 pb-12 px-4 relative overflow-hidden sm:pt-16 sm:pb-24">
            <div class="absolute top-0 right-0 -mr-20 -mt-20 w-80 h-80 rounded-full bg-gradient-to-br from-yellow-500 to-yellow-600 opacity-15 blur-3xl animate-pulse"></div>
            <div class="absolute bottom-0 left-0 -ml-20 -mb-20 w-80 h-80 rounded-full bg-gradient-to-br from-gray-400 to-gray-600 opacity-10 blur-3xl"></div>
            <div class="max-w-7xl mx-auto text-center relative z-10">
                <div class="inline-flex items-center gap-2 bg-yellow-500 bg-opacity-20 text-yellow-400 font-bold tracking-widest uppercase text-sm mb-4 px-4 py-2 rounded-full border border-yellow-400 border-opacity-30">
                    <i class="fa-solid fa-gavel"></i>
                    <span>Layanan Publik</span>
                </div>
                <h1 class="text-3xl sm:text-4xl md:text-6xl font-extrabold text-white mb-6 leading-tight drop-shadow-lg">
                    Pendaftaran Kunjungan <span class="animate-text-shimmer bg-gradient-to-r from-yellow-400 to-yellow-300 bg-clip-text text-transparent">Tatap Muka</span>
                </h1>
                <p class="text-base sm:text-lg text-gray-200 max-w-4xl mx-auto leading-relaxed drop-shadow-sm">
                    Mohon pelajari <strong class="text-yellow-300 underline decoration-yellow-400">Jadwal</strong>, <strong class="text-yellow-300 underline decoration-yellow-400">Alur Layanan</strong>, dan <strong class="text-yellow-300 underline decoration-yellow-400">Ketentuan Barang</strong> di bawah ini sebelum mengisi formulir pendaftaran demi kelancaran kunjungan Anda.
                </p>
                <div class="mt-8 flex flex-col sm:flex-row items-center justify-center gap-4">
                    <div class="bg-white bg-opacity-10 backdrop-blur-sm border border-white border-opacity-20 px-4 py-2 rounded-full text-white text-sm font-medium">
                        <i class="fa-solid fa-shield-alt mr-2"></i> Aman & Terpercaya
                    </div>
                    <div class="bg-white bg-opacity-10 backdrop-blur-sm border border-white border-opacity-20 px-4 py-2 rounded-full text-white text-sm font-medium">
                        <i class="fa-solid fa-clock mr-2"></i> Proses Cepat
                    </div>
                </div>
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 -mt-8 sm:-mt-16 relative z-20">

            {{-- BADGE KEMENTERIAN --}}
            <div class="text-center mb-8">
                <div class="inline-flex items-center text-center gap-2 sm:gap-3 bg-gradient-to-r from-blue-950 to-blue-900 text-yellow-400 px-4 py-3 sm:px-6 rounded-full font-bold shadow-2xl border-2 border-yellow-500 border-opacity-50 text-xs sm:text-sm">
                    <i class="fa-solid fa-landmark text-base sm:text-lg"></i>
                    <span class="sm:hidden">KEMENKUMHAM RI</span>
                    <span class="hidden sm:inline">KEMENTERIAN IMIGRASI DAN PEMASYARAKATAN RI</span>
                    <i class="fa-solid fa-scale-balanced text-base sm:text-lg"></i>
                </div>
            </div>

            {{-- 1. JADWAL & KUOTA --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">
                {{-- Card 1: Waktu Layanan --}}
                <div class="bg-white rounded-2xl shadow-2xl p-4 sm:p-6 border-t-4 border-blue-600 flex flex-col h-full card-hover-scale transition-all duration-300 hover:shadow-blue-500/20">
                    <div class="flex items-center gap-4 mb-6">
                        <div class="w-14 h-14 flex-shrink-0 flex items-center justify-center bg-gradient-to-br from-blue-100 to-blue-200 rounded-full text-blue-600 shadow-lg">
                            <i class="fa-solid fa-clock text-2xl"></i>
                        </div>
                        <div>
                            <h3 class="font-bold text-lg sm:text-xl text-slate-800">Waktu Layanan</h3>
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
                <div class="bg-white rounded-2xl shadow-2xl p-4 sm:p-6 border-t-4 border-yellow-500 flex flex-col h-full card-hover-scale transition-all duration-300 hover:shadow-yellow-500/20">
                    <div class="flex items-center gap-4 mb-6">
                        <div class="w-14 h-14 flex-shrink-0 flex items-center justify-center bg-gradient-to-br from-yellow-100 to-yellow-200 rounded-full text-yellow-600 shadow-lg">
                            <i class="fa-solid fa-calendar-check text-2xl"></i>
                        </div>
                        <div>
                            <h3 class="font-bold text-lg sm:text-xl text-slate-800">Jadwal Kunjungan</h3>
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
                <div class="bg-white rounded-2xl shadow-2xl p-4 sm:p-6 border-t-4 border-emerald-500 flex flex-col h-full card-hover-scale transition-all duration-300 hover:shadow-emerald-500/20">
                    <div class="flex items-center gap-4 mb-6">
                        <div class="w-14 h-14 flex-shrink-0 flex items-center justify-center bg-gradient-to-br from-emerald-100 to-emerald-200 rounded-full text-emerald-600 shadow-lg">
                            <i class="fa-solid fa-users text-2xl"></i>
                        </div>
                        <div>
                            <h3 class="font-bold text-lg sm:text-xl text-slate-800">Kuota Antrian</h3>
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

            {{-- 2. ALUR LAYANAN (FULL VERSION) --}}
            <div class="bg-white rounded-3xl shadow-2xl p-4 sm:p-8 mb-12 overflow-hidden relative border border-gray-100">
                <div class="absolute top-0 left-0 w-2 h-full bg-gradient-to-b from-yellow-400 to-yellow-600"></div>
                <div class="text-center mb-10">
                    <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 mb-4">ALUR LAYANAN KUNJUNGAN</h2>
                    <p class="text-slate-500 mt-2 text-base sm:text-lg">Ikuti 9 langkah berikut untuk kenyamanan bersama</p>
                    <div class="w-24 h-1 bg-gradient-to-r from-yellow-400 to-yellow-600 mx-auto mt-4 rounded-full"></div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-3 gap-6 relative z-10">
                    <div class="relative flex flex-col items-center text-center p-4 sm:p-6 bg-gradient-to-br from-slate-50 to-slate-100 rounded-xl hover:shadow-xl transition-all duration-300 border border-slate-200 group hover:border-yellow-300 card-hover-scale">
                        <div class="w-10 h-10 sm:w-12 sm:h-12 bg-gradient-to-br from-blue-900 to-blue-800 text-yellow-400 rounded-full flex items-center justify-center font-bold text-lg sm:text-xl mb-4 shadow-lg group-hover:scale-110 transition-all duration-300">1</div>
                        <h4 class="font-bold text-slate-900 text-lg mb-2">Daftar Online (H-1)</h4>
                        <p class="text-sm text-slate-600">Daftar via Website atau WA: <br><strong class="text-blue-700">08573333400</strong></p>
                    </div>
                    <div class="relative flex flex-col items-center text-center p-4 sm:p-6 bg-gradient-to-br from-slate-50 to-slate-100 rounded-xl hover:shadow-xl transition-all duration-300 border border-slate-200 group hover:border-yellow-300 card-hover-scale">
                        <div class="w-10 h-10 sm:w-12 sm:h-12 bg-white border-4 border-slate-200 text-slate-500 rounded-full flex items-center justify-center font-bold text-lg sm:text-xl mb-4 shadow-lg group-hover:border-yellow-500 group-hover:text-yellow-600 transition-all duration-300">2</div>
                        <h4 class="font-bold text-slate-900 text-lg mb-2">Ruang Transit</h4>
                        <p class="text-sm text-slate-600">Menunggu panggilan petugas di ruang transit.</p>
                    </div>
                    <div class="relative flex flex-col items-center text-center p-4 sm:p-6 bg-gradient-to-br from-slate-50 to-slate-100 rounded-xl hover:shadow-xl transition-all duration-300 border border-slate-200 group hover:border-yellow-300 card-hover-scale">
                        <div class="w-10 h-10 sm:w-12 sm:h-12 bg-white border-4 border-slate-200 text-slate-500 rounded-full flex items-center justify-center font-bold text-lg sm:text-xl mb-4 shadow-lg group-hover:border-yellow-500 group-hover:text-yellow-600 transition-all duration-300">3</div>
                        <h4 class="font-bold text-slate-900 text-lg mb-2">Loket Pelayanan</h4>
                        <p class="text-sm text-slate-600">Verifikasi data & ambil nomor antrian.</p>
                    </div>
                    <div class="relative flex flex-col items-center text-center p-4 sm:p-6 bg-gradient-to-br from-slate-50 to-slate-100 rounded-xl hover:shadow-xl transition-all duration-300 border border-slate-200 group hover:border-yellow-300 card-hover-scale">
                        <div class="w-10 h-10 sm:w-12 sm:h-12 bg-white border-4 border-slate-200 text-slate-500 rounded-full flex items-center justify-center font-bold text-lg sm:text-xl mb-4 shadow-lg group-hover:border-yellow-500 group-hover:text-yellow-600 transition-all duration-300">4</div>
                        <h4 class="font-bold text-slate-900 text-lg mb-2">Penggeledahan</h4>
                        <p class="text-sm text-slate-600">Pemeriksaan badan & barang bawaan.</p>
                    </div>
                    <div class="relative flex flex-col items-center text-center p-4 sm:p-6 bg-gradient-to-br from-slate-50 to-slate-100 rounded-xl hover:shadow-xl transition-all duration-300 border border-slate-200 group hover:border-yellow-300 card-hover-scale">
                        <div class="w-10 h-10 sm:w-12 sm:h-12 bg-white border-4 border-slate-200 text-slate-500 rounded-full flex items-center justify-center font-bold text-lg sm:text-xl mb-4 shadow-lg group-hover:border-yellow-500 group-hover:text-yellow-600 transition-all duration-300">5</div>
                        <h4 class="font-bold text-slate-900 text-lg mb-2">P2U (Identitas)</h4>
                        <p class="text-sm text-slate-600">Tukar KTP dengan ID Card Kunjungan.</p>
                    </div>
                    <div class="relative flex flex-col items-center text-center p-4 sm:p-6 bg-gradient-to-br from-slate-50 to-slate-100 rounded-xl hover:shadow-xl transition-all duration-300 border border-slate-200 group hover:border-yellow-300 card-hover-scale">
                        <div class="w-10 h-10 sm:w-12 sm:h-12 bg-white border-4 border-slate-200 text-slate-500 rounded-full flex items-center justify-center font-bold text-lg sm:text-xl mb-4 shadow-lg group-hover:border-yellow-500 group-hover:text-yellow-600 transition-all duration-300">6</div>
                        <h4 class="font-bold text-slate-900 text-lg mb-2">Ganti Alas Kaki</h4>
                        <p class="text-sm text-slate-600">Wajib pakai sandal inventaris Lapas.</p>
                    </div>
                    <div class="relative flex flex-col items-center text-center p-6 bg-gradient-to-br from-green-50 to-green-100 border border-green-200 rounded-xl hover:shadow-xl transition-all duration-300 group card-hover-scale hover:border-green-400">
                        <div class="w-10 h-10 sm:w-12 sm:h-12 bg-gradient-to-br from-green-600 to-green-700 text-white rounded-full flex items-center justify-center font-bold text-lg sm:text-xl mb-4 shadow-lg group-hover:scale-110 transition-all duration-300">7</div>
                        <h4 class="font-bold text-green-800 text-lg mb-2">PELAKSANAAN</h4>
                        <p class="text-sm text-green-700">Masuk ruang kunjungan & bertemu WBP.</p>
                    </div>
                    <div class="relative flex flex-col items-center text-center p-4 sm:p-6 bg-gradient-to-br from-slate-50 to-slate-100 rounded-xl hover:shadow-xl transition-all duration-300 border border-slate-200 group hover:border-yellow-300 card-hover-scale">
                        <div class="w-10 h-10 sm:w-12 sm:h-12 bg-white border-4 border-slate-200 text-slate-500 rounded-full flex items-center justify-center font-bold text-lg sm:text-xl mb-4 shadow-lg group-hover:border-yellow-500 group-hover:text-yellow-600 transition-all duration-300">8</div>
                        <h4 class="font-bold text-slate-900 text-lg mb-2">Selesai</h4>
                        <p class="text-sm text-slate-600">Ambil KTP & kembalikan ID Card.</p>
                    </div>
                    <div class="relative flex flex-col items-center text-center p-4 sm:p-6 bg-gradient-to-br from-slate-50 to-slate-100 rounded-xl hover:shadow-xl transition-all duration-300 border border-slate-200 group hover:border-yellow-300 card-hover-scale">
                        <div class="w-10 h-10 sm:w-12 sm:h-12 bg-white border-4 border-slate-200 text-slate-500 rounded-full flex items-center justify-center font-bold text-lg sm:text-xl mb-4 shadow-lg group-hover:border-yellow-500 group-hover:text-yellow-600 transition-all duration-300">9</div>
                        <h4 class="font-bold text-slate-900 text-lg mb-2">Pulang</h4>
                        <p class="text-sm text-slate-600">Cek stempel & tinggalkan area Lapas.</p>
                    </div>
                </div>
            </div>

            {{-- 3. KETENTUAN BARANG BAWAAN (FULL VERSION) --}}
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-12">
                {{-- A. DIPERBOLEHKAN --}}
                <div class="bg-white rounded-2xl shadow-2xl overflow-hidden border border-slate-100 h-full">
                    <div class="bg-gradient-to-r from-yellow-400 to-yellow-600 px-4 py-3 sm:px-6 sm:py-4 flex items-center justify-between">
                        <h3 class="font-extrabold text-slate-900 text-base sm:text-lg flex items-center gap-2">
                            <i class="fa-solid fa-check-circle text-green-600"></i> DIPERBOLEHKAN
                        </h3>
                        <div class="w-8 h-8 bg-white bg-opacity-20 rounded-full flex items-center justify-center">
                            <i class="fa-solid fa-plus text-yellow-800"></i>
                        </div>
                    </div>
                    <div class="p-4 sm:p-6 space-y-5">
                        <div class="flex gap-4 items-start p-3 sm:p-4 bg-gradient-to-r from-yellow-50 to-yellow-100 rounded-lg border border-yellow-200 hover:shadow-md transition-all duration-300 card-hover-scale">
                            <div class="w-12 h-12 flex-shrink-0 bg-yellow-200 rounded-full flex items-center justify-center text-xl sm:text-2xl shadow-sm">🍇</div>
                            <div>
                                <h4 class="font-bold text-slate-800">Buah-buahan</h4>
                                <p class="text-sm text-slate-600 mt-1">Wajib <strong>dikupas, potong, tanpa biji</strong>. (Salak/Durian dilarang).</p>
                            </div>
                        </div>
                        <div class="flex gap-4 items-start p-3 sm:p-4 bg-gradient-to-r from-yellow-50 to-yellow-100 rounded-lg border border-yellow-200 hover:shadow-md transition-all duration-300 card-hover-scale">
                            <div class="w-12 h-12 flex-shrink-0 bg-yellow-200 rounded-full flex items-center justify-center text-xl sm:text-2xl shadow-sm">🍜</div>
                            <div>
                                <h4 class="font-bold text-slate-800">Makanan Berkuah</h4>
                                <p class="text-sm text-slate-600 mt-1">Harus <strong>BENING & POLOS</strong>. Tanpa kecap/sambal campur.</p>
                            </div>
                        </div>
                        <div class="flex gap-4 items-start p-3 sm:p-4 bg-gradient-to-r from-yellow-50 to-yellow-100 rounded-lg border border-yellow-200 hover:shadow-md transition-all duration-300 card-hover-scale">
                            <div class="w-12 h-12 flex-shrink-0 bg-yellow-200 rounded-full flex items-center justify-center text-xl sm:text-2xl shadow-sm">🍗</div>
                            <div>
                                <h4 class="font-bold text-slate-800">Lauk Pauk</h4>
                                <p class="text-sm text-slate-600 mt-1">Terlihat jelas isinya. Telur wajib dibelah. (Jeroan dilarang).</p>
                            </div>
                        </div>
                        <div class="flex gap-4 items-start p-3 sm:p-4 bg-gradient-to-r from-yellow-50 to-yellow-100 rounded-lg border border-yellow-200 hover:shadow-md transition-all duration-300 card-hover-scale">
                            <div class="w-12 h-12 flex-shrink-0 bg-yellow-200 rounded-full flex items-center justify-center text-xl sm:text-2xl shadow-sm">🛍️</div>
                            <div>
                                <h4 class="font-bold text-slate-800">Kemasan</h4>
                                <p class="text-sm text-slate-600 mt-1">Wajib <strong>Plastik Bening</strong> (Ukuran 45). 1 Plastik per rombongan.</p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- B. DILARANG --}}
                <div class="bg-white rounded-2xl shadow-2xl overflow-hidden border border-slate-100 h-full">
                    <div class="bg-gradient-to-r from-red-600 to-red-700 px-4 py-3 sm:px-6 sm:py-4 flex items-center justify-between">
                        <h3 class="font-extrabold text-white text-base sm:text-lg flex items-center gap-2">
                            <i class="fa-solid fa-ban"></i> DILARANG KERAS
                        </h3>
                        <div class="w-8 h-8 bg-white bg-opacity-20 rounded-full flex items-center justify-center">
                            <i class="fa-solid fa-xmark text-red-800"></i>
                        </div>
                    </div>
                    <div class="p-4 sm:p-6">
                        <div class="grid grid-cols-2 sm:grid-cols-3 gap-4 text-center">
                            <div class="bg-gradient-to-br from-red-50 to-red-100 p-3 sm:p-4 rounded-lg flex flex-col items-center justify-center h-20 sm:h-24 hover:shadow-lg transition-all duration-300 card-hover-scale border border-red-200">
                                <span class="text-xl sm:text-2xl mb-2">🍢</span>
                                <span class="text-xs font-bold text-red-800 leading-tight">Makanan Berongga</span>
                            </div>
                            <div class="bg-gradient-to-br from-red-50 to-red-100 p-3 sm:p-4 rounded-lg flex flex-col items-center justify-center h-20 sm:h-24 hover:shadow-lg transition-all duration-300 card-hover-scale border border-red-200">
                                <span class="text-xl sm:text-2xl mb-2">🥤</span>
                                <span class="text-xs font-bold text-red-800 leading-tight">Minuman / Cairan</span>
                            </div>
                            <div class="bg-gradient-to-br from-red-50 to-red-100 p-3 sm:p-4 rounded-lg flex flex-col items-center justify-center h-20 sm:h-24 hover:shadow-lg transition-all duration-300 card-hover-scale border border-red-200">
                                <span class="text-xl sm:text-2xl mb-2">🍞</span>
                                <span class="text-xs font-bold text-red-800 leading-tight">Kemasan Pabrik</span>
                            </div>
                            <div class="bg-gradient-to-br from-red-50 to-red-100 p-3 sm:p-4 rounded-lg flex flex-col items-center justify-center h-20 sm:h-24 hover:shadow-lg transition-all duration-300 card-hover-scale border border-red-200">
                                <span class="text-xl sm:text-2xl mb-2">🦀</span>
                                <span class="text-xs font-bold text-red-800 leading-tight">Makanan Bercangkang</span>
                            </div>
                            <div class="bg-gradient-to-br from-red-50 to-red-100 p-3 sm:p-4 rounded-lg flex flex-col items-center justify-center h-20 sm:h-24 hover:shadow-lg transition-all duration-300 card-hover-scale border border-red-200">
                                <span class="text-xl sm:text-2xl mb-2">🧂</span>
                                <span class="text-xs font-bold text-red-800 leading-tight">Saos Sachet</span>
                            </div>
                            <div class="bg-gradient-to-br from-red-50 to-red-100 p-3 sm:p-4 rounded-lg flex flex-col items-center justify-center h-20 sm:h-24 hover:shadow-lg transition-all duration-300 card-hover-scale border border-red-200">
                                <span class="text-xl sm:text-2xl mb-2">🚬</span>
                                <span class="text-xs font-bold text-red-800 leading-tight">Rokok / Korek</span>
                            </div>
                            <div class="bg-gradient-to-br from-red-50 to-red-100 p-3 sm:p-4 rounded-lg flex flex-col items-center justify-center h-20 sm:h-24 hover:shadow-lg transition-all duration-300 card-hover-scale border border-red-200">
                                <span class="text-xl sm:text-2xl mb-2">📱</span>
                                <span class="text-xs font-bold text-red-800 leading-tight">HP / Elektronik</span>
                            </div>
                            <div class="bg-gradient-to-br from-red-50 to-red-100 p-3 sm:p-4 rounded-lg flex flex-col items-center justify-center h-20 sm:h-24 hover:shadow-lg transition-all duration-300 card-hover-scale border border-red-200">
                                <span class="text-xl sm:text-2xl mb-2">💊</span>
                                <span class="text-xs font-bold text-red-800 leading-tight">Obat / Narkoba</span>
                            </div>
                            <div class="bg-gradient-to-br from-red-50 to-red-100 p-3 sm:p-4 rounded-lg flex flex-col items-center justify-center h-20 sm:h-24 hover:shadow-lg transition-all duration-300 card-hover-scale border border-red-200">
                                <span class="text-xl sm:text-2xl mb-2">🤢</span>
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
                    class="group relative inline-flex items-center justify-start overflow-hidden rounded-full bg-gradient-to-r from-blue-950 to-black px-8 py-4 sm:px-12 sm:py-6 font-bold text-white transition-all duration-300 hover:from-black hover:to-blue-950 hover:scale-105 shadow-2xl hover:shadow-blue-900/50 border-2 border-yellow-500 border-opacity-50">
                    <span class="absolute right-0 -mt-12 h-32 w-8 translate-x-12 rotate-12 bg-gradient-to-b from-yellow-500 to-yellow-600 opacity-30 transition-all duration-1000 ease-out group-hover:-translate-x-40"></span>
                    <span class="relative flex items-center gap-3 text-base sm:text-lg tracking-wide">
                        <i class="fa-solid fa-file-signature text-yellow-400"></i>
                        ISI FORMULIR PENDAFTARAN
                        <i class="fa-solid fa-arrow-right group-hover:translate-x-1 transition"></i>
                    </span>
                </button>
            </div>
        </div>
    </div>

    {{-- ============================================================== --}}
    {{-- BAGIAN 2: FORMULIR PENDAFTARAN --}}
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
                    <h2 class="text-xl sm:text-2xl font-bold text-yellow-400 flex items-center gap-2">
                        <i class="fa-solid fa-clipboard-list"></i>
                        Formulir Kunjungan
                    </h2>
                    <p class="text-gray-200 text-sm mt-1">Lengkapi data di bawah ini dengan benar dan lengkap.</p>
                </div>
                <button @click="showForm = false" class="relative z-10 text-gray-300 hover:text-white transition flex items-center gap-2 text-sm font-semibold bg-blue-800 bg-opacity-50 hover:bg-opacity-70 px-4 py-2 rounded-lg shadow-md backdrop-blur-sm">
                    <i class="fa-solid fa-xmark text-lg"></i> Batal
                </button>
            </div>

            <div class="p-4 sm:p-10">
                {{-- ALERT BAWAAN --}}
                @if (session('success'))
                    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded-lg mb-8" role="alert">
                        <p class="font-bold">Berhasil!</p>
                        <p>{{ session('success') }}</p>
                    </div>
                @endif
                @if (session('error'))
                    <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-lg mb-8" role="alert">
                        <p class="font-bold">Gagal!</p>
                        <p>{{ session('error') }}</p>
                    </div>
                @endif

                {{-- ALERT VALIDASI --}}
                @if ($errors->any())
                <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6 rounded-r shadow-md">
                    <div class="ml-3">
                        <h3 class="text-sm font-bold text-red-800">Periksa Inputan Anda</h3>
                        <ul class="list-disc list-inside text-sm text-red-700 mt-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                @endif

                {{-- FORM START (Tambahkan x-data untuk handling loading) --}}
                <form method="POST" action="{{ route('kunjungan.store') }}" enctype="multipart/form-data" class="space-y-8 animate-fade-in" x-data="{ isSubmitting: false }" @submit="isSubmitting = true" @reset-submitting.window="isSubmitting = false">
                    @csrf

                    {{-- Data Pengunjung --}}
                    <div class="bg-gradient-to-r from-blue-50 to-gray-50 p-4 sm:p-6 rounded-2xl border border-blue-100 animate-slide-up">
                        <h3 class="text-base sm:text-lg font-bold text-slate-800 border-b-2 border-blue-200 pb-3 mb-6 flex items-center gap-3">
                            <span class="bg-gradient-to-r from-blue-600 to-blue-700 text-white text-xs font-extrabold px-3 py-1.5 rounded-full shadow-md flex items-center gap-1 animate-pulse">
                                <i class="fa-solid fa-user"></i> 1
                            </span> 
                            <span class="text-blue-800">Data Pengunjung</span>
                        </h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="group">
                                <label class="block text-sm font-semibold text-slate-700 mb-2 flex items-center gap-2">
                                    <i class="fa-solid fa-id-card text-blue-500"></i> Nama Lengkap (Sesuai KTP)
                                </label>
                                <input id="nama_pengunjung" type="text" name="nama_pengunjung" value="{{ old('nama_pengunjung') }}" class="w-full rounded-xl border-2 border-gray-200 focus:ring-2 focus:ring-yellow-400 focus:border-yellow-500 transition-all duration-300 shadow-sm py-3 px-4 bg-white @error('nama_pengunjung') border-red-500 @enderror" required placeholder="Budi Santoso">
                            </div>

                            <div class="group">
                                <label class="block text-sm font-semibold text-slate-700 mb-2 flex items-center gap-2">
                                    <i class="fa-solid fa-hashtag text-blue-500"></i> NIK (16 Digit)
                                </label>
                                <input id="nik_ktp" type="text" name="nik_ktp" value="{{ old('nik_ktp') }}" class="w-full rounded-xl border-2 border-gray-200 focus:ring-2 focus:ring-yellow-400 focus:border-yellow-500 transition-all duration-300 shadow-sm py-3 px-4 bg-white @error('nik_ktp') border-red-500 @enderror" required placeholder="351xxxxxxxxx" maxlength="16">
                            </div>

                            <div class="group">
                                <label class="block text-sm font-semibold text-slate-700 mb-2 flex items-center gap-2">
                                    <i class="fa-solid fa-venus-mars text-blue-500"></i> Jenis Kelamin
                                </label>
                                <select id="jenis_kelamin" name="jenis_kelamin" class="w-full rounded-xl border-2 border-gray-200 focus:ring-2 focus:ring-yellow-400 focus:border-yellow-500 py-3 px-4 bg-white" required>
                                    <option value="">- Pilih -</option>
                                    <option value="Laki-laki" {{ old('jenis_kelamin') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                    <option value="Perempuan" {{ old('jenis_kelamin') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                                </select>
                            </div>

                            <div class="group">
                                <label class="block text-sm font-semibold text-slate-700 mb-2 flex items-center gap-2">
                                    <i class="fa-brands fa-whatsapp text-green-500"></i> Nomor WhatsApp
                                </label>
                                <input id="nomor_hp" type="text" name="nomor_hp" value="{{ old('nomor_hp') }}" class="w-full rounded-xl border-2 border-gray-200 focus:ring-2 focus:ring-yellow-400 focus:border-yellow-500 py-3 px-4 bg-white" required placeholder="08xxxxxxxx">
                            </div>

                            <div class="group">
                                <label class="block text-sm font-semibold text-slate-700 mb-2 flex items-center gap-2">
                                    <i class="fa-solid fa-envelope text-blue-500"></i> Alamat Email (Wajib)
                                </label>
                                <input id="email_pengunjung" type="email" name="email_pengunjung" value="{{ old('email_pengunjung') }}" class="w-full rounded-xl border-2 border-gray-200 focus:ring-2 focus:ring-yellow-400 py-3 px-4 bg-white" required placeholder="contoh@gmail.com">
                                <p class="text-[10px] text-slate-400 mt-1">*Tiket dan Status akan dikirim ke email ini.</p>
                            </div>

                            <div class="md:col-span-2 group">
                                <label class="block text-sm font-semibold text-slate-700 mb-2 flex items-center gap-2">
                                    <i class="fa-solid fa-map-marker-alt text-red-500"></i> Alamat Lengkap
                                </label>
                                <input id="alamat_lengkap" type="text" name="alamat_lengkap" value="{{ old('alamat_lengkap') }}" class="w-full rounded-xl border-2 border-gray-200 focus:ring-2 focus:ring-yellow-400 focus:border-yellow-500 py-3 px-4 bg-white" required placeholder="Jalan, RT/RW, Desa, Kecamatan">
                            </div>

                            <div class="md:col-span-2 group">
                                <label class="block text-sm font-semibold text-slate-700 mb-2 flex items-center gap-2">
                                    <i class="fa-solid fa-paper-plane text-purple-500"></i> Kanal Notifikasi Pilihan
                                </label>
                                <div class="flex gap-2 rounded-xl bg-slate-200 p-1 border-2 border-gray-200">
                                    <label class="flex-1 text-center cursor-pointer">
                                        <input type="radio" name="preferred_notification_channel" value="email" class="hidden peer" checked>
                                        <span class="block w-full py-2 px-4 rounded-lg text-sm font-semibold text-slate-600 bg-white peer-checked:bg-blue-600 peer-checked:text-white peer-checked:shadow-md transition-all">
                                            <i class="fa-solid fa-envelope mr-1"></i> Email
                                        </span>
                                    </label>
                                    <label class="flex-1 text-center cursor-pointer">
                                        <input type="radio" name="preferred_notification_channel" value="whatsapp" class="hidden peer" {{ old('preferred_notification_channel') == 'whatsapp' ? 'checked' : '' }}>
                                        <span class="block w-full py-2 px-4 rounded-lg text-sm font-semibold text-slate-600 bg-white peer-checked:bg-green-600 peer-checked:text-white peer-checked:shadow-md transition-all">
                                            <i class="fa-brands fa-whatsapp mr-1"></i> WhatsApp
                                        </span>
                                    </label>
                                </div>
                                <p class="text-[10px] text-slate-400 mt-1">*Pilih metode pengiriman status pendaftaran dan tiket barcode.</p>
                            </div>

                            <div class="md:col-span-2 group">
                                <label class="block text-sm font-semibold text-slate-700 mb-2 flex items-center gap-2">
                                    <i class="fa-solid fa-box-open text-orange-500"></i> Barang Bawaan (Opsional)
                                </label>
                                <input type="text" name="barang_bawaan" value="{{ old('barang_bawaan') }}" class="w-full rounded-xl border-2 border-gray-200 focus:ring-2 focus:ring-yellow-400 focus:border-yellow-500 transition-all duration-300 shadow-sm py-3 px-4 bg-white hover:border-blue-300" placeholder="Contoh: Baju ganti, makanan ringan, obat-obatan">
                                <p class="text-[10px] text-slate-400 mt-1">*Sebutkan barang yang dibawa untuk pemeriksaan petugas.</p>
                            </div>

                            <div class="md:col-span-2 group">
                                <label class="block text-sm font-semibold text-slate-700 mb-2 flex items-center gap-2">
                                    <i class="fa-solid fa-camera text-slate-500"></i> Upload Foto KTP (Wajib, Max 2MB)
                                </label>
                                <input type="file" name="foto_ktp" accept="image/*" class="w-full rounded-xl border-2 border-gray-200 focus:ring-2 focus:ring-yellow-400 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100" required>
                            </div>
                        </div>
                    </div>

                    {{-- Data WBP (AUTOCOMPLETE) --}}
                    <div class="mt-8 bg-gradient-to-r from-yellow-50 to-orange-50 p-4 sm:p-6 rounded-2xl border border-yellow-100 animate-slide-up-delay">
                        <h3 class="text-base sm:text-lg font-bold text-slate-800 border-b-2 border-yellow-200 pb-3 mb-6 flex items-center gap-3">
                            <span class="bg-gradient-to-r from-yellow-500 to-yellow-600 text-slate-900 text-xs font-extrabold px-3 py-1.5 rounded-full shadow-md flex items-center gap-1 animate-pulse">
                                <i class="fa-solid fa-users"></i> 2
                            </span> 
                            <span class="text-yellow-800">Data Tujuan Kunjungan</span>
                        </h3>
                        
                        <div class="bg-red-50 border-l-4 border-red-400 p-4 mb-6 rounded-r-lg" role="alert">
                            <div class="flex">
                                <div class="py-1">
                                    <svg class="h-6 w-6 text-red-500 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="font-bold text-red-800">Penting: Aturan Jadwal Pendaftaran</p>
                                    <p class="text-sm text-red-700">Pendaftaran hanya bisa dilakukan <strong>H-1 (satu hari sebelum)</strong>. Khusus pendaftaran untuk hari <strong>Senin</strong>, formulir dibuka pada hari <strong>Jumat, Sabtu, &amp; Minggu</strong>.</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6"
                            x-data="{
                                datesByDay: {{ json_encode($datesByDay) }},
                                selectedDay: '{{ old('selected_day', '') }}',
                                selectedDate: '{{ old('tanggal_kunjungan', '') }}',
                                selectedSesi: '{{ old('sesi', '') }}',
                                availableDates: [],
                                isMonday: false,
                                quotaInfo: '',
                                isLoading: false,
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
                                            sesi: this.isMonday ? this.selectedSesi : 'pagi', 
                                        });
                                        const response = await fetch(`{{ route('kunjungan.quota.api') }}?${params}`);
                                        if (!response.ok) throw new Error('Gagal');
                                        const data = await response.json();
                                        if (data.sisa_kuota > 0) {
                                            this.quotaInfo = `<span class='text-green-600 font-semibold'><i class='fa-solid fa-check-circle mr-1'></i>Sisa Kuota: ${data.sisa_kuota}</span>`;
                                        } else {
                                            this.quotaInfo = `<span class='text-red-600 font-semibold'><i class='fa-solid fa-times-circle mr-1'></i>Kuota Penuh</span>`;
                                        }
                                    } catch (error) {
                                        this.quotaInfo = `<span class='text-red-600'>Gagal cek kuota.</span>`;
                                    } finally {
                                        this.isLoading = false;
                                    }
                                }
                            }">

                            <div class="group relative">
                                <label class="block text-sm font-semibold text-slate-700 mb-2 flex items-center gap-2">
                                    <i class="fa-solid fa-user-tie text-yellow-600"></i> Cari Nama WBP
                                </label>
                                <input type="text" id="wbp_search_input" class="w-full rounded-xl border-2 border-gray-200 focus:ring-2 focus:ring-yellow-400 focus:border-yellow-500 py-3 px-4 bg-white" placeholder="Ketik nama atau no. registrasi..." autocomplete="off"
                                    role="combobox"
                                    aria-haspopup="listbox"
                                    aria-expanded="false"
                                    aria-controls="wbp_results_list">
                                
                                <input type="hidden" name="wbp_id" id="wbp_id_hidden">
                                <div id="wbp_results" role="listbox" class="search-results" aria-label="Hasil pencarian WBP"></div>

                                <div id="selected_wbp_info" class="hidden mt-2 p-3 bg-yellow-100 rounded-lg border border-yellow-300 text-sm text-yellow-800 flex justify-between items-center">
                                    <div>
                                        <strong>Terpilih:</strong> <span id="disp_nama"></span><br>
                                        <span class="text-xs">No.Reg: <span id="disp_noreg"></span> | Blok: <span id="disp_blok"></span></span>
                                    </div>
                                    <button type="button" id="btn_reset_wbp" class="text-red-600 text-xs font-bold underline">Ganti</button>
                                </div>
                            </div>

                            <div class="group">
                                <label class="block text-sm font-semibold text-slate-700 mb-2 flex items-center gap-2">
                                    <i class="fa-solid fa-heart text-red-500"></i> Hubungan
                                </label>
                                <select name="hubungan" class="w-full rounded-xl border-2 border-gray-200 focus:ring-2 focus:ring-yellow-400 py-3 px-4 bg-white" required>
                                    <option value="">- Pilih -</option>
                                    <option value="Istri/Suami">Istri/Suami</option>
                                    <option value="Orang Tua">Orang Tua</option>
                                    <option value="Anak">Anak</option>
                                    <option value="Saudara">Saudara</option>
                                    <option value="Lainnya">Lainnya</option>
                                </select>
                            </div>

                            <div class="group">
                                <label class="block text-sm font-semibold text-slate-700 mb-2 flex items-center gap-2">
                                    <i class="fa-solid fa-calendar-day text-blue-500"></i> Pilih Hari
                                </label>
                                <select name="selected_day" @change="handleDayChange()" x-model="selectedDay" class="w-full rounded-xl border-2 border-gray-200 focus:ring-2 focus:ring-yellow-400 py-3 px-4 bg-white">
                                    <option value="" disabled>Pilih hari...</option>
                                    @foreach (array_keys($datesByDay) as $day)
                                        <option value="{{ $day }}">{{ $day }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="group">
                                <label class="block text-sm font-semibold text-slate-700 mb-2 flex items-center gap-2">
                                    <i class="fa-solid fa-calendar-alt text-green-500"></i> Pilih Tanggal
                                </label>
                                <select name="tanggal_kunjungan" x-model="selectedDate" :disabled="!selectedDay" class="w-full rounded-xl border-2 border-gray-200 focus:ring-2 focus:ring-yellow-400 py-3 px-4 bg-white disabled:bg-gray-100">
                                    <option value="" disabled>-- Pilih hari dulu --</option>
                                    <template x-for="date in availableDates" :key="date.value">
                                        <option :value="date.value" x-text="date.label"></option>
                                    </template>
                                </select>
                                <div class="mt-2 text-sm" x-html="quotaInfo"></div>
                            </div>

                            <div x-show="isMonday" class="md:col-span-2 bg-blue-50 p-4 rounded-xl border border-blue-200">
                                <label class="block text-sm font-semibold text-slate-700 mb-2">
                                    <i class="fa-solid fa-clock text-blue-600"></i> Sesi Kunjungan (Senin)
                                </label>
                                <select name="sesi" x-model="selectedSesi" class="w-full rounded-xl border-2 border-gray-200 focus:ring-2 focus:ring-yellow-400 py-3 px-4 bg-white">
                                    <option value="" disabled>Pilih sesi...</option>
                                    <option value="pagi">Sesi Pagi (08:30 - 10:00)</option>
                                    <option value="siang">Sesi Siang (13:30 - 14:30)</option>
                                </select>
                            </div>
                        </div>
                    </div>

                   {{-- DATA PENGIKUT --}}
                    <div class="mt-8 bg-gradient-to-r from-emerald-50 to-green-50 p-4 sm:p-6 rounded-2xl border border-emerald-100 animate-slide-up-delay" 
                         x-data="{ 
                             followers: []
                         }">
                        
                        <div class="border-b-2 border-emerald-200 pb-3 mb-6 flex justify-between items-center">
                            <h3 class="text-base sm:text-lg font-bold text-slate-800 flex items-center gap-3">
                                <span class="bg-gradient-to-r from-emerald-500 to-green-600 text-white text-xs font-extrabold px-3 py-1.5 rounded-full shadow-md flex items-center gap-1 animate-pulse">
                                    <i class="fa-solid fa-users"></i> 3
                                </span> 
                                <span class="text-emerald-800">Data Pengikut (Maksimal 4 Orang)</span>
                            </h3>
                            
                            <div>
                                <button type="button" 
                                    @click="if(followers.length < 4) followers.push({id: Date.now()})"
                                    :disabled="followers.length >= 4"
                                    :class="followers.length >= 4 ? 'bg-slate-400 cursor-not-allowed' : 'bg-emerald-600 hover:bg-emerald-700'"
                                    class="text-xs text-white font-bold py-2 px-3 rounded-lg shadow transition flex items-center gap-1"
                                    aria-label="Tambah pengikut">
                                    <i class="fa-solid fa-plus"></i> Tambah Orang
                                </button>
                            </div>
                        </div>

                        <p x-show="followers.length >= 4" x-transition class="text-center text-sm font-semibold text-red-600 bg-red-100 border border-red-300 rounded-lg p-2 mb-4">
                            <i class="fa-solid fa-exclamation-circle mr-1"></i> Anda telah mencapai batas maksimal 4 pengikut.
                        </p>

                        <div class="space-y-6">
                            <template x-for="(follower, index) in followers" :key="follower.id">
                                <div class="bg-white p-5 rounded-xl shadow-sm border border-emerald-200 relative transition-all duration-300 hover:shadow-md animate-fade-in">
                                    
                                    <div class="flex justify-between items-center mb-4">
                                        <span class="text-xs font-bold text-emerald-600 uppercase tracking-wide bg-emerald-50 px-2 py-1 rounded">
                                            Pengikut ke-<span x-text="index + 1"></span>
                                        </span>
                                        <button type="button" @click="followers.splice(index, 1)" class="text-red-500 hover:text-red-700 text-xs font-bold underline">
                                            <i class="fa-solid fa-trash"></i> Hapus
                                        </button>
                                    </div>

                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div>
                                            <label class="block text-xs font-semibold text-slate-600 mb-1">Nama Lengkap</label>
                                            <input type="text" name="pengikut_nama[]" class="w-full rounded-lg border-2 border-gray-200 focus:border-emerald-500 text-sm px-3 py-2" placeholder="Nama sesuai KTP" required>
                                        </div>

                                        <div>
                                            <label class="block text-xs font-semibold text-slate-600 mb-1">NIK (KTP/KIA)</label>
                                            <input type="number" name="pengikut_nik[]" class="w-full rounded-lg border-2 border-gray-200 focus:border-emerald-500 text-sm px-3 py-2" placeholder="Nomor Induk Kependudukan">
                                        </div>

                                        <div>
                                            <label class="block text-xs font-semibold text-slate-600 mb-1">Hubungan</label>
                                            <select name="pengikut_hubungan[]" class="w-full rounded-lg border-2 border-gray-200 focus:border-emerald-500 text-sm px-3 py-2">
                                                <option value="Istri/Suami">Istri/Suami</option>
                                                <option value="Anak">Anak</option>
                                                <option value="Saudara">Saudara</option>
                                                <option value="Orang Tua">Orang Tua</option>
                                                <option value="Lainnya">Lainnya</option>
                                            </select>
                                        </div>

                                        <div>
                                            <label class="block text-xs font-semibold text-slate-600 mb-1">Barang Bawaan</label>
                                            <input type="text" name="pengikut_barang[]" class="w-full rounded-lg border-2 border-gray-200 focus:border-emerald-500 text-sm px-3 py-2" placeholder="Contoh: Baju ganti, Susu bayi">
                                        </div>

                                        <div class="md:col-span-2">
                                            <label class="block text-xs font-semibold text-slate-600 mb-1">Foto KTP/Identitas Pengikut</label>
                                            <input type="file" name="pengikut_foto[]" accept="image/*" class="w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-semibold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100 border border-gray-300 rounded-lg cursor-pointer">
                                            <p class="text-[10px] text-gray-400 mt-1">*Wajib upload foto KTP/KIA/Kartu Pelajar pengikut.</p>
                                        </div>
                                    </div>
                                </div>
                            </template>

                            <div x-show="followers.length === 0" class="text-center py-6 border-2 border-dashed border-emerald-200 rounded-xl bg-white bg-opacity-50">
                                <i class="fa-solid fa-user-plus text-3xl text-emerald-200 mb-2"></i>
                                <p class="text-sm text-slate-500">Tidak ada pengikut tambahan.</p>
                                <p class="text-xs text-slate-400">Klik tombol <strong>+ Tambah Orang</strong> jika Anda membawa teman/keluarga.</p>
                            </div>
                        </div>
                    </div>

                    {{-- Tombol Kirim dengan Loading --}}
                    <div class="pt-8 border-t-2 border-gray-200 flex flex-col-reverse sm:flex-row sm:justify-between items-stretch sm:items-center gap-4 bg-gradient-to-r from-gray-50 to-blue-50 p-4 sm:p-6 rounded-2xl">
                        <button type="button" @click="showForm = false" class="w-full sm:w-auto px-6 py-3 text-slate-600 font-bold hover:text-slate-900 transition bg-gray-100 hover:bg-gray-200 rounded-xl flex items-center justify-center gap-2">
                            <i class="fa-solid fa-arrow-left"></i> Kembali
                        </button>
                        <button type="submit" :disabled="isSubmitting" :class="isSubmitting ? 'opacity-75 cursor-wait' : 'hover:scale-105'" class="w-full sm:w-auto bg-gradient-to-r from-yellow-500 to-yellow-600 text-slate-900 font-bold px-8 py-4 rounded-xl shadow-xl transition transform flex items-center justify-center gap-3 text-base sm:text-lg">
                            <template x-if="!isSubmitting">
                                <span class="flex items-center gap-3"><i class="fa-solid fa-paper-plane sm:text-xl"></i> KIRIM</span>
                            </template>
                            <template x-if="isSubmitting">
                                <span class="flex items-center gap-2">
                                    <svg class="animate-spin h-5 w-5 text-slate-900" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                    </svg>
                                    Mengirim...
                                </span>
                            </template>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- SCRIPT AREA --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        @if(session('error_duplicate_entry'))
            Swal.fire({ icon: 'warning', title: 'Antrian Padat', text: "{!! session('error_duplicate_entry') !!}", confirmButtonText: 'Baik, Saya Coba Lagi', confirmButtonColor: '#3085d6' });
        @endif
        @if(session('error'))
            Swal.fire({ icon: 'error', title: 'Pendaftaran Ditolak', text: "{!! session('error') !!}", confirmButtonText: 'Saya Mengerti', confirmButtonColor: '#d33', background: '#fff', allowOutsideClick: false });
        @endif
        @if($errors->any())
            let pesanError = '<ul style="text-align: left; margin-left: 20px;">';
            @foreach($errors->all() as $error) pesanError += '<li>{{ $error }}</li>'; @endforeach
            pesanError += '</ul>';
            Swal.fire({ icon: 'warning', title: 'Data Belum Lengkap / Salah', html: pesanError, confirmButtonText: 'Perbaiki', confirmButtonColor: '#f59e0b' });
        @endif
        
        // --- BAGIAN INI YANG DIPERBAIKI ---
        @if(session('success') && session('kunjungan_id'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: "{{ session('success') }}",
                confirmButtonText: 'Lihat Status',
                confirmButtonColor: '#10b981', // Koma ditambahkan di sini
                allowOutsideClick: false // Supaya user terpaksa klik tombol
            }).then((result) => {
                if (result.isConfirmed) {
                    // Redirect ke halaman status menggunakan ID dari session
                    window.location.href = "{{ route('kunjungan.status', session('kunjungan_id')) }}";
                }
            });
        @elseif(session('success'))
            Swal.fire({ icon: 'success', title: 'Berhasil!', text: "{{ session('success') }}", confirmButtonText: 'OK', confirmButtonColor: '#10b981' });
        @endif
        // ----------------------------------

        // Client-side validation: ukuran file maksimal 2MB
        const MAX_BYTES = 2 * 1024 * 1024;
        const formEl = document.querySelector('form[action="{{ route('kunjungan.store') }}"]');
        if (formEl) {
            formEl.addEventListener('submit', function(e) {
                // Foto KTP
                const foto = formEl.querySelector('input[name="foto_ktp"]');
                if (foto && foto.files && foto.files.length) {
                    if (foto.files[0].size > MAX_BYTES) {
                        e.preventDefault();
                        formEl.dispatchEvent(new CustomEvent('reset-submitting', { bubbles: true }));
                        Swal.fire({ icon:'error', title:'Ukuran File Terlalu Besar', text: 'Foto KTP melebihi 2MB. Silakan kompres atau pilih file lain.', confirmButtonText:'OK', confirmButtonColor:'#d33' });
                        return false;
                    }
                }

                // Foto pengikut
                const pengikutFiles = formEl.querySelectorAll('input[name="pengikut_foto[]"]');
                for (const input of pengikutFiles) {
                    if (input.files && input.files.length) {
                        if (input.files[0].size > MAX_BYTES) {
                            e.preventDefault();
                            formEl.dispatchEvent(new CustomEvent('reset-submitting', { bubbles: true }));
                            Swal.fire({ icon:'error', title:'Ukuran File Terlalu Besar', text: 'Salah satu foto pengikut melebihi 2MB. Silakan kompres atau pilih file lain.', confirmButtonText:'OK', confirmButtonColor:'#d33' });
                            return false;
                        }
                    }
                }
            });

            // Client-side compression helper. Compress images on file selection to reduce upload size.
            function compressImageFile(file, maxWidth = 1200, quality = 0.8) {
                return new Promise((resolve, reject) => {
                    if (!file.type.startsWith('image/')) return reject(new Error('Not an image'));
                    const img = new Image();
                    const reader = new FileReader();
                    reader.onload = function(e) { img.src = e.target.result; };
                    img.onerror = () => reject(new Error('Failed to load image'));
                    img.onload = function() {
                        const canvas = document.createElement('canvas');
                        let width = img.width;
                        let height = img.height;
                        if (width > maxWidth) {
                            const ratio = maxWidth / width;
                            width = Math.round(width * ratio);
                            height = Math.round(height * ratio);
                        }
                        canvas.width = width;
                        canvas.height = height;
                        const ctx = canvas.getContext('2d');
                        ctx.drawImage(img, 0, 0, width, height);
                        canvas.toBlob((blob) => {
                            if (!blob) return reject(new Error('Canvas toBlob failed'));
                            // If compressed blob still too large, reduce quality progressively
                            const tryCompress = (blobCandidate, q, attemptsLeft = 3) => {
                                if (blobCandidate.size <= MAX_BYTES || attemptsLeft <= 0) {
                                    const compressedFile = new File([blobCandidate], file.name.replace(/\.[^/.]+$/, '') + '.jpg', { type: 'image/jpeg' });
                                    return resolve(compressedFile);
                                }
                                // reduce quality and retry
                                canvas.toBlob((b) => tryCompress(b, q * 0.7, attemptsLeft - 1), 'image/jpeg', q * 0.7);
                            };
                            tryCompress(blob, quality, 3);
                        }, 'image/jpeg', quality);
                    };
                    reader.readAsDataURL(file);
                });
            }

            // Hook for main KTP input
            const fotoInput = document.querySelector('input[name="foto_ktp"]');
            if (fotoInput) {
                fotoInput.addEventListener('change', async function(e) {
                    const file = this.files && this.files[0];
                    if (!file) return;
                    if (file.size <= MAX_BYTES) return; // already OK
                    try {
                        const compressed = await compressImageFile(file);
                        const dataTransfer = new DataTransfer();
                        dataTransfer.items.add(compressed);
                        this.files = dataTransfer.files;
                        if (compressed.size > MAX_BYTES) {
                            Swal.fire({ icon:'warning', title:'Hasil Kompres Masih Besar', text:'Setelah kompres, file masih lebih dari 2MB. Silakan pilih file yang lebih kecil.', confirmButtonText:'OK', confirmButtonColor:'#d33' });
                        }
                    } catch (err) {
                        console.warn('Compress failed', err);
                        Swal.fire({ icon:'warning', title:'Gagal Kompres', text:'Gagal mengompres gambar di perangkat Anda. Silakan unggah gambar yang lebih kecil.', confirmButtonText:'OK', confirmButtonColor:'#d33' });
                    }
                });
            }

            // Delegate for dynamic pengikut file inputs
            document.addEventListener('change', async function(ev) {
                const input = ev.target;
                if (input && input.matches('input[name="pengikut_foto[]"]')) {
                    const file = input.files && input.files[0];
                    if (!file) return;
                    if (file.size <= MAX_BYTES) return;
                    try {
                        const compressed = await compressImageFile(file);
                        const dataTransfer = new DataTransfer();
                        dataTransfer.items.add(compressed);
                        input.files = dataTransfer.files;
                        if (compressed.size > MAX_BYTES) {
                            Swal.fire({ icon:'warning', title:'Hasil Kompres Masih Besar', text:'Salah satu foto pengikut tetap lebih dari 2MB setelah kompres. Silakan pilih file lain.', confirmButtonText:'OK', confirmButtonColor:'#d33' });
                        }
                    } catch (err) {
                        console.warn('Compress failed', err);
                        Swal.fire({ icon:'warning', title:'Gagal Kompres', text:'Gagal mengompres gambar di perangkat Anda. Silakan unggah gambar yang lebih kecil.', confirmButtonText:'OK', confirmButtonColor:'#d33' });
                    }
                }
            });
        }
    });

    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('wbp_search_input');
        const resultsDiv = document.getElementById('wbp_results');
        const hiddenId = document.getElementById('wbp_id_hidden');
        const infoDiv = document.getElementById('selected_wbp_info');
        const btnReset = document.getElementById('btn_reset_wbp');

        if(searchInput) {
            searchInput.addEventListener('keyup', function() {
                let query = this.value;
                hiddenId.value = ''; 
                
                if(query.length > 2) {
                    fetch(`{{ route('api.search.wbp') }}?q=${query}`)
                        .then(res => res.json())
                        .then(data => {
                            resultsDiv.innerHTML = '';
                            resultsDiv.style.display = 'block';
                            searchInput.setAttribute('aria-expanded', 'true');
                            
                            if(data.length === 0) {
                                resultsDiv.innerHTML = '<div class="p-3 text-sm text-gray-500 italic">Data tidak ditemukan.</div>';
                            }
                            
                            data.forEach(item => {
                                let div = document.createElement('div');
                                div.className = 'wbp-item';
                                div.setAttribute('role', 'option');
                                div.innerHTML = `<div><strong>${item.nama}</strong><br><span class="text-xs text-gray-500">${item.no_registrasi}</span></div>`;
                                
                                div.onclick = () => {
                                    searchInput.value = item.nama; 
                                    hiddenId.value = item.id;      
                                    infoDiv.classList.remove('hidden');
                                    document.getElementById('disp_nama').innerText = item.nama;
                                    document.getElementById('disp_noreg').innerText = item.no_registrasi;
                                    document.getElementById('disp_blok').innerText = item.blok || '-'; 
                                    searchInput.classList.add('hidden');
                                    resultsDiv.style.display = 'none';
                                    searchInput.setAttribute('aria-expanded', 'false');
                                };
                                resultsDiv.appendChild(div);
                            });
                        })
                        .catch(err => {
                            console.error(err);
                            resultsDiv.innerHTML = '<div class="p-3 text-sm text-red-500 italic">Gagal memuat data.</div>';
                        });
                } else {
                    resultsDiv.style.display = 'none';
                    searchInput.setAttribute('aria-expanded', 'false');
                }
            });
        }

        if(btnReset) {
            btnReset.addEventListener('click', function() {
                hiddenId.value = '';
                searchInput.value = '';
                searchInput.classList.remove('hidden');
                infoDiv.classList.add('hidden');
                searchInput.focus();
            });
        }

        document.addEventListener('click', function(e) {
            if (searchInput && resultsDiv) {
                if (!searchInput.contains(e.target) && !resultsDiv.contains(e.target)) {
                    resultsDiv.style.display = 'none';
                    searchInput.setAttribute('aria-expanded', 'false');
                }
            }
        });

        const mainForm = document.querySelector('form');
        if(mainForm) {
            mainForm.addEventListener('submit', function(e) {
                if (!hiddenId.value) {
                    e.preventDefault();
                    // Reset loading state if validation fails
                    if(this.__x) this.__x.$data.isSubmitting = false; 
                    Swal.fire({ icon: 'error', title: 'WBP Belum Dipilih', text: 'Silahkan cari dan klik nama WBP dari daftar pencarian yang muncul.', confirmButtonColor: '#1e3a8a' });
                }
            });
        }
    });

    // SCRIPT AUTO-FILL NIK (DIPERBAIKI)
    document.addEventListener('DOMContentLoaded', function () {
        const nikInput = document.getElementById('nik_ktp');
        const inputsToFill = {
            'nama_pengunjung': document.getElementById('nama_pengunjung'),
            'nomor_hp': document.getElementById('nomor_hp'),
            'email_pengunjung': document.getElementById('email_pengunjung'),
            'alamat_lengkap': document.getElementById('alamat_lengkap'),
            'jenis_kelamin': document.getElementById('jenis_kelamin')
        };
        
        const statusMessage = document.createElement('p');
        statusMessage.className = 'text-xs mt-1 transition-all duration-300';
        nikInput.parentElement.appendChild(statusMessage);

        if (nikInput) {
            nikInput.addEventListener('keyup', function () { 
                const nik = this.value;
                
                if (nik.length !== 16) {
                    statusMessage.textContent = 'NIK harus 16 digit angka.';
                    statusMessage.className = 'text-xs mt-1 text-slate-400';
                    return;
                }

                if (/^\d{16}$/.test(nik)) {
                    statusMessage.innerHTML = '<i class="fa-solid fa-circle-notch fa-spin"></i> Mencari data profil...';
                    statusMessage.className = 'text-xs mt-1 text-blue-600 font-medium';

                    fetch(`/api/profil-by-nik/${nik}`)
                        .then(response => {
                            if (!response.ok) throw new Error(response.status);
                            return response.json();
                        })
                        .then(data => {
                            statusMessage.innerHTML = '<i class="fa-solid fa-check-circle"></i> Data ditemukan! Silakan lengkapi sisa form.';
                            statusMessage.className = 'text-xs mt-1 text-green-600 font-bold';

                            Object.keys(inputsToFill).forEach(key => {
                                if (inputsToFill[key]) { 
                                    let jsonKey = key;
                                    if(key === 'nama_pengunjung') jsonKey = 'nama';
                                    if(key === 'email_pengunjung') jsonKey = 'email';
                                    if(key === 'alamat_lengkap') jsonKey = 'alamat';
                                    
                                    if(data[jsonKey]) {
                                        inputsToFill[key].value = data[jsonKey];
                                        inputsToFill[key].classList.add('bg-blue-50', 'border-blue-300');
                                        setTimeout(() => inputsToFill[key].classList.remove('bg-blue-50', 'border-blue-300'), 1500);
                                    }
                                }
                            });
                        })
                        .catch(error => {
                            if(error.message == '404') {
                                statusMessage.innerHTML = '<i class="fa-solid fa-user-plus"></i> Profil baru. Silakan isi data secara manual.';
                                statusMessage.className = 'text-xs mt-1 text-slate-500 italic';
                            } else {
                                statusMessage.textContent = 'Gagal memuat data. Silakan isi manual.';
                                statusMessage.className = 'text-xs mt-1 text-red-500';
                            }
                        });
                } else {
                      statusMessage.textContent = 'Format NIK harus angka.';
                      statusMessage.className = 'text-xs mt-1 text-red-500';
                }
            });
        }
    });
</script>
@endsection