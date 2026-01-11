@extends('layouts.admin')

@section('content')
<style>
    .visitor-card {
        transition: all 0.3s ease;
        transform-style: preserve-3d;
        perspective: 1000px;
    }
    .visitor-card:hover {
        transform: translateY(-8px) scale(1.03);
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.2);
    }
    .animated-fade-in {
        animation: fadeIn 0.8s ease-out forwards;
        opacity: 0;
    }
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>

<div class="space-y-6">
    
    {{-- Header --}}
    <div class="flex flex-col md:flex-row justify-between items-center gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">👥 Database Pengunjung</h1>
            <p class="text-slate-500 text-sm mt-1">Daftar unik pengunjung yang pernah mendaftar.</p>
        </div>
        <form method="GET" class="relative w-full md:w-80">
            <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                <i class="fa-solid fa-magnifying-glass"></i>
            </span>
            <input type="text" name="search" value="{{ request('search') }}" class="w-full pl-10 pr-4 py-2.5 bg-white border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition shadow-sm" placeholder="Cari Nama / NIK Pengunjung...">
        </form>
    </div>

    {{-- Visitors Grid --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
        @forelse($visitors as $index => $visitor)
        <div class="visitor-card bg-white rounded-xl shadow-md border border-slate-200 overflow-hidden animated-fade-in" style="animation-delay: {{ $index * 50 }}ms;">
            <div class="p-5">
                <div class="flex items-start gap-4">
                    <div class="flex-shrink-0 w-12 h-12 rounded-full bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center text-white text-lg font-bold">
                        {{ strtoupper(substr($visitor->nama_pengunjung, 0, 1)) }}
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="font-bold text-slate-800 text-base truncate">{{ $visitor->nama_pengunjung }}</p>
                        <p class="text-sm text-slate-500">{{ $visitor->nik_ktp }}</p>
                    </div>
                </div>
                <div class="mt-4 space-y-2 text-xs text-slate-600">
                    <div class="flex items-center gap-2">
                        <i class="fa-solid fa-envelope text-slate-400 w-4 text-center"></i>
                        <span>{{ $visitor->email_pengunjung }}</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <i class="fa-solid fa-phone text-slate-400 w-4 text-center"></i>
                        <span>{{ $visitor->no_wa_pengunjung }}</span>
                    </div>
                </div>
            </div>
            <div class="bg-slate-50/70 p-3 border-t border-slate-200 flex justify-between items-center text-xs">
                <div class="font-semibold text-slate-500">
                    Total Kunjungan: <span class="text-blue-600 font-bold text-sm">{{ $visitor->total_kunjungan }}</span>
                </div>
                <div class="text-right">
                    <p class="text-slate-400">Terakhir:</p>
                    <p class="font-bold text-slate-600">{{ \Carbon\Carbon::parse($visitor->terakhir_berkunjung)->translatedFormat('d M Y') }}</p>
                </div>
            </div>
        </div>
        @empty
        <div class="col-span-full text-center py-12 text-slate-400">
            <i class="fa-solid fa-user-slash text-4xl mb-3"></i>
            <p>Data pengunjung tidak ditemukan.</p>
        </div>
        @endforelse
    </div>

    {{-- Pagination --}}
    @if($visitors->hasPages())
    <div class="p-4 bg-white rounded-xl shadow-md border border-slate-200">
        {{ $visitors->links() }}
    </div>
    @endif

</div>
@endsection
