@extends('layouts.admin')

@section('content')
<div class="space-y-6">

    {{-- HEADER & TOMBOL KEMBALI --}}
    <div class="flex flex-col md:flex-row justify-between items-center gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">📜 Riwayat Warga Binaan</h1>
            <p class="text-slate-500 text-sm mt-1">Detail profil dan log kunjungan WBP.</p>
        </div>
        <a href="{{ route('wbp.index') }}" class="inline-flex items-center px-4 py-2 bg-white border border-slate-300 rounded-lg text-slate-700 text-sm font-medium hover:bg-slate-50 transition shadow-sm">
            <i class="fa-solid fa-arrow-left mr-2"></i> Kembali
        </a>
    </div>

    {{-- KARTU PROFIL WBP (DESAIN BARU) --}}
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
        <div class="p-6 md:p-8">
            <div class="flex flex-col md:flex-row gap-8 items-start">
                
                {{-- AVATAR / IKON --}}
                <div class="flex-shrink-0">
                    <div class="w-24 h-24 bg-slate-100 rounded-full flex items-center justify-center text-slate-400 border-4 border-slate-50">
                        <i class="fa-solid fa-user text-4xl"></i>
                    </div>
                </div>

                {{-- DETAIL INFORMASI --}}
                <div class="flex-1 w-full">
                    <div class="flex flex-col md:flex-row justify-between items-start gap-4">
                        <div>
                            <h2 class="text-2xl font-extrabold text-slate-800">{{ $wbp->nama }}</h2>
                            <div class="flex flex-wrap gap-2 mt-2">
                                {{-- Badge No Reg --}}
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-md text-sm font-mono font-medium bg-blue-50 text-blue-700 border border-blue-100">
                                    <i class="fa-solid fa-id-card mr-1.5"></i> {{ $wbp->no_registrasi }}
                                </span>
                                {{-- Badge Alias --}}
                                @if($wbp->nama_panggilan && $wbp->nama_panggilan != '-')
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-md text-sm font-medium bg-amber-50 text-amber-700 border border-amber-100">
                                    <i class="fa-solid fa-tag mr-1.5"></i> {{ $wbp->nama_panggilan }}
                                </span>
                                @endif
                            </div>
                        </div>
                    </div>

                    {{-- GRID INFORMASI DETIL --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mt-8 pt-6 border-t border-slate-100">
                        
                        {{-- Blok --}}
                        <div class="bg-slate-50 p-3 rounded-lg border border-slate-100">
                            <span class="text-xs font-bold text-slate-400 uppercase tracking-wider block mb-1">Blok Hunian</span>
                            <div class="flex items-center gap-2">
                                <span class="w-8 h-8 rounded bg-indigo-100 text-indigo-600 flex items-center justify-center">
                                    <i class="fa-solid fa-building"></i>
                                </span>
                                <span class="text-lg font-bold text-slate-700">{{ $wbp->blok ?? '-' }}</span>
                            </div>
                        </div>

                        {{-- Kamar --}}
                        <div class="bg-slate-50 p-3 rounded-lg border border-slate-100">
                            <span class="text-xs font-bold text-slate-400 uppercase tracking-wider block mb-1">Kamar / Sel</span>
                            <div class="flex items-center gap-2">
                                <span class="w-8 h-8 rounded bg-emerald-100 text-emerald-600 flex items-center justify-center">
                                    <i class="fa-solid fa-dungeon"></i>
                                </span>
                                <span class="text-lg font-bold text-slate-700">{{ $wbp->kamar ?? '-' }}</span>
                            </div>
                        </div>

                        {{-- Tanggal Masuk --}}
                        <div class="bg-slate-50 p-3 rounded-lg border border-slate-100">
                            <span class="text-xs font-bold text-slate-400 uppercase tracking-wider block mb-1">Tanggal Masuk</span>
                            <div class="flex items-center gap-2">
                                <span class="w-8 h-8 rounded bg-slate-200 text-slate-600 flex items-center justify-center">
                                    <i class="fa-regular fa-calendar"></i>
                                </span>
                                <span class="text-sm font-bold text-slate-700">
                                    {{ $wbp->tanggal_masuk ? \Carbon\Carbon::parse($wbp->tanggal_masuk)->format('d M Y') : '-' }}
                                </span>
                            </div>
                        </div>

                        {{-- Ekspirasi --}}
                        <div class="bg-red-50 p-3 rounded-lg border border-red-100">
                            <span class="text-xs font-bold text-red-400 uppercase tracking-wider block mb-1">Ekspirasi</span>
                            <div class="flex items-center gap-2">
                                <span class="w-8 h-8 rounded bg-red-200 text-red-600 flex items-center justify-center">
                                    <i class="fa-solid fa-hourglass-end"></i>
                                </span>
                                <span class="text-sm font-bold text-red-700">
                                    {{ $wbp->tanggal_ekspirasi ? \Carbon\Carbon::parse($wbp->tanggal_ekspirasi)->format('d M Y') : '-' }}
                                </span>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- TABEL RIWAYAT KUNJUNGAN --}}
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-100 bg-slate-50 flex justify-between items-center">
            <h3 class="font-bold text-slate-700">Log Kunjungan Masuk</h3>
            <span class="bg-slate-200 text-slate-600 text-xs font-bold px-2 py-1 rounded-full">
                Total: {{ $wbp->kunjungans->count() }}
            </span>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead class="bg-white text-slate-500 uppercase text-xs font-bold tracking-wider border-b border-slate-100">
                    <tr>
                        <th class="p-4 w-32">Tanggal</th>
                        <th class="p-4">Pengunjung</th>
                        <th class="p-4">Hubungan</th>
                        <th class="p-4">Pengikut</th>
                        <th class="p-4 text-center">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($wbp->kunjungans as $kunjungan)
                    <tr class="hover:bg-slate-50 transition">
                        <td class="p-4 text-sm text-slate-600 font-mono">
                            {{ $kunjungan->created_at->format('d/m/Y') }}
                            <span class="block text-xs text-slate-400">{{ $kunjungan->created_at->format('H:i') }} WIB</span>
                        </td>
                        <td class="p-4 font-medium text-slate-800">
                            {{ $kunjungan->nama_pengunjung }}
                            <span class="block text-xs text-slate-400 font-normal">{{ $kunjungan->nik_ktp }}</span>
                        </td>
                        <td class="p-4 text-sm text-slate-600">
                            {{ $kunjungan->hubungan }}
                        </td>
                        <td class="p-4 text-sm text-slate-600">
                            {{ $kunjungan->pengikuts->count() }} Orang
                        </td>
                        <td class="p-4 text-center">
                            @if($kunjungan->status == 'approved' || $kunjungan->status == 'selesai')
                                <span class="inline-flex items-center px-2 py-1 rounded text-xs font-bold bg-green-100 text-green-700">
                                    Disetujui
                                </span>
                            @elseif($kunjungan->status == 'rejected')
                                <span class="inline-flex items-center px-2 py-1 rounded text-xs font-bold bg-red-100 text-red-700">
                                    Ditolak
                                </span>
                            @else
                                <span class="inline-flex items-center px-2 py-1 rounded text-xs font-bold bg-yellow-100 text-yellow-700">
                                    Menunggu
                                </span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="p-12 text-center">
                            <div class="flex flex-col items-center justify-center text-slate-400">
                                <i class="fa-regular fa-calendar-xmark text-4xl mb-3 opacity-50"></i>
                                <p class="text-sm font-medium">Belum ada riwayat kunjungan.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection