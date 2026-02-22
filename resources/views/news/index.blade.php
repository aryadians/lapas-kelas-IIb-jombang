@extends('layouts.main')

@section('title', 'Berita & Informasi')

@section('content')

<style>
    .news-card:hover .news-img { transform: scale(1.07); }
    .news-card { transition: all 0.3s cubic-bezier(0.4,0,0.2,1); }
    .news-card:hover { transform: translateY(-6px); box-shadow: 0 24px 40px rgba(0,0,0,0.12); }
</style>

{{-- HERO --}}
<section class="relative bg-gradient-to-br from-slate-900 via-blue-950 to-indigo-950 pt-32 pb-20 overflow-hidden">
    <div class="absolute inset-0 pointer-events-none">
        <div class="absolute -top-24 -right-24 w-96 h-96 bg-blue-400 rounded-full blur-[100px] opacity-10"></div>
        <div class="absolute -bottom-16 -left-16 w-72 h-72 bg-indigo-400 rounded-full blur-[80px] opacity-10"></div>
    </div>
    <div class="container mx-auto px-6 max-w-5xl text-center relative z-10">
        <div class="inline-flex items-center px-4 py-1.5 rounded-full bg-white/10 border border-white/20 text-blue-200 text-xs font-bold uppercase tracking-widest mb-6">
            <i class="fas fa-newspaper mr-2"></i> Berita & Informasi
        </div>
        <h1 class="text-4xl sm:text-5xl md:text-6xl font-black text-white tracking-tighter mb-5 leading-tight">
            Berita <span class="bg-gradient-to-r from-yellow-400 to-amber-500 bg-clip-text text-transparent">Terbaru</span>
        </h1>
        <p class="text-lg text-blue-200/70 max-w-2xl mx-auto leading-relaxed mb-8">
            Informasi terkini, kegiatan, dan berita penting dari Lembaga Pemasyarakatan Kelas IIB Jombang.
        </p>

        {{-- Search & Filter --}}
        <form method="GET" action="{{ route('news.public.index') }}" class="flex flex-col sm:flex-row gap-3 justify-center items-center max-w-2xl mx-auto">
            <div class="relative w-full sm:w-auto flex-1">
                <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-blue-300 text-sm"></i>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari berita..."
                    class="w-full pl-11 pr-4 py-3 bg-white/10 border border-white/20 rounded-full text-white placeholder-blue-300 text-sm focus:outline-none focus:ring-2 focus:ring-yellow-400 focus:border-transparent backdrop-blur-sm">
            </div>
            <div class="relative w-full sm:w-44">
                <select name="category" class="w-full px-5 py-3 pr-8 bg-white/15 border border-white/25 rounded-full text-white text-sm focus:outline-none focus:ring-2 focus:ring-yellow-400 appearance-none cursor-pointer backdrop-blur-sm">
                    <option value="" class="text-slate-900">Semua Kategori</option>
                    <option value="kegiatan"    class="text-slate-900" {{ request('category') == 'kegiatan' ? 'selected' : '' }}>Kegiatan</option>
                    <option value="pengumuman"  class="text-slate-900" {{ request('category') == 'pengumuman' ? 'selected' : '' }}>Pengumuman</option>
                    <option value="berita"      class="text-slate-900" {{ request('category') == 'berita' ? 'selected' : '' }}>Berita</option>
                </select>
                <i class="fas fa-chevron-down absolute right-4 top-1/2 -translate-y-1/2 text-white/60 text-xs pointer-events-none"></i>
            </div>
            <button type="submit" class="px-6 py-3 bg-yellow-500 hover:bg-yellow-400 text-slate-900 font-black rounded-full transition-all shadow-lg hover:shadow-yellow-500/30 hover:-translate-y-0.5 text-sm flex-shrink-0">
                <i class="fas fa-search mr-2"></i> Cari
            </button>
        </form>
    </div>
</section>

