@extends('layouts.admin')

@section('title', 'Analisis Barang Bawaan')

@section('content')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

@php
    $totalItems = $itemCounts->sum();
    $topItem    = $itemCounts->keys()->first() ?? '—';
    $topItemVal = $itemCounts->values()->first() ?? 0;
    $itemMax    = $topItemVal ?: 1;
@endphp

<div class="space-y-6 pb-12">

    {{-- HEADER --}}
    <div class="relative bg-gradient-to-br from-teal-900 via-emerald-900 to-cyan-900 rounded-3xl p-7 md:p-9 text-white shadow-2xl overflow-hidden">
        <div class="absolute top-0 right-0 -mr-16 -mt-16 w-64 h-64 rounded-full bg-teal-400 opacity-10 blur-3xl"></div>
        <div class="relative z-10">
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/10 border border-white/20 text-xs font-bold uppercase tracking-wider mb-3 text-teal-200">
                <i class="fas fa-box-open"></i> Analisis
            </div>
            <h1 class="text-3xl md:text-4xl font-black tracking-tight">Analisis Barang Bawaan</h1>
            <p class="text-teal-100/70 mt-2 text-sm max-w-xl">
                Frekuensi barang yang dibawa pengunjung berdasarkan data kunjungan disetujui.
            </p>
        </div>
    </div>

    {{-- STAT CARDS --}}
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-5 flex items-center gap-4">
            <div class="w-11 h-11 bg-teal-100 rounded-xl flex items-center justify-center text-teal-600 text-xl flex-shrink-0">
                <i class="fas fa-list-ol"></i>
            </div>
            <div>
                <p class="text-xs text-slate-400 font-bold uppercase tracking-widest">Total Jenis</p>
                <p class="text-2xl font-black text-slate-800">{{ $itemCounts->count() }}</p>
                <p class="text-xs text-slate-400">jenis barang unik</p>
            </div>
        </div>
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-5 flex items-center gap-4">
            <div class="w-11 h-11 bg-emerald-100 rounded-xl flex items-center justify-center text-emerald-600 text-xl flex-shrink-0">
                <i class="fas fa-layer-group"></i>
            </div>
            <div>
                <p class="text-xs text-slate-400 font-bold uppercase tracking-widest">Total Entri</p>
                <p class="text-2xl font-black text-slate-800">{{ number_format($totalItems) }}</p>
                <p class="text-xs text-slate-400">entri barang dari semua kunjungan</p>
            </div>
        </div>
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-5 flex items-center gap-4">
            <div class="w-11 h-11 bg-amber-100 rounded-xl flex items-center justify-center text-amber-600 text-xl flex-shrink-0">
                <i class="fas fa-crown"></i>
            </div>
            <div>
                <p class="text-xs text-slate-400 font-bold uppercase tracking-widest">Paling Sering</p>
                <p class="text-lg font-black text-slate-800 leading-tight">{{ Str::limit($topItem, 20) }}</p>
                <p class="text-xs text-slate-400">{{ $topItemVal }}x dibawa</p>
            </div>
        </div>
    </div>

    {{-- MAIN CONTENT: Chart + Ranking --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

        {{-- Chart --}}
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6">
            <h3 class="font-black text-slate-800 mb-1">Top 20 Barang Paling Sering Dibawa</h3>
            <p class="text-xs text-slate-400 mb-5">Berdasarkan frekuensi kemunculan</p>
            <div class="h-[520px]"><canvas id="itemsChart"></canvas></div>
        </div>

        {{-- Ranking Table --}}
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
            <div class="p-5 border-b border-slate-50">
                <h3 class="font-black text-slate-800 text-sm">Ranking Lengkap</h3>
                <p class="text-xs text-slate-400">Semua barang dengan progress relatif</p>
            </div>
            <div class="p-5 space-y-3 max-h-[520px] overflow-y-auto">
                @php $ri = 0; @endphp
                @foreach($itemCounts as $item => $count)
                @php $ri++; $pct = round($count/$itemMax*100); @endphp
                <div class="flex items-center gap-3">
                    <span class="w-6 h-6 rounded-full text-[10px] font-black flex items-center justify-center flex-shrink-0
                        {{ $ri === 1 ? 'bg-amber-400 text-white' : ($ri === 2 ? 'bg-slate-400 text-white' : ($ri === 3 ? 'bg-orange-400 text-white' : 'bg-slate-100 text-slate-500')) }}">
                        {{ $ri }}
                    </span>
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center justify-between mb-1">
                            <span class="text-xs font-bold text-slate-700 truncate" title="{{ $item }}">{{ $item }}</span>
                            <div class="flex items-center gap-2 flex-shrink-0 ml-2">
                                <span class="text-[10px] text-slate-400">{{ $pct }}%</span>
                                <span class="text-xs font-black text-teal-700 bg-teal-100 px-2 py-0.5 rounded-full">{{ $count }}</span>
                            </div>
                        </div>
                        <div class="bg-slate-100 rounded-full h-1.5">
                            <div class="h-1.5 rounded-full bg-gradient-to-r from-teal-400 to-emerald-500" style="width: {{ $pct }}%"></div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const labels = {!! json_encode($itemCounts->take(20)->keys()) !!};
    const data   = {!! json_encode($itemCounts->take(20)->values()) !!};
    const max    = Math.max(...data);

    const bgColors = data.map((v, i) => `hsla(${170 + (i * 8) % 60}, 65%, ${45 + (i % 3) * 8}%, 0.85)`);

    new Chart(document.getElementById('itemsChart'), {
        type: 'bar',
        data: {
            labels,
            datasets: [{ data, backgroundColor: bgColors, borderRadius: 6, borderWidth: 0, label: 'Frekuensi' }]
        },
        options: {
            indexAxis: 'y',
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: { backgroundColor: 'rgba(15,23,42,.9)', padding: 12, cornerRadius: 8 }
            },
            scales: {
                x: { beginAtZero: true, ticks: { precision: 0 }, grid: { color: 'rgba(226,232,240,0.6)' } },
                y: { grid: { display: false }, ticks: { font: { size: 11, weight: 'bold' } } }
            }
        }
    });
});
</script>
@endsection
