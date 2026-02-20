@extends('layouts.admin')

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<style>
    /* Select2 Custom Styling - Enhanced Border & Focus */
    .select2-container .select2-selection--single {
        height: 56px !important;
        display: flex;
        align-items: center;
        padding-left: 0.75rem;
        border-radius: 1rem !important;
        border: 2px solid #e2e8f0 !important; /* border-slate-200 */
        background-color: #ffffff !important;
        transition: all 0.3s ease;
    }
    .select2-container--default .select2-selection--single:focus-within {
        border-color: #eab308 !important; /* yellow-500 */
        box-shadow: 0 0 0 4px rgba(234, 179, 8, 0.15);
    }
    .select2-container--default .select2-selection--single .select2-selection__rendered {
        color: #1e293b;
        font-weight: 700;
        font-size: 0.95rem;
    }
    .select2-dropdown {
        border-radius: 1rem !important;
        border: 2px solid #e2e8f0 !important;
        box-shadow: 0 20px 25px -5px rgba(0,0,0,0.1);
        overflow: hidden;
    }

    /* Premium Input Styling - Stronger Borders */
    .form-input-premium {
        @apply w-full rounded-2xl border-2 border-slate-200 focus:ring-4 focus:ring-yellow-400/10 focus:border-yellow-500 transition-all duration-300 shadow-sm py-4 px-5 bg-white font-bold text-slate-700 placeholder-slate-300 outline-none;
    }

    .form-label-premium {
        @apply block text-[11px] font-black text-slate-500 uppercase tracking-[0.2em] mb-2 ml-2 flex items-center gap-2;
    }

    .section-card-premium {
        @apply p-8 sm:p-10 rounded-[2.5rem] border-2 border-slate-100 shadow-2xl shadow-slate-200/50 overflow-hidden relative bg-white transition-all duration-500 hover:shadow-blue-500/5;
    }

    .section-badge-premium {
        @apply flex items-center justify-center w-10 h-10 rounded-xl text-white shadow-lg transition-transform duration-500 hover:rotate-12;
    }

    /* Animation */
    .animate-shimmer-text {
        background: linear-gradient(to right, #fbbf24 20%, #fef3c7 40%, #fef3c7 60%, #fbbf24 80%);
        background-size: 200% auto;
        animation: shimmer 3s linear infinite;
    }
    @keyframes shimmer { to { background-position: 200% center; } }
</style>
@endpush

@section('content')
<div class="max-w-5xl mx-auto space-y-12 pb-24">
    
    {{-- HEADER --}}
    <div class="bg-slate-900 rounded-[2.5rem] shadow-2xl overflow-hidden border-4 border-white relative animate__animated animate__fadeInDown">
        <div class="absolute inset-0 bg-[url('data:image/svg+xml,%3Csvg width=\"60\" height=\"60\" viewBox=\"0 0 60 60\" xmlns=\"http://www.w3.org/2000/svg\"%3E%3Cg fill=\"none\" fill-rule=\"evenodd\"%3E%3Cg fill=\"%23ffffff\" fill-opacity=\"0.03\"%3E%3Ccircle cx=\"30\" cy=\"30\" r=\"2\"/%3E%3C/g%3E%3C/g%3E%3C/svg%3E')] opacity-30"></div>
        <div class="px-10 py-12 flex flex-col md:flex-row justify-between items-center gap-8 relative z-10">
            <div class="text-center md:text-left">
                <div class="inline-flex items-center gap-2 bg-yellow-500 text-slate-900 font-black tracking-widest uppercase text-[10px] mb-4 px-4 py-1.5 rounded-full shadow-lg">
                    <i class="fa-solid fa-bolt-lightning"></i>
                    <span>Sistem Internal Lapas</span>
                </div>
                <h2 class="text-4xl sm:text-5xl font-black text-white tracking-tighter leading-none">
                    Pendaftaran <span class="animate-shimmer-text bg-clip-text text-transparent italic">Offline</span>
                </h2>
                <p class="text-slate-400 text-base mt-4 font-medium max-w-md">Input data kunjungan walk-in secara cepat, akurat, dan profesional.</p>
            </div>
            <a href="{{ route('admin.kunjungan.index') }}" class="group bg-white/10 hover:bg-white text-white hover:text-slate-900 transition-all duration-300 flex items-center gap-3 px-8 py-4 rounded-2xl font-black uppercase text-xs tracking-widest border border-white/20 shadow-xl backdrop-blur-md">
                <i class="fa-solid fa-arrow-left group-hover:-translate-x-2 transition-transform"></i> Kembali
            </a>
        </div>
    </div>

    <form action="{{ route('admin.kunjungan.storeOffline') }}" method="POST" class="space-y-12 animate__animated animate__fadeInUp">
        @csrf
        
        <div x-data="{
            pLaki: {{ old('pengikut_laki', 0) }},
            pPerempuan: {{ old('pengikut_perempuan', 0) }},
            pAnak: {{ old('pengikut_anak', 0) }},
            get total() { return (parseInt(this.pLaki) || 0) + (parseInt(this.pPerempuan) || 0) + (parseInt(this.pAnak) || 0); }
        }" class="space-y-12">

            {{-- SECTION 1: JADWAL & TUJUAN --}}
            <div class="section-card-premium">
                <div class="flex items-center gap-4 mb-12">
                    <div class="section-badge-premium bg-gradient-to-br from-yellow-400 to-orange-600">01</div>
                    <div>
                        <h3 class="text-xl font-black text-slate-800 uppercase tracking-tight">Jadwal & Tujuan</h3>
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-1">Pengaturan waktu dan WBP yang dikunjungi</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10">
                    <div class="lg:col-span-3">
                        <label class="form-label-premium"><i class="fa-solid fa-user-shield text-yellow-500"></i> Nama Warga Binaan (WBP)</label>
                        <select id="wbp_id" name="wbp_id" class="w-full" required></select>
                        <x-input-error :messages="$errors->get('wbp_id')" class="mt-2" />
                    </div>

                    <div class="form-group">
                        <label class="form-label-premium"><i class="fa-solid fa-calendar-day text-blue-500"></i> Tanggal Kunjungan</label>
                        <input type="date" name="tanggal_kunjungan" id="tanggal_kunjungan" 
                            value="{{ old('tanggal_kunjungan', date('Y-m-d')) }}" 
                            class="form-input-premium">
                    </div>

                    <div class="form-group">
                        <label class="form-label-premium"><i class="fa-solid fa-clock text-indigo-500"></i> Sesi Waktu</label>
                        <select id="sesi" name="sesi" class="form-input-premium !py-3.5 border-2 !border-slate-200 cursor-pointer">
                            <option value="pagi" {{ old('sesi') == 'pagi' ? 'selected' : '' }}>🌅 Sesi Pagi (08:00 - 12:00)</option>
                            <option value="siang" {{ old('sesi') == 'siang' ? 'selected' : '' }}>☀️ Sesi Siang (13:00 - 16:00)</option>
                        </select>
                    </div>

                    <div class="flex flex-col justify-end">
                        <div id="quotaContainer" class="px-6 py-4 rounded-2xl border-4 border-double flex items-center justify-between transition-all duration-500 bg-slate-50 border-slate-200 h-[60px]">
                            <div class="flex items-center gap-3">
                                <div id="quotaIcon" class="w-10 h-10 rounded-xl flex items-center justify-center text-lg shadow-sm bg-white text-slate-400">
                                    <i class="fas fa-users"></i>
                                </div>
                                <p id="quotaText" class="text-[9px] font-black uppercase tracking-widest text-slate-500 leading-tight">Status Kuota</p>
                            </div>
                            <div id="quotaLoading" class="hidden"><i class="fas fa-circle-notch fa-spin text-blue-500"></i></div>
                            <span id="quotaValue" class="text-2xl font-black text-slate-800">-</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- SECTION 2: IDENTITAS PENGUNJUNG --}}
            <div class="section-card-premium">
                <div class="flex items-center gap-4 mb-12">
                    <div class="section-badge-premium bg-gradient-to-br from-blue-500 to-blue-800">02</div>
                    <div>
                        <h3 class="text-xl font-black text-slate-800 uppercase tracking-tight">Data Pengunjung</h3>
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-1">Informasi lengkap pengunjung utama</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                    <div class="form-group">
                        <label class="form-label-premium"><i class="fa-solid fa-id-badge text-blue-500"></i> Nama Lengkap (Sesuai KTP)</label>
                        <input type="text" name="nama_pengunjung" value="{{ old('nama_pengunjung') }}" placeholder="Contoh: BUDI SANTOSO" class="form-input-premium" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label-premium"><i class="fa-solid fa-fingerprint text-blue-500"></i> Nomor NIK (16 Digit)</label>
                        <input type="text" name="nik_ktp" value="{{ old('nik_ktp') }}" placeholder="3512XXXXXXXXXXXX" class="form-input-premium" required maxlength="16">
                    </div>

                    <div class="form-group">
                        <label class="form-label-premium"><i class="fa-solid fa-users-viewfinder text-indigo-500"></i> Hubungan Keluarga</label>
                        <input type="text" name="hubungan" value="{{ old('hubungan') }}" placeholder="Istri, Anak, Saudara, dll" class="form-input-premium" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label-premium"><i class="fa-solid fa-venus-mars text-pink-500"></i> Jenis Kelamin</label>
                        <div class="grid grid-cols-2 gap-4">
                            <label class="cursor-pointer">
                                <input type="radio" name="jenis_kelamin" value="Laki-laki" class="hidden peer" {{ old('jenis_kelamin') != 'Perempuan' ? 'checked' : '' }}>
                                <div class="py-4 bg-slate-50 border-2 border-slate-100 rounded-2xl text-center font-black uppercase text-[10px] tracking-widest text-slate-400 peer-checked:border-blue-500 peer-checked:bg-blue-50 peer-checked:text-blue-600 transition-all shadow-sm">
                                    Laki-laki
                                </div>
                            </label>
                            <label class="cursor-pointer">
                                <input type="radio" name="jenis_kelamin" value="Perempuan" class="hidden peer" {{ old('jenis_kelamin') == 'Perempuan' ? 'checked' : '' }}>
                                <div class="py-4 bg-slate-50 border-2 border-slate-100 rounded-2xl text-center font-black uppercase text-[10px] tracking-widest text-slate-400 peer-checked:border-pink-500 peer-checked:bg-pink-50 peer-checked:text-pink-600 transition-all shadow-sm">
                                    Perempuan
                                </div>
                            </label>
                        </div>
                    </div>

                    <div class="md:col-span-2 form-group">
                        <label class="form-label-premium"><i class="fa-solid fa-map-location-dot text-red-500"></i> Alamat Lengkap Domisili</label>
                        <textarea name="alamat_pengunjung" rows="3" placeholder="Tuliskan alamat lengkap sesuai KTP..." class="form-input-premium !py-5 resize-none border-2 !border-slate-200 focus:!border-yellow-500" required>{{ old('alamat_pengunjung') }}</textarea>
                    </div>

                    <div class="form-group">
                        <label class="form-label-premium"><i class="fa-brands fa-whatsapp text-green-500"></i> Nomor WhatsApp</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-5 text-slate-400 font-black text-sm">+62</span>
                            <input type="text" name="no_wa_pengunjung" value="{{ old('no_wa_pengunjung') }}" placeholder="812345678" class="form-input-premium pl-14">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label-premium"><i class="fa-solid fa-envelope-open-text text-blue-400"></i> Email (Opsional)</label>
                        <input type="email" name="email_pengunjung" value="{{ old('email_pengunjung') }}" placeholder="alamat@email.com" class="form-input-premium">
                    </div>
                </div>
            </div>

            {{-- SECTION 3: PENGIKUT & LOGISTIK --}}
            <div class="section-card-premium">
                <div class="flex items-center gap-4 mb-12">
                    <div class="section-badge-premium bg-gradient-to-br from-emerald-500 to-green-800">03</div>
                    <div>
                        <h3 class="text-xl font-black text-slate-800 uppercase tracking-tight">Rombongan & Barang</h3>
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-1">Detail pengikut dan barang titipan</p>
                    </div>
                </div>

                <div class="space-y-12">
                    <div class="p-10 bg-slate-50 rounded-[3rem] border-2 border-slate-100 shadow-inner space-y-10">
                        <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
                            <span class="text-xs font-black text-slate-400 uppercase tracking-[0.2em]">Kapasitas Rombongan</span>
                            <div class="px-6 py-2.5 rounded-full text-xs font-black uppercase tracking-widest border-4 border-white shadow-xl transition-all"
                                :class="total > 4 ? 'bg-red-500 text-white animate-bounce' : 'bg-white text-emerald-600'">
                                <i class="fas fa-user-group mr-2"></i> Total: <span x-text="total">0</span> / 4 Orang
                            </div>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-10">
                            <div class="space-y-3 text-center">
                                <label class="text-[10px] font-black text-slate-500 uppercase tracking-[0.2em] block">Laki-laki</label>
                                <input type="number" name="pengikut_laki" x-model.number="pLaki" min="0" class="form-input-premium text-center !text-3xl !py-6 !bg-white !border-slate-100 hover:border-emerald-400">
                            </div>
                            <div class="space-y-3 text-center">
                                <label class="text-[10px] font-black text-slate-500 uppercase tracking-[0.2em] block">Perempuan</label>
                                <input type="number" name="pengikut_perempuan" x-model.number="pPerempuan" min="0" class="form-input-premium text-center !text-3xl !py-6 !bg-white !border-slate-100 hover:border-emerald-400">
                            </div>
                            <div class="space-y-3 text-center">
                                <label class="text-[10px] font-black text-slate-500 uppercase tracking-[0.2em] block">Anak-anak</label>
                                <input type="number" name="pengikut_anak" x-model.number="pAnak" min="0" class="form-input-premium text-center !text-3xl !py-6 !bg-white !border-slate-100 hover:border-emerald-400">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label-premium"><i class="fa-solid fa-briefcase text-orange-500"></i> Daftar Barang Bawaan (Titipan)</label>
                        <textarea name="barang_bawaan" rows="3" placeholder="Sebutkan jenis makanan, pakaian, atau barang lainnya yang dibawa..." class="form-input-premium !py-5 resize-none border-2 !border-slate-200 focus:!border-yellow-500">{{ old('barang_bawaan') }}</textarea>
                        <div class="mt-4 flex items-start gap-3 bg-orange-50 p-4 rounded-2xl border border-orange-100">
                            <i class="fas fa-info-circle text-orange-500 mt-0.5"></i>
                            <p class="text-[10px] text-orange-700 font-bold uppercase tracking-wider leading-relaxed">Harap sebutkan barang bawaan secara detail untuk mempermudah proses pemeriksaan keamanan petugas di gerbang utama Lapas Kelas IIB Jombang.</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ACTION BUTTONS --}}
            <div class="flex flex-col sm:flex-row items-center justify-center gap-8 pt-12 border-t-4 border-slate-100">
                <button type="reset" class="w-full sm:w-auto px-12 py-5 text-slate-400 font-black uppercase text-xs tracking-[0.3em] hover:text-red-600 transition-all hover:scale-105 flex items-center gap-3">
                    <i class="fa-solid fa-trash-can"></i> Kosongkan Form
                </button>
                
                <button type="submit" :disabled="total > 4"
                    class="group relative inline-flex items-center justify-center overflow-hidden rounded-[2rem] bg-slate-900 px-16 py-6 font-black text-white transition-all duration-500 hover:bg-black hover:scale-105 shadow-2xl hover:shadow-blue-500/40 border-4 border-white disabled:opacity-50 disabled:cursor-not-allowed">
                    <span class="absolute right-0 -mt-12 h-40 w-12 translate-x-12 rotate-12 bg-white/10 opacity-30 transition-all duration-1000 ease-out group-hover:-translate-x-[40rem]"></span>
                    <span class="relative flex items-center gap-4 text-sm tracking-[0.25em] uppercase">
                        <i class="fa-solid fa-cloud-arrow-up text-yellow-400 text-xl group-hover:animate-bounce"></i>
                        Simpan & Terbitkan Antrian
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
                        qCont.className = 'px-6 py-4 rounded-2xl border-4 border-double flex items-center justify-between transition-all duration-500 bg-red-50 border-red-200 shadow-sm';
                        qIcon.className = 'w-10 h-10 rounded-xl flex items-center justify-center text-lg shadow-inner bg-red-100 text-red-600';
                        qTxt.className = 'text-[9px] font-black uppercase tracking-widest text-red-600 leading-tight';
                        qTxt.innerText = 'Layanan Tutup';
                        qVal.innerText = '0';
                        qVal.className = 'text-2xl font-black text-red-600';
                    } else {
                        const sisa = data.sisa_kuota;
                        qVal.innerText = sisa;
                        qCont.className = 'px-6 py-4 rounded-2xl border-4 border-double flex items-center justify-between transition-all duration-500 bg-white shadow-inner border-slate-100';
                        qIcon.className = 'w-10 h-10 rounded-xl flex items-center justify-center text-lg shadow-inner';
                        qVal.className = 'text-2xl font-black';

                        if (sisa <= 0) {
                            qCont.classList.add('bg-red-50', 'border-red-200');
                            qIcon.classList.add('bg-red-100', 'text-red-600');
                            qTxt.innerText = 'Kuota Penuh';
                            qTxt.className = 'text-[9px] font-black uppercase tracking-widest text-red-600';
                            qVal.classList.add('text-red-600');
                        } else if (sisa < 5) {
                            qCont.classList.add('bg-amber-50', 'border-amber-200');
                            qIcon.classList.add('bg-amber-100', 'text-amber-600');
                            qTxt.innerText = 'Kuota Menipis';
                            qTxt.className = 'text-[9px] font-black uppercase tracking-widest text-amber-600';
                            qVal.classList.add('text-amber-600');
                        } else {
                            qCont.classList.add('bg-emerald-50', 'border-emerald-200');
                            qIcon.classList.add('bg-emerald-100', 'text-emerald-600');
                            qTxt.innerText = 'Kuota Aman';
                            qTxt.className = 'text-[9px] font-black uppercase tracking-widest text-emerald-600';
                            qVal.classList.add('text-emerald-600');
                        }
                    }
                    qLoad.classList.add('hidden');
                    qVal.classList.remove('hidden');
                })
                .catch(err => {
                    qVal.innerText = '?';
                    qTxt.innerText = 'Error API';
                    qLoad.classList.add('hidden');
                    qVal.classList.remove('hidden');
                });
        }

        tglInp.addEventListener('change', updateQuota);
        sesiInp.addEventListener('change', updateQuota);
        updateQuota();

        $('#wbp_id').select2({
            placeholder: "Cari WBP (Nama atau Nomor Registrasi)...",
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
