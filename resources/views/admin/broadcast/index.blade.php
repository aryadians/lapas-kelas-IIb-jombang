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
        {{-- SETTINGS --}}
        <form action="{{ route('admin.broadcast.update', $template->id) }}" method="POST" class="bg-white p-6 rounded-3xl shadow-sm border border-slate-100 space-y-4">
            @csrf
            @method('PUT')
            <h2 class="text-lg font-black text-slate-800 mb-4 border-b pb-2">Pengaturan Template</h2>

            <div>
                <label class="block text-xs font-bold text-slate-400 uppercase mb-2">WhatsApp Body (Template)</label>
                <textarea name="whatsapp_body" class="w-full p-4 bg-slate-50 border-2 border-slate-100 rounded-2xl focus:border-blue-500 focus:ring-0" rows="12">{{ $template->whatsapp_body }}</textarea>
                <small class="text-slate-400">Gunakan: {nama}, {tanggal}, {alasan}</small>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-400 uppercase mb-2">Email Subject</label>
                <input type="text" name="email_subject" value="{{ $template->email_subject }}" class="w-full p-4 bg-slate-50 border-2 border-slate-100 rounded-2xl focus:border-blue-500 focus:ring-0">
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-400 uppercase mb-2">Email Body (HTML)</label>
                <textarea name="email_body" class="w-full p-4 bg-slate-50 border-2 border-slate-100 rounded-2xl focus:border-blue-500 focus:ring-0" rows="15">{{ $template->email_body }}</textarea>
            </div>

            <button type="submit" class="w-full bg-slate-900 text-white px-6 py-4 rounded-2xl font-bold hover:bg-slate-800 transition">Simpan Template</button>
        </form>

        {{-- ACTION --}}
        <form action="{{ route('admin.broadcast.send') }}" method="POST" class="bg-white p-6 rounded-3xl shadow-sm border border-slate-100 space-y-6">
            @csrf
            <h2 class="text-lg font-black text-rose-600 mb-4 border-b border-rose-100 pb-2">Eksekusi Pengiriman</h2>

            <div class="grid grid-cols-1 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-400 uppercase mb-2">Tanggal Kunjungan (Target)</label>
                    <input type="date" name="tanggal" class="w-full p-4 bg-slate-50 border-2 border-slate-100 rounded-2xl focus:border-rose-500 focus:ring-0" required>
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-400 uppercase mb-2">Alasan Pembatalan</label>
                    <input type="text" name="alasan" placeholder="Contoh: Perbaikan Gedung / Hari Libur Nasional" class="w-full p-4 bg-slate-50 border-2 border-slate-100 rounded-2xl focus:border-rose-500 focus:ring-0" required>
                </div>
            </div>

            <div class="bg-rose-50 p-4 rounded-xl text-rose-700 text-xs font-bold italic">
                <i class="fa-solid fa-circle-info mr-1"></i> Aksi ini akan mengirim notifikasi ke SEMUA pengunjung yang terdaftar pada tanggal tersebut. Pastikan data sudah benar.
            </div>

            <button type="submit" class="w-full bg-rose-600 text-white px-6 py-4 rounded-2xl font-black hover:bg-rose-700 transition shadow-lg shadow-rose-500/20" onclick="return confirm('Apakah Anda yakin ingin mengirim broadcast ini?')">KIRIM BROADCAST SEKARANG</button>
        </form>
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
