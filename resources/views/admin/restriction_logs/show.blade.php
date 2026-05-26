@extends('layouts.admin')

@section('content')
<div class="space-y-6 pb-12">

    {{-- HERO HEADER --}}
    <div class="relative bg-gradient-to-br from-slate-900 via-indigo-950 to-violet-950 rounded-3xl overflow-hidden shadow-2xl animate__animated animate__fadeIn">
        <div class="absolute inset-0 pointer-events-none overflow-hidden">
            <div class="absolute -top-20 -right-20 w-80 h-80 bg-indigo-400 rounded-full blur-[90px] opacity-10"></div>
            <div class="absolute -bottom-16 -left-16 w-60 h-60 bg-violet-400 rounded-full blur-[80px] opacity-10"></div>
        </div>
        <div class="relative z-10 px-8 py-7 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/10 border border-white/20 text-indigo-200 text-xs font-bold uppercase tracking-widest mb-3">
                    <i class="fas fa-info-circle"></i> Detail Sesi
                </div>
                <h1 class="text-3xl font-black text-white tracking-tight">Detail Log Broadcast</h1>
                <p class="text-indigo-100/60 mt-1 text-sm">Informasi lengkap mengenai pembatalan kunjungan pada sesi ini.</p>
            </div>
            <div>
                <a href="{{ route('admin.restriction-logs.index') }}" 
                    class="inline-flex items-center gap-2 px-5 py-2.5 bg-white text-indigo-950 hover:bg-slate-50 text-sm font-black rounded-xl transition-all shadow-xl hover:-translate-y-0.5 active:scale-95">
                    <i class="fas fa-arrow-left"></i> Kembali ke Daftar
                </a>
            </div>
        </div>
    </div>

    {{-- HIGHLIGHT DETAILS CARD --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        {{-- Status & Meta --}}
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6 space-y-4">
            <h3 class="text-sm font-black text-slate-800 uppercase tracking-wider border-b pb-3 flex items-center gap-2">
                <i class="fas fa-info text-indigo-500"></i> Metadata Sesi
            </h3>
            <div class="space-y-3">
                <div class="flex justify-between items-center text-sm">
                    <span class="text-slate-400 font-medium">Status</span>
                    {!! $log->status_badge !!}
                </div>
                <div class="flex justify-between items-center text-sm">
                    <span class="text-slate-400 font-medium">Metode Pemicu</span>
                    {!! $log->triggered_by_badge !!}
                </div>
                <div class="flex justify-between items-center text-sm">
                    <span class="text-slate-400 font-medium">Waktu Eksekusi</span>
                    <span class="font-bold text-slate-800">
                        {{ $log->created_at->timezone('Asia/Jakarta')->format('d M Y, H:i:s') }}
                    </span>
                </div>
                <div class="flex justify-between items-center text-sm">
                    <span class="text-slate-400 font-medium">Durasi Relatif</span>
                    <span class="font-bold text-slate-500 text-xs">
                        {{ $log->created_at->diffForHumans() }}
                    </span>
                </div>
            </div>
        </div>

        {{-- Statistics --}}
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6 space-y-4 lg:col-span-2">
            <h3 class="text-sm font-black text-slate-800 uppercase tracking-wider border-b pb-3 flex items-center gap-2">
                <i class="fas fa-chart-pie text-indigo-500"></i> Statistik Hasil
            </h3>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <div class="bg-slate-50 rounded-xl p-4 flex flex-col">
                    <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">WBP Diproses</span>
                    <span class="text-2xl font-black text-slate-800 mt-1">{{ $log->total_wbp_processed }}</span>
                </div>
                <div class="bg-slate-50 rounded-xl p-4 flex flex-col">
                    <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">WBP Aman</span>
                    <span class="text-2xl font-black text-slate-600 mt-1">{{ $log->total_wbp_no_restriction }}</span>
                </div>
                <div class="bg-red-50/50 rounded-xl p-4 flex flex-col border border-red-100">
                    <span class="text-[10px] font-bold text-red-400 uppercase tracking-widest">Kunjungan Batal</span>
                    <span class="text-2xl font-black text-red-700 mt-1">{{ $log->total_kunjungan_cancelled }}</span>
                </div>
                <div class="bg-emerald-50/50 rounded-xl p-4 flex flex-col border border-emerald-100">
                    <span class="text-[10px] font-bold text-emerald-400 uppercase tracking-widest">Notif Terantri</span>
                    <span class="text-2xl font-black text-emerald-700 mt-1">{{ $log->total_notifications_queued }}</span>
                </div>
            </div>
        </div>
    </div>

    {{-- Execution Summary / Notes --}}
    @if($log->notes)
    <div class="bg-indigo-50/50 border border-indigo-100 rounded-2xl p-5 flex items-start gap-3.5">
        <div class="w-10 h-10 bg-indigo-100 rounded-xl flex items-center justify-center text-indigo-600 flex-shrink-0">
            <i class="fas fa-comment-alt-lines text-sm"></i>
        </div>
        <div>
            <h4 class="text-xs font-black text-indigo-900 uppercase tracking-wider">Catatan Eksekusi</h4>
            <p class="text-sm text-indigo-950/80 mt-1 leading-relaxed">{{ $log->notes }}</p>
        </div>
    </div>
    @endif

    {{-- DETAILS TAB --}}
    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
        <div class="bg-slate-50 px-6 py-4 border-b border-slate-100 flex items-center gap-3">
            <div class="w-9 h-9 bg-indigo-600 rounded-xl flex items-center justify-center text-white">
                <i class="fas fa-tasks text-sm"></i>
            </div>
            <div>
                <h2 class="font-black text-slate-800 text-sm uppercase tracking-tight">Detail Per-WBP Terkena Pembatasan</h2>
                <p class="text-slate-400 text-xs">Menampilkan daftar WBP dan kunjungan terdaftar yang dibatalkan</p>
            </div>
        </div>

        @if($detailsByWbp->isEmpty())
        <div class="py-20 text-center">
            <div class="w-16 h-16 bg-slate-100 rounded-2xl flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-clipboard-check text-slate-400 text-2xl"></i>
            </div>
            <p class="text-slate-500 font-bold">Tidak Ada Data Detil</p>
            <p class="text-slate-400 text-sm mt-1">Seluruh WBP yang diproses tidak memiliki kunjungan aktif untuk dibatalkan.</p>
        </div>
        @else
        <div class="divide-y divide-slate-100">
            @foreach($detailsByWbp as $wbpNama => $items)
                @php
                    $firstItem = $items->first();
                    $hasRestriction = !empty($firstItem->restriction_type);
                @endphp
                <div class="p-6 space-y-4">
                    {{-- WBP Header info --}}
                    <div class="flex flex-col md:flex-row md:items-center justify-between gap-3 bg-slate-50/50 p-4 rounded-xl border border-slate-100">
                        <div>
                            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Warga Binaan (WBP)</span>
                            <h3 class="text-base font-black text-slate-800 mt-0.5">{{ $wbpNama }}</h3>
                        </div>
                        @if($hasRestriction)
                        <div class="flex items-center gap-2">
                            <span class="px-2.5 py-1 bg-amber-100 border border-amber-200 text-amber-800 text-xs font-black rounded-lg">
                                <i class="fas fa-lock mr-1"></i> {{ $firstItem->restriction_type }}
                            </span>
                            @if($firstItem->restriction_start && $firstItem->restriction_end)
                            <span class="text-xs font-bold text-slate-500">
                                ({{ $firstItem->restriction_start->format('d/m/Y') }} s.d. {{ $firstItem->restriction_end->format('d/m/Y') }})
                            </span>
                            @endif
                        </div>
                        @else
                        <span class="px-2.5 py-1 bg-slate-100 border border-slate-200 text-slate-500 text-xs font-black rounded-lg">
                            <i class="fas fa-minus-circle mr-1"></i> Tanpa Pembatasan
                        </span>
                        @endif
                    </div>

                    {{-- Visits Table --}}
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm text-left">
                            <thead>
                                <tr class="text-xs font-black text-slate-400 uppercase tracking-wider border-b border-slate-100">
                                    <th class="pb-2">Kode Booking</th>
                                    <th class="pb-2">Tgl Kunjungan</th>
                                    <th class="pb-2">Nama Pengunjung</th>
                                    <th class="pb-2">Kontak Pengunjung</th>
                                    <th class="pb-2">Status Notif</th>
                                    <th class="pb-2">Aksi Log</th>
                                    <th class="pb-2">Keterangan/Error</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                @foreach($items as $item)
                                    @if($item->kunjungan_id)
                                    <tr class="text-slate-700">
                                        <td class="py-3 font-mono font-bold text-slate-900">
                                            {{ $item->kode_booking ?? '-' }}
                                        </td>
                                        <td class="py-3 font-bold text-slate-800">
                                            {{ $item->tanggal_kunjungan ? $item->tanggal_kunjungan->format('d/m/Y') : '-' }}
                                        </td>
                                        <td class="py-3 font-medium text-slate-800">{{ $item->pengunjung_nama ?? '-' }}</td>
                                        <td class="py-3 text-xs space-y-1">
                                            <div class="flex items-center gap-1">
                                                <i class="fab fa-whatsapp text-emerald-500"></i>
                                                <span class="font-bold text-slate-800">{{ $item->pengunjung_wa ?? '-' }}</span>
                                            </div>
                                            @if($item->pengunjung_email && $item->pengunjung_email !== '-')
                                            <div class="flex items-center gap-1">
                                                <i class="far fa-envelope text-indigo-500"></i>
                                                <span class="text-slate-500">{{ $item->pengunjung_email }}</span>
                                            </div>
                                            @endif
                                        </td>
                                        <td class="py-3 space-y-1">
                                            @if($item->wa_queued)
                                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-800 border border-emerald-200">
                                                <i class="fas fa-check-circle text-[8px]"></i> WA Terkirim
                                            </span>
                                            @else
                                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-bold bg-slate-100 text-slate-400 border border-slate-200">
                                                <i class="fas fa-minus-circle text-[8px]"></i> WA N/A
                                            </span>
                                            @endif
                                            
                                            @if($item->email_queued)
                                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-bold bg-indigo-100 text-indigo-800 border border-indigo-200 block w-fit">
                                                <i class="fas fa-check-circle text-[8px]"></i> Email Terkirim
                                            </span>
                                            @endif
                                        </td>
                                        <td class="py-3">{!! $item->action_badge !!}</td>
                                        <td class="py-3 text-xs">
                                            @if($item->error_message)
                                            <span class="text-red-500 font-bold block max-w-xs truncate" title="{{ $item->error_message }}">
                                                <i class="fas fa-exclamation-triangle mr-1"></i> {{ $item->error_message }}
                                            </span>
                                            @elseif($item->action === 'cancelled')
                                            <span class="text-slate-400">Kunjungan dibatalkan & notifikasi diantrekan</span>
                                            @else
                                            <span class="text-slate-400">—</span>
                                            @endif
                                        </td>
                                    </tr>
                                    @else
                                    <tr class="text-slate-400">
                                        <td colspan="7" class="py-3 text-center italic text-xs">
                                            Tidak ada pendaftaran kunjungan untuk WBP ini yang overlap dengan periode pembatasan.
                                        </td>
                                    </tr>
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endforeach
        </div>
        @endif
    </div>

</div>
@endsection
