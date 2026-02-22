@extends('layouts.admin')

@section('title', 'Tambah Laporan Publik')

@section('content')
<div class="max-w-3xl mx-auto space-y-6 pb-12"
    x-data="{
        categoryMode: 'existing',
        customCategory: '',
        selectedCategory: '{{ old('category', $categories->first()) }}',
        fileName: ''
    }">

    {{-- HEADER --}}
    <div class="flex items-center gap-4">
        <a href="{{ route('admin.financial-reports.index') }}"
            class="w-10 h-10 rounded-xl bg-white border border-slate-200 flex items-center justify-center text-slate-400 hover:text-blue-600 hover:border-blue-300 transition-all shadow-sm">
            <i class="fas fa-arrow-left text-sm"></i>
        </a>
        <div>
            <h1 class="text-2xl font-black text-slate-900 tracking-tight">Tambah Laporan Publik</h1>
            <p class="text-slate-400 text-sm">Unggah dokumen informasi publik baru.</p>
        </div>
    </div>

    {{-- ERRORS --}}
    @if($errors->any())
    <div class="bg-red-50 border border-red-200 rounded-2xl p-4 flex gap-3">
        <i class="fas fa-exclamation-circle text-red-500 mt-0.5 flex-shrink-0"></i>
        <ul class="text-sm text-red-700 font-medium space-y-1">
            @foreach($errors->all() as $e) <li>{{ $e }}</li> @endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('admin.financial-reports.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
            <div class="p-6 space-y-6">

                {{-- Judul --}}
                <div class="space-y-1.5">
                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Judul Laporan <span class="text-red-500">*</span></label>
                    <input type="text" name="title" value="{{ old('title') }}" required
                        class="w-full px-4 py-3 bg-slate-50 border-2 border-slate-100 rounded-xl font-bold text-slate-700 text-sm focus:bg-white focus:border-blue-400 focus:outline-none transition-all @error('title') border-red-400 @enderror"
                        placeholder="Contoh: LHKPN Kepala Lapas Tahun 2025">
                </div>

                {{-- ═══════════════ KATEGORI DINAMIS ═══════════════ --}}
                <div class="space-y-3">
                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest">
                        Kategori Laporan <span class="text-red-500">*</span>
                    </label>

                    {{-- Toggle mode --}}
                    <div class="flex p-1 bg-slate-100 rounded-xl w-fit gap-1">
                        <button type="button" @click="categoryMode = 'existing'"
                            :class="categoryMode === 'existing' ? 'bg-white text-slate-800 shadow-sm' : 'text-slate-500 hover:text-slate-700'"
                            class="px-4 py-2 rounded-lg font-bold text-xs transition-all">
                            <i class="fas fa-list mr-1.5"></i> Pilih yang Ada
                        </button>
                        <button type="button" @click="categoryMode = 'new'"
                            :class="categoryMode === 'new' ? 'bg-white text-blue-700 shadow-sm' : 'text-slate-500 hover:text-slate-700'"
                            class="px-4 py-2 rounded-lg font-bold text-xs transition-all">
                            <i class="fas fa-plus mr-1.5"></i> Tambah Kategori Baru
                        </button>
                    </div>

                    {{-- Pilih kategori yang sudah ada --}}
                    <div x-show="categoryMode === 'existing'" x-transition>
                        <div class="relative">
                            <select name="category" x-model="selectedCategory"
                                :required="categoryMode === 'existing'"
                                class="w-full px-4 py-3 bg-slate-50 border-2 border-slate-100 rounded-xl font-bold text-slate-700 text-sm focus:bg-white focus:border-blue-400 focus:outline-none appearance-none cursor-pointer transition-all">
                                @foreach($categories as $cat)
                                <option value="{{ $cat }}" {{ old('category') === $cat ? 'selected' : '' }}>{{ $cat }}</option>
                                @endforeach
                            </select>
                            <i class="fas fa-chevron-down absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 text-xs pointer-events-none"></i>
                        </div>

                        {{-- Preview badge kategori --}}
                        <div class="flex flex-wrap gap-2 mt-3">
                            @foreach($categories as $cat)
                            @php
                                $colors = ['LHKPN'=>'bg-violet-100 text-violet-700','LAKIP'=>'bg-blue-100 text-blue-700','Keuangan'=>'bg-emerald-100 text-emerald-700','Renstra'=>'bg-amber-100 text-amber-700','RKT'=>'bg-cyan-100 text-cyan-700','Profil Lapas'=>'bg-rose-100 text-rose-700'];
                                $cc = $colors[$cat] ?? 'bg-slate-100 text-slate-600';
                            @endphp
                            <button type="button" @click="selectedCategory = '{{ $cat }}'"
                                :class="selectedCategory === '{{ $cat }}' ? 'ring-2 ring-offset-1 ring-blue-400' : ''"
                                class="{{ $cc }} px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-widest cursor-pointer transition-all hover:opacity-80">
                                {{ $cat }}
                            </button>
                            @endforeach
                        </div>
                    </div>

                    {{-- Buat kategori baru --}}
                    <div x-show="categoryMode === 'new'" x-transition>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none">
                                <i class="fas fa-tag text-blue-400 text-sm"></i>
                            </div>
                            <input type="text" name="custom_category" x-model="customCategory"
                                :required="categoryMode === 'new'"
                                class="w-full pl-11 pr-4 py-3 bg-blue-50 border-2 border-blue-100 rounded-xl font-bold text-blue-800 text-sm focus:bg-white focus:border-blue-400 focus:outline-none transition-all @error('custom_category') border-red-400 @enderror"
                                placeholder="Ketik nama kategori baru, mis: Laporan Tahunan · SPIP · LKjIP">
                        </div>
                        <div class="mt-2 flex items-start gap-2 bg-amber-50 border border-amber-200 rounded-xl px-3 py-2">
                            <i class="fas fa-lightbulb text-amber-400 text-xs mt-0.5 flex-shrink-0"></i>
                            <p class="text-xs text-amber-700 font-medium">
                                Kategori baru akan langsung tersedia di sistem dan bisa dipilih untuk laporan berikutnya.
                            </p>
                        </div>
                    </div>
                </div>

                {{-- Tahun & File (grid 2) --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    {{-- Tahun --}}
                    <div class="space-y-1.5">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Tahun Anggaran <span class="text-red-500">*</span></label>
                        <div class="relative">
                            <i class="fas fa-calendar absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-sm"></i>
                            <input type="number" name="year" value="{{ old('year', date('Y')) }}" required min="2000" max="{{ date('Y')+1 }}"
                                class="w-full pl-11 pr-4 py-3 bg-slate-50 border-2 border-slate-100 rounded-xl font-black text-slate-700 text-sm focus:bg-white focus:border-blue-400 focus:outline-none transition-all">
                        </div>
                    </div>

                    {{-- Upload File --}}
                    <div class="space-y-1.5">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Dokumen (PDF/Excel) <span class="text-red-500">*</span></label>
                        <label class="block cursor-pointer group">
                            <input type="file" name="file" required class="hidden"
                                @change="fileName = $event.target.files[0]?.name || ''">
                            <div class="w-full px-4 py-3 bg-slate-50 border-2 border-dashed border-slate-200 rounded-xl flex items-center gap-3 group-hover:border-blue-400 group-hover:bg-blue-50 transition-all"
                                :class="fileName ? 'border-emerald-400 bg-emerald-50' : ''">
                                <div class="w-8 h-8 rounded-lg flex items-center justify-center flex-shrink-0"
                                    :class="fileName ? 'bg-emerald-100 text-emerald-600' : 'bg-white text-slate-400'">
                                    <i class="fas" :class="fileName ? 'fa-check-circle' : 'fa-cloud-upload-alt'" class="text-sm"></i>
                                </div>
                                <span class="text-xs font-bold truncate"
                                    :class="fileName ? 'text-emerald-700' : 'text-slate-400 group-hover:text-blue-500'"
                                    x-text="fileName || 'Pilih file dari komputer...'"></span>
                            </div>
                        </label>
                        <p class="text-[10px] text-slate-400 pl-1">Maks. 10 MB · PDF, DOC, XLS</p>
                    </div>
                </div>

                {{-- Deskripsi --}}
                <div class="space-y-1.5">
                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Ringkasan / Keterangan</label>
                    <textarea name="description" rows="3"
                        class="w-full px-4 py-3 bg-slate-50 border-2 border-slate-100 rounded-xl font-medium text-slate-700 text-sm focus:bg-white focus:border-blue-400 focus:outline-none resize-none transition-all"
                        placeholder="Gambaran singkat isi laporan ini...">{{ old('description') }}</textarea>
                </div>

                {{-- Status Publikasi --}}
                <div class="flex items-center justify-between bg-slate-50 border border-slate-200 rounded-xl px-5 py-4">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 bg-blue-100 rounded-xl flex items-center justify-center text-blue-600 flex-shrink-0">
                            <i class="fas fa-globe-asia text-sm"></i>
                        </div>
                        <div>
                            <p class="text-sm font-black text-slate-800">Publikasikan Sekarang</p>
                            <p class="text-xs text-slate-400">Langsung tampil di halaman laporan publik pengunjung.</p>
                        </div>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" name="is_published" value="1" class="sr-only peer" checked>
                        <div class="w-12 h-6 bg-slate-200 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:left-[3px] after:bg-white after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                    </label>
                </div>
            </div>

            {{-- Footer --}}
            <div class="bg-slate-50 px-6 py-4 flex justify-end gap-3 border-t border-slate-100">
                <a href="{{ route('admin.financial-reports.index') }}"
                    class="px-5 py-2.5 bg-white border border-slate-200 text-slate-600 font-bold rounded-xl hover:bg-slate-100 transition-all text-sm">
                    Batal
                </a>
                <button type="submit"
                    class="px-6 py-2.5 bg-slate-900 hover:bg-blue-600 text-white font-black rounded-xl transition-all active:scale-95 shadow-lg shadow-slate-300/50 text-sm flex items-center gap-2">
                    <i class="fas fa-save"></i> Simpan Laporan
                </button>
            </div>
        </div>
    </form>
</div>
@endsection
