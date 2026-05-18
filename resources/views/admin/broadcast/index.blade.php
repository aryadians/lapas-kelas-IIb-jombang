@extends('layouts.admin')

@section('content')
<div class="space-y-6 animate__animated animate__fadeIn">
    {{-- HEADER --}}
    <div class="bg-slate-900 rounded-3xl p-8 text-white shadow-xl shadow-slate-200 mb-8">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h1 class="text-3xl md:text-4xl font-black tracking-tight">Broadcast Pengumuman Darurat</h1>
                <p class="text-blue-200 mt-2 font-medium opacity-80">Kirim pemberitahuan mendadak ke pengunjung yang terdaftar</p>
            </div>
            <div class="bg-rose-500 text-white px-5 py-3 rounded-xl font-bold text-xs uppercase tracking-wider flex items-center gap-2 shadow-lg shadow-rose-900/20">
                <i class="fa-solid fa-triangle-exclamation"></i> Mode Darurat
            </div>
        </div>
    </div>
    
    @if(session('success'))
    <div class="bg-emerald-100 border-l-4 border-emerald-500 p-4 rounded-xl text-emerald-800 font-bold shadow-sm">
        {{ session('success') }}
    </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        {{-- ... Existing Forms ... --}}
    </div>

    {{-- HISTORY LOGS --}}
    <div class="bg-white p-6 rounded-3xl shadow-sm border border-slate-100">
        <h2 class="text-lg font-black text-slate-800 mb-4">Riwayat Broadcast</h2>
        <table class="w-full">
            <thead>
                <tr class="text-xs uppercase text-slate-400 font-bold border-b">
                    <th class="p-3 text-left">Tanggal Target</th>
                    <th class="p-3 text-left">Alasan</th>
                    <th class="p-3 text-center">Berhasil</th>
                    <th class="p-3 text-center">Gagal</th>
                    <th class="p-3 text-center">Waktu</th>
                </tr>
            </thead>
            <tbody>
                @foreach($logs as $log)
                <tr class="border-b hover:bg-slate-50">
                    <td class="p-3">{{ $log->target_date }}</td>
                    <td class="p-3">{{ $log->reason }}</td>
                    <td class="p-3 text-center font-bold text-emerald-600">{{ $log->sent_count }}</td>
                    <td class="p-3 text-center font-bold text-rose-600">{{ $log->failed_count }}</td>
                    <td class="p-3 text-center text-xs text-slate-500">{{ $log->created_at->format('d/m/Y H:i') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
