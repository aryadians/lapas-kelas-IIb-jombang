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
        border-radius: 0.75rem !important;
        border: 2px solid #e2e8f0 !important;
        background-color: #ffffff !important;
        transition: all 0.3s ease;
    }
    .select2-container--default .select2-selection--single:focus-within {
        border-color: #eab308 !important; /* yellow-500 */
        box-shadow: 0 0 0 4px rgba(234, 179, 8, 0.1);
    }
    .select2-container--default .select2-selection--single .select2-selection__rendered {
        color: #334155;
        font-weight: 600;
    }
    .select2-dropdown {
        border-radius: 0.75rem !important;
        border: 1px solid #e2e8f0 !important;
        box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1);
        overflow: hidden;
    }

    .form-input-guest {
        @apply w-full rounded-xl border-2 border-gray-200 focus:ring-2 focus:ring-yellow-400 focus:border-yellow-500 transition-all duration-300 shadow-sm py-3 px-4 bg-white font-semibold text-slate-700 placeholder-slate-300;
    }

    .form-label-guest {
        @apply block text-sm font-semibold text-slate-700 mb-2 flex items-center gap-2;
    }

    .section-card-guest {
        @apply p-4 sm:p-8 rounded-3xl border border-gray-100 shadow-xl overflow-hidden relative;
    }

    .section-header-badge {
        @apply text-white text-xs font-extrabold px-3 py-1.5 rounded-full shadow-md flex items-center gap-1 animate-pulse;
    }
</style>
@endpush

