@extends('layouts.admin')

@section('title', 'Edit ' . $institutional->title)

@section('content')
<div class="max-w-4xl mx-auto space-y-6 pb-12">
    {{-- HEADER --}}
    <div class="flex items-center justify-between bg-white p-6 rounded-3xl border border-slate-100 shadow-sm">
        <div class="flex items-center gap-4">
            <a href="{{ route('admin.institutional.index') }}" class="w-10 h-10 flex items-center justify-center rounded-xl bg-slate-100 text-slate-500 hover:bg-slate-200 transition-all">
                <i class="fas fa-arrow-left"></i>
            </a>
            <div>
                <h1 class="text-xl font-black text-slate-800">Edit {{ $institutional->title }}</h1>
                <p class="text-xs text-slate-400 font-bold uppercase tracking-widest mt-0.5">Pengaturan Konten Lembaga</p>
            </div>
        </div>
    </div>

    {{-- FORM --}}
    <div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-xl overflow-hidden">
        <form action="{{ route('admin.institutional.update', $institutional->id) }}" method="POST" class="p-10 space-y-8">
            @csrf
            @method('PUT')

            <div class="space-y-2">
                <label class="block text-sm font-black text-slate-700 uppercase tracking-widest">Judul Informasi</label>
                <input type="text" name="title" value="{{ old('title', $institutional->title) }}" 
                    class="w-full px-6 py-4 bg-slate-50 border-2 border-slate-100 rounded-2xl focus:border-blue-500 focus:outline-none font-bold text-slate-700 transition-all" required>
            </div>

            <div class="space-y-2">
                <label class="block text-sm font-black text-slate-700 uppercase tracking-widest">Konten / Isi</label>
                @if($institutional->type === 'html')
                    <div class="prose max-w-none">
                        <input id="content" type="hidden" name="content" value="{{ old('content', $institutional->content) }}">
                        <trix-editor input="content" class="min-h-[300px] bg-slate-50 border-2 border-slate-100 rounded-2xl p-4 focus:border-blue-500 outline-none"></trix-editor>
                    </div>
                    <p class="text-[10px] text-slate-400 italic mt-1">* Gunakan editor di atas untuk mengatur tampilan (list, bold, dll).</p>
                @else
                    <textarea name="content" rows="8" 
                        class="w-full px-6 py-4 bg-slate-50 border-2 border-slate-100 rounded-2xl focus:border-blue-500 focus:outline-none font-medium text-slate-600 transition-all" required>{{ old('content', $institutional->content) }}</textarea>
                @endif
            </div>

            <div class="pt-6 border-t border-slate-50 flex gap-3">
                <button type="submit" class="px-8 py-4 bg-slate-900 hover:bg-black text-white font-black rounded-2xl shadow-xl hover:-translate-y-1 active:scale-95 transition-all flex items-center gap-3">
                    <i class="fas fa-save"></i>
                    Simpan Perubahan
                </button>
                <a href="{{ route('admin.institutional.index') }}" class="px-8 py-4 bg-slate-100 hover:bg-slate-200 text-slate-600 font-black rounded-2xl transition-all">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>

{{-- trix assets --}}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/trix/2.0.10/trix.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/trix/2.0.10/trix.umd.min.js"></script>
<style>
    trix-toolbar .trix-button-group--file-tools { display: none !important; }
</style>
@endsection
