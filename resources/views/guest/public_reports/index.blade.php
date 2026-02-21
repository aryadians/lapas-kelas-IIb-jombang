@extends('layouts.main')

@section('title', 'Transparansi & Laporan Publik')

@section('content')

<style>
    :root {
        --navy:    #0a0f1e;
        --navy-2:  #0f172a;
        --navy-3:  #1e2a45;
        --gold:    #c9a227;
        --gold-lt: #e8c547;
        --plat:    #d0d6e0;
        --plat-dk: #8a9ab2;
    }

    .report-hero {
        background: linear-gradient(135deg, var(--navy) 0%, #0f1b35 50%, #101535 100%);
        position: relative;
        overflow: hidden;
    }
    .report-hero::before {
        content: '';
        position: absolute;
        top: -120px; right: -120px;
        width: 450px; height: 450px;
        background: radial-gradient(circle, rgba(201,162,39,0.15) 0%, transparent 70%);
        border-radius: 50%;
    }
    .report-hero::after {
        content: '';
        position: absolute;
        bottom: -80px; left: -80px;
        width: 300px; height: 300px;
        background: radial-gradient(circle, rgba(201,162,39,0.08) 0%, transparent 70%);
        border-radius: 50%;
    }

    .gold-line {
        height: 3px;
        background: linear-gradient(90deg, transparent, var(--gold), var(--gold-lt), var(--gold), transparent);
    }

    .doc-card {
        background: linear-gradient(145deg, rgba(30,42,69,0.9), rgba(15,23,42,0.95));
        border: 1px solid rgba(201,162,39,0.15);
        backdrop-filter: blur(8px);
        transition: all 0.35s cubic-bezier(0.4, 0, 0.2, 1);
    }
    .doc-card:hover {
        border-color: rgba(201,162,39,0.5);
        transform: translateY(-6px);
        box-shadow: 0 24px 48px rgba(0,0,0,0.4), 0 0 32px rgba(201,162,39,0.08);
    }

    .cat-icon {
        background: linear-gradient(135deg, #c9a227, #e8c547);
        box-shadow: 0 4px 20px rgba(201,162,39,0.35);
    }

    .doc-btn {
        background: linear-gradient(135deg, var(--gold), var(--gold-lt));
        color: #0a0f1e;
        transition: all 0.2s;
    }
    .doc-btn:hover {
        background: linear-gradient(135deg, var(--gold-lt), var(--gold));
        box-shadow: 0 6px 20px rgba(201,162,39,0.4);
        transform: translateY(-1px);
    }

    .year-badge {
        background: rgba(201,162,39,0.15);
        border: 1px solid rgba(201,162,39,0.3);
        color: var(--gold-lt);
    }

    .cat-divider {
        height: 1px;
        background: linear-gradient(90deg, rgba(201,162,39,0.4), rgba(201,162,39,0.05), transparent);
    }

    .plat-text { color: var(--plat); }
    .plat-dk-text { color: var(--plat-dk); }
</style>

{{-- HERO --}}
<div class="report-hero pt-32 pb-20 px-4 sm:px-6">
    <div class="max-w-5xl mx-auto text-center relative z-10">
        {{-- Badge --}}
        <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full border border-yellow-600/30 bg-yellow-500/10 text-yellow-400 text-xs font-black uppercase tracking-widest mb-6">
            <i class="fas fa-landmark text-[10px]"></i>
            Lapas Kelas IIB Jombang
        </div>
        <h1 class="text-4xl md:text-6xl font-black text-white tracking-tighter leading-tight mb-4">
            Transparansi &amp;<br>
            <span style="background: linear-gradient(90deg, #c9a227, #e8c547, #c9a227); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;">
                Informasi Publik
            </span>
        </h1>
        <p class="text-slate-400 text-base md:text-lg font-medium max-w-2xl mx-auto leading-relaxed mb-8">
            Akses dokumen laporan kinerja dan keterbukaan informasi publik resmi Lapas Kelas IIB Jombang.
        </p>
        {{-- Decorative line --}}
        <div class="gold-line w-48 mx-auto rounded-full"></div>
    </div>
</div>

{{-- STAT STRIP --}}
<div style="background: #0a0f1e; border-top: 1px solid rgba(201,162,39,0.15); border-bottom: 1px solid rgba(201,162,39,0.15);">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 py-5 flex flex-wrap justify-center gap-8">
        @php $totalDocs = $reports->flatten()->count(); $totalCats = $reports->count(); @endphp
        <div class="text-center">
            <p class="text-2xl font-black" style="color: #e8c547;">{{ $totalCats }}</p>
            <p class="text-[10px] uppercase tracking-widest font-bold" style="color: #8a9ab2;">Kategori</p>
        </div>
        <div class="w-px" style="background: rgba(201,162,39,0.2);"></div>
        <div class="text-center">
            <p class="text-2xl font-black" style="color: #e8c547;">{{ $totalDocs }}</p>
            <p class="text-[10px] uppercase tracking-widest font-bold" style="color: #8a9ab2;">Dokumen</p>
        </div>
        <div class="w-px" style="background: rgba(201,162,39,0.2);"></div>
        <div class="text-center">
            <p class="text-2xl font-black text-white">{{ now()->year }}</p>
            <p class="text-[10px] uppercase tracking-widest font-bold" style="color: #8a9ab2;">Tahun Aktif</p>
        </div>
    </div>
</div>

{{-- CONTENT --}}
<div style="background: linear-gradient(180deg, #0a0f1e 0%, #080c18 100%); min-height: 60vh;">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">

        @if($reports->isEmpty())
        <div class="text-center py-24">
            <div class="w-20 h-20 rounded-3xl cat-icon flex items-center justify-center text-navy text-3xl mx-auto mb-5">
                <i class="fas fa-folder-open" style="color: #0a0f1e;"></i>
            </div>
            <h3 class="text-xl font-black text-white mb-2">Belum ada dokumen tersedia</h3>
            <p style="color: #8a9ab2;" class="text-sm">Silakan kembali lagi nanti untuk informasi terbaru.</p>
        </div>

        @else
        <div class="space-y-16">
            @foreach($reports as $cat => $docs)
            <div>
                {{-- Category Header --}}
                <div class="flex items-center gap-4 mb-8">
                    <div class="cat-icon w-12 h-12 rounded-2xl flex items-center justify-center flex-shrink-0">
                        @if($cat == 'LHKPN')     <i class="fa-solid fa-vault text-xl" style="color: #0a0f1e;"></i>
                        @elseif($cat == 'LAKIP') <i class="fa-solid fa-chart-line text-xl" style="color: #0a0f1e;"></i>
                        @elseif($cat == 'Keuangan') <i class="fa-solid fa-money-bill-transfer text-xl" style="color: #0a0f1e;"></i>
                        @else <i class="fa-solid fa-file-invoice text-xl" style="color: #0a0f1e;"></i>
                        @endif
                    </div>
                    <div class="flex-1">
                        <h2 class="text-xl md:text-2xl font-black text-white uppercase tracking-tight">{{ $cat }}</h2>
                        <div class="cat-divider mt-2"></div>
                    </div>
                    <span class="year-badge text-[10px] font-black uppercase tracking-widest px-3 py-1 rounded-full flex-shrink-0">
                        {{ $docs->count() }} Dokumen
                    </span>
                </div>

                {{-- Document Cards --}}
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($docs as $doc)
                    <div class="doc-card rounded-3xl p-6 group">
                        {{-- Top row --}}
                        <div class="flex justify-between items-start mb-5">
                            <span class="year-badge text-[10px] font-black uppercase tracking-widest px-3 py-1 rounded-lg">
                                {{ $doc->year }}
                            </span>
                            <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background: rgba(201,162,39,0.1); border: 1px solid rgba(201,162,39,0.2);">
                                <i class="fa-solid fa-file-pdf text-lg" style="color: #c9a227;"></i>
                            </div>
                        </div>

                        {{-- Title --}}
                        <h3 class="text-base font-black text-white mb-2 leading-snug group-hover:text-yellow-300 transition-colors">
                            {{ $doc->title }}
                        </h3>
                        <p class="text-sm leading-relaxed mb-6 line-clamp-2" style="color: #8a9ab2;">
                            {{ $doc->description ?? 'Tidak ada keterangan tambahan.' }}
                        </p>

                        {{-- Footer --}}
                        <div class="pt-4 border-t flex justify-between items-center" style="border-color: rgba(201,162,39,0.1);">
                            <div class="text-[10px] font-bold uppercase tracking-widest" style="color: #4a5a7a;">
                                <i class="fas fa-calendar-alt mr-1"></i>
                                {{ $doc->created_at->format('d M Y') }}
                            </div>
                            <a href="{{ Storage::url($doc->file_path) }}" target="_blank"
                                class="doc-btn inline-flex items-center gap-1.5 text-xs font-black uppercase tracking-wider px-4 py-2 rounded-xl">
                                <i class="fas fa-download text-[10px]"></i>
                                Unduh
                            </a>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endforeach
        </div>
        @endif

        {{-- Footer Note --}}
        <div class="text-center mt-20 pt-10" style="border-top: 1px solid rgba(201,162,39,0.1);">
            <div class="cat-icon w-10 h-10 rounded-2xl flex items-center justify-center mx-auto mb-3">
                <i class="fas fa-shield-halved text-sm" style="color: #0a0f1e;"></i>
            </div>
            <p class="text-xs font-bold uppercase tracking-widest mb-1" style="color: #c9a227;">Dokumen Resmi</p>
            <p class="text-xs" style="color: #4a5a7a;">Seluruh dokumen merupakan publikasi resmi Lapas Kelas IIB Jombang.<br>Untuk pertanyaan hubungi melalui kanal resmi.</p>
        </div>
    </div>
</div>

@endsection
