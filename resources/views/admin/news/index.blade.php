@extends('layouts.admin')

@section('content')
{{-- Load Animate.css --}}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>

<style>
    /* 3D Perspective */
    .perspective-1000 { perspective: 1000px; }

    /* 3D Card Effect */
    .card-3d {
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        transform-style: preserve-3d;
        backface-visibility: hidden;
    }
    .card-3d:hover {
        transform: translateY(-8px) scale(1.02);
        box-shadow: 0 20px 30px -10px rgba(0, 0, 0, 0.15);
        z-index: 10;
    }

    /* Gradient Text */
    .text-gradient {
        background-clip: text;
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-image: linear-gradient(to right, #1e293b, #2563eb);
    }

    /* Glassmorphism */
    .glass-panel {
        background: rgba(255, 255, 255, 0.9);
        backdrop-filter: blur(12px);
        border: 1px solid rgba(255, 255, 255, 0.5);
        box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.05);
    }
</style>

<div class="space-y-8 pb-12 perspective-1000">

    {{-- HEADER --}}
    <header class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 animate__animated animate__fadeInDown">
        <div>
            <h1 class="text-3xl font-extrabold text-gradient">Kelola Berita</h1>
            <p class="text-slate-500 mt-1 font-medium">Daftar publikasi dan artikel kegiatan.</p>
        </div>
        <div class="flex items-center gap-3">
            <button onclick="window.print()" class="group flex items-center gap-2 bg-white text-slate-600 font-bold px-5 py-2.5 rounded-xl shadow-sm border border-slate-200 hover:border-slate-300 hover:bg-slate-50 transition-all active:scale-95">
                <i class="fas fa-print text-slate-400 group-hover:text-slate-600 transition-colors"></i>
                <span>Cetak</span>
            </button>
            <a href="{{ route('news.create') }}" class="group inline-flex items-center gap-2 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-bold py-2.5 px-6 rounded-xl shadow-lg shadow-blue-500/30 transition-all hover:-translate-y-1 active:scale-95">
                <i class="fas fa-plus group-hover:rotate-90 transition-transform duration-300"></i>
                <span>Tulis Berita</span>
            </a>
        </div>
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

    {{-- SEARCH & FILTER FORM --}}
    <form method="GET" action="{{ route('news.index') }}" class="animate__animated animate__fadeInUp">
        <div class="glass-panel rounded-2xl p-6 shadow-sm">
            <div class="flex flex-col md:flex-row items-center gap-4">
                {{-- Search Input --}}
                <div class="relative flex-grow w-full md:w-auto group">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <i class="fas fa-search text-slate-400 group-focus-within:text-blue-500 transition-colors"></i>
                    </div>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari judul berita..." class="w-full pl-11 pr-4 py-3.5 bg-slate-50 border-2 border-slate-100 rounded-xl focus:bg-white focus:outline-none focus:border-blue-500 focus:ring-0 transition-all font-medium text-slate-700 placeholder-slate-400">
                </div>

                {{-- Status Filter --}}
                <div class="w-full md:w-auto relative">
                    <select name="status" class="w-full py-3.5 pl-4 pr-10 bg-slate-50 border-2 border-slate-100 rounded-xl focus:bg-white focus:outline-none focus:border-blue-500 focus:ring-0 transition-all font-medium text-slate-700 appearance-none cursor-pointer">
                        <option value="">Semua Status</option>
                        <option value="published" @if(request('status') == 'published') selected @endif>✅ Tayang</option>
                        <option value="draft" @if(request('status') == 'draft') selected @endif>📝 Draft</option>
                    </select>
                    <i class="fas fa-chevron-down absolute right-4 top-4 text-slate-400 pointer-events-none"></i>
                </div>

                {{-- Buttons --}}
                <div class="flex items-center gap-3 w-full md:w-auto">
                    <button type="submit" class="w-full md:w-auto inline-flex items-center justify-center gap-2 px-6 py-3.5 bg-slate-800 text-white font-bold rounded-xl hover:bg-slate-900 transition-all shadow-lg active:scale-95">
                        <i class="fas fa-filter"></i> Filter
                    </button>
                    <a href="{{ route('news.index') }}" class="w-full md:w-auto inline-flex items-center justify-center gap-2 px-6 py-3.5 bg-white text-slate-600 font-bold rounded-xl border-2 border-slate-200 hover:bg-slate-50 transition-all active:scale-95">
                        Reset
                    </a>
                </div>
            </div>
        </div>
    </form>

    {{-- NEWS GRID --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 animate__animated animate__fadeInUp delay-100">
        @forelse ($news as $item)
            <div class="card-3d bg-white rounded-[2rem] shadow-lg border border-slate-100 overflow-hidden flex flex-col h-full group relative">
                
                {{-- Image Thumbnail --}}
                <div class="relative h-56 overflow-hidden bg-slate-100">
                    @if(is_array($item->image) && count($item->image) > 0)
                        <img src="{{ $item->image[0] }}" alt="{{ $item->title }}" class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-700">
                        {{-- Overlay Gradient --}}
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent opacity-60"></div>
                    @else
                        <div class="w-full h-full flex flex-col items-center justify-center text-slate-400 bg-slate-50">
                            <i class="fas fa-image text-5xl mb-2"></i>
                            <span class="text-xs font-bold uppercase tracking-widest">No Image</span>
                        </div>
                    @endif

                    {{-- Badge Status --}}
                    <div class="absolute top-4 right-4">
                        @if($item->status == 'published')
                            <span class="px-3 py-1 bg-emerald-500/90 backdrop-blur-md text-white text-xs font-bold rounded-full shadow-lg flex items-center gap-1">
                                <i class="fas fa-check-circle"></i> Tayang
                            </span>
                        @else
                            <span class="px-3 py-1 bg-slate-500/90 backdrop-blur-md text-white text-xs font-bold rounded-full shadow-lg flex items-center gap-1">
                                <i class="fas fa-edit"></i> Draft
                            </span>
                        @endif
                    </div>
                </div>

                {{-- Content --}}
                <div class="p-6 flex-grow flex flex-col">
                    <div class="text-xs text-slate-400 font-bold mb-2 flex items-center gap-2">
                        <i class="far fa-calendar-alt text-blue-500"></i>
                        {{ $item->created_at->translatedFormat('d F Y') }}
                    </div>
                    
                    <h3 class="font-extrabold text-xl text-slate-800 leading-tight mb-3 line-clamp-2 group-hover:text-blue-600 transition-colors">
                        {{ $item->title }}
                    </h3>
                    
                    <p class="text-slate-500 text-sm line-clamp-3 leading-relaxed mb-4 flex-grow">
                        {{ Str::limit(strip_tags($item->content), 120) }}
                    </p>
                </div>

                {{-- Footer Actions --}}
                <div class="px-6 py-4 bg-slate-50 border-t border-slate-100 flex justify-between items-center">
                    <a href="{{ route('news.show', $item->id) }}" class="text-sm font-bold text-slate-600 hover:text-blue-600 transition-colors flex items-center gap-1">
                        Baca Selengkapnya <i class="fas fa-arrow-right text-xs"></i>
                    </a>

                    <div class="flex items-center gap-2">
                        <a href="{{ route('news.edit', $item->id) }}" class="w-8 h-8 rounded-lg bg-white border border-slate-200 text-slate-500 hover:text-blue-600 hover:border-blue-200 flex items-center justify-center transition-all shadow-sm" title="Edit">
                            <i class="fas fa-pen text-xs"></i>
                        </a>
                        <button onclick="confirmDelete(event, '{{ $item->id }}', '{{ addslashes(Str::limit($item->title, 20)) }}')" class="w-8 h-8 rounded-lg bg-white border border-slate-200 text-slate-500 hover:text-red-600 hover:border-red-200 flex items-center justify-center transition-all shadow-sm" title="Hapus">
                            <i class="fas fa-trash text-xs"></i>
                        </button>
                        <form id="delete-form-{{ $item->id }}" action="{{ route('news.destroy', $item->id) }}" method="POST" class="hidden">
                            @csrf @method('DELETE')
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-1 md:col-span-2 lg:col-span-3 text-center py-20 animate__animated animate__fadeIn">
                <div class="w-24 h-24 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-4 shadow-inner">
                    <i class="fas fa-newspaper text-4xl text-slate-300"></i>
                </div>
                <h3 class="text-2xl font-bold text-slate-700">Belum Ada Berita</h3>
                <p class="text-slate-500 mt-2">Mulai menulis artikel pertama Anda sekarang.</p>
                <a href="{{ route('news.create') }}" class="inline-block mt-6 px-6 py-3 bg-blue-600 text-white font-bold rounded-xl hover:bg-blue-700 transition-all shadow-lg">
                    Buat Berita Baru
                </a>
            </div>
        @endforelse
    </div>

    {{-- PAGINATION --}}
    @if($news->hasPages())
        <div class="mt-10 animate__animated animate__fadeInUp">
            {{ $news->links() }}
        </div>
    @endif

</div>

{{-- Script SweetAlert --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    const swal3DConfig = {
        showClass: { popup: 'animate__animated animate__zoomInDown animate__faster' },
        hideClass: { popup: 'animate__animated animate__zoomOutUp animate__faster' },
        customClass: {
            popup: 'rounded-3xl shadow-2xl border-4 border-white/50 backdrop-blur-xl',
            title: 'text-2xl font-black text-slate-800',
            confirmButton: 'rounded-xl px-6 py-3 font-bold shadow-lg bg-red-600 text-white mr-2',
            cancelButton: 'rounded-xl px-6 py-3 font-bold shadow-lg bg-slate-200 text-slate-600'
        },
        buttonsStyling: false
    };

    function confirmDelete(event, id, title) {
        event.preventDefault();
        
        Swal.fire({
            ...swal3DConfig,
            title: 'Hapus Berita?',
            html: `Anda akan menghapus artikel <b>"${title}"</b>.<br>Tindakan ini permanen.`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById(`delete-form-${id}`).submit();
            }
        });
    }
</script>
@endsection