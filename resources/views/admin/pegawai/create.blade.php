@extends('layouts.admin')

@section('title', 'Tambah Pegawai')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">

    {{-- Header --}}
    <div class="flex items-center justify-between">
        <div class="flex items-center gap-4">
            <a href="{{ route('admin.pegawai.index') }}" class="w-10 h-10 flex items-center justify-center rounded-xl bg-white shadow-sm border border-slate-200 text-slate-500 hover:bg-slate-50 transition-all">
                <i class="fas fa-arrow-left"></i>
            </a>
            <div>
                <h1 class="text-2xl font-bold text-slate-800">Tambah Pegawai Baru</h1>
                <p class="text-slate-500 text-sm">Masukkan detail pejabat struktural untuk ditampilkan di halaman profil.</p>
            </div>
        </div>
    </div>

    {{-- Form --}}
    <form action="{{ route('admin.pegawai.store') }}" method="POST" enctype="multipart/form-data" class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden">
        @csrf
        
        <div class="p-8 space-y-8">
            {{-- Foto Profile Preview --}}
            <div class="flex flex-col items-center justify-center space-y-4">
                <div class="relative group">
                    <div id="imagePreview" class="w-32 h-32 rounded-full border-4 border-slate-100 shadow-md overflow-hidden bg-slate-50 flex items-center justify-center text-slate-300">
                        <i class="fas fa-user text-5xl"></i>
                    </div>
                    <label for="foto" class="absolute bottom-0 right-0 w-10 h-10 bg-blue-600 text-white rounded-full flex items-center justify-center shadow-lg cursor-pointer hover:bg-blue-700 transition-colors border-4 border-white">
                        <i class="fas fa-camera text-sm"></i>
                        <input type="file" name="foto" id="foto" class="hidden" accept="image/*" onchange="previewImage(event)">
                    </label>
                </div>
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Foto Pegawai (Maks 2MB)</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- Nama --}}
                <div class="space-y-2">
                    <label class="text-sm font-black text-slate-700 uppercase tracking-wider ml-1">Nama Lengkap & Gelar</label>
                    <input type="text" name="nama" value="{{ old('nama') }}" required
                           class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all outline-none"
                           placeholder="Contoh: RINO SOLEH SUMITRO, A.Md.IP, S.H., M.H.">
                    @error('nama') <p class="text-xs text-rose-500 font-bold mt-1 ml-1">{{ $message }}</p> @enderror
                </div>

                {{-- Jabatan --}}
                <div class="space-y-2">
                    <label class="text-sm font-black text-slate-700 uppercase tracking-wider ml-1">Jabatan</label>
                    <input type="text" name="jabatan" value="{{ old('jabatan') }}" required
                           class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all outline-none"
                           placeholder="Contoh: Kepala Lapas">
                    @error('jabatan') <p class="text-xs text-rose-500 font-bold mt-1 ml-1">{{ $message }}</p> @enderror
                </div>

                {{-- Seksi --}}
                <div class="space-y-2">
                    <label class="text-sm font-black text-slate-700 uppercase tracking-wider ml-1">Seksi / Unit (Opsional)</label>
                    <input type="text" name="seksi" value="{{ old('seksi') }}"
                           class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all outline-none"
                           placeholder="Contoh: Kesatuan Pengamanan Lapas">
                    @error('seksi') <p class="text-xs text-rose-500 font-bold mt-1 ml-1">{{ $message }}</p> @enderror
                </div>

                {{-- Level --}}
                <div class="space-y-2">
                    <label class="text-sm font-black text-slate-700 uppercase tracking-wider ml-1">Tingkatan / Eselon</label>
                    <select name="level" required
                            class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all outline-none appearance-none bg-[url('data:image/svg+xml;charset=UTF-8,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20viewBox%3D%220%200%2024%2024%22%20fill%3D%22none%22%20stroke%3D%22currentColor%22%20stroke-width%3D%222%22%20stroke-linecap%3D%22round%22%20stroke-linejoin%3D%22round%22%3E%3Cpolyline%20points%3D%226%209%2012%2015%2018%209%22%3E%3C%2Fpolyline%3E%3C%2Fsvg%3E')] bg-[length:1em_1em] bg-[right_1rem_center] bg-no-repeat">
                        <option value="kalapas">Kalapas</option>
                        <option value="eselon_4">Pejabat Struktural Eselon IV</option>
                        <option value="eselon_5">Pejabat Struktural Eselon V</option>
                    </select>
                    @error('level') <p class="text-xs text-rose-500 font-bold mt-1 ml-1">{{ $message }}</p> @enderror
                </div>

                {{-- Order Index --}}
                <div class="space-y-2">
                    <label class="text-sm font-black text-slate-700 uppercase tracking-wider ml-1">Urutan Tampil</label>
                    <input type="number" name="order_index" value="{{ old('order_index', 0) }}" required
                           class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all outline-none">
                    <p class="text-[10px] text-slate-400 italic font-bold">Semakin kecil angkanya, semakin awal ditampilkan.</p>
                </div>
            </div>

            {{-- Quotes (Khusus Kalapas) --}}
            <div class="space-y-2">
                <label class="text-sm font-black text-slate-700 uppercase tracking-wider ml-1">Quotes / Motto (Opsional)</label>
                <textarea name="quotes" rows="3"
                          class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all outline-none"
                          placeholder="Melayani dengan Hati, Berintegritas, dan Profesional..."></textarea>
                <p class="text-[10px] text-slate-400 italic font-bold">Catatan: Quotes biasanya hanya ditampilkan untuk profil Kalapas.</p>
            </div>
        </div>

        <div class="p-8 bg-slate-50/50 border-t border-slate-100 flex justify-end gap-3">
            <a href="{{ route('admin.pegawai.index') }}" class="px-8 py-3 rounded-xl text-sm font-black text-slate-500 hover:bg-slate-200 transition-all">BATAL</a>
            <button type="submit" class="px-10 py-3 bg-blue-600 hover:bg-blue-700 text-white font-black rounded-xl shadow-lg shadow-blue-200 transition-all active:scale-95">
                SIMPAN DATA
            </button>
        </div>
    </form>
</div>

@push('scripts')
<script>
    function previewImage(event) {
        const input = event.target;
        const reader = new FileReader();
        reader.onload = function() {
            const preview = document.getElementById('imagePreview');
            preview.innerHTML = `<img src="${reader.result}" class="w-full h-full object-cover">`;
        };
        reader.readAsDataURL(input.files[0]);
    }
</script>
@endpush
@endsection
