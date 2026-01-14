@extends('layouts.main')

@php
    use App\Enums\KunjunganStatus;
@endphp

@section('content')
<div class="bg-slate-50 min-h-screen pb-20">
    <div class="max-w-5xl mx-auto py-12 px-4 sm:px-6 lg:px-8">

        {{-- HEADER --}}
        <div class="mb-8">
            <h1 class="text-3xl font-extrabold text-slate-800">Riwayat Kunjungan</h1>
            <p class="text-slate-500 mt-1">Menampilkan semua pendaftaran yang terkait dengan NIK: <strong class="text-slate-700">{{ $nik }}</strong></p>
        </div>

        {{-- VISIT LIST --}}
        @if ($kunjungans->count() > 0)
            <div class="space-y-4">
                @foreach ($kunjungans as $kunjungan)
                    <div class="bg-white rounded-lg shadow-md border border-gray-100 overflow-hidden hover:shadow-lg hover:border-gray-200 transition-all duration-300">
                        <div class="p-5 grid grid-cols-1 md:grid-cols-4 gap-4 items-center">
                            {{-- WBP & Tanggal --}}
                            <div class="md:col-span-2">
                                <p class="text-xs text-gray-500">Tujuan Kunjungan</p>
                                <p class="font-bold text-slate-800 text-lg">{{ $kunjungan->nama_wbp }}</p>
                                <p class="text-sm text-slate-600 font-semibold">{{ \Carbon\Carbon::parse($kunjungan->tanggal_kunjungan)->translatedFormat('l, d F Y') }}</p>
                            </div>
                            
                            {{-- Status --}}
                            <div class="flex justify-start md:justify-center">
                                @if($kunjungan->status == KunjunganStatus::APPROVED)
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">Disetujui</span>
                                @elseif($kunjungan->status == KunjunganStatus::REJECTED)
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800">Ditolak</span>
                                @else
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800">Menunggu</span>
                                @endif
                            </div>

                            {{-- Action Button --}}
                            <div class="text-left md:text-right">
                                <a href="{{ route('kunjungan.status', $kunjungan) }}" class="inline-block bg-slate-800 text-white font-bold py-2 px-4 rounded-lg hover:bg-slate-700 transition text-sm shadow-sm">
                                    Lihat Detail
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- PAGINATION --}}
            @if ($kunjungans->hasPages())
            <div class="mt-8">
                {{ $kunjungans->links() }}
            </div>
            @endif

        @else
            {{-- NO RESULTS --}}
            <div class="text-center bg-white p-12 rounded-lg shadow border">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                    <path vector-effect="non-scaling-stroke" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 13h6m-3-3v6m-9 1V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z" />
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900">Tidak Ada Riwayat</h3>
                <p class="mt-1 text-sm text-gray-500">Tidak ditemukan riwayat pendaftaran kunjungan dengan NIK tersebut.</p>
                <div class="mt-6">
                    <a href="{{ route('kunjungan.history') }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-slate-800 hover:bg-slate-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-slate-500">
                        <svg class="mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16l-4-4m0 0l4-4m-4 4h18"></path></svg>
                        Coba NIK Lain
                    </a>
                </div>
            </div>
        @endif
        
    </div>
</div>
@endsection
