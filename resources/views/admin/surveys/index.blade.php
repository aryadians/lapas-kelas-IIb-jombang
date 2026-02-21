@extends('layouts.admin')

@section('title', 'Laporan Survey IKM')

@section('content')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@php
    $total      = $stats->sangat_baik + $stats->baik + $stats->cukup + $stats->buruk;
    $ikmScore   = $total > 0 ? round($averageRating / 4 * 100, 1) : 0;
    $ikmLabel   = match(true) {
        $averageRating >= 3.5 => ['label' => 'Sangat Baik', 'color' => 'emerald', 'grade' => 'A'],
        $averageRating >= 2.5 => ['label' => 'Baik',        'color' => 'blue',    'grade' => 'B'],
        $averageRating >= 1.5 => ['label' => 'Cukup Baik',  'color' => 'amber',   'grade' => 'C'],
        default               => ['label' => 'Tidak Baik',  'color' => 'red',     'grade' => 'D'],
    };

    $ratingRows = [
        4 => ['label' => 'Sangat Baik', 'icon' => 'fa-star',         'color' => 'emerald', 'count' => $stats->sangat_baik],
        3 => ['label' => 'Baik',        'icon' => 'fa-thumbs-up',    'color' => 'blue',    'count' => $stats->baik],
        2 => ['label' => 'Cukup',       'icon' => 'fa-meh',          'color' => 'amber',   'count' => $stats->cukup],
        1 => ['label' => 'Buruk',       'icon' => 'fa-thumbs-down',  'color' => 'red',     'count' => $stats->buruk],
    ];
@endphp

<div class="space-y-6 pb-12">

    {{-- HERO HEADER --}}
    <div class="relative bg-gradient-to-br from-indigo-900 via-blue-900 to-slate-900 rounded-3xl overflow-hidden shadow-2xl">
        <div class="absolute inset-0 overflow-hidden pointer-events-none">
            <div class="absolute -top-20 -right-20 w-80 h-80 rounded-full bg-blue-400 opacity-10 blur-3xl"></div>
            <div class="absolute -bottom-20 -left-20 w-64 h-64 rounded-full bg-indigo-400 opacity-10 blur-3xl"></div>
        </div>
        <div class="relative z-10 p-7 md:p-9 flex flex-col md:flex-row items-start md:items-center gap-8">
            {{-- Title --}}
            <div class="flex-1">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/10 border border-white/20 text-xs font-bold uppercase tracking-wider mb-3 text-blue-200">
                    <i class="fas fa-poll"></i> Indeks Kepuasan Masyarakat
                </div>
                <h1 class="text-3xl md:text-4xl font-black text-white tracking-tight">Laporan Survey IKM</h1>
                <p class="text-blue-100/70 mt-2 text-sm max-w-lg">
                    Analisis kepuasan pengunjung berdasarkan feedback layanan kunjungan Lapas Kelas IIB Jombang.
                </p>
                <div class="flex flex-wrap items-center gap-3 mt-5">
                    <span class="inline-flex items-center gap-2 bg-white/10 border border-white/20 text-white text-sm font-bold px-4 py-2 rounded-xl">
                        <i class="fas fa-clipboard-list text-blue-300"></i>
                        {{ number_format($total) }} Responden
                    </span>
                    <span class="inline-flex items-center gap-2 bg-white/10 border border-white/20 text-white text-sm font-bold px-4 py-2 rounded-xl">
                        <i class="fas fa-star text-yellow-300"></i>
                        Rata-rata {{ number_format($averageRating, 2) }} / 4.00
                    </span>
                </div>
            </div>

            {{-- IKM Score Gauge --}}
            <div class="flex-shrink-0 bg-white/10 border border-white/20 rounded-3xl p-6 text-center min-w-44">
                <p class="text-xs font-black uppercase tracking-widest text-blue-200 mb-3">Indeks IKM</p>
                <div class="relative w-32 h-32 mx-auto mb-3">
                    <canvas id="gaugeChart" width="128" height="128"></canvas>
                    <div class="absolute inset-0 flex flex-col items-center justify-center">
                        <span class="text-3xl font-black text-white">{{ $ikmScore }}</span>
                        <span class="text-xs text-blue-200 font-bold">/ 100</span>
                    </div>
                </div>
                <span class="inline-block px-4 py-1.5 rounded-full text-sm font-black
                    {{ $ikmLabel['color'] === 'emerald' ? 'bg-emerald-400/30 text-emerald-200' :
                       ($ikmLabel['color'] === 'blue' ? 'bg-blue-400/30 text-blue-200' :
                       ($ikmLabel['color'] === 'amber' ? 'bg-amber-400/30 text-amber-200' : 'bg-red-400/30 text-red-200')) }}">
                    Grade {{ $ikmLabel['grade'] }} — {{ $ikmLabel['label'] }}
                </span>
            </div>
        </div>
    </div>

    {{-- STAT CARDS + DISTRIBUTION CHART --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- Distribution Donut Chart --}}
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6 flex flex-col justify-center">
            <h3 class="font-black text-slate-800 mb-1 text-sm">Distribusi Penilaian</h3>
            <p class="text-xs text-slate-400 mb-4">Proporsi setiap kategori feedback</p>
            <div class="h-64"><canvas id="surveyChart"></canvas></div>
        </div>

        {{-- Stat Bars --}}
        <div class="lg:col-span-2 bg-white rounded-2xl border border-slate-100 shadow-sm p-6">
            <h3 class="font-black text-slate-800 mb-1 text-sm">Rincian Penilaian</h3>
            <p class="text-xs text-slate-400 mb-6">Jumlah responden per kategori</p>
            <div class="space-y-5">
                @foreach($ratingRows as $score => $r)
                @php $pct = $total > 0 ? round($r['count'] / $total * 100) : 0; @endphp
                <div class="flex items-center gap-4">
                    <div class="flex items-center gap-2 w-28 flex-shrink-0">
                        <div class="w-8 h-8 rounded-xl flex items-center justify-center
                            {{ $r['color'] === 'emerald' ? 'bg-emerald-100 text-emerald-600' :
                               ($r['color'] === 'blue' ? 'bg-blue-100 text-blue-600' :
                               ($r['color'] === 'amber' ? 'bg-amber-100 text-amber-600' : 'bg-red-100 text-red-600')) }}">
                            <i class="fas {{ $r['icon'] }} text-xs"></i>
                        </div>
                        <span class="text-xs font-bold text-slate-600">{{ $r['label'] }}</span>
                    </div>
                    <div class="flex-1 bg-slate-100 rounded-full h-3 overflow-hidden">
                        <div class="h-3 rounded-full transition-all duration-700
                            {{ $r['color'] === 'emerald' ? 'bg-emerald-500' :
                               ($r['color'] === 'blue' ? 'bg-blue-500' :
                               ($r['color'] === 'amber' ? 'bg-amber-500' : 'bg-red-500')) }}"
                            style="width: {{ $pct }}%"></div>
                    </div>
                    <div class="flex items-center gap-2 flex-shrink-0 w-20 text-right">
                        <span class="text-sm font-black text-slate-800">{{ $r['count'] }}</span>
                        <span class="text-xs text-slate-400 font-medium">({{ $pct }}%)</span>
                    </div>
                </div>
                @endforeach
            </div>

            {{-- Summary mini-cards --}}
            <div class="grid grid-cols-4 gap-3 mt-6 pt-5 border-t border-slate-100">
                @foreach($ratingRows as $score => $r)
                <div class="text-center">
                    <p class="text-lg font-black
                        {{ $r['color'] === 'emerald' ? 'text-emerald-600' :
                           ($r['color'] === 'blue' ? 'text-blue-600' :
                           ($r['color'] === 'amber' ? 'text-amber-600' : 'text-red-600')) }}">
                        {{ $r['count'] }}
                    </p>
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-0.5">{{ $r['label'] }}</p>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    {{-- FEEDBACK TABLE --}}
    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
        {{-- Table Header + Filter --}}
        <div class="p-5 border-b border-slate-100 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 bg-blue-100 rounded-xl flex items-center justify-center text-blue-600">
                    <i class="fas fa-comments text-sm"></i>
                </div>
                <div>
                    <h3 class="font-black text-slate-800 text-sm">Semua Feedback Pengunjung</h3>
                    <p class="text-xs text-slate-400">{{ $surveys->total() }} entri ditemukan</p>
                </div>
            </div>
            <form method="GET" class="flex items-center gap-2 flex-wrap">
                <div class="relative">
                    <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
                    <input type="text" name="search" value="{{ request('search') }}"
                        placeholder="Cari saran..."
                        class="pl-9 pr-4 py-2.5 border-2 border-slate-100 bg-slate-50 rounded-xl text-xs font-medium text-slate-700 focus:border-blue-400 focus:outline-none focus:bg-white w-48 transition-all">
                </div>
                <div class="relative">
                    <select name="rating" onchange="this.form.submit()"
                        class="pl-3 pr-8 py-2.5 border-2 border-slate-100 bg-slate-50 rounded-xl text-xs font-bold text-slate-700 focus:border-blue-400 focus:outline-none focus:bg-white appearance-none transition-all">
                        <option value="">Semua Rating</option>
                        <option value="4" @selected(request('rating') == 4)>⭐⭐⭐⭐ Sangat Baik</option>
                        <option value="3" @selected(request('rating') == 3)>⭐⭐⭐ Baik</option>
                        <option value="2" @selected(request('rating') == 2)>⭐⭐ Cukup</option>
                        <option value="1" @selected(request('rating') == 1)>⭐ Buruk</option>
                    </select>
                    <i class="fas fa-chevron-down absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 text-xs pointer-events-none"></i>
                </div>
                <button type="submit"
                    class="px-4 py-2.5 bg-slate-800 hover:bg-slate-900 text-white text-xs font-bold rounded-xl transition-all">
                    <i class="fas fa-filter mr-1"></i> Filter
                </button>
                @if(request('search') || request('rating'))
                <a href="{{ route('admin.surveys.index') }}"
                    class="px-4 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-600 text-xs font-bold rounded-xl transition-all">
                    <i class="fas fa-times"></i>
                </a>
                @endif
            </form>
        </div>

        {{-- Table Body --}}
        @if($surveys->isEmpty())
        <div class="py-20 text-center">
            <div class="w-16 h-16 bg-slate-100 rounded-3xl flex items-center justify-center text-slate-300 text-3xl mx-auto mb-3">
                <i class="fas fa-comment-slash"></i>
            </div>
            <h3 class="font-black text-slate-700 mb-1">Belum Ada Data Survey</h3>
            <p class="text-slate-400 text-sm">Feedback dari pengunjung akan muncul di sini setelah kunjungan selesai.</p>
        </div>
        @else
        <div class="overflow-x-auto">
            <table class="min-w-full">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="px-5 py-3 text-left text-[11px] font-black text-slate-400 uppercase tracking-widest w-36">Penilaian</th>
                        <th class="px-5 py-3 text-left text-[11px] font-black text-slate-400 uppercase tracking-widest">Saran & Kritik</th>
                        <th class="px-5 py-3 text-left text-[11px] font-black text-slate-400 uppercase tracking-widest hidden md:table-cell w-36">Waktu</th>
                        <th class="px-5 py-3 text-center text-[11px] font-black text-slate-400 uppercase tracking-widest w-16">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @foreach($surveys as $survey)
                    @php
                        $ri = match((int)$survey->rating) {
                            4 => ['label' => 'Sangat Baik', 'color' => 'emerald', 'icon' => 'fa-star',        'stars' => 4],
                            3 => ['label' => 'Baik',        'color' => 'blue',    'icon' => 'fa-thumbs-up',   'stars' => 3],
                            2 => ['label' => 'Cukup',       'color' => 'amber',   'icon' => 'fa-meh',         'stars' => 2],
                            1 => ['label' => 'Buruk',       'color' => 'red',     'icon' => 'fa-thumbs-down', 'stars' => 1],
                            default => ['label' => 'N/A',   'color' => 'slate',   'icon' => 'fa-question',    'stars' => 0],
                        };
                        $bgMap = ['emerald' => 'bg-emerald-50', 'blue' => 'bg-sky-50', 'amber' => 'bg-amber-50', 'red' => 'bg-red-50', 'slate' => ''];
                        $badgeBg = ['emerald' => 'bg-emerald-100 text-emerald-700', 'blue' => 'bg-blue-100 text-blue-700', 'amber' => 'bg-amber-100 text-amber-700', 'red' => 'bg-red-100 text-red-700', 'slate' => 'bg-slate-100 text-slate-500'];
                    @endphp
                    <tr class="hover:bg-slate-50 transition-colors group">
                        <td class="px-5 py-4">
                            <div class="flex flex-col gap-1.5">
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-black {{ $badgeBg[$ri['color']] }}">
                                    <i class="fas {{ $ri['icon'] }} text-[10px]"></i>
                                    {{ $ri['label'] }}
                                </span>
                                <div class="flex gap-0.5">
                                    @for($s = 1; $s <= 4; $s++)
                                    <i class="fas fa-star text-[9px] {{ $s <= $ri['stars'] ? 'text-yellow-400' : 'text-slate-200' }}"></i>
                                    @endfor
                                </div>
                            </div>
                        </td>
                        <td class="px-5 py-4 max-w-sm">
                            @if($survey->saran)
                            <p class="text-sm text-slate-700 leading-relaxed">{{ $survey->saran }}</p>
                            @else
                            <span class="text-xs text-slate-400 italic">Tidak ada saran.</span>
                            @endif
                        </td>
                        <td class="px-5 py-4 hidden md:table-cell">
                            <p class="text-xs font-semibold text-slate-700">{{ $survey->created_at->diffForHumans() }}</p>
                            <p class="text-[11px] text-slate-400 font-mono mt-0.5">{{ $survey->created_at->format('d/m/Y H:i') }}</p>
                        </td>
                        <td class="px-5 py-4 text-center">
                            <form action="{{ route('admin.surveys.destroy', $survey->id) }}" method="POST"
                                onsubmit="return confirmDelete(event, this)">
                                @csrf @method('DELETE')
                                <button type="submit"
                                    class="w-8 h-8 rounded-xl bg-slate-100 hover:bg-red-100 hover:text-red-600 text-slate-400 flex items-center justify-center mx-auto transition-all text-xs">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        @if($surveys->hasPages())
        <div class="p-5 border-t border-slate-100">
            {{ $surveys->links() }}
        </div>
        @endif
        @endif
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const stats  = @json($stats);
    const total  = stats.sangat_baik + stats.baik + stats.cukup + stats.buruk;
    const score  = total > 0 ? ({{ $averageRating }} / 4 * 100).toFixed(1) : 0;

    // ─── Gauge Chart (donut half) ───────────────────────────────────────
    new Chart(document.getElementById('gaugeChart'), {
        type: 'doughnut',
        data: {
            datasets: [{
                data: [score, 100 - score],
                backgroundColor: [
                    score >= 87.5 ? '#10b981' : score >= 62.5 ? '#3b82f6' : score >= 37.5 ? '#f59e0b' : '#ef4444',
                    'rgba(255,255,255,0.1)'
                ],
                borderWidth: 0,
                circumference: 270,
                rotation: -135,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            cutout: '78%',
            plugins: { legend: { display: false }, tooltip: { enabled: false } },
            animation: { animateRotate: true, duration: 1200 }
        }
    });

    // ─── Donut Distribution Chart ───────────────────────────────────────
    new Chart(document.getElementById('surveyChart'), {
        type: 'doughnut',
        data: {
            labels: ['Sangat Baik', 'Baik', 'Cukup', 'Buruk'],
            datasets: [{
                data: [stats.sangat_baik, stats.baik, stats.cukup, stats.buruk],
                backgroundColor: ['#10b981', '#3b82f6', '#f59e0b', '#ef4444'],
                borderColor: '#fff',
                borderWidth: 3,
                hoverOffset: 12,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            cutout: '68%',
            plugins: {
                legend: { position: 'bottom', labels: { padding: 16, font: { size: 11, weight: 'bold' }, usePointStyle: true, pointStyle: 'circle' } },
                tooltip: { backgroundColor: 'rgba(15,23,42,.9)', padding: 12, cornerRadius: 8 }
            },
            animation: { animateRotate: true, animateScale: true, duration: 1000 }
        }
    });
});

function confirmDelete(event, form) {
    event.preventDefault();
    Swal.fire({
        customClass: { popup: 'rounded-3xl shadow-2xl', confirmButton: 'rounded-xl px-5 py-2.5 font-bold bg-red-600 text-white mr-2', cancelButton: 'rounded-xl px-5 py-2.5 font-bold bg-slate-200 text-slate-600' },
        buttonsStyling: false,
        title: 'Hapus Feedback?',
        text: 'Data feedback ini akan dihapus permanen.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: '<i class="fas fa-trash-alt mr-1"></i> Hapus',
        cancelButtonText: 'Batal'
    }).then(r => { if (r.isConfirmed) form.submit(); });
    return false;
}
</script>
@endsection