{{-- BERITA --}}
<section class="py-16 bg-gradient-to-b from-slate-50 to-white">
    <div class="container mx-auto px-6 max-w-7xl">
        {{-- Sub header --}}
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3 mb-10">
            <div>
                <h2 class="text-2xl font-black text-slate-800">Semua Berita</h2>
                <div class="h-1 w-16 bg-gradient-to-r from-blue-500 to-yellow-500 rounded-full mt-1.5"></div>
            </div>
            <p class="text-sm text-slate-500">
                Menampilkan <span class="font-bold text-blue-600">{{ $allNews->count() }}</span>
                dari <span class="font-bold text-blue-600">{{ $allNews->total() }}</span> berita
                · Diperbarui {{ now()->translatedFormat('d F Y') }}
            </p>
        </div>

        {{-- Grid --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-12">
            @forelse($allNews as $item)
            <article class="news-card bg-white rounded-2xl overflow-hidden border border-slate-100 shadow-sm flex flex-col h-full">
                {{-- Image --}}
                <div class="relative h-52 overflow-hidden flex-shrink-0 bg-slate-100">
                    @if(is_array($item->image) && count($item->image) > 0)
                    <img src="{{ $item->image[0] }}" alt="{{ $item->title }}"
                        class="news-img w-full h-full object-cover transition-transform duration-500 ease-out" loading="lazy">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/30 to-transparent"></div>
                    @else
                    <div class="w-full h-full bg-gradient-to-br from-blue-50 to-indigo-100 flex items-center justify-center">
                        <i class="fas fa-newspaper text-4xl text-blue-200"></i>
                    </div>
                    @endif
                    {{-- Date badge --}}
                    <div class="absolute bottom-3 left-3 bg-white/95 text-slate-700 text-[10px] font-black px-2.5 py-1 rounded-lg shadow-sm">
                        <i class="fas fa-calendar mr-1 text-blue-500"></i>{{ $item->created_at->translatedFormat('d M Y') }}
                    </div>
                    {{-- Category badge --}}
                    <div class="absolute top-3 right-3">
                        <span class="bg-blue-600/95 text-white text-[10px] font-black px-2.5 py-1 rounded-lg shadow-sm uppercase tracking-widest">Berita</span>
                    </div>
                </div>

                {{-- Content --}}
                <div class="p-5 flex flex-col flex-grow">
                    <h3 class="font-black text-slate-800 text-base leading-snug mb-2 line-clamp-2 group-hover:text-blue-700 transition-colors">
                        {{ $item->title }}
                    </h3>
                    <p class="text-slate-500 text-sm leading-relaxed mb-4 line-clamp-3 flex-grow">
                        {{ Str::limit(strip_tags($item->content), 120) }}
                    </p>
                    <div class="flex items-center justify-between pt-3 border-t border-slate-100">
                        <a href="{{ route('news.public.show', $item->slug) }}"
                            class="inline-flex items-center gap-1.5 text-xs font-black text-blue-600 hover:text-blue-800 transition-all uppercase tracking-wider">
                            Baca Selengkapnya <i class="fas fa-arrow-right"></i>
                        </a>
                        <span class="text-[10px] text-slate-400 font-medium">
                            <i class="fas fa-clock mr-1"></i>{{ $item->created_at->diffForHumans() }}
                        </span>
                    </div>
                </div>
            </article>
            @empty
            <div class="col-span-full text-center py-20 bg-slate-50 rounded-3xl border-2 border-dashed border-slate-200">
                <div class="w-16 h-16 bg-white rounded-full flex items-center justify-center mx-auto mb-4 shadow-sm border border-slate-100">
                    <i class="fas fa-newspaper text-3xl text-slate-300"></i>
                </div>
                <h3 class="text-lg font-black text-slate-700 mb-1">Belum Ada Berita</h3>
                <p class="text-slate-400 text-sm mb-6">Informasi terbaru akan segera dipublikasikan.</p>
                <a href="/" class="inline-flex items-center gap-2 px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-xl transition-all text-sm">
                    <i class="fas fa-home"></i> Beranda
                </a>
            </div>
            @endforelse
        </div>

        {{-- Pagination --}}
        @if($allNews->hasPages())
        <div class="flex justify-center">
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-3">
                {{ $allNews->appends(request()->query())->links() }}
            </div>
        </div>
        @endif

        {{-- Back --}}
        <div class="text-center mt-12 pt-8 border-t border-slate-100">
            <a href="/" class="inline-flex items-center gap-2 px-6 py-3 bg-slate-900 hover:bg-blue-600 text-white font-bold rounded-xl transition-all shadow-md hover:-translate-y-0.5 text-sm">
                <i class="fas fa-home"></i> Kembali ke Beranda
            </a>
        </div>
    </div>
</section>

@endsection
