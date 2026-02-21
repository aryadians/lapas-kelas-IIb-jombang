@extends('layouts.admin')

@section('title', 'Rekapitulasi Kunjungan')

@section('content')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

@php
    $totalKunjungan = array_sum($sessionCounts->toArray());
    $topWbp = $mostVisitedWbp->first();
    $lakiTotal  = $visitorGender['Laki-laki'] ?? 0;
    $wanitaTotal = $visitorGender['Perempuan'] ?? 0;
    $totalGender = $lakiTotal + $wanitaTotal;
@endphp

<div class="space-y-6 pb-12">

    {{-- HEADER --}}
    <div class="relative bg-gradient-to-br from-slate-900 via-blue-900 to-indigo-900 rounded-3xl p-7 md:p-9 text-white shadow-2xl overflow-hidden">
        <div class="absolute top-0 right-0 -mr-16 -mt-16 w-72 h-72 rounded-full bg-blue-400 opacity-10 blur-3xl"></div>
        <div class="absolute bottom-0 left-0 -ml-16 -mb-16 w-56 h-56 rounded-full bg-indigo-400 opacity-10 blur-3xl"></div>

        <div class="relative z-10 flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
            <div>
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/10 border border-white/20 text-xs font-bold uppercase tracking-wider mb-3 text-blue-200">
                    <i class="fas fa-chart-bar"></i> Laporan
                </div>
                <h1 class="text-3xl md:text-4xl font-black tracking-tight">Rekapitulasi Kunjungan</h1>
                <p class="text-blue-100/70 mt-2 text-sm max-w-xl">
                    Analisis komprehensif data kunjungan, demografi pengunjung, dan WBP.
                </p>
            </div>
            {{-- Filter Jenis Pendaftaran --}}
            <div x-data="{ open: false, selected: '{{ ucfirst(request('registration_type', 'Semua')) }}' }" class="relative flex-shrink-0">
                <p class="text-xs text-blue-300 font-bold mb-1 uppercase tracking-widest">Filter Jenis</p>
                <button @click="open = !open"
                    class="flex items-center gap-3 bg-white/10 hover:bg-white/20 border border-white/20 text-white font-bold px-4 py-2.5 rounded-xl transition-all min-w-36">
                    <i class="fas fa-filter text-blue-300 text-xs"></i>
                    <span x-text="selected" class="flex-1 text-left text-sm"></span>
                    <i class="fas fa-chevron-down text-xs transition-transform" :class="open ? 'rotate-180' : ''"></i>
                </button>
                <div x-show="open" @click.away="open = false" x-transition
                    class="absolute right-0 mt-2 w-44 bg-white rounded-2xl shadow-2xl border border-slate-100 overflow-hidden z-50"
                    style="display:none">
                    @foreach(['all' => 'Semua', 'online' => 'Online', 'offline' => 'Offline'] as $val => $label)
                    <a href="{{ route('admin.rekapitulasi', ['registration_type' => $val]) }}"
                        @click="selected = '{{ $label }}'; open = false"
                        class="flex items-center gap-2 px-4 py-2.5 text-sm font-semibold text-slate-700 hover:bg-blue-50 hover:text-blue-700 transition-colors {{ request('registration_type', 'all') === $val ? 'bg-blue-50 text-blue-700' : '' }}">
                        {{ $label }}
                        @if(request('registration_type', 'all') === $val)
                        <i class="fas fa-check ml-auto text-blue-500 text-xs"></i>
                        @endif
                    </a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    {{-- STAT CARDS --}}
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-5">
            <div class="flex items-center gap-3 mb-2">
                <div class="w-9 h-9 bg-blue-100 rounded-xl flex items-center justify-center text-blue-600"><i class="fas fa-users text-sm"></i></div>
                <span class="text-xs font-black text-slate-400 uppercase tracking-widest">Total</span>
            </div>
            <p class="text-3xl font-black text-slate-800">{{ $totalKunjungan }}</p>
            <p class="text-xs text-slate-400 mt-1">kunjungan disetujui</p>
        </div>
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-5">
            <div class="flex items-center gap-3 mb-2">
                <div class="w-9 h-9 bg-sky-100 rounded-xl flex items-center justify-center text-sky-600"><i class="fas fa-male text-sm"></i></div>
                <span class="text-xs font-black text-slate-400 uppercase tracking-widest">Laki-laki</span>
            </div>
            <p class="text-3xl font-black text-slate-800">{{ $lakiTotal }}</p>
            <p class="text-xs text-slate-400 mt-1">{{ $totalGender > 0 ? round($lakiTotal / $totalGender * 100) : 0 }}% dari total</p>
        </div>
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-5">
            <div class="flex items-center gap-3 mb-2">
                <div class="w-9 h-9 bg-pink-100 rounded-xl flex items-center justify-center text-pink-600"><i class="fas fa-female text-sm"></i></div>
                <span class="text-xs font-black text-slate-400 uppercase tracking-widest">Perempuan</span>
            </div>
            <p class="text-3xl font-black text-slate-800">{{ $wanitaTotal }}</p>
            <p class="text-xs text-slate-400 mt-1">{{ $totalGender > 0 ? round($wanitaTotal / $totalGender * 100) : 0 }}% dari total</p>
        </div>
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-5">
            <div class="flex items-center gap-3 mb-2">
                <div class="w-9 h-9 bg-amber-100 rounded-xl flex items-center justify-center text-amber-600"><i class="fas fa-trophy text-sm"></i></div>
                <span class="text-xs font-black text-slate-400 uppercase tracking-widest">Top WBP</span>
            </div>
            <p class="text-lg font-black text-slate-800 leading-tight">{{ $topWbp?->nama ?? '—' }}</p>
            <p class="text-xs text-slate-400 mt-1">{{ $topWbp?->visit_count ?? 0 }}x dikunjungi</p>
        </div>
    </div>

    {{-- CHARTS ROW --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6">
            <h3 class="font-black text-slate-800 mb-1">Demografi Gender</h3>
            <p class="text-xs text-slate-400 mb-5">Berdasarkan gender pendaftar utama</p>
            <div class="h-72">
                <canvas id="genderChart"></canvas>
            </div>
        </div>
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6">
            <h3 class="font-black text-slate-800 mb-1">Sesi Kunjungan Terpadat</h3>
            <p class="text-xs text-slate-400 mb-5">Berdasarkan jumlah pendaftar disetujui per sesi</p>
            <div class="h-72">
                <canvas id="busiestSessionChart"></canvas>
            </div>
        </div>
    </div>

    {{-- TOP WBP TABLE --}}
    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
        <div class="flex items-center gap-3 p-6 border-b border-slate-50">
            <div class="w-10 h-10 bg-amber-100 rounded-xl flex items-center justify-center text-amber-600">
                <i class="fas fa-trophy"></i>
            </div>
            <div>
                <h3 class="font-black text-slate-800 text-base">Top 10 WBP Paling Sering Dikunjungi</h3>
                <p class="text-xs text-slate-400">Data berdasarkan kunjungan berstatus approved</p>
            </div>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="px-5 py-3 text-left text-[11px] font-black text-slate-400 uppercase tracking-widest w-10">#</th>
                        <th class="px-5 py-3 text-left text-[11px] font-black text-slate-400 uppercase tracking-widest">Nama WBP</th>
                        <th class="px-5 py-3 text-left text-[11px] font-black text-slate-400 uppercase tracking-widest hidden md:table-cell">No. Registrasi</th>
                        <th class="px-5 py-3 text-left text-[11px] font-black text-slate-400 uppercase tracking-widest hidden sm:table-cell">Blok / Kamar</th>
                        <th class="px-5 py-3 text-center text-[11px] font-black text-slate-400 uppercase tracking-widest">Kunjungan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($mostVisitedWbp as $wbp)
                    @php $i = $loop->iteration; @endphp
                    <tr class="hover:bg-slate-50 transition-colors {{ $i === 1 ? 'bg-amber-50/40' : '' }}">
                        <td class="px-5 py-3.5">
                            <span class="w-7 h-7 rounded-full flex items-center justify-center text-[11px] font-black
                                {{ $i === 1 ? 'bg-amber-400 text-white' : ($i === 2 ? 'bg-slate-400 text-white' : ($i === 3 ? 'bg-orange-400 text-white' : 'bg-slate-200 text-slate-600')) }}">
                                {{ $i }}
                            </span>
                        </td>
                        <td class="px-5 py-3.5">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-xl flex items-center justify-center text-xs font-black text-white flex-shrink-0"
                                    style="background: hsl({{ ($i * 47) % 360 }}, 60%, 55%)">
                                    {{ strtoupper(substr($wbp->nama, 0, 1)) }}
                                </div>
                                <span class="text-sm font-bold text-slate-800">{{ $wbp->nama }}</span>
                            </div>
                        </td>
                        <td class="px-5 py-3.5 hidden md:table-cell">
                            <span class="text-xs font-mono text-slate-500 bg-slate-100 px-2 py-1 rounded-lg">{{ $wbp->no_registrasi }}</span>
                        </td>
                        <td class="px-5 py-3.5 hidden sm:table-cell text-xs text-slate-500">
                            <i class="fas fa-building text-slate-300 mr-1"></i>{{ $wbp->blok ?? '-' }} / {{ $wbp->kamar ?? '-' }}
                        </td>
                        <td class="px-5 py-3.5 text-center">
                            <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-black {{ $i === 1 ? 'bg-amber-100 text-amber-700' : 'bg-blue-100 text-blue-700' }}">
                                <i class="fas fa-users text-[10px]"></i> {{ $wbp->visit_count }}
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="py-16 text-center text-slate-400 text-sm">
                            <i class="fas fa-box-open text-3xl mb-3 block text-slate-300"></i>
                            Belum ada data kunjungan yang disetujui.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const swalColors = { tooltip: { backgroundColor: 'rgba(15,23,42,.9)', padding: 12, cornerRadius: 8, titleFont: { size: 13, weight: 'bold' }, bodyFont: { size: 12 } } };

    // Gender chart
    new Chart(document.getElementById('genderChart'), {
        type: 'doughnut',
        data: {
            labels: ['Laki-laki', 'Perempuan'],
            datasets: [{ data: [{{ $visitorGender['Laki-laki'] ?? 0 }}, {{ $visitorGender['Perempuan'] ?? 0 }}],
                backgroundColor: ['rgba(56,189,248,0.9)', 'rgba(244,114,182,0.9)'],
                borderColor: ['#fff','#fff'], borderWidth: 3, hoverOffset: 10 }]
        },
        options: { responsive: true, maintainAspectRatio: false, cutout: '65%',
            plugins: { legend: { position: 'bottom', labels: { font: { size: 12, weight: 'bold' }, padding: 20 } },
                tooltip: swalColors.tooltip } }
    });

    // Session chart
    new Chart(document.getElementById('busiestSessionChart'), {
        type: 'bar',
        data: {
            labels: {!! json_encode($sessionCounts->keys()) !!},
            datasets: [{ label: 'Kunjungan', data: {!! json_encode($sessionCounts->values()) !!},
                backgroundColor: {!! json_encode($sessionCounts->keys()->map(fn($k, $i) => ['rgba(34,197,94,0.8)', 'rgba(59,130,246,0.8)', 'rgba(168,85,247,0.8)', 'rgba(245,158,11,0.8)'][$i % 4])->toArray()) !!},
                borderRadius: 8, borderWidth: 0 }]
        },
        options: { responsive: true, maintainAspectRatio: false,
            plugins: { legend: { display: false }, tooltip: swalColors.tooltip },
            scales: { y: { beginAtZero: true, ticks: { precision: 0 }, grid: { color: 'rgba(226,232,240,0.6)' } }, x: { grid: { display: false } } } }
    });
});
</script>
@endsection
