@extends('layouts.admin')

@section('content')
<div class="space-y-6">
    
    {{-- Header --}}
    <div class="flex flex-col md:flex-row justify-between items-center gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">🗂️ Database Warga Binaan</h1>
            <p class="text-slate-500 text-sm mt-1">Kelola data WBP, lokasi sel, dan masa tahanan.</p>
        </div>
        <div class="bg-white border border-slate-200 px-4 py-2 rounded-lg shadow-sm flex items-center gap-3">
            <div class="p-2 bg-blue-50 text-blue-600 rounded-md">
                <i class="fa-solid fa-users text-lg"></i>
            </div>
            <div>
                <p class="text-xs font-bold text-slate-400 uppercase">Total WBP</p>
                <p class="text-xl font-black text-slate-800">{{ $wbps->total() }}</p>
            </div>
        </div>
    </div>

    {{-- Content Card --}}
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
        
        {{-- TOOLBAR: UPLOAD & SEARCH --}}
        <div class="p-5 border-b border-slate-100 bg-slate-50/50 flex flex-col md:flex-row justify-between items-center gap-4">
            
            {{-- Bagian Kiri: Form Upload --}}
            <form action="{{ route('wbp.import') }}" method="POST" enctype="multipart/form-data" class="flex w-full md:w-auto items-center gap-2">
                @csrf
                <div class="relative flex-1 md:w-80">
                    <input type="file" name="file" class="block w-full text-xs text-slate-500 file:mr-3 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-xs file:font-semibold file:bg-indigo-600 file:text-white hover:file:bg-indigo-700 cursor-pointer bg-white border border-slate-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" required>
                </div>
                <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white p-2 rounded-md transition shadow-sm flex-shrink-0" title="Upload CSV">
                    <i class="fa-solid fa-cloud-arrow-up"></i>
                </button>
            </form>

            {{-- Bagian Kanan: Search Bar --}}
            <form method="GET" class="relative w-full md:w-72">
                <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </span>
                <input type="text" name="search" value="{{ request('search') }}" 
                       class="w-full pl-10 pr-4 py-2.5 bg-white border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition shadow-sm" 
                       placeholder="Cari Nama / No. Reg...">
            </form>
        </div>

        {{-- Table --}}
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead class="bg-slate-50 text-slate-600 uppercase text-xs font-bold tracking-wider">
                    <tr>
                        <th class="p-4 border-b">Identitas WBP</th>
                        <th class="p-4 border-b text-center">Lokasi</th>
                        <th class="p-4 border-b">Masa Tahanan</th>
                        <th class="p-4 border-b text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($wbps as $wbp)
                    <tr class="hover:bg-slate-50 transition duration-150">
                        {{-- Identitas --}}
                        <td class="p-4 align-top">
                            <div class="flex items-start gap-3">
                                <div class="mt-1 bg-slate-200 h-8 w-8 rounded-full flex items-center justify-center text-slate-500 text-xs">
                                    <i class="fa-solid fa-user"></i>
                                </div>
                                <div>
                                    <div class="font-bold text-slate-800 text-sm">{{ $wbp->nama }}</div>
                                    <div class="flex items-center gap-2 mt-1">
                                        <span class="text-[10px] font-mono bg-slate-100 text-slate-600 px-1.5 py-0.5 rounded border border-slate-200">
                                            {{ $wbp->no_registrasi }}
                                        </span>
                                        @if($wbp->nama_panggilan && $wbp->nama_panggilan != '-')
                                            <span class="text-[10px] text-amber-600 bg-amber-50 px-1.5 py-0.5 rounded border border-amber-100">
                                                Alias: {{ $wbp->nama_panggilan }}
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </td>

                        {{-- Lokasi --}}
                        <td class="p-4 align-middle text-center">
                            <div class="inline-flex divide-x divide-slate-200 border border-slate-200 rounded-lg bg-white shadow-sm">
                                <div class="px-3 py-1">
                                    <span class="block text-[10px] text-slate-400 font-bold uppercase">Blok</span>
                                    <span class="font-bold text-indigo-600">{{ $wbp->blok ?? '-' }}</span>
                                </div>
                                <div class="px-3 py-1">
                                    <span class="block text-[10px] text-slate-400 font-bold uppercase">Kamar</span>
                                    <span class="font-bold text-emerald-600">{{ $wbp->kamar ?? '-' }}</span>
                                </div>
                            </div>
                        </td>

                        {{-- Tanggal --}}
                        <td class="p-4 align-middle">
                            <div class="space-y-1 text-xs">
                                <div class="flex justify-between w-32">
                                    <span class="text-slate-500">Masuk:</span>
                                    <span class="font-medium text-slate-700">
                                        {{ $wbp->tanggal_masuk ? \Carbon\Carbon::parse($wbp->tanggal_masuk)->format('d/m/Y') : '-' }}
                                    </span>
                                </div>
                                <div class="flex justify-between w-32">
                                    <span class="text-slate-500">Ekspirasi:</span>
                                    <span class="font-bold text-red-600">
                                        {{ $wbp->tanggal_ekspirasi ? \Carbon\Carbon::parse($wbp->tanggal_ekspirasi)->format('d/m/Y') : '-' }}
                                    </span>
                                </div>
                            </div>
                        </td>

                        {{-- Aksi --}}
                        <td class="p-4 align-middle text-center">
                            <a href="{{ route('wbp.history', $wbp->id) }}" class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-white border border-slate-200 text-slate-400 hover:text-indigo-600 hover:border-indigo-300 hover:bg-indigo-50 transition" title="Riwayat">
                                <i class="fa-solid fa-clock-rotate-left"></i>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="p-12 text-center text-slate-400 bg-slate-50/30">
                            <div class="flex flex-col items-center">
                                <i class="fa-regular fa-folder-open text-3xl mb-2 opacity-50"></i>
                                <p class="text-sm">Data WBP belum tersedia.</p>
                                <p class="text-xs mt-1">Silahkan upload file CSV.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div class="p-4 border-t border-slate-200 bg-slate-50">
            {{ $wbps->links() }}
        </div>
    </div>
</div>
@endsection