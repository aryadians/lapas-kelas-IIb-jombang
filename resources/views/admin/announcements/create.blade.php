@extends('layouts.admin')

@section('title', 'Buat Pengumuman Baru')

@section('content')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/trix@2.0.0/dist/trix.css">
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/trix@2.0.0/dist/trix.umd.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<style>
    trix-editor { border: 2px solid #e2e8f0 !important; border-radius: 0.75rem; padding: 1rem; min-height: 260px; background: white; }
    trix-editor:focus { border-color: #3b82f6 !important; box-shadow: 0 0 0 4px rgba(59,130,246,0.1); }
    .input-field { border: 2px solid #e2e8f0; transition: all 0.2s; }
    .input-field:focus { border-color: #3b82f6; box-shadow: 0 0 0 4px rgba(59,130,246,0.1); outline: none; }
</style>

<div class="max-w-5xl mx-auto pb-12 space-y-6"
    x-data="{
        title: '{{ old('title', '') }}',
        status: '{{ old('status', 'published') }}',
        date: '{{ old('date', date('Y-m-d')) }}',
        get formattedDate() {
            if (!this.date) return 'Belum dipilih';
            const d = new Date(this.date);
            return d.toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' });
        }
    }">

    {{-- HEADER --}}
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 bg-gradient-to-br from-blue-600 to-indigo-700 rounded-2xl flex items-center justify-center shadow-xl shadow-blue-500/20">
                <i class="fas fa-bullhorn text-white text-xl"></i>
            </div>
            <div>
                <h1 class="text-2xl font-black text-slate-800">Buat Pengumuman Baru</h1>
                <p class="text-slate-400 text-sm">Isi formulir untuk menerbitkan pengumuman</p>
            </div>
        </div>
        <a href="{{ route('announcements.index') }}"
            class="inline-flex items-center gap-2 bg-white text-slate-600 font-bold py-2.5 px-5 rounded-2xl shadow-sm border border-slate-200 hover:bg-slate-50 transition-all active:scale-95 text-sm">
            <i class="fas fa-arrow-left text-slate-400"></i> Kembali
        </a>
    </div>

    <form action="{{ route('announcements.store') }}" method="POST" id="createForm" class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        @csrf

        {{-- KOLOM KIRI: Konten --}}
        <div class="lg:col-span-2 space-y-5">

            {{-- Judul --}}
            <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6">
                <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2">
                    Judul Pengumuman <span class="text-red-500">*</span>
                </label>
                <input type="text" name="title" x-model="title"
                    value="{{ old('title') }}"
                    placeholder="Contoh: Perubahan Jadwal Kunjungan Bulan Ramadan"
                    class="input-field w-full px-4 py-3.5 rounded-xl bg-slate-50 text-slate-800 font-bold text-base placeholder-slate-300"
                    required>
                @error('title') <p class="text-red-500 text-xs mt-2">{{ $message }}</p> @enderror
            </div>

            {{-- Isi Konten --}}
            <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6">
                <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2">
                    Isi Pengumuman <span class="text-red-500">*</span>
                </label>
                <input id="content" type="hidden" name="content" value="{{ old('content') }}">
                <trix-editor input="content"></trix-editor>
                @error('content') <p class="text-red-500 text-xs mt-2">{{ $message }}</p> @enderror
            </div>
        </div>

        {{-- KOLOM KANAN: Sidebar --}}
        <div class="space-y-5">

            {{-- Preview Pengumuman --}}
            <div class="bg-gradient-to-br from-blue-600 to-indigo-700 rounded-2xl p-5 text-white shadow-xl shadow-blue-500/20">
                <p class="text-[10px] font-black uppercase tracking-widest text-blue-200 mb-3">Preview Kartu</p>
                <div class="flex items-start gap-3">
                    <div class="flex-shrink-0 bg-white/20 backdrop-blur rounded-xl p-3 text-center min-w-14">
                        <template x-if="date">
                            <div>
                                <div class="text-xl font-black leading-none" x-text="new Date(date).getDate()"></div>
                                <div class="text-[10px] font-bold uppercase opacity-80 mt-0.5"
                                    x-text="new Date(date).toLocaleDateString('id-ID', {month:'short'})"></div>
                            </div>
                        </template>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="font-black text-sm leading-tight line-clamp-2"
                            x-text="title || 'Judul pengumuman...'"></p>
                        <div class="flex items-center gap-1.5 mt-2">
                            <span class="text-[11px] font-bold px-2 py-0.5 rounded-full"
                                :class="status === 'published' ? 'bg-emerald-400/30 text-emerald-100' : 'bg-amber-400/30 text-amber-100'"
                                x-text="status === 'published' ? '✅ Published' : '📝 Draft'"></span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Tanggal --}}
            <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-5">
                <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2">
                    Tanggal Berlaku <span class="text-red-500">*</span>
                </label>
                <input type="date" name="date" x-model="date"
                    value="{{ old('date', date('Y-m-d')) }}"
                    class="input-field w-full px-4 py-3 rounded-xl bg-slate-50 text-slate-700 font-bold text-sm"
                    required>
                <p class="text-xs text-slate-400 mt-2 flex items-center gap-1">
                    <i class="fas fa-calendar-check text-blue-400"></i>
                    <span x-text="formattedDate"></span>
                </p>
                @error('date') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Status --}}
            <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-5">
                <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-3">Status Publikasi</label>
                <div class="grid grid-cols-2 gap-2">
                    <label class="relative cursor-pointer">
                        <input type="radio" name="status" value="published" x-model="status"
                            {{ old('status', 'published') == 'published' ? 'checked' : '' }} class="peer hidden">
                        <div class="flex flex-col items-center gap-1.5 p-3 rounded-xl border-2 border-slate-200 peer-checked:border-emerald-500 peer-checked:bg-emerald-50 transition-all">
                            <span class="text-xl">✅</span>
                            <span class="text-xs font-black text-slate-600 peer-checked:text-emerald-700">Terbitkan</span>
                        </div>
                    </label>
                    <label class="relative cursor-pointer">
                        <input type="radio" name="status" value="draft" x-model="status"
                            {{ old('status') == 'draft' ? 'checked' : '' }} class="peer hidden">
                        <div class="flex flex-col items-center gap-1.5 p-3 rounded-xl border-2 border-slate-200 peer-checked:border-amber-500 peer-checked:bg-amber-50 transition-all">
                            <span class="text-xl">📝</span>
                            <span class="text-xs font-black text-slate-600 peer-checked:text-amber-700">Draft</span>
                        </div>
                    </label>
                </div>
                @error('status') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Tips --}}
            <div class="bg-blue-50 border border-blue-100 rounded-2xl p-4">
                <p class="text-xs font-black text-blue-700 mb-2"><i class="fas fa-lightbulb mr-1"></i> Tips</p>
                <ul class="text-xs text-blue-600 space-y-1 list-disc list-inside">
                    <li>Gunakan judul yang jelas dan singkat</li>
                    <li>Cantumkan info kontak jika perlu</li>
                    <li>Draft tidak akan tampil di publik</li>
                </ul>
            </div>

            {{-- Tombol Aksi --}}
            <div class="space-y-3">
                <button type="button" onclick="confirmCreate()"
                    class="w-full py-3.5 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-bold rounded-2xl shadow-lg shadow-blue-500/30 transition-all hover:-translate-y-0.5 active:scale-95 flex items-center justify-center gap-2">
                    <i class="fas fa-bullhorn"></i>
                    <span x-text="status === 'published' ? 'Terbitkan Pengumuman' : 'Simpan sebagai Draft'"></span>
                </button>
                <a href="{{ route('announcements.index') }}"
                    class="block w-full py-3.5 bg-slate-100 hover:bg-slate-200 text-slate-600 font-bold rounded-2xl text-center transition-all active:scale-95 text-sm">
                    Batal
                </a>
            </div>
        </div>
    </form>
</div>

<script>
    function confirmCreate() {
        const status = document.querySelector('input[name="status"]:checked')?.value;
        Swal.fire({
            customClass: {
                popup: 'rounded-3xl shadow-2xl',
                confirmButton: 'rounded-xl px-6 py-3 font-bold bg-blue-600 text-white mr-2',
                cancelButton: 'rounded-xl px-6 py-3 font-bold bg-slate-200 text-slate-600'
            },
            buttonsStyling: false,
            title: status === 'published' ? 'Terbitkan Pengumuman?' : 'Simpan sebagai Draft?',
            text: status === 'published' ? 'Pengumuman akan langsung tampil ke publik.' : 'Pengumuman disimpan sebagai draft, belum tampil ke publik.',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: status === 'published' ? '📣 Ya, Terbitkan' : '📝 Ya, Simpan Draft',
            cancelButtonText: 'Cek Lagi'
        }).then(result => {
            if (result.isConfirmed) {
                Swal.fire({ title: 'Menyimpan...', allowOutsideClick: false, showConfirmButton: false, didOpen: () => Swal.showLoading() });
                document.getElementById('createForm').submit();
            }
        });
    }
</script>
@endsection