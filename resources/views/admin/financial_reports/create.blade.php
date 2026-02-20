@extends('layouts.admin')

@section('content')
<div class="max-w-5xl mx-auto space-y-8">
    <header class="flex items-center gap-4 animate__animated animate__fadeInDown">
        <a href="{{ route('admin.financial-reports.index') }}" class="w-12 h-12 rounded-2xl bg-white border border-slate-200 flex items-center justify-center text-slate-400 hover:text-blue-600 transition-all shadow-sm">
            <i class="fas fa-arrow-left"></i>
        </a>
        <div>
            <h1 class="text-3xl font-black text-slate-900 tracking-tighter">Tambah Laporan</h1>
            <p class="text-slate-500 font-medium">Unggah dokumen informasi publik baru.</p>
        </div>
    </header>

    <form action="{{ route('admin.financial-reports.store') }}" method="POST" enctype="multipart/form-data" class="animate__animated animate__fadeInUp">
        @csrf
        <div class="bg-white rounded-[2.5rem] shadow-2xl shadow-slate-200/50 border border-slate-100 overflow-hidden">
            <div class="p-10 space-y-8">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    {{-- Judul --}}
                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ml-2">Judul Laporan</label>
                        <input type="text" name="title" value="{{ old('title') }}" required 
                            class="w-full p-4 bg-slate-50 border-2 border-slate-100 rounded-2xl focus:bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all font-bold text-slate-700" 
                            placeholder="Contoh: LHKPN Kalapas 2024">
                    </div>

                    {{-- Kategori --}}
                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ml-2">Kategori Laporan</label>
                        <select name="category" required class="w-full p-4 bg-slate-50 border-2 border-slate-100 rounded-2xl focus:bg-white focus:border-blue-500 focus:ring-0 font-bold text-slate-700 cursor-pointer">
                            <option value="LHKPN">LHKPN (Harta Kekayaan)</option>
                            <option value="LAKIP">LAKIP (Kinerja Pemerintah)</option>
                            <option value="Keuangan">Laporan Keuangan</option>
                            <option value="Lainnya">Informasi Publik Lainnya</option>
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    {{-- Tahun --}}
                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ml-2">Tahun Anggaran</label>
                        <input type="number" name="year" value="{{ date('Y') }}" required 
                            class="w-full p-4 bg-slate-50 border-2 border-slate-100 rounded-2xl focus:bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all font-bold text-slate-700">
                    </div>

                    {{-- Upload File --}}
                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ml-2">Unggah Dokumen (PDF/Excel)</label>
                        <div class="relative group">
                            <input type="file" name="file" required class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">
                            <div class="w-full p-4 bg-slate-50 border-2 border-dashed border-slate-200 rounded-2xl flex items-center gap-4 group-hover:border-blue-400 transition-colors">
                                <div class="w-10 h-10 rounded-xl bg-white flex items-center justify-center text-slate-400">
                                    <i class="fas fa-cloud-upload-alt"></i>
                                </div>
                                <span class="text-sm font-bold text-slate-400 group-hover:text-blue-500">Pilih file dari komputer...</span>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Deskripsi --}}
                <div class="space-y-2">
                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ml-2">Ringkasan / Keterangan</label>
                    <textarea name="description" rows="4" 
                        class="w-full p-5 bg-slate-50 border-2 border-slate-100 rounded-3xl focus:bg-white focus:border-blue-500 focus:ring-0 transition-all font-bold text-slate-700" 
                        placeholder="Berikan gambaran singkat mengenai isi laporan ini..."></textarea>
                </div>

                {{-- Publish Toggle --}}
                <div class="bg-blue-50/50 p-6 rounded-[2rem] border border-blue-100 flex items-center justify-between group hover:bg-blue-50 transition-all">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-2xl bg-white flex items-center justify-center text-blue-600 shadow-sm group-hover:scale-110 transition-transform">
                            <i class="fas fa-globe-asia text-xl"></i>
                        </div>
                        <div>
                            <p class="font-black text-slate-800 uppercase tracking-tight">Status Publikasi</p>
                            <p class="text-xs text-slate-500">Jika diaktifkan, laporan akan langsung muncul di halaman pengunjung.</p>
                        </div>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" name="is_published" value="1" class="sr-only peer" checked>
                        <div class="w-14 h-7 bg-slate-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:left-[4px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-6 after:w-6 after:transition-all peer-checked:bg-blue-600"></div>
                    </label>
                </div>
            </div>

            {{-- Footer Form --}}
            <div class="bg-slate-50 px-10 py-8 flex flex-col sm:flex-row justify-end gap-4 border-t border-slate-100">
                <a href="{{ route('admin.financial-reports.index') }}" class="px-8 py-4 bg-white text-slate-600 font-black rounded-2xl border border-slate-200 hover:bg-slate-100 transition-all text-center">Batal</a>
                <button type="submit" class="px-10 py-4 bg-slate-900 text-white font-black rounded-2xl hover:bg-blue-600 transition-all active:scale-95 shadow-2xl shadow-slate-300">
                    Simpan Laporan Sekarang
                </button>
            </div>
        </div>
    </form>
</div>
@endsection
