@extends('layouts.main')

@section('content')
<div class="min-h-screen bg-slate-50 pt-24 pb-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">
        
        {{-- HEADER --}}
        <div class="text-center mb-16 animate__animated animate__fadeIn">
            <h1 class="text-4xl md:text-5xl font-black text-slate-900 mb-4 tracking-tighter">Transparansi & Informasi Publik</h1>
            <p class="text-slate-500 font-medium max-w-2xl mx-auto text-lg">Akses dokumen laporan kinerja dan keterbukaan informasi publik Lapas Kelas IIB Jombang.</p>
            <div class="w-24 h-1 bg-blue-600 mx-auto mt-6 rounded-full"></div>
        </div>

        @if($reports->isEmpty())
            <div class="text-center py-20 bg-white rounded-[2rem] shadow-sm border border-slate-100">
                <i class="fa-solid fa-folder-open text-6xl text-slate-200 mb-4"></i>
                <h3 class="text-xl font-bold text-slate-800">Belum ada dokumen tersedia</h3>
                <p class="text-slate-500 mt-2">Silakan kembali lagi nanti untuk informasi terbaru.</p>
            </div>
        @else
            <div class="space-y-16">
                @foreach($reports as $cat => $docs)
                    <div class="animate__animated animate__fadeInUp">
                        <div class="flex items-center gap-4 mb-8 border-b border-slate-200 pb-4">
                            <div class="w-12 h-12 bg-blue-600 rounded-2xl flex items-center justify-center text-white shadow-lg">
                                @if($cat == 'LHKPN') <i class="fa-solid fa-vault text-xl"></i>
                                @elseif($cat == 'LAKIP') <i class="fa-solid fa-chart-line text-xl"></i>
                                @elseif($cat == 'Keuangan') <i class="fa-solid fa-money-bill-transfer text-xl"></i>
                                @else <i class="fa-solid fa-file-invoice text-xl"></i>
                                @endif
                            </div>
                            <h2 class="text-2xl font-black text-slate-800 uppercase tracking-tight">{{ $cat }}</h2>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                            @foreach($docs as $doc)
                                <div class="bg-white rounded-3xl p-6 shadow-xl shadow-slate-200/50 border border-slate-100 hover:shadow-2xl hover:-translate-y-2 transition-all duration-300 group">
                                    <div class="flex justify-between items-start mb-4">
                                        <span class="px-3 py-1 bg-slate-100 text-slate-600 rounded-lg text-[10px] font-black uppercase tracking-widest">{{ $doc->year }}</span>
                                        <i class="fa-solid fa-file-pdf text-rose-500 text-2xl opacity-50 group-hover:opacity-100 transition-opacity"></i>
                                    </div>
                                    
                                    <h3 class="text-xl font-bold text-slate-800 mb-2 group-hover:text-blue-600 transition-colors">{{ $doc->title }}</h3>
                                    <p class="text-slate-500 text-sm mb-6 line-clamp-2">{{ $doc->description ?? 'Tidak ada keterangan tambahan.' }}</p>
                                    
                                    <div class="pt-4 border-t border-slate-50 flex justify-between items-center">
                                        <div class="text-[10px] font-bold text-slate-400 uppercase">
                                            Diunggah: {{ $doc->created_at->format('d M Y') }}
                                        </div>
                                        <a href="{{ Storage::url($doc->file_path) }}" target="_blank" class="inline-flex items-center gap-2 text-blue-600 font-black text-sm hover:text-blue-800 transition-colors uppercase tracking-wider">
                                            <span>Lihat Dokumen</span>
                                            <i class="fa-solid fa-arrow-right"></i>
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

    </div>
</div>
@endsection