@section('content')
<div class="max-w-5xl mx-auto space-y-8 pb-20">
    
    {{-- HEADER (GUEST STYLE) --}}
    <div class="bg-gradient-to-r from-blue-950 via-blue-900 to-blue-800 rounded-3xl shadow-2xl overflow-hidden border-2 border-gray-200 relative animate__animated animate__fadeInDown">
        <div class="absolute top-0 right-0 w-32 h-32 bg-yellow-500 opacity-10 rounded-full -mr-16 -mt-16"></div>
        <div class="px-8 py-8 flex flex-col md:flex-row justify-between items-center gap-6 relative z-10">
            <div class="text-center md:text-left">
                <h2 class="text-2xl sm:text-3xl font-black text-yellow-400 flex items-center justify-center md:justify-start gap-3">
                    <i class="fa-solid fa-file-signature"></i>
                    Pendaftaran Offline
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
    <div class="bg-red-50 border-l-4 border-red-500 p-6 rounded-r-2xl animate__animated animate__shakeX flex items-center gap-4 text-red-700 shadow-lg">
        <div class="w-12 h-12 bg-red-100 rounded-2xl flex items-center justify-center text-red-600 shrink-0">
            <i class="fas fa-exclamation-triangle text-xl"></i>
        </div>
        <p class="font-bold text-sm">{{ session('error') }}</p>
    </div>
    @endif

    <form action="{{ route('admin.kunjungan.storeOffline') }}" method="POST" class="space-y-10 animate__animated animate__fadeInUp">
        @csrf
        
        <div x-data="{
            pLaki: {{ old('pengikut_laki', 0) }},
            pPerempuan: {{ old('pengikut_perempuan', 0) }},
            pAnak: {{ old('pengikut_anak', 0) }},
            get total() { return (parseInt(this.pLaki) || 0) + (parseInt(this.pPerempuan) || 0) + (parseInt(this.pAnak) || 0); }
        }" class="space-y-10">

            {{-- SECTION 1: TUJUAN KUNJUNGAN (GUEST SECTION 2 STYLE) --}}
            <div class="section-card-guest bg-gradient-to-r from-yellow-50 to-orange-50 border-yellow-100">
                <h3 class="text-base sm:text-lg font-bold text-slate-800 border-b-2 border-yellow-200 pb-4 mb-8 flex items-center gap-3">
                    <span class="section-header-badge bg-gradient-to-r from-yellow-500 to-yellow-600 text-slate-900">
                        <i class="fa-solid fa-users"></i> 1
                    </span> 
                    <span class="text-yellow-800">Informasi Jadwal & WBP</span>
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <div class="lg:col-span-3">
                        <label class="form-label-guest">
                            <i class="fa-solid fa-user-tie text-yellow-600"></i> Cari Warga Binaan (WBP)
                        </label>
                        <select id="wbp_id" name="wbp_id" class="w-full" required>
                            <option value="">Ketik nama atau nomor registrasi WBP...</option>
                        </select>
                        <x-input-error :messages="$errors->get('wbp_id')" class="mt-2" />
                    </div>

                    <div>
                        <label class="form-label-guest">
                            <i class="fa-solid fa-calendar-alt text-green-500"></i> Tanggal Kunjungan
                        </label>
                        <input type="date" name="tanggal_kunjungan" id="tanggal_kunjungan" 
                            value="{{ old('tanggal_kunjungan', date('Y-m-d')) }}" 
                            class="form-input-guest" required>
                        <x-input-error :messages="$errors->get('tanggal_kunjungan')" class="mt-2" />
                    </div>

                    <div>
                        <label class="form-label-guest">
                            <i class="fa-solid fa-clock text-blue-500"></i> Sesi Waktu
                        </label>
                        <select id="sesi" name="sesi" class="form-input-guest font-bold" required>
                            <option value="pagi" {{ old('sesi') == 'pagi' ? 'selected' : '' }}>🌅 Sesi Pagi (08:00 - 12:00)</option>
                            <option value="siang" {{ old('sesi') == 'siang' ? 'selected' : '' }}>☀️ Sesi Siang (13:00 - 16:00)</option>
                        </select>
                        <x-input-error :messages="$errors->get('sesi')" class="mt-2" />
                    </div>

                    <div class="flex flex-col justify-end">
                        <div id="quotaContainer" class="px-6 py-3.5 rounded-xl border-2 border-dashed flex items-center justify-between transition-all duration-500 bg-white shadow-inner min-h-[52px]">
                            <div class="flex items-center gap-3">
                                <div id="quotaIcon" class="w-10 h-10 rounded-full flex items-center justify-center text-lg shadow-sm bg-slate-50 text-slate-400">
                                    <i class="fas fa-users"></i>
                                </div>
                                <p id="quotaText" class="text-[10px] font-black uppercase tracking-widest text-slate-500 leading-tight">Status Kuota Offline</p>
                            </div>
                            <div class="text-right">
                                <div id="quotaLoading" class="hidden"><i class="fas fa-circle-notch fa-spin text-blue-500"></i></div>
                                <span id="quotaValue" class="text-2xl font-black text-slate-700">-</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- SECTION 2: IDENTITAS PENGUNJUNG (GUEST SECTION 1 STYLE) --}}
            <div class="section-card-guest bg-gradient-to-r from-blue-50 to-gray-50 border-blue-100">
                <h3 class="text-base sm:text-lg font-bold text-slate-800 border-b-2 border-yellow-200 pb-4 mb-8 flex items-center gap-3">
                    <span class="section-header-badge bg-gradient-to-r from-blue-600 to-blue-700">
                        <i class="fa-solid fa-user"></i> 2
                    </span> 
                    <span class="text-blue-800">Identitas Pengunjung Utama</span>
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div>
                        <label class="form-label-guest">
                            <i class="fa-solid fa-user-tag text-blue-500"></i> Nama Lengkap (Sesuai KTP)
                        </label>
                        <input type="text" name="nama_pengunjung" value="{{ old('nama_pengunjung') }}" placeholder="Contoh: BUDI SANTOSO" class="form-input-guest" required>
                        <x-input-error :messages="$errors->get('nama_pengunjung')" class="mt-2" />
                    </div>

                    <div>
                        <label class="form-label-guest">
                            <i class="fa-solid fa-id-card text-blue-500"></i> Nomor NIK (16 Digit)
                        </label>
                        <input type="text" name="nik_ktp" value="{{ old('nik_ktp') }}" placeholder="3512XXXXXXXXXXXX" class="form-input-guest" required maxlength="16">
                        <x-input-error :messages="$errors->get('nik_ktp')" class="mt-2" />
                    </div>

                    <div>
                        <label class="form-label-guest">
                            <i class="fa-solid fa-heart text-red-500"></i> Hubungan Keluarga
                        </label>
                        <input type="text" name="hubungan" value="{{ old('hubungan') }}" placeholder="Istri, Orang Tua, Anak, dll" class="form-input-guest" required>
                        <x-input-error :messages="$errors->get('hubungan')" class="mt-2" />
                    </div>

                    <div>
                        <label class="form-label-guest">
                            <i class="fa-solid fa-venus-mars text-blue-500"></i> Jenis Kelamin
                        </label>
                        <div class="flex gap-2 rounded-xl bg-slate-200 p-1 border-2 border-gray-200">
                            <label class="flex-1 text-center cursor-pointer">
                                <input type="radio" name="jenis_kelamin" value="Laki-laki" class="hidden peer" {{ old('jenis_kelamin') != 'Perempuan' ? 'checked' : '' }}>
                                <span class="block w-full py-2.5 rounded-lg text-sm font-bold text-slate-600 bg-white peer-checked:bg-blue-600 peer-checked:text-white peer-checked:shadow-md transition-all">
                                    Laki-laki
                                </span>
                            </label>
                            <label class="flex-1 text-center cursor-pointer">
                                <input type="radio" name="jenis_kelamin" value="Perempuan" class="hidden peer" {{ old('jenis_kelamin') == 'Perempuan' ? 'checked' : '' }}>
                                <span class="block w-full py-2.5 rounded-lg text-sm font-bold text-slate-600 bg-white peer-checked:bg-pink-600 peer-checked:text-white peer-checked:shadow-md transition-all">
                                    Perempuan
                                </span>
                            </label>
                        </div>
                        <x-input-error :messages="$errors->get('jenis_kelamin')" class="mt-2" />
                    </div>

                    <div class="md:col-span-2">
                        <label class="form-label-guest">
                            <i class="fa-solid fa-map-marker-alt text-red-500"></i> Alamat Lengkap
                        </label>
                        <textarea name="alamat_pengunjung" rows="3" placeholder="Alamat lengkap sesuai KTP..." class="form-input-guest py-4 resize-none">{{ old('alamat_pengunjung') }}</textarea>
                        <x-input-error :messages="$errors->get('alamat_pengunjung')" class="mt-2" />
                    </div>

                    <div>
                        <label class="form-label-guest">
                            <i class="fa-brands fa-whatsapp text-green-500"></i> Nomor WhatsApp
                        </label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-gray-500 font-bold">+62</span>
                            <input type="text" name="no_wa_pengunjung" value="{{ old('no_wa_pengunjung') }}" placeholder="812345678" class="form-input-guest pl-12">
                        </div>
                        <x-input-error :messages="$errors->get('no_wa_pengunjung')" class="mt-2" />
                    </div>

                    <div>
                        <label class="form-label-guest">
                            <i class="fa-solid fa-envelope text-blue-500"></i> Alamat Email (Opsional)
                        </label>
                        <input type="email" name="email_pengunjung" value="{{ old('email_pengunjung') }}" placeholder="alamat@email.com" class="form-input-guest">
                        <x-input-error :messages="$errors->get('email_pengunjung')" class="mt-2" />
                    </div>
                </div>
            </div>

            {{-- SECTION 3: PENGIKUT & LOGISTIK (GUEST SECTION 3 STYLE) --}}
            <div class="section-card-guest bg-gradient-to-r from-emerald-50 to-green-50 border-emerald-100">
                <h3 class="text-base sm:text-lg font-bold text-slate-800 border-b-2 border-emerald-200 pb-4 mb-8 flex items-center gap-3">
                    <span class="section-header-badge bg-gradient-to-r from-emerald-500 to-green-600">
                        <i class="fa-solid fa-box-open"></i> 3
                    </span> 
                    <span class="text-emerald-800">Rombongan & Barang Bawaan</span>
                </h3>

                <div class="space-y-10">
                    <div class="p-8 bg-white rounded-3xl border-2 border-emerald-100 shadow-inner space-y-8">
                        <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
                            <span class="text-xs font-black text-slate-400 uppercase tracking-widest">Komposisi Pengikut</span>
                            <div class="px-6 py-2 rounded-full text-xs font-black uppercase tracking-widest border-2 shadow-sm transition-all"
                                :class="total > 4 ? 'bg-red-50 text-red-600 border-red-200' : 'bg-emerald-50 text-emerald-600 border-emerald-200'">
                                Total: <span x-text="total">0</span> / 4 Orang Maksimal
                            </div>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                            <div class="space-y-2 text-center">
                                <label class="text-[10px] font-black text-slate-500 uppercase tracking-widest block">Laki-laki</label>
                                <input type="number" name="pengikut_laki" x-model.number="pLaki" min="0" class="form-input-guest text-center !text-2xl !py-4 focus:ring-emerald-500/10">
                            </div>
                            <div class="space-y-2 text-center">
                                <label class="text-[10px] font-black text-slate-500 uppercase tracking-widest block">Perempuan</label>
                                <input type="number" name="pengikut_perempuan" x-model.number="pPerempuan" min="0" class="form-input-guest text-center !text-2xl !py-4 focus:ring-emerald-500/10">
                            </div>
                            <div class="space-y-2 text-center">
                                <label class="text-[10px] font-black text-slate-500 uppercase tracking-widest block">Anak-anak</label>
                                <input type="number" name="pengikut_anak" x-model.number="pAnak" min="0" class="form-input-guest text-center !text-2xl !py-4 focus:ring-emerald-500/10">
                            </div>
                        </div>
                        
                        <template x-if="total > 4">
                            <div class="flex items-center justify-center gap-2 text-red-600 font-black text-xs animate__animated animate__headShake bg-red-100 py-3 rounded-xl border border-red-200 uppercase tracking-tighter">
                                <i class="fas fa-exclamation-circle text-lg"></i>
                                Jumlah pengikut melebihi batas maksimal (4 orang)
                            </div>
                        </template>
                    </div>

                    <div>
                        <label class="form-label-guest">
                            <i class="fa-solid fa-briefcase text-orange-500"></i> Daftar Barang Bawaan (Titipan)
                        </label>
                        <textarea name="barang_bawaan" rows="3" placeholder="Sebutkan jenis makanan, pakaian, atau barang lainnya yang dibawa..." class="form-input-guest py-4 resize-none">{{ old('barang_bawaan') }}</textarea>
                        <p class="text-[10px] text-slate-400 mt-2 italic px-2">*Sebutkan barang bawaan secara detail untuk mempermudah pemeriksaan petugas.</p>
                        <x-input-error :messages="$errors->get('barang_bawaan')" class="mt-2" />
                    </div>
                </div>
            </div>

            {{-- ACTION BUTTONS (GUEST STYLE) --}}
            <div class="flex flex-col sm:flex-row items-center justify-center gap-6 pt-10 border-t-2 border-gray-100">
                <button type="reset" class="w-full sm:w-auto px-10 py-5 text-slate-400 font-black uppercase text-[11px] tracking-widest hover:text-slate-600 transition-colors">
                    <i class="fa-solid fa-eraser mr-2"></i> Kosongkan Form
                </button>
                
                <button type="submit" :disabled="total > 4"
                    class="group relative inline-flex items-center justify-center overflow-hidden rounded-full bg-gradient-to-r from-blue-950 to-black px-12 py-5 font-bold text-white transition-all duration-300 hover:from-black hover:to-blue-950 hover:scale-105 shadow-2xl hover:shadow-blue-900/50 border-2 border-yellow-500 border-opacity-50 disabled:opacity-50 disabled:cursor-not-allowed">
                    <span class="absolute right-0 -mt-12 h-32 w-8 translate-x-12 rotate-12 bg-gradient-to-b from-yellow-500 to-yellow-600 opacity-30 transition-all duration-1000 ease-out group-hover:-translate-x-64"></span>
                    <span class="relative flex items-center gap-3 text-sm tracking-widest uppercase">
                        <i class="fa-solid fa-check-circle text-yellow-400 text-lg"></i>
                        Terbitkan Antrian & Simpan
                    </span>
                </button>
            </div>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
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
