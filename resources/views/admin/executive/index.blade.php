@extends('layouts.admin')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>

<style>
    /* 3D Perspective Container */
    .perspective-1000 { perspective: 1000px; }

    /* 3D Card Effect */
    .card-3d {
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        transform-style: preserve-3d;
    }
    .card-3d:hover {
        transform: translateY(-10px) scale(1.03) rotateX(5deg) rotateY(2deg);
        box-shadow: 0 25px 40px -15px rgba(0, 0, 0, 0.2);
        z-index: 10;
    }
    .kpi-card-3d:hover {
        transform: translateY(-8px) scale(1.05);
        box-shadow: 0 20px 30px -10px rgba(0, 0, 0, 0.15);
    }

    /* Glassmorphism Panel */
    .glass-panel {
        background: rgba(255, 255, 255, 0.85);
        backdrop-filter: blur(15px);
        border: 1px solid rgba(226, 232, 240, 0.9);
    }

    /* Active button style for chart toggle */
    .btn-active {
        background-color: #3b82f6 !important;
        color: white !important;
        box-shadow: 0 4px 14px 0 rgb(0 118 255 / 39%);
    }

    /* Table styles */
    .th-sortable { cursor: pointer; }
    .th-sortable:hover { background-color: #f3f4f6; }
</style>

<div class="space-y-8 pb-12 perspective-1000">

    {{-- 1. HERO SECTION --}}
    <div class="relative bg-gradient-to-br from-slate-900 via-blue-900 to-indigo-800 rounded-2xl p-8 md:p-10 text-white shadow-2xl overflow-hidden animate__animated animate__fadeInDown border-2 border-white/10 card-3d">
        <div class="absolute top-0 right-0 -mr-20 -mt-20 w-96 h-96 rounded-full bg-yellow-400 opacity-10 blur-3xl animate-pulse"></div>
        <div class="absolute bottom-0 left-0 -ml-20 -mb-20 w-72 h-72 rounded-full bg-blue-400 opacity-10 blur-3xl animate-pulse" style="animation-delay: 1s;"></div>
        
        <div class="relative z-10">
            <div class="inline-flex items-center px-3 py-1 rounded-full bg-white/10 border border-white/20 text-xs font-semibold uppercase tracking-wider mb-3 text-blue-200">
                <i class="fas fa-chart-pie mr-2"></i> Laporan Performa
            </div>
            <h1 class="text-3xl sm:text-4xl font-extrabold tracking-tight">
                Dashboard Eksekutif
            </h1>
            <p class="text-blue-100/80 mt-2 text-base font-light max-w-2xl leading-relaxed">
                Analisis visual performa dan tren layanan kunjungan untuk pengambilan keputusan strategis.
            </p>
        </div>
    </div>

    {{-- 2. KPI CARDS --}}
    <div id="kpi-container" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 animate__animated animate__fadeInUp delay-100">
        @php
            $kpis = [
                ['id' => 'total_visits_30d', 'label' => 'Total Kunjungan (30 Hari)', 'icon' => 'fa-users', 'bg' => 'from-blue-500 to-indigo-600'],
                ['id' => 'busiest_day', 'label' => 'Hari Paling Ramai', 'icon' => 'fa-calendar-day', 'bg' => 'from-green-500 to-emerald-600'],
                ['id' => 'busiest_hour', 'label' => 'Jam Tersibuk', 'icon' => 'fa-clock', 'bg' => 'from-amber-500 to-orange-600'],
                ['id' => 'top_relationship', 'label' => 'Hubungan Teratas', 'icon' => 'fa-heart', 'bg' => 'from-purple-500 to-violet-600'],
            ];
        @endphp

        @foreach($kpis as $kpi)
        <div class="kpi-card-3d transition-all duration-300 relative overflow-hidden rounded-xl bg-gradient-to-br {{ $kpi['bg'] }} p-6 text-white shadow-lg group">
            <div class="absolute -top-4 -right-4 p-4 opacity-10 group-hover:opacity-20 transition-opacity transform group-hover:scale-125 duration-500">
                <i class="fa-solid {{ $kpi['icon'] }} text-7xl"></i>
            </div>
            <div class="relative z-10">
                <p class="text-xs font-bold uppercase tracking-widest opacity-80">{{ $kpi['label'] }}</p>
                <h3 id="{{ $kpi['id'] }}" class="text-4xl font-black tracking-tight mt-2">...</h3>
            </div>
        </div>
        @endforeach
    </div>

    {{-- 3. CHARTS ROW 1 --}}
    <div class="grid grid-cols-1 lg:grid-cols-5 gap-8">
        <div class="lg:col-span-3 card-3d glass-panel p-4 sm:p-6 rounded-xl shadow-lg border animate__animated animate__fadeInLeft delay-200">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-4">
                <div>
                    <h3 class="text-xl font-bold text-slate-800">Grafik Tren Kunjungan</h3>
                    <p class="text-sm text-slate-500">Analisis tren kunjungan harian dan bulanan.</p>
                </div>
                <div id="trend-toggle-buttons" class="flex-shrink-0 mt-3 sm:mt-0 bg-slate-100 p-1 rounded-lg">
                    <button data-period="daily" class="px-3 py-1 text-sm font-semibold rounded-md text-slate-600 btn-active">Harian (30 hari)</button>
                    <button data-period="monthly" class="px-3 py-1 text-sm font-semibold rounded-md text-slate-600">Bulanan (1 tahun)</button>
                </div>
            </div>
            <div class="h-80 w-full mt-6">
                <canvas id="kunjunganTrendChart"></canvas>
            </div>
        </div>
        <div class="lg:col-span-2 card-3d glass-panel p-4 sm:p-6 rounded-xl shadow-lg border animate__animated animate__fadeInRight delay-300">
            <h3 class="text-xl font-bold text-slate-800">Heatmap Jam Pendaftaran</h3>
            <p class="text-sm text-slate-500 mb-4">Visualisasi jam pendaftaran tersibuk.</p>
            <div class="h-80 w-full mt-6">
                <canvas id="kunjunganHeatmapChart"></canvas>
            </div>
        </div>
    </div>

    {{-- 4. CHARTS ROW 2 --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <div class="card-3d glass-panel p-4 sm:p-6 rounded-xl shadow-lg border animate__animated animate__fadeInUp delay-400">
            <h3 class="text-xl font-bold text-slate-800 mb-4">Demografi Pengunjung (Gender)</h3>
            <div class="h-80 w-full flex items-center justify-center">
                <canvas id="demographicsGenderChart"></canvas>
            </div>
        </div>
        <div class="card-3d glass-panel p-4 sm:p-6 rounded-xl shadow-lg border animate__animated animate__fadeInUp delay-500">
            <h3 class="text-xl font-bold text-slate-800 mb-4">Demografi Pengunjung (Hubungan)</h3>
            <div class="h-80 w-full flex items-center justify-center">
                <canvas id="demographicsRelationshipChart"></canvas>
            </div>
        </div>
    </div>
    
    {{-- 5. NEW FEATURES ROW --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
        <div class="card-3d glass-panel p-4 sm:p-6 rounded-xl shadow-lg border animate__animated animate__fadeInUp delay-600">
            <h3 class="text-xl font-bold text-slate-800 mb-4">Distribusi Usia Pengunjung</h3>
            <div class="h-80 w-full flex items-center justify-center">
                <canvas id="ageDistributionChart"></canvas>
            </div>
        </div>

        {{-- TOP 10 KECAMATAN --}}
        <div class="card-3d glass-panel p-4 sm:p-6 rounded-xl shadow-lg border animate__animated animate__fadeInUp delay-700">
            <div class="flex items-center gap-3 mb-5">
                <div class="w-10 h-10 bg-sky-100 rounded-xl flex items-center justify-center text-sky-600">
                    <i class="fas fa-map-marker-alt"></i>
                </div>
                <div>
                    <h3 class="text-base font-black text-slate-800">Top 10 Kecamatan</h3>
                    <p class="text-xs text-slate-400">Asal wilayah pengunjung terbanyak</p>
                </div>
            </div>
            <div id="kecamatan-list" class="space-y-2.5">
                {{-- Skeleton loading --}}
                @for($s = 0; $s < 5; $s++)
                <div class="h-9 bg-slate-100 animate-pulse rounded-xl"></div>
                @endfor
            </div>
        </div>
    </div>

    {{-- TOP 10 DESA --}}
    <div class="grid grid-cols-1 gap-6 mb-8">
        <div class="card-3d glass-panel p-4 sm:p-6 rounded-xl shadow-lg border animate__animated animate__fadeInUp delay-750">
            <div class="flex items-center gap-3 mb-5">
                <div class="w-10 h-10 bg-violet-100 rounded-xl flex items-center justify-center text-violet-600">
                    <i class="fas fa-home"></i>
                </div>
                <div>
                    <h3 class="text-base font-black text-slate-800">Top 10 Desa / Kelurahan</h3>
                    <p class="text-xs text-slate-400">Asal desa/kel. pengunjung terbanyak</p>
                </div>
            </div>
            <div id="desa-list" class="grid grid-cols-1 md:grid-cols-2 gap-2.5">
                @for($s = 0; $s < 6; $s++)
                <div class="h-9 bg-slate-100 animate-pulse rounded-xl"></div>
                @endfor
            </div>
        </div>
    </div>

    {{-- 6. MOST VISITED WBP TABLE --}}
    <div x-data="mostVisitedWbpController()" x-init="fetchData" class="card-3d glass-panel p-4 sm:p-6 rounded-xl shadow-lg border animate__animated animate__fadeInUp delay-800">
        <div class="flex items-center gap-3 mb-6">
            <div class="w-10 h-10 bg-amber-100 rounded-xl flex items-center justify-center text-amber-600">
                <i class="fas fa-trophy"></i>
            </div>
            <div>
                <h3 class="text-base font-black text-slate-800">Top 10 WBP Paling Sering Dikunjungi</h3>
                <p class="text-xs text-slate-400">Berdasarkan jumlah kunjungan disetujui</p>
            </div>
        </div>
        <div class="overflow-x-auto rounded-xl border border-slate-100">
            <table class="min-w-full">
                <thead>
                    <tr class="bg-slate-50">
                        <th class="px-4 py-3 text-left text-[11px] font-black text-slate-400 uppercase tracking-widest w-10">#</th>
                        <th @click="sortBy('nama')" class="th-sortable px-4 py-3 text-left text-[11px] font-black text-slate-400 uppercase tracking-widest">Nama WBP</th>
                        <th @click="sortBy('no_registrasi')" class="th-sortable px-4 py-3 text-left text-[11px] font-black text-slate-400 uppercase tracking-widest hidden md:table-cell">No. Reg</th>
                        <th @click="sortBy('blok')" class="th-sortable px-4 py-3 text-left text-[11px] font-black text-slate-400 uppercase tracking-widest hidden sm:table-cell">Blok/Kamar</th>
                        <th @click="sortBy('visit_count')" class="th-sortable px-4 py-3 text-right text-[11px] font-black text-slate-400 uppercase tracking-widest">Kunjungan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    <template x-if="loading">
                        <tr><td colspan="5" class="p-8 text-center">
                            <div class="inline-flex items-center gap-2 text-slate-400">
                                <i class="fas fa-circle-notch fa-spin"></i> Memuat data...
                            </div>
                        </td></tr>
                    </template>
                    <template x-for="(wbp, idx) in sortedWbp" :key="wbp.no_registrasi">
                        <tr class="hover:bg-slate-50 transition-colors"
                            :class="idx === 0 ? 'bg-amber-50/50' : ''">
                            <td class="px-4 py-3">
                                <span class="w-6 h-6 rounded-full flex items-center justify-center text-[11px] font-black"
                                    :class="idx === 0 ? 'bg-amber-400 text-white' : idx === 1 ? 'bg-slate-400 text-white' : idx === 2 ? 'bg-orange-400 text-white' : 'bg-slate-200 text-slate-600'"
                                    x-text="idx + 1"></span>
                            </td>
                            <td class="px-4 py-3">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-xl flex items-center justify-center text-xs font-black text-white flex-shrink-0"
                                        :style="`background: hsl(${(idx * 47) % 360}, 60%, 55%)`"
                                        x-text="wbp.nama?.charAt(0)?.toUpperCase() ?? '?'"></div>
                                    <span class="text-sm font-bold text-slate-800" x-text="wbp.nama"></span>
                                </div>
                            </td>
                            <td class="px-4 py-3 hidden md:table-cell">
                                <span class="text-xs font-mono text-slate-500 bg-slate-100 px-2 py-1 rounded-lg" x-text="wbp.no_registrasi"></span>
                            </td>
                            <td class="px-4 py-3 hidden sm:table-cell">
                                <span class="text-xs text-slate-600">
                                    <i class="fas fa-building text-slate-400 mr-1"></i>
                                    <span x-text="(wbp.blok ?? '-') + ' / ' + (wbp.kamar ?? '-')"></span>
                                </span>
                            </td>
                            <td class="px-4 py-3 text-right">
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-black"
                                    :class="idx === 0 ? 'bg-amber-100 text-amber-700' : 'bg-blue-100 text-blue-700'">
                                    <i class="fas fa-users text-[10px]"></i>
                                    <span x-text="wbp.visit_count"></span>
                                </span>
                            </td>
                        </tr>
                    </template>
                </tbody>
            </table>
        </div>
    </div>


</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        // --- HELPERS ---
        const commonChartOptions = (extraOptions = {}) => ({
            responsive: true,
            maintainAspectRatio: false,
            animation: { duration: 1000, easing: 'easeInOutQuart' },
            plugins: {
                legend: { position: 'bottom', labels: { font: { size: 12 } } },
                tooltip: { backgroundColor: 'rgba(15, 23, 42, 0.9)', padding: 12, cornerRadius: 8, titleFont: { size: 14, weight: 'bold' }, bodyFont: { size: 12 } }
            },
            scales: {
                y: { beginAtZero: true, grid: { color: 'rgba(226, 232, 240, 0.7)' }, ticks: { precision: 0 } },
                x: { grid: { display: false } }
            },
            ...extraOptions
        });

        // --- KPI FETCH ---
        fetch('{{ route("api.executive.kpis") }}').then(r => r.json()).then(data => {
            document.getElementById('total_visits_30d').textContent = data.total_visits_30d;
            document.getElementById('busiest_day').textContent = data.busiest_day;
            document.getElementById('busiest_hour').textContent = data.busiest_hour;
            document.getElementById('top_relationship').textContent = data.top_relationship;
        });

        // --- TREND CHART ---
        const trendCtx = document.getElementById('kunjunganTrendChart').getContext('2d');
        const trendChart = new Chart(trendCtx, { type: 'line', data: { labels: [], datasets: [{ data: [], tension: 0.4, fill: true }] }, options: commonChartOptions() });
        let trendDataStore = {};
        fetch('{{ route("api.executive.kunjungan-trend") }}').then(r => r.json()).then(data => {
            trendDataStore = data;
            updateTrendChart('daily');
        });

        function updateTrendChart(period) {
            const data = trendDataStore[period];
            if (!data) return;
            trendChart.data.labels = data.labels;
            trendChart.data.datasets[0].data = data.data;
            trendChart.data.datasets[0].label = `Kunjungan ${period === 'daily' ? 'Harian' : 'Bulanan'}`;
            trendChart.data.datasets[0].borderColor = period === 'daily' ? '#3b82f6' : '#8b5cf6';
            trendChart.data.datasets[0].backgroundColor = period === 'daily' ? 'rgba(59, 130, 246, 0.1)' : 'rgba(139, 92, 246, 0.1)';
            trendChart.update();
            document.querySelectorAll('#trend-toggle-buttons button').forEach(btn => btn.classList.toggle('btn-active', btn.dataset.period === period));
        }
        document.getElementById('trend-toggle-buttons').addEventListener('click', e => e.target.tagName === 'BUTTON' && updateTrendChart(e.target.dataset.period));

        // --- HEATMAP CHART ---
        fetch('{{ route("api.executive.kunjungan-heatmap") }}').then(r => r.json()).then(data => {
            const maxVal = Math.max(...data.data);
            const bgColors = data.data.map(val => `rgba(239, 68, 68, ${Math.max(0.2, val / maxVal)})`);
            new Chart(document.getElementById('kunjunganHeatmapChart').getContext('2d'), {
                type: 'bar',
                data: { labels: data.labels, datasets: [{ label: 'Jumlah Pendaftar', data: data.data, backgroundColor: bgColors, borderColor: '#ef4444', borderWidth: 1 }] },
                options: commonChartOptions({ plugins: { legend: { display: false } } })
            });
        });

        // --- DEMOGRAPHICS CHARTS ---
        fetch('{{ route("api.executive.demographics") }}').then(r => r.json()).then(data => {
            new Chart(document.getElementById('demographicsGenderChart').getContext('2d'), {
                type: 'doughnut',
                data: { labels: data.gender.labels, datasets: [{ data: data.gender.data, backgroundColor: ['rgba(59, 130, 246, 0.8)', 'rgba(236, 72, 153, 0.8)'], borderColor: ['#3b82f6', '#ec4899'], borderWidth: 2 }] },
                options: commonChartOptions({ scales: {} })
            });
            new Chart(document.getElementById('demographicsRelationshipChart').getContext('2d'), {
                type: 'pie',
                data: { labels: data.relationship.labels, datasets: [{ data: data.relationship.data, backgroundColor: ['#22c55e', '#f59e0b', '#8b5cf6', '#ef4444', '#64748b', '#3b82f6'].map(c => c + 'CC'), borderWidth: 2 }] },
                options: commonChartOptions({ scales: {} })
            });
        });
        
        // --- NEW VISITOR DEMOGRAPHICS CHARTS + RANKING TABLES ---
        fetch('{{ route("api.executive.visitor-demographics") }}').then(r => r.json()).then(data => {
            // Age chart
            new Chart(document.getElementById('ageDistributionChart').getContext('2d'), {
                type: 'bar',
                data: { labels: data.age_distribution.labels, datasets: [{ label: 'Jumlah Pengunjung', data: data.age_distribution.data, backgroundColor: ['#10b981','#3b82f6','#8b5cf6','#f59e0b','#ef4444','#64748b'] }] },
                options: commonChartOptions({ plugins: { legend: { display: false } } })
            });

            // --- Ranking helpers ---
            const rankColors = ['bg-amber-400 text-white', 'bg-slate-400 text-white', 'bg-orange-400 text-white'];
            const defaultRankColor = 'bg-slate-200 text-slate-600';

            function buildRankingList(containerId, items, colors, maxBar) {
                const container = document.getElementById(containerId);
                if (!container) return;
                container.innerHTML = '';
                if (!items || items.length === 0) {
                    container.innerHTML = '<p class="text-slate-400 text-sm text-center py-4">Data tidak tersedia</p>';
                    return;
                }
                items.forEach((item, idx) => {
                    const pct = maxBar > 0 ? Math.round((item.count / maxBar) * 100) : 0;
                    const rankClass = idx < 3 ? rankColors[idx] : defaultRankColor;
                    const barColor = colors[idx % colors.length];
                    const div = document.createElement('div');
                    div.className = 'flex items-center gap-3 group';
                    div.innerHTML = `
                        <span class="w-7 h-7 flex-shrink-0 rounded-full flex items-center justify-center text-xs font-black ${rankClass}">${idx + 1}</span>
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center justify-between mb-1">
                                <span class="text-xs font-bold text-slate-700 truncate pr-2" title="${item.label}">${item.label}</span>
                                <span class="text-xs font-black text-slate-500 flex-shrink-0">${item.count}</span>
                            </div>
                            <div class="w-full bg-slate-100 rounded-full h-1.5">
                                <div class="h-1.5 rounded-full transition-all duration-700" style="width: ${pct}%; background: ${barColor}"></div>
                            </div>
                        </div>
                    `;
                    container.appendChild(div);
                });
            }

            // Build Kecamatan list
            const kecItems = data.city_distribution.labels.map((label, i) => ({ label, count: data.city_distribution.data[i] }));
            const kecMax   = kecItems[0]?.count ?? 1;
            buildRankingList('kecamatan-list', kecItems, ['#0ea5e9','#38bdf8','#7dd3fc','#bae6fd','#e0f2fe','#0ea5e9','#38bdf8','#7dd3fc','#bae6fd','#e0f2fe'], kecMax);

            // Build Desa list
            const desaItems = data.village_distribution.labels.map((label, i) => ({ label, count: data.village_distribution.data[i] }));
            const desaMax   = desaItems[0]?.count ?? 1;
            buildRankingList('desa-list', desaItems, ['#8b5cf6','#a78bfa','#c4b5fd','#ddd6fe','#ede9fe','#8b5cf6','#a78bfa','#c4b5fd','#ddd6fe','#ede9fe'], desaMax);
        });
    });

    // --- MOST VISITED WBP TABLE (ALPINE.JS) ---
    function mostVisitedWbpController() {
        return {
            wbpData: [],
            loading: true,
            sortCol: 'visit_count',
            sortAsc: false,
            fetchData() {
                fetch('{{ route("api.executive.most-visited-wbp") }}')
                    .then(response => response.json())
                    .then(data => {
                        this.wbpData = data;
                        this.loading = false;
                    });
            },
            sortBy(col) {
                if (this.sortCol === col) this.sortAsc = !this.sortAsc;
                else this.sortCol = col;
            },
            get sortedWbp() {
                return [...this.wbpData].sort((a, b) => {
                    let valA = a[this.sortCol], valB = b[this.sortCol];
                    if (typeof valA === 'string') {
                        valA = valA.toLowerCase();
                        valB = valB.toLowerCase();
                    }
                    if (valA < valB) return this.sortAsc ? -1 : 1;
                    if (valA > valB) return this.sortAsc ? 1 : -1;
                    return 0;
                });
            }
        }
    }
</script>
@endsection

