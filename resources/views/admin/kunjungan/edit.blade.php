@extends('layouts.admin')

@section('content')
<div class="max-w-5xl mx-auto space-y-8 pb-12" x-data="{ new_pengikuts: [] }">
    {{-- HEADER --}}
    <header class="flex items-center gap-4 animate__animated animate__fadeInDown">
        <a href="{{ route('admin.kunjungan.index') }}" class="w-12 h-12 rounded-2xl bg-white border border-slate-200 flex items-center justify-center text-slate-400 hover:text-blue-600 transition-all shadow-sm">
            <i class="fas fa-arrow-left"></i>
        </a>
        <div>
            <h1 class="text-3xl font-black text-slate-900 tracking-tighter">Verifikasi & Koreksi Data</h1>
            <p class="text-slate-500 font-medium">Periksa data pengunjung sebelum memberikan persetujuan manual.</p>
        </div>
    </header>

    @if(session('info'))
    <div class="bg-blue-50 border-l-4 border-blue-500 p-4 rounded-xl animate__animated animate__headShake">
        <div class="flex items-center gap-3">
            <i class="fas fa-info-circle text-blue-500 text-xl"></i>
            <p class="text-blue-700 font-bold text-sm">{{ session('info') }}</p>
        </div>
    </div>
    @endif

    {{-- Tampilkan Error Validasi --}}
    @if($errors->any())
    <div class="bg-red-50 border-l-4 border-red-500 p-4 rounded-xl">
        <div class="flex">
            <div class="flex-shrink-0">
                <i class="fas fa-exclamation-circle text-red-400"></i>
            </div>
            <div class="ml-3">
                <h3 class="text-sm font-bold text-red-800">Ada kesalahan input:</h3>
                <ul class="mt-1 list-disc list-inside text-xs text-red-700">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
    @endif

    <form action="{{ route('admin.kunjungan.update', $kunjungan->id) }}" method="POST">
        @csrf
        @method('PATCH')

        <div class="grid grid-cols-1 xl:grid-cols-3 gap-8">
            
            {{-- KOLOM KIRI: FORM EDIT --}}
            <div class="xl:col-span-2 space-y-8">
                {{-- Data Pengunjung Utama --}}
                <div class="bg-white rounded-[2.5rem] shadow-xl shadow-slate-200/50 border border-slate-100 overflow-hidden animate__animated animate__fadeInUp">
                    <div class="bg-slate-50 px-8 py-6 border-b border-slate-100 flex items-center gap-4">
                        <div class="w-10 h-10 bg-blue-600 rounded-xl flex items-center justify-center text-white shadow-lg">
                            <i class="fas fa-user-edit"></i>
                        </div>
                        <h2 class="text-lg font-black text-slate-800 uppercase tracking-tight">Identitas Pengunjung</h2>
                    </div>
                    
                    <div class="p-8 space-y-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-2">
                                <label class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ml-2">Nama Pengunjung</label>
                                <input type="text" name="nama_pengunjung" value="{{ old('nama_pengunjung', $kunjungan->nama_pengunjung) }}" required class="w-full p-4 bg-slate-50 border-2 border-slate-100 rounded-2xl font-bold text-slate-700 focus:border-blue-500 focus:ring-0">
                            </div>
                            <div class="space-y-2">
                                <label class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ml-2">NIK (KTP)</label>
                                <input type="text" name="nik_ktp" value="{{ old('nik_ktp', $kunjungan->nik_ktp) }}" required maxlength="16" class="w-full p-4 bg-slate-50 border-2 border-slate-100 rounded-2xl font-bold text-slate-700 focus:border-blue-500 focus:ring-0">
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-2">
                                <label class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ml-2">Kontak WhatsApp</label>
                                <input type="text" name="no_wa_pengunjung" value="{{ old('no_wa_pengunjung', $kunjungan->no_wa_pengunjung) }}" class="w-full p-4 bg-slate-50 border-2 border-slate-100 rounded-2xl font-bold text-slate-700 focus:border-blue-500 focus:ring-0">
                            </div>
                            <div class="space-y-2">
                                <label class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ml-2">Hubungan dengan WBP</label>
                                <input type="text" name="hubungan" value="{{ old('hubungan', $kunjungan->hubungan) }}" required class="w-full p-4 bg-slate-50 border-2 border-slate-100 rounded-2xl font-bold text-slate-700 focus:border-blue-500 focus:ring-0">
                            </div>
                        </div>

                        <div class="space-y-2">
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ml-2">Alamat Pengunjung</label>
                            <textarea name="alamat_pengunjung" rows="2" class="w-full p-4 bg-slate-50 border-2 border-slate-100 rounded-2xl font-bold text-slate-700 focus:border-blue-500 focus:ring-0">{{ old('alamat_pengunjung', $kunjungan->alamat_pengunjung) }}</textarea>
                        </div>

                        <div class="space-y-2">
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ml-2">Barang Bawaan</label>
                            <input type="text" name="barang_bawaan" value="{{ old('barang_bawaan', $kunjungan->barang_bawaan) }}" class="w-full p-4 bg-slate-50 border-2 border-slate-100 rounded-2xl font-bold text-slate-700 focus:border-blue-500 focus:ring-0">
                        </div>

                        <div class="space-y-2">
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ml-2">WBP yang Dikunjungi</label>
                            <select name="wbp_id" required class="w-full p-4 bg-slate-50 border-2 border-slate-100 rounded-2xl font-bold text-slate-700 focus:border-blue-500 focus:ring-0">
                                @foreach($wbps as $wbp)
                                    <option value="{{ $wbp->id }}" {{ $kunjungan->wbp_id == $wbp->id ? 'selected' : '' }}>{{ $wbp->nama }} ({{ $wbp->no_registrasi }})</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                {{-- Data Pengikut --}}
                <div class="bg-white rounded-[2.5rem] shadow-xl shadow-slate-200/50 border border-slate-100 overflow-hidden animate__animated animate__fadeInUp">
                    <div class="bg-slate-50 px-8 py-6 border-b border-slate-100 flex items-center justify-between">
                        <div class="flex items-center gap-4">
                            <div class="w-10 h-10 bg-emerald-600 rounded-xl flex items-center justify-center text-white shadow-lg">
                                <i class="fas fa-users"></i>
                            </div>
                            <h2 class="text-lg font-black text-slate-800 uppercase tracking-tight">Koreksi Data Pengikut</h2>
                        </div>
                        <button type="button" @click="new_pengikuts.push({nama: '', nik: '', identityType: 'nik'})" class="w-10 h-10 bg-emerald-100 text-emerald-600 rounded-xl flex items-center justify-center hover:bg-emerald-600 hover:text-white transition-all shadow-sm" title="Tambah Pengikut">
                            <i class="fas fa-plus"></i>
                        </button>
                    </div>
                    <div class="p-8">
                        <div class="space-y-6">
                            @if($kunjungan->pengikuts->count() > 0)
                                @foreach($kunjungan->pengikuts as $pengikut)
                                @php
                                    // Deteksi tipe identitas default berdasarkan data yang ada
                                    $isNumeric16 = is_numeric($pengikut->nik) && strlen($pengikut->nik) === 16;
                                    $defaultType = $isNumeric16 ? 'nik' : 'lainnya';
                                @endphp
                                <div class="bg-slate-50 p-6 rounded-3xl border-2 border-slate-100 space-y-4" x-data="{ identityType: '{{ $defaultType }}' }">
                                    <p class="text-[10px] font-black text-emerald-600 uppercase tracking-widest">Pengikut #{{ $loop->iteration }}</p>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div class="space-y-1">
                                            <label class="text-[9px] font-black text-slate-400 uppercase ml-1">Nama Lengkap</label>
                                            <input type="text" name="pengikut[{{ $pengikut->id }}][nama]" value="{{ $pengikut->nama }}" class="w-full p-3 bg-white border-2 border-slate-100 rounded-xl font-bold text-slate-700 text-sm focus:border-emerald-500 focus:ring-0">
                                        </div>
                                        <div class="space-y-1">
                                            <label class="text-[9px] font-black text-slate-400 uppercase ml-1">Identitas (NIK/Lainnya)</label>
                                            <div class="flex gap-2">
                                                <select x-model="identityType" name="pengikut[{{ $pengikut->id }}][identitas_type]" class="rounded-xl border-2 border-slate-100 bg-white text-xs font-bold text-slate-600 focus:border-emerald-500 focus:ring-0 px-2">
                                                    <option value="nik">NIK</option>
                                                    <option value="lainnya">Lainnya</option>
                                                </select>
                                                <input :type="identityType === 'nik' ? 'number' : 'text'" 
                                                       name="pengikut[{{ $pengikut->id }}][nik]" 
                                                       value="{{ $pengikut->nik }}" 
                                                       :required="identityType === 'nik'"
                                                       maxlength="16" 
                                                       class="flex-1 p-3 bg-white border-2 border-slate-100 rounded-xl font-bold text-slate-700 text-sm focus:border-emerald-500 focus:ring-0">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            @endif

                            {{-- Pengikut Baru (Dynamic) --}}
                            <template x-for="(item, index) in new_pengikuts" :key="index">
                                <div class="bg-emerald-50 p-6 rounded-3xl border-2 border-emerald-100 space-y-4 relative animate__animated animate__fadeIn">
                                    <button type="button" @click="new_pengikuts.splice(index, 1)" class="absolute top-4 right-4 text-emerald-400 hover:text-red-500 transition-colors">
                                        <i class="fas fa-times-circle text-xl"></i>
                                    </button>
                                    <p class="text-[10px] font-black text-emerald-600 uppercase tracking-widest">Pengikut Baru</p>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div class="space-y-1">
                                            <label class="text-[9px] font-black text-slate-400 uppercase ml-1">Nama Lengkap</label>
                                            <input type="text" :name="'new_pengikut['+index+'][nama]'" x-model="item.nama" required class="w-full p-3 bg-white border-2 border-slate-100 rounded-xl font-bold text-slate-700 text-sm focus:border-emerald-500 focus:ring-0">
                                        </div>
                                        <div class="space-y-1">
                                            <label class="text-[9px] font-black text-slate-400 uppercase ml-1">Identitas (NIK/Lainnya)</label>
                                            <div class="flex gap-2">
                                                <select x-model="item.identityType" :name="'new_pengikut['+index+'][identitas_type]'" class="rounded-xl border-2 border-slate-100 bg-white text-xs font-bold text-slate-600 focus:border-emerald-500 focus:ring-0 px-2">
                                                    <option value="nik">NIK</option>
                                                    <option value="lainnya">Lainnya</option>
                                                </select>
                                                <input :type="item.identityType === 'nik' ? 'number' : 'text'" 
                                                       :name="'new_pengikut['+index+'][nik]'" 
                                                       x-model="item.nik" 
                                                       :required="item.identityType === 'nik'"
                                                       maxlength="16" 
                                                       class="flex-1 p-3 bg-white border-2 border-slate-100 rounded-xl font-bold text-slate-700 text-sm focus:border-emerald-500 focus:ring-0">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </template>

                            @if($kunjungan->pengikuts->count() == 0)
                                <div x-show="new_pengikuts.length == 0" class="text-center py-10 opacity-40">
                                    <i class="fas fa-user-slash text-4xl mb-3"></i>
                                    <p class="font-bold uppercase text-xs tracking-widest">Tidak ada pengikut tambahan</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            {{-- KOLOM KANAN: STATUS & ACTION --}}
            <div class="xl:col-span-1 space-y-8">
                
                {{-- Card Preview KTP --}}
                <div class="bg-white rounded-[2.5rem] shadow-xl shadow-slate-200/50 border border-slate-100 overflow-hidden animate__animated animate__fadeInRight">
                    <div class="bg-slate-50 px-6 py-4 border-b border-slate-100 flex items-center justify-between">
                        <h2 class="text-xs font-black text-slate-800 uppercase tracking-widest">Foto KTP</h2>
                        <a href="{{ $kunjungan->foto_ktp_url }}" target="_blank" class="text-[10px] font-bold text-blue-600 underline">Lihat Full</a>
                    </div>
                    <div class="p-6">
                        @if($kunjungan->foto_ktp)
                            <img src="{{ $kunjungan->foto_ktp_url }}" class="w-full h-auto rounded-2xl shadow-sm border-4 border-slate-50" alt="KTP">
                        @else
                            <div class="aspect-video bg-slate-100 rounded-2xl flex items-center justify-center text-slate-300">
                                <i class="fas fa-image text-4xl"></i>
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Card Keputusan Verifikasi --}}
                <div class="bg-slate-900 rounded-[2.5rem] shadow-2xl shadow-slate-900/20 overflow-hidden animate__animated animate__fadeInUp sticky top-8">
                    <div class="p-8 space-y-6">
                        <div class="text-center space-y-2">
                            <p class="text-yellow-500 text-[10px] font-black uppercase tracking-[0.3em]">Decision Room</p>
                            <h2 class="text-white text-xl font-black uppercase tracking-tight">Status Verifikasi</h2>
                        </div>

                        <div class="space-y-4">
                            <label class="block">
                                <input type="radio" name="status" value="approved" class="peer sr-only" {{ $kunjungan->status == \App\Enums\KunjunganStatus::APPROVED ? 'checked' : '' }} required>
                                <div class="p-4 bg-slate-800 border-2 border-slate-700 rounded-2xl text-slate-400 font-bold text-sm cursor-pointer transition-all peer-checked:border-emerald-500 peer-checked:bg-emerald-500/10 peer-checked:text-emerald-500 flex items-center gap-3">
                                    <div class="w-6 h-6 rounded-full border-2 border-current flex items-center justify-center">
                                        <div class="w-2.5 h-2.5 bg-current rounded-full opacity-0 peer-checked:opacity-100"></div>
                                    </div>
                                    <i class="fas fa-check-circle"></i> SETUJUI KUNJUNGAN
                                </div>
                            </label>

                            <label class="block">
                                <input type="radio" name="status" value="rejected" class="peer sr-only" {{ $kunjungan->status == \App\Enums\KunjunganStatus::REJECTED ? 'checked' : '' }}>
                                <div class="p-4 bg-slate-800 border-2 border-slate-700 rounded-2xl text-slate-400 font-bold text-sm cursor-pointer transition-all peer-checked:border-red-500 peer-checked:bg-red-500/10 peer-checked:text-red-500 flex items-center gap-3">
                                    <div class="w-6 h-6 rounded-full border-2 border-current flex items-center justify-center">
                                        <div class="w-2.5 h-2.5 bg-current rounded-full opacity-0 peer-checked:opacity-100"></div>
                                    </div>
                                    <i class="fas fa-times-circle"></i> TOLAK PENDAFTARAN
                                </div>
                            </label>

                            <label class="block">
                                <input type="radio" name="status" value="pending" class="peer sr-only" {{ $kunjungan->status == \App\Enums\KunjunganStatus::PENDING ? 'checked' : '' }}>
                                <div class="p-4 bg-slate-800 border-2 border-slate-700 rounded-2xl text-slate-400 font-bold text-sm cursor-pointer transition-all peer-checked:border-amber-500 peer-checked:bg-amber-500/10 peer-checked:text-amber-500 flex items-center gap-3">
                                    <div class="w-6 h-6 rounded-full border-2 border-current flex items-center justify-center">
                                        <div class="w-2.5 h-2.5 bg-current rounded-full opacity-0 peer-checked:opacity-100"></div>
                                    </div>
                                    <i class="fas fa-clock"></i> TAHAN (PENDING)
                                </div>
                            </label>
                        </div>

                        <div class="pt-4">
                            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-black py-5 rounded-2xl shadow-xl shadow-blue-900/50 transition-all active:scale-95 flex items-center justify-center gap-3 uppercase tracking-tighter">
                                <span>Simpan & Proses</span>
                                <i class="fas fa-save text-lg"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
