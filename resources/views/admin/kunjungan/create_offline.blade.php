@extends('layouts.admin')

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<style>
    /* Select2 Overwrite to Match Guest UI Input Look */
    .select2-container .select2-selection--single {
        height: 52px !important; 
        display: flex;
        align-items: center;
        padding-left: 0.75rem;
        border-radius: 0.75rem !important; /* rounded-xl */
        border: 2px solid #e5e7eb !important; /* gray-200 */
        background-color: #ffffff !important;
        transition: all 0.3s ease;
        box-sizing: border-box; 
    }
    .select2-container--default .select2-selection--single:focus-within {
        border-color: #facc15 !important; /* yellow-400 */
        box-shadow: 0 0 0 2px rgba(250, 204, 21, 0.5); /* ring-yellow-400 */
    }
    .select2-container--default .select2-selection--single .select2-selection__rendered {
        color: #334155;
        font-weight: 600;
    }
    .select2-dropdown {
        border-radius: 0.75rem !important;
        border: 1px solid #e5e7eb !important;
        box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1);
        overflow: hidden;
    }

    /* Animation for header shimmer */
    .animate-text-shimmer {
        background: linear-gradient(to right, #fbbf24 20%, #fef3c7 40%, #fef3c7 60%, #fbbf24 80%);
        background-size: 200% auto;
        animation: shimmer 3s linear infinite;
    }
    @keyframes shimmer { to { background-position: 200% center; } }
</style>
@endpush

@section('content')
<div class="max-w-5xl mx-auto space-y-8 pb-20">
    
    {{-- HEADER (GUEST UI STYLE) --}}
    <div class="bg-gradient-to-r from-blue-950 via-blue-900 to-blue-800 rounded-3xl shadow-2xl overflow-hidden border-2 border-gray-200 relative animate__animated animate__fadeInDown">
        <div class="absolute top-0 right-0 w-32 h-32 bg-yellow-500 opacity-10 rounded-full -mr-16 -mt-16"></div>
        <div class="px-8 py-8 flex flex-col md:flex-row justify-between items-center gap-6 relative z-10">
            <div class="text-center md:text-left">
                <h2 class="text-2xl sm:text-3xl font-black text-yellow-400 flex items-center justify-center md:justify-start gap-3">
                    <i class="fa-solid fa-file-signature"></i>
                    Pendaftaran <span class="animate-text-shimmer bg-clip-text text-transparent">Offline</span>
                </h2>
                <p class="text-gray-200 text-sm mt-2 font-medium">Input pendaftaran tamu walk-in dengan standar desain sistem terbaru.</p>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('admin.kunjungan.index') }}" class="text-gray-300 hover:text-white transition flex items-center gap-2 text-sm font-bold bg-blue-800 bg-opacity-50 hover:bg-opacity-70 px-6 py-3 rounded-xl shadow-md backdrop-blur-sm">
                    <i class="fa-solid fa-arrow-left"></i> Kembali
                </a>
            </div>
        </div>
    </div>

    @if (session('error'))
    <div class="bg-red-50 border-l-4 border-red-500 p-6 rounded-r-2xl animate__animated animate__shakeX flex items-center gap-4 text-red-700 shadow-lg" role="alert">
        <div class="w-12 h-12 bg-red-100 rounded-2xl flex items-center justify-center text-red-600 shrink-0">
            <i class="fas fa-exclamation-triangle text-xl"></i>
        </div>
        <p class="font-bold text-sm">{{ session('error') }}</p>
    </div>
    @endif
    
    @if ($errors->any())
    <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6 rounded-r shadow-md" role="alert">
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

    {{-- MAIN FORM CARD WRAPPER --}}
    <div class="max-w-4xl mx-auto bg-gradient-to-br from-white via-gray-50 to-white rounded-3xl shadow-2xl overflow-hidden border-2 border-gray-200">
        {{-- Form Card Header --}}
        <div class="bg-gradient-to-r from-blue-950 via-blue-900 to-blue-800 px-8 py-6 flex justify-between items-center relative overflow-hidden">
            <div class="absolute top-0 right-0 w-32 h-32 bg-yellow-500 opacity-10 rounded-full -mr-16 -mt-16"></div>
            <div class="relative z-10">
                <h2 class="text-xl sm:text-2xl font-bold text-yellow-400 flex items-center gap-2">
                    <i class="fa-solid fa-clipboard-list"></i>
                    Formulir Kunjungan Offline
                </h2>
                <p class="text-gray-200 text-sm mt-1">Lengkapi data di bawah ini dengan benar dan lengkap.</p>
            </div>
        </div>

        {{-- Form Card Body --}}
        <div class="p-4 sm:p-10">
            <form action="{{ route('admin.kunjungan.storeOffline') }}" method="POST" class="space-y-8 animate-fade-in" x-data="{ isSubmitting: false }" @submit="isSubmitting = true">
                @csrf
                
                {{-- Data Pengunjung --}}
                <div class="bg-gradient-to-r from-blue-50 to-gray-50 p-4 sm:p-6 rounded-2xl border border-blue-100 animate-slide-up">
                    <h3 class="text-base sm:text-lg font-bold text-slate-800 border-b-2 border-blue-200 pb-3 mb-6 flex items-center gap-3">
                        <span class="bg-gradient-to-r from-blue-600 to-blue-700 text-white text-xs font-extrabold px-3 py-1.5 rounded-full shadow-md flex items-center gap-1 animate-pulse">
                            <i class="fa-solid fa-user"></i> 1
                        </span> 
                        <span class="text-blue-800">Data Pengunjung Utama</span>
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="group">
                            <label class="block text-sm font-semibold text-slate-700 mb-2 flex items-center gap-2">
                                <i class="fa-solid fa-id-card text-blue-500"></i> Nama Lengkap (Sesuai KTP)
                            </label>
                            <input type="text" name="nama_pengunjung" value="{{ old('nama_pengunjung') }}" class="w-full rounded-xl border-2 border-gray-200 focus:ring-2 focus:ring-yellow-400 focus:border-yellow-500 transition-all duration-300 shadow-sm py-3 px-4 bg-white @error('nama_pengunjung') border-red-500 @enderror" required placeholder="Contoh: BUDI SANTOSO">
                        </div>

                        <div class="group">
                            <label class="block text-sm font-semibold text-slate-700 mb-2 flex items-center gap-2">
                                <i class="fa-solid fa-hashtag text-blue-500"></i> NIK (16 Digit)
                            </label>
                            <input type="text" name="nik_ktp" value="{{ old('nik_ktp') }}" class="w-full rounded-xl border-2 border-gray-200 focus:ring-2 focus:ring-yellow-400 focus:border-yellow-500 transition-all duration-300 shadow-sm py-3 px-4 bg-white @error('nik_ktp') border-red-500 @enderror" required placeholder="3512XXXXXXXXXXXX" maxlength="16">
                        </div>

                        <div class="group">
                            <label class="block text-sm font-semibold text-slate-700 mb-2 flex items-center gap-2">
                                <i class="fa-solid fa-venus-mars text-blue-500"></i> Jenis Kelamin
                            </label>
                            <select name="jenis_kelamin" class="w-full rounded-xl border-2 border-gray-200 focus:ring-2 focus:ring-yellow-400 py-3 px-4 bg-white" required>
                                <option value="">- Pilih -</option>
                                <option value="Laki-laki" {{ old('jenis_kelamin') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                <option value="Perempuan" {{ old('jenis_kelamin') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                            </select>
                        </div>

                        <div class="group">
                            <label class="block text-sm font-semibold text-slate-700 mb-2 flex items-center gap-2">
                                <i class="fa-brands fa-whatsapp text-green-500"></i> Nomor WhatsApp
                            </label>
                            <input type="text" name="no_wa_pengunjung" value="{{ old('no_wa_pengunjung') }}" class="w-full rounded-xl border-2 border-gray-200 focus:ring-2 focus:ring-yellow-400 focus:border-yellow-500 py-3 px-4 bg-white" placeholder="Contoh: 0812345678" required>
                        </div>

                        <div class="group">
                            <label class="block text-sm font-semibold text-slate-700 mb-2 flex items-center gap-2">
                                <i class="fa-solid fa-envelope text-blue-500"></i> Alamat Email (Opsional)
                            </label>
                            <input type="email" name="email_pengunjung" value="{{ old('email_pengunjung') }}" class="w-full rounded-xl border-2 border-gray-200 focus:ring-2 focus:ring-yellow-400 py-3 px-4 bg-white" placeholder="alamat@email.com">
                        </div>

                        <div class="md:col-span-2 group">
                            <label class="block text-sm font-semibold text-slate-700 mb-2 flex items-center gap-2">
                                <i class="fa-solid fa-map-marker-alt text-red-500"></i> Alamat Lengkap
                            </label>
                            <textarea name="alamat_pengunjung" rows="3" class="w-full rounded-xl border-2 border-gray-200 focus:ring-2 focus:ring-yellow-400 focus:border-yellow-500 py-3 px-4 bg-white resize-none" required placeholder="Alamat lengkap sesuai KTP...">{{ old('alamat_pengunjung') }}</textarea>
                        </div>
                    </div>
                </div>

                {{-- Data WBP & Jadwal --}}
                <div class="mt-8 bg-gradient-to-r from-yellow-50 to-orange-50 p-4 sm:p-6 rounded-2xl border border-yellow-100 animate-slide-up-delay">
                    <h3 class="text-base sm:text-lg font-bold text-slate-800 border-b-2 border-yellow-200 pb-3 mb-6 flex items-center gap-3">
                        <span class="bg-gradient-to-r from-yellow-500 to-yellow-600 text-slate-900 text-xs font-extrabold px-3 py-1.5 rounded-full shadow-md flex items-center gap-1 animate-pulse">
                            <i class="fa-solid fa-users"></i> 2
                        </span> 
                        <span class="text-yellow-800">Data Tujuan & Jadwal</span>
                    </h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                        <div class="md:col-span-2 group relative">
                            <label class="block text-sm font-semibold text-slate-700 mb-2 flex items-center gap-2">
                                <i class="fa-solid fa-user-tie text-yellow-600"></i> Cari Nama WBP
                            </label>
                            <select id="wbp_id" name="wbp_id" class="w-full" required>
                                <option value="">Ketik nama atau nomor registrasi WBP...</option>
                            </select>
                        </div>

                        <div class="group">
                            <label class="block text-sm font-semibold text-slate-700 mb-2 flex items-center gap-2">
                                <i class="fa-solid fa-heart text-red-500"></i> Hubungan
                            </label>
                            <select name="hubungan" class="w-full rounded-xl border-2 border-gray-200 focus:ring-2 focus:ring-yellow-400 py-3 px-4 bg-white" required>
                                <option value="" disabled selected>- Pilih -</option>
                                <option value="Istri/Suami" {{ old('hubungan') == 'Istri/Suami' ? 'selected' : '' }}>Istri/Suami</option>
                                <option value="Orang Tua" {{ old('hubungan') == 'Orang Tua' ? 'selected' : '' }}>Orang Tua</option>
                                <option value="Anak" {{ old('hubungan') == 'Anak' ? 'selected' : '' }}>Anak</option>
                                <option value="Saudara" {{ old('hubungan') == 'Saudara' ? 'selected' : '' }}>Saudara</option>
                                <option value="Lainnya" {{ old('hubungan') != '' && !in_array(old('hubungan'), ['Istri/Suami', 'Orang Tua', 'Anak', 'Saudara']) ? 'selected' : '' }}>Lainnya</option>
                            </select>
                        </div>

                        <div class="group">
                            <label class="block text-sm font-semibold text-slate-700 mb-2 flex items-center gap-2">
                                <i class="fa-solid fa-calendar-alt text-green-500"></i> Tanggal Kunjungan
                            </label>
                            <input type="date" name="tanggal_kunjungan" id="tanggal_kunjungan" value="{{ old('tanggal_kunjungan', date('Y-m-d')) }}" class="w-full rounded-xl border-2 border-gray-200 focus:ring-2 focus:ring-yellow-400 py-3 px-4 bg-white" required>
                        </div>

                        <div class="group">
                            <label class="block text-sm font-semibold text-slate-700 mb-2 flex items-center gap-2">
                                <i class="fa-solid fa-clock text-blue-600"></i> Sesi Kunjungan
                            </label>
                            <select id="sesi" name="sesi" class="w-full rounded-xl border-2 border-gray-200 focus:ring-2 focus:ring-yellow-400 py-3 px-4 bg-white" required>
                                <option value="pagi" {{ old('sesi') == 'pagi' ? 'selected' : '' }}>Sesi Pagi (08:30 - 11:30)</option>
                                <option value="siang" {{ old('sesi') == 'siang' ? 'selected' : '' }}>Sesi Siang (13:30 - 15:00)</option>
                            </select>
                        </div>

                        <div class="md:col-span-2 group">
                            <label class="block text-sm font-semibold text-slate-700 mb-2 flex items-center gap-2">
                                <i class="fa-solid fa-users text-purple-600"></i> Status Kuota
                            </label>
                            <div id="quotaContainer" class="px-6 py-3.5 rounded-xl border-2 border-dashed flex items-center justify-between transition-all duration-500 bg-white shadow-inner min-h-[52px]">
                                <div class="flex items-center gap-3">
                                    <div id="quotaIcon" class="w-10 h-10 rounded-full flex items-center justify-center text-lg shadow-sm bg-slate-50 text-slate-400">
                                        <i class="fas fa-info-circle"></i>
                                    </div>
                                    <p id="quotaText" class="text-[10px] font-black uppercase tracking-widest text-slate-500 leading-tight">Menghitung...</p>
                                </div>
                                <div class="text-right">
                                    <div id="quotaLoading"><i class="fas fa-circle-notch fa-spin text-blue-500"></i></div>
                                    <span id="quotaValue" class="text-2xl font-black text-slate-700 hidden">-</span>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                {{-- DATA PENGIKUT --}}
                <div class="mt-8 bg-gradient-to-r from-emerald-50 to-green-50 p-4 sm:p-6 rounded-2xl border border-emerald-100 animate-slide-up-delay" 
                     x-data="{
                         pLaki: {{ old('pengikut_laki', 0) }},
                         pPerempuan: {{ old('pengikut_perempuan', 0) }},
                         pAnak: {{ old('pengikut_anak', 0) }},
                         get total() { return (parseInt(this.pLaki) || 0) + (parseInt(this.pPerempuan) || 0) + (parseInt(this.pAnak) || 0); }
                     }">
                    
                    <h3 class="text-base sm:text-lg font-bold text-slate-800 border-b-2 border-emerald-200 pb-3 mb-6 flex items-center gap-3">
                        <span class="bg-gradient-to-r from-emerald-500 to-green-600 text-white text-xs font-extrabold px-3 py-1.5 rounded-full shadow-md flex items-center gap-1 animate-pulse">
                            <i class="fa-solid fa-box-open"></i> 3
                        </span> 
                        <span class="text-emerald-800">Rombongan & Barang Bawaan</span>
                    </h3>

                    <p x-show="total >= 4" x-transition class="text-center text-sm font-semibold text-red-600 bg-red-100 border border-red-300 rounded-lg p-2 mb-4">
                        <i class="fa-solid fa-exclamation-circle mr-1"></i> Telah mencapai batas maksimal 4 pengikut.
                    </p>

                    <div class="space-y-6">
                        <div class="bg-white p-5 rounded-xl shadow-sm border border-emerald-200 relative transition-all duration-300 hover:shadow-md animate-fade-in">
                            
                            <div class="flex justify-between items-center mb-4">
                                <span class="text-xs font-bold text-emerald-600 uppercase tracking-wide bg-emerald-50 px-2 py-1 rounded">
                                    Total Pengikut
                                </span>
                                <div class="px-4 py-1 rounded-full text-xs font-bold uppercase tracking-widest border transition-all"
                                    :class="total > 4 ? 'bg-red-50 text-red-600 border-red-200' : 'bg-emerald-50 text-emerald-600 border-emerald-200'">
                                    Total: <span x-text="total">0</span> / 4 
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                <div>
                                    <label class="block text-xs font-semibold text-slate-600 mb-1 text-center">Laki-laki</label>
                                    <input type="number" name="pengikut_laki" x-model.number="pLaki" min="0" class="w-full rounded-lg border-2 border-gray-200 focus:border-emerald-500 text-center py-3 font-bold text-xl" placeholder="0">
                                </div>

                                <div>
                                    <label class="block text-xs font-semibold text-slate-600 mb-1 text-center">Perempuan</label>
                                    <input type="number" name="pengikut_perempuan" x-model.number="pPerempuan" min="0" class="w-full rounded-lg border-2 border-gray-200 focus:border-emerald-500 text-center py-3 font-bold text-xl" placeholder="0">
                                </div>

                                <div>
                                    <label class="block text-xs font-semibold text-slate-600 mb-1 text-center">Anak-anak</label>
                                    <input type="number" name="pengikut_anak" x-model.number="pAnak" min="0" class="w-full rounded-lg border-2 border-gray-200 focus:border-emerald-500 text-center py-3 font-bold text-xl" placeholder="0">
                                </div>

                                <div class="md:col-span-3 mt-2">
                                    <label class="block text-sm font-semibold text-slate-700 mb-2 flex items-center gap-2">
                                        <i class="fa-solid fa-briefcase text-orange-500"></i> Barang Bawaan (Opsional)
                                    </label>
                                    <textarea name="barang_bawaan" class="w-full rounded-xl border-2 border-gray-200 focus:ring-2 focus:ring-emerald-400 focus:border-emerald-500 px-3 py-3 text-sm bg-white resize-none" rows="3" placeholder="Sebutkan jenis makanan, pakaian, atau barang lainnya yang dibawa...">{{ old('barang_bawaan') }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Action Button --}}
                <div class="pt-8 flex flex-col-reverse sm:flex-row sm:justify-between items-stretch sm:items-center gap-4 p-4 sm:p-6 rounded-2xl">
                    <button type="reset" class="w-full sm:w-auto px-6 py-3 text-slate-600 font-bold hover:text-slate-900 transition bg-transparent hover:bg-gray-100 rounded-xl flex items-center justify-center gap-2">
                        <i class="fa-solid fa-eraser"></i> Kosongkan
                    </button>
                    <button type="submit" :disabled="isSubmitting" :class="isSubmitting ? 'opacity-75 cursor-wait' : 'hover:scale-105'" class="w-full sm:w-auto bg-gradient-to-r from-yellow-500 to-yellow-600 text-slate-900 font-bold px-8 py-4 rounded-xl shadow-xl transition transform flex items-center justify-center gap-3 text-base sm:text-lg">
                        <template x-if="!isSubmitting">
                            <span class="flex items-center gap-3">
                                <i class="fa-solid fa-check-circle text-lg"></i>
                                TERBITKAN ANTRIAN
                            </span>
                        </template>
                        <template x-if="isSubmitting">
                            <span class="flex items-center gap-2">
                                <svg class="animate-spin h-5 w-5 text-slate-900" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                Menyimpan...
                            </span>
                        </template>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
    @if(session('success'))
        document.addEventListener('DOMContentLoaded', function() {
            setTimeout(function() {
                @php
                    $kunjunganId = session('kunjungan_id');
                    $statusUrl = $kunjunganId ? route('admin.kunjungan.offline.success', $kunjunganId) : null;
                @endphp
                Swal.fire({
                    icon: 'success',
                    title: 'Pendaftaran Berhasil!',
                    html: `<div class="text-center">
                            <p class="mb-4 text-slate-700">{!! session('success') !!}</p>
                            <p class="text-xs text-slate-500 bg-slate-100 p-2 rounded">Antrian telah diterbitkan.</p>
                           </div>`,
                    @if($statusUrl)
                    confirmButtonText: '<i class="fa-solid fa-ticket mr-2"></i> LIHAT TIKET SAYA',
                    confirmButtonColor: '#10b981',
                    showCancelButton: true,
                    cancelButtonText: 'Tutup',
                    @else
                    confirmButtonText: 'Selesai',
                    confirmButtonColor: '#3b82f6',
                    @endif
                    allowOutsideClick: false,
                    allowEscapeKey: false
                }).then((result) => {
                    if (result.isConfirmed && "{{ $statusUrl }}") {
                        window.location.href = "{{ $statusUrl }}";
                    }
                });
            }, 500); 
        });
    @endif

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
    });

    $(document).ready(function() {
        const tglInp = document.getElementById('tanggal_kunjungan');
        const sesiInp = document.getElementById('sesi');
        const qVal = document.getElementById('quotaValue');
        const qTxt = document.getElementById('quotaText');
        const qIcon = document.getElementById('quotaIcon');
        const qLoad = document.getElementById('quotaLoading');
        const qCont = document.getElementById('quotaContainer');

        function updateQuota() {
            const tgl = tglInp.value;
            const sesi = sesiInp.value;
            if (!tgl) return;

            qLoad.classList.remove('hidden');
            qVal.classList.add('hidden');
            qTxt.innerText = 'Menghitung...';
            
            fetch(`/api/kunjungan/quota?tanggal_kunjungan=${tgl}&sesi=${sesi}&type=offline`)
                .then(res => res.json())
                .then(data => {
                    if (data.status === 'closed') {
                        qCont.className = 'px-6 py-3.5 rounded-xl border-2 border-dashed flex items-center justify-between transition-all duration-500 bg-red-50 border-red-200 shadow-sm';
                        qIcon.className = 'w-10 h-10 rounded-full flex items-center justify-center text-lg shadow-inner bg-red-100 text-red-600';
                        qTxt.className = 'text-[10px] font-black uppercase tracking-widest text-red-600 leading-tight';
                        qTxt.innerText = 'Layanan Tutup (Hari Libur)';
                        qVal.innerText = '0';
                        qVal.className = 'text-2xl font-black text-red-600';
                    } else {
                        const sisa = data.sisa_kuota;
                        qVal.innerText = sisa;
                        qCont.className = 'px-6 py-3.5 rounded-xl border-2 border-dashed flex items-center justify-between transition-all duration-500 bg-white shadow-inner border-gray-200';
                        qIcon.className = 'w-10 h-10 rounded-full flex items-center justify-center text-lg shadow-inner';
                        qVal.className = 'text-2xl font-black';

                        if (sisa <= 0) {
                            qCont.classList.add('bg-red-50', 'border-red-200');
                            qIcon.classList.add('bg-red-100', 'text-red-600');
                            qTxt.innerText = 'Kuota Offline Penuh';
                            qTxt.className = 'text-[10px] font-black uppercase tracking-widest text-red-600 leading-tight';
                            qVal.classList.add('text-red-600');
                        } else if (sisa < 5) {
                            qCont.classList.add('bg-amber-50', 'border-amber-200');
                            qIcon.classList.add('bg-amber-100', 'text-amber-600');
                            qTxt.innerText = 'Kuota Hampir Habis';
                            qTxt.className = 'text-[10px] font-black uppercase tracking-widest text-amber-600 leading-tight';
                            qVal.classList.add('text-amber-600');
                        } else {
                            qCont.classList.add('bg-emerald-50', 'border-emerald-200');
                            qIcon.classList.add('bg-emerald-100', 'text-emerald-600');
                            qTxt.innerText = 'Sisa Kuota Offline';
                            qTxt.className = 'text-[10px] font-black uppercase tracking-widest text-emerald-600 leading-tight';
                            qVal.classList.add('text-emerald-600');
                        }
                    }
                    qLoad.classList.add('hidden');
                    qVal.classList.remove('hidden');
                })
                .catch(err => {
                    console.error('Quota Error:', err);
                    qVal.innerText = '?';
                    qTxt.innerText = 'Gagal memuat kuota';
                    qLoad.classList.add('hidden');
                    qVal.classList.remove('hidden');
                });
        }

        tglInp.addEventListener('change', updateQuota);
        sesiInp.addEventListener('change', updateQuota);
        updateQuota();

        $('#wbp_id').select2({
            placeholder: "Ketik nama atau nomor registrasi WBP...",
            width: '100%',
            ajax: {
                url: '{{ route("api.search.wbp") }}',
                dataType: 'json',
                delay: 250,
                data: function (p) { return { q: p.term }; },
                processResults: function (d) {
                    return {
                        results: $.map(d, function (i) {
                            return { text: i.nama + ' (' + i.no_registrasi + ')', id: i.id }
                        })
                    };
                },
                cache: true
            },
            minimumInputLength: 1
        });
    });
</script>
@endpush
