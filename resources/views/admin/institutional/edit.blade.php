@extends('layouts.admin')

@section('title', 'Edit ' . $institutional->title)

@section('content')
<div class="max-w-5xl mx-auto space-y-6 pb-12">
    {{-- HEADER --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 bg-white p-8 rounded-[2rem] border border-slate-100 shadow-sm relative overflow-hidden">
        <div class="absolute top-0 right-0 w-32 h-32 bg-blue-50 rounded-full blur-3xl -mt-10 -mr-10"></div>
        <div class="flex items-center gap-6 relative z-10">
            <a href="{{ route('admin.institutional.index') }}" class="w-12 h-12 flex items-center justify-center rounded-2xl bg-slate-100 text-slate-500 hover:bg-blue-600 hover:text-white transition-all shadow-sm">
                <i class="fas fa-arrow-left"></i>
            </a>
            <div>
                <h1 class="text-2xl font-black text-slate-800 tracking-tight">Perbarui {{ $institutional->title }}</h1>
                <div class="flex items-center gap-2 mt-1">
                    <span class="w-2 h-2 rounded-full bg-blue-500 animate-pulse"></span>
                    <p class="text-[10px] text-slate-400 font-black uppercase tracking-[0.2em]">Live Content Management</p>
                </div>
            </div>
        </div>
    </div>

    {{-- FORM --}}
    <div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-2xl overflow-hidden animate__animated animate__fadeInUp">
        <form action="{{ route('admin.institutional.update', $institutional->id) }}" method="POST" class="p-8 md:p-12 space-y-10">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 gap-10">
                {{-- Judul --}}
                <div class="space-y-3">
                    <label class="flex items-center gap-2 text-xs font-black text-slate-500 uppercase tracking-[0.2em]">
                        <i class="fas fa-tag text-blue-500"></i> Judul Informasi
                    </label>
                    <input type="text" name="title" value="{{ old('title', $institutional->title) }}" 
                        class="w-full px-8 py-5 bg-slate-50 border-2 border-slate-100 rounded-2xl focus:border-blue-500 focus:bg-white focus:outline-none font-black text-slate-700 transition-all text-lg shadow-inner" required>
                    <p class="text-[10px] text-slate-400 font-medium italic">Judul ini akan tampil sebagai tajuk utama di halaman profil.</p>
                </div>

                {{-- Konten --}}
                <div class="space-y-3">
                    <label class="flex items-center gap-2 text-xs font-black text-slate-500 uppercase tracking-[0.2em]">
                        <i class="fas fa-align-left text-blue-500"></i> Isi Konten Utama
                    </label>
                    
                    @if($institutional->type === 'html')
                        <div class="prose max-w-none">
                            <input id="content" type="hidden" name="content" value="{{ old('content', $institutional->content) }}">
                            <trix-editor input="content" class="min-h-[400px] bg-white border-2 border-slate-100 rounded-3xl p-6 focus:border-blue-500 outline-none shadow-inner text-slate-600 leading-relaxed"></trix-editor>
                        </div>
                        <div class="flex items-center gap-2 bg-blue-50 p-4 rounded-2xl border border-blue-100">
                            <i class="fas fa-info-circle text-blue-500"></i>
                            <p class="text-[11px] text-blue-700 font-bold leading-tight">Gunakan toolbar di atas untuk mengatur format daftar (list), penebalan teks, dan lainnya agar tampilan di halaman depan lebih rapi.</p>
                        </div>
                    @else
                        <textarea name="content" rows="10" 
                            class="w-full px-8 py-6 bg-slate-50 border-2 border-slate-100 rounded-3xl focus:border-blue-500 focus:bg-white focus:outline-none font-medium text-slate-600 transition-all leading-relaxed shadow-inner" required>{{ old('content', $institutional->content) }}</textarea>
                    @endif
                </div>
            </div>

            {{-- Actions --}}
            <div class="pt-10 border-t border-slate-50 flex flex-col sm:flex-row gap-4">
                <button type="submit" class="flex-1 sm:flex-none px-10 py-5 bg-slate-900 hover:bg-black text-white font-black rounded-2xl shadow-xl hover:-translate-y-1 active:scale-95 transition-all flex items-center justify-center gap-3 group">
                    <i class="fas fa-cloud-upload-alt text-blue-400 group-hover:scale-110 transition-transform"></i>
                    SIMPAN & PUBLIKASIKAN
                </button>
                <a href="{{ route('admin.institutional.index') }}" class="flex-1 sm:flex-none px-10 py-5 bg-slate-100 hover:bg-slate-200 text-slate-600 font-black rounded-2xl transition-all flex items-center justify-center">
                    BATAL
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
    trix-editor { font-size: 14px !important; }
    trix-editor ul { list-style-type: disc !important; padding-left: 2rem !important; margin-bottom: 1rem !important; display: block !important; }
    trix-editor ol { list-style-type: decimal !important; padding-left: 2rem !important; margin-bottom: 1rem !important; display: block !important; }
    trix-editor li { display: list-item !important; margin-bottom: 0.5rem !important; }
</style>
@endsection
