@extends('layouts.admin')

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<style>
    .select2-container .select2-selection--single {
        height: 48px !important;
        display: flex;
        align-items: center;
        padding-left: 1rem;
        border-radius: 0.75rem !important;
        border: 2px solid #e2e8f0 !important;
        background-color: #f8fafc !important;
    }
    .select2-container--default .select2-selection--single .select2-selection__rendered {
        color: #334155;
        line-height: 48px;
    }
    .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: 46px !important;
        right: 10px !important;
    }
    .select2-dropdown {
        border-radius: 0.75rem !important;
        border: 2px solid #e2e8f0 !important;
        box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1);
    }
    .select2-container--open .select2-dropdown--above,
    .select2-container--open .select2-dropdown--below {
        border-top-left-radius: 0.75rem !important;
        border-top-right-radius: 0.75rem !important;
    }
</style>
@endpush

@section('content')
<div class="space-y-8 pb-12">
    {{-- HEADER --}}
    <header class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 animate__animated animate__fadeInDown">
        <div>
            <h1 class="text-3xl sm:text-4xl font-extrabold text-gradient">
                Pendaftaran Kunjungan Offline
            </h1>
            <p class="text-slate-500 mt-2 font-medium">Buat pendaftaran baru untuk pengunjung yang datang langsung (walk-in).</p>
        </div>
        <a href="{{ route('admin.kunjungan.index') }}" class="flex items-center justify-center gap-2 bg-white text-slate-600 font-bold px-5 py-2.5 rounded-xl shadow-sm border border-slate-200 hover:border-slate-300 hover:bg-slate-50 transition-all active:scale-95">
            <i class="fas fa-arrow-left text-slate-400"></i>
            <span>Kembali</span>
        </a>
    </header>

    {{-- ALERT MESSAGES --}}
    @if(session('success'))
    <div class="animate__animated animate__bounceIn bg-emerald-50 border-l-4 border-emerald-500 p-4 rounded-r-xl shadow-sm flex items-start gap-3">
        <div class="mt-0.5"><i class="fas fa-check-circle text-emerald-500 text-xl"></i></div>
        <div>
            <h3 class="font-bold text-emerald-800">Berhasil!</h3>
            <p class="text-emerald-700 text-sm">{{ session('success') }}</p>
        </div>
    </div>
    @endif
    @if (session('error'))
    <div class="animate__animated animate__shakeX bg-red-50 border-l-4 border-red-500 p-4 rounded-r-xl shadow-sm flex items-start gap-3">
        <div class="mt-0.5"><i class="fas fa-times-circle text-red-500 text-xl"></i></div>
        <div>
            <h3 class="font-bold text-red-800">Gagal!</h3>
            <p class="text-red-700 text-sm">{{ session('error') }}</p>
        </div>
    </div>
    @endif
    @if ($errors->any())
    <div class="animate__animated animate__shakeX bg-red-50 border-l-4 border-red-500 p-4 rounded-r-xl shadow-sm flex items-start gap-3">
        <div class="mt-0.5"><i class="fas fa-exclamation-triangle text-red-500 text-xl"></i></div>
        <div>
            <h3 class="font-bold text-red-800">Periksa Inputan Anda</h3>
            <ul class="list-disc list-inside text-sm text-red-700 mt-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    </div>
    @endif

    <form action="{{ route('admin.kunjungan.storeOffline') }}" method="POST" class="animate__animated animate__fadeInUp">
        @csrf
        <div class="glass-panel rounded-2xl p-6 space-y-8">

            {{-- SECTION 1: DATA KUNJUNGAN --}}
            <section>
                <h3 class="text-lg font-bold text-slate-800 border-b-2 border-slate-200 pb-3 mb-6 flex items-center gap-3">
                    <span class="bg-blue-100 text-blue-600 text-sm font-extrabold px-3 py-1.5 rounded-full shadow-sm">1</span>
                    Data Kunjungan
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <div class="lg:col-span-3">
                        <label for="wbp_id" class="block text-sm font-bold text-slate-500 uppercase tracking-wider mb-2">Warga Binaan (WBP)</label>
                        <select id="wbp_id" name="wbp_id" class="w-full" required>
                            <option value="">Cari nama WBP...</option>
                            @foreach($wbps as $wbp)
                                <option value="{{ $wbp->id }}" {{ old('wbp_id') == $wbp->id ? 'selected' : '' }}>
                                    {{ $wbp->nama }} (No. Reg: {{ $wbp->no_registrasi }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="tanggal_kunjungan" class="block text-sm font-bold text-slate-500 uppercase tracking-wider mb-2">Tanggal Kunjungan</label>
                        <input type="date" name="tanggal_kunjungan" id="tanggal_kunjungan" value="{{ old('tanggal_kunjungan') }}" class="w-full px-4 py-3 bg-slate-50 border-2 border-slate-200 rounded-xl focus:bg-white focus:border-blue-500 focus:ring-0 transition-all font-medium text-slate-700" required>
                    </div>
                    <div>
                        <label for="sesi" class="block text-sm font-bold text-slate-500 uppercase tracking-wider mb-2">Sesi</label>
                        <select id="sesi" name="sesi" class="w-full px-4 py-3 bg-slate-50 border-2 border-slate-200 rounded-xl focus:bg-white focus:border-blue-500 focus:ring-0 transition-all font-medium text-slate-700" required>
                            <option value="pagi" {{ old('sesi') == 'pagi' ? 'selected' : '' }}>Pagi</option>
                            <option value="siang" {{ old('sesi') == 'siang' ? 'selected' : '' }}>Siang</option>
                        </select>
                    </div>
                    <div>
                        <label for="hubungan" class="block text-sm font-bold text-slate-500 uppercase tracking-wider mb-2">Hubungan</label>
                        <input type="text" name="hubungan" id="hubungan" value="{{ old('hubungan') }}" placeholder="Contoh: Istri, Anak, Orang Tua" class="w-full px-4 py-3 bg-slate-50 border-2 border-slate-200 rounded-xl focus:bg-white focus:border-blue-500 focus:ring-0 transition-all font-medium text-slate-700" required>
                    </div>
                </div>
            </section>

            {{-- SECTION 2: DATA PENGUNJUNG --}}
            <section>
                <h3 class="text-lg font-bold text-slate-800 border-b-2 border-slate-200 pb-3 mb-6 flex items-center gap-3">
                    <span class="bg-blue-100 text-blue-600 text-sm font-extrabold px-3 py-1.5 rounded-full shadow-sm">2</span>
                    Data Pengunjung Utama
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="nama_pengunjung" class="block text-sm font-bold text-slate-500 uppercase tracking-wider mb-2">Nama Pengunjung</label>
                        <input type="text" name="nama_pengunjung" id="nama_pengunjung" value="{{ old('nama_pengunjung') }}" placeholder="Sesuai KTP" class="w-full px-4 py-3 bg-slate-50 border-2 border-slate-200 rounded-xl focus:bg-white focus:border-blue-500 focus:ring-0 transition-all font-medium text-slate-700" required>
                    </div>
                    <div>
                        <label for="nik_ktp" class="block text-sm font-bold text-slate-500 uppercase tracking-wider mb-2">NIK KTP</label>
                        <input type="text" name="nik_ktp" id="nik_ktp" value="{{ old('nik_ktp') }}" placeholder="16 digit angka" class="w-full px-4 py-3 bg-slate-50 border-2 border-slate-200 rounded-xl focus:bg-white focus:border-blue-500 focus:ring-0 transition-all font-medium text-slate-700" required>
                    </div>
                    <div>
                        <label for="jenis_kelamin" class="block text-sm font-bold text-slate-500 uppercase tracking-wider mb-2">Jenis Kelamin</label>
                        <select id="jenis_kelamin" name="jenis_kelamin" class="w-full px-4 py-3 bg-slate-50 border-2 border-slate-200 rounded-xl focus:bg-white focus:border-blue-500 focus:ring-0 transition-all font-medium text-slate-700" required>
                            <option value="Laki-laki" {{ old('jenis_kelamin') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                            <option value="Perempuan" {{ old('jenis_kelamin') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                    </div>
                    <div>
                        <label for="no_wa_pengunjung" class="block text-sm font-bold text-slate-500 uppercase tracking-wider mb-2">No. WhatsApp</label>
                        <input type="text" name="no_wa_pengunjung" id="no_wa_pengunjung" value="{{ old('no_wa_pengunjung') }}" placeholder="cth: 08123456789" class="w-full px-4 py-3 bg-slate-50 border-2 border-slate-200 rounded-xl focus:bg-white focus:border-blue-500 focus:ring-0 transition-all font-medium text-slate-700">
                    </div>
                     <div class="md:col-span-2">
                        <label for="alamat_pengunjung" class="block text-sm font-bold text-slate-500 uppercase tracking-wider mb-2">Alamat Pengunjung</label>
                        <textarea name="alamat_pengunjung" id="alamat_pengunjung" rows="3" placeholder="Alamat lengkap sesuai KTP" class="w-full px-4 py-3 bg-slate-50 border-2 border-slate-200 rounded-xl focus:bg-white focus:border-blue-500 focus:ring-0 transition-all font-medium text-slate-700">{{ old('alamat_pengunjung') }}</textarea>
                    </div>
                    <div class="md:col-span-2">
                        <label for="email_pengunjung" class="block text-sm font-bold text-slate-500 uppercase tracking-wider mb-2">Email (Opsional)</label>
                        <input type="email" name="email_pengunjung" id="email_pengunjung" value="{{ old('email_pengunjung') }}" placeholder="Untuk notifikasi (jika ada)" class="w-full px-4 py-3 bg-slate-50 border-2 border-slate-200 rounded-xl focus:bg-white focus:border-blue-500 focus:ring-0 transition-all font-medium text-slate-700">
                    </div>
                </div>
            </section>

             {{-- SECTION 3: DATA PENGIKUT --}}
             <section>
                <h3 class="text-lg font-bold text-slate-800 border-b-2 border-slate-200 pb-3 mb-6 flex items-center gap-3">
                    <span class="bg-blue-100 text-blue-600 text-sm font-extrabold px-3 py-1.5 rounded-full shadow-sm">3</span>
                    Data Pengikut Tambahan
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div>
                        <label for="pengikut_laki" class="block text-sm font-bold text-slate-500 uppercase tracking-wider mb-2">Jml. Laki-laki Dewasa</label>
                        <input type="number" name="pengikut_laki" id="pengikut_laki" value="{{ old('pengikut_laki', 0) }}" min="0" class="w-full px-4 py-3 bg-slate-50 border-2 border-slate-200 rounded-xl focus:bg-white focus:border-blue-500 focus:ring-0 transition-all font-medium text-slate-700">
                    </div>
                    <div>
                        <label for="pengikut_perempuan" class="block text-sm font-bold text-slate-500 uppercase tracking-wider mb-2">Jml. Perempuan Dewasa</label>
                        <input type="number" name="pengikut_perempuan" id="pengikut_perempuan" value="{{ old('pengikut_perempuan', 0) }}" min="0" class="w-full px-4 py-3 bg-slate-50 border-2 border-slate-200 rounded-xl focus:bg-white focus:border-blue-500 focus:ring-0 transition-all font-medium text-slate-700">
                    </div>
                    <div>
                        <label for="pengikut_anak" class="block text-sm font-bold text-slate-500 uppercase tracking-wider mb-2">Jml. Anak-anak</label>
                        <input type="number" name="pengikut_anak" id="pengikut_anak" value="{{ old('pengikut_anak', 0) }}" min="0" class="w-full px-4 py-3 bg-slate-50 border-2 border-slate-200 rounded-xl focus:bg-white focus:border-blue-500 focus:ring-0 transition-all font-medium text-slate-700">
                    </div>
                </div>
            </section>
            
            {{-- SECTION 4: LAIN-LAIN --}}
            <section>
                 <h3 class="text-lg font-bold text-slate-800 border-b-2 border-slate-200 pb-3 mb-6 flex items-center gap-3">
                    <span class="bg-blue-100 text-blue-600 text-sm font-extrabold px-3 py-1.5 rounded-full shadow-sm">4</span>
                    Lain-lain
                </h3>
                <div>
                    <label for="barang_bawaan" class="block text-sm font-bold text-slate-500 uppercase tracking-wider mb-2">Barang Bawaan</label>
                    <textarea name="barang_bawaan" id="barang_bawaan" rows="3" placeholder="Sebutkan barang bawaan yang perlu diperiksa petugas" class="w-full px-4 py-3 bg-slate-50 border-2 border-slate-200 rounded-xl focus:bg-white focus:border-blue-500 focus:ring-0 transition-all font-medium text-slate-700">{{ old('barang_bawaan') }}</textarea>
                </div>
            </section>

            {{-- SUBMIT BUTTON --}}
            <div class="flex justify-end mt-6 pt-8 border-t-2 border-slate-200">
                <a href="{{ route('admin.kunjungan.index') }}" class="px-8 py-3 bg-white text-slate-600 font-bold rounded-xl border-2 border-slate-200 hover:bg-slate-50 transition-all active:scale-95 text-center mr-4">
                    Batal
                </a>
                <button type="submit" class="px-8 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-bold rounded-xl hover:from-blue-700 hover:to-indigo-700 transition-all shadow-lg shadow-blue-500/30 active:scale-95 flex items-center gap-2">
                    <i class="fas fa-save"></i> Simpan Pendaftaran
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
        $('#wbp_id').select2({
            placeholder: "Cari nama atau nomor registrasi WBP",
            width: '100%',
        });
    });
</script>
@endpush
