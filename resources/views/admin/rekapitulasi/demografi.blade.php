@extends('layouts.admin')

@section('title', 'Demografi Pengunjung')

@section('content')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

@php
    $lakiTotal   = $visitorGender['Laki-laki'] ?? 0;
    $wanitaTotal = $visitorGender['Perempuan'] ?? 0;
    $totalGender = $lakiTotal + $wanitaTotal;
    $topCity     = $cityCounts->keys()->first() ?? '—';
    $topCityVal  = $cityCounts->values()->first() ?? 0;
@endphp

<div class="space-y-6 pb-12">

    {{-- HEADER --}}
    <div class="relative bg-gradient-to-br from-violet-900 via-purple-900 to-indigo-900 rounded-3xl p-7 md:p-9 text-white shadow-2xl overflow-hidden">
        <div class="absolute top-0 right-0 -mr-16 -mt-16 w-72 h-72 rounded-full bg-purple-400 opacity-10 blur-3xl"></div>
        <div class="relative z-10">
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/10 border border-white/20 text-xs font-bold uppercase tracking-wider mb-3 text-purple-200">
                <i class="fas fa-users"></i> Demografis
            </div>
            <h1 class="text-3xl md:text-4xl font-black tracking-tight">Demografi Pengunjung</h1>
            <p class="text-purple-100/70 mt-2 text-sm">Analisis usia, gender, dan asal daerah pengunjung.</p>
        </div>
    </div>

    {{-- STAT CARDS --}}
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-5">
            <div class="w-10 h-10 bg-blue-100 rounded-xl flex items-center justify-center text-blue-600 mb-3"><i class="fas fa-users"></i></div>
            <p class="text-2xl font-black text-slate-800">{{ $totalGender }}</p>
            <p class="text-xs text-slate-400 mt-0.5">Total pengunjung</p>
        </div>
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-5">
            <div class="w-10 h-10 bg-sky-100 rounded-xl flex items-center justify-center text-sky-600 mb-3"><i class="fas fa-male"></i></div>
            <p class="text-2xl font-black text-slate-800">{{ $lakiTotal }}</p>
            <p class="text-xs text-slate-400 mt-0.5">Laki-laki ({{ $totalGender > 0 ? round($lakiTotal/$totalGender*100) : 0 }}%)</p>
        </div>
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-5">
            <div class="w-10 h-10 bg-pink-100 rounded-xl flex items-center justify-center text-pink-600 mb-3"><i class="fas fa-female"></i></div>
            <p class="text-2xl font-black text-slate-800">{{ $wanitaTotal }}</p>
            <p class="text-xs text-slate-400 mt-0.5">Perempuan ({{ $totalGender > 0 ? round($wanitaTotal/$totalGender*100) : 0 }}%)</p>
        </div>
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-5">
            <div class="w-10 h-10 bg-emerald-100 rounded-xl flex items-center justify-center text-emerald-600 mb-3"><i class="fas fa-map-pin"></i></div>
            <p class="text-base font-black text-slate-800 leading-tight">{{ Str::limit($topCity, 18) }}</p>
            <p class="text-xs text-slate-400 mt-0.5">Kota terbanyak ({{ $topCityVal }})</p>
        </div>
    </div>

    {{-- CHARTS ROW 1 --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6">
            <h3 class="font-black text-slate-800 mb-1">Distribusi Usia</h3>
            <p class="text-xs text-slate-400 mb-5">Dihitung dari NIK KTP pendaftar</p>
            <div class="h-72"><canvas id="ageChart"></canvas></div>
        </div>
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6">
            <h3 class="font-black text-slate-800 mb-1">Distribusi Gender</h3>
            <p class="text-xs text-slate-400 mb-5">Berdasarkan gender pendaftar utama</p>
            <div class="h-72"><canvas id="genderChart"></canvas></div>
        </div>
    </div>

    {{-- KOTA/KECAMATAN --}}
    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6">
        <h3 class="font-black text-slate-800 mb-1">Top 10 Kota / Kecamatan Asal</h3>
        <p class="text-xs text-slate-400 mb-5">Berdasarkan field alamat pengunjung</p>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-start">
            <div class="h-80"><canvas id="cityChart"></canvas></div>
            {{-- Ranking list di sebelah kanan --}}
            <div class="space-y-2.5">
                @php $cityMax = $cityCounts->values()->first() ?? 1; $ci = 0; @endphp
                @foreach($cityCounts->take(10) as $city => $count)
                @php $ci++; @endphp
                <div class="flex items-center gap-3">
                    <span class="w-6 h-6 rounded-full text-[11px] font-black flex items-center justify-center flex-shrink-0
                        {{ $ci === 1 ? 'bg-amber-400 text-white' : ($ci === 2 ? 'bg-slate-400 text-white' : ($ci === 3 ? 'bg-orange-400 text-white' : 'bg-slate-200 text-slate-600')) }}">
                        {{ $ci }}
                    </span>
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center justify-between mb-1">
                            <span class="text-xs font-bold text-slate-700 truncate" title="{{ $city }}">{{ $city }}</span>
                            <span class="text-xs font-black text-slate-500 ml-2 flex-shrink-0">{{ $count }}</span>
                        </div>
                        <div class="bg-slate-100 rounded-full h-1.5">
                            <div class="h-1.5 rounded-full bg-violet-500" style="width: {{ $cityMax > 0 ? round($count/$cityMax*100) : 0 }}%"></div>
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
    const tooltipOpt = { backgroundColor: 'rgba(15,23,42,.9)', padding: 12, cornerRadius: 8 };

    new Chart(document.getElementById('ageChart'), {
        type: 'bar',
        data: {
            labels: {!! json_encode(array_keys($ageGroups)) !!},
            datasets: [{ data: {!! json_encode(array_values($ageGroups)) !!},
                backgroundColor: ['#a78bfa','#818cf8','#60a5fa','#38bdf8','#34d399','#fbbf24'].slice(0, {!! count($ageGroups) !!}),
                borderRadius: 8, borderWidth: 0 }]
        },
        options: { responsive: true, maintainAspectRatio: false,
            plugins: { legend: { display: false }, tooltip: tooltipOpt },
            scales: { y: { beginAtZero: true, ticks: { precision: 0 }, grid: { color: 'rgba(226,232,240,0.6)' } }, x: { grid: { display: false } } } }
    });

    new Chart(document.getElementById('genderChart'), {
        type: 'doughnut',
        data: {
            labels: ['Laki-laki', 'Perempuan'],
            datasets: [{ data: [{{ $lakiTotal }}, {{ $wanitaTotal }}],
                backgroundColor: ['rgba(56,189,248,0.9)', 'rgba(244,114,182,0.9)'],
                borderColor: ['#fff','#fff'], borderWidth: 3, hoverOffset: 10 }]
        },
        options: { responsive: true, maintainAspectRatio: false, cutout: '65%',
            plugins: { legend: { position: 'bottom', labels: { font: { size: 12, weight: 'bold' }, padding: 20 } }, tooltip: tooltipOpt } }
    });

    new Chart(document.getElementById('cityChart'), {
        type: 'bar',
        data: {
            labels: {!! json_encode($cityCounts->keys()) !!},
            datasets: [{ data: {!! json_encode($cityCounts->values()) !!},
                backgroundColor: 'rgba(139,92,246,0.75)', borderRadius: 8, borderWidth: 0 }]
        },
        options: { indexAxis: 'y', responsive: true, maintainAspectRatio: false,
            plugins: { legend: { display: false }, tooltip: tooltipOpt },
            scales: { x: { beginAtZero: true, ticks: { precision: 0 }, grid: { color: 'rgba(226,232,240,0.6)' } }, y: { grid: { display: false }, ticks: { font: { size: 11, weight: 'bold' } } } } }
    });
});
</script>
@endsection
