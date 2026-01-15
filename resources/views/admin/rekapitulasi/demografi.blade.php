@extends('layouts.admin')

@section('content')
<div class="space-y-8">
    <div class="relative bg-gradient-to-r from-slate-900 via-blue-900 to-indigo-900 rounded-[2rem] p-8 md:p-10 text-white shadow-2xl">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-4xl md:text-5xl font-extrabold tracking-tight leading-tight">Demografi Pengunjung</h1>
                <p class="text-blue-100/80 mt-3 text-lg font-light max-w-xl leading-relaxed">
                    Analisis data demografi pengunjung berdasarkan usia, jenis kelamin, dan kota asal.
                </p>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        {{-- Age Chart --}}
        <div class="glass-panel p-6 rounded-2xl shadow-sm">
            <h3 class="text-xl font-bold text-slate-800 mb-2">Distribusi Usia Pengunjung</h3>
            <p class="text-sm text-slate-500 mb-6">Berdasarkan usia pendaftar (dihitung dari NIK).</p>
            <div class="h-80 w-full">
                <canvas id="ageChart"></canvas>
            </div>
        </div>

        {{-- Gender Chart --}}
        <div class="glass-panel p-6 rounded-2xl shadow-sm">
            <h3 class="text-xl font-bold text-slate-800 mb-2">Distribusi Gender Pengunjung</h3>
            <p class="text-sm text-slate-500 mb-6">Berdasarkan gender pendaftar.</p>
            <div class="h-80 w-full">
                <canvas id="genderChart"></canvas>
            </div>
        </div>
    </div>

    <div class="mt-8">
        {{-- City Chart --}}
        <div class="glass-panel p-6 rounded-2xl shadow-sm">
            <h3 class="text-xl font-bold text-slate-800 mb-4">Top 10 Kota Asal Pengunjung</h3>
            <div class="h-96 w-full">
                <canvas id="cityChart"></canvas>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', () => {
    // Chart 1: Age Distribution
    const ageChartCtx = document.getElementById('ageChart')?.getContext('2d');
    if (ageChartCtx) {
        new Chart(ageChartCtx, {
            type: 'bar',
            data: {
                labels: {!! json_encode(array_keys($ageGroups)) !!},
                datasets: [{
                    label: 'Jumlah Pengunjung',
                    data: {!! json_encode(array_values($ageGroups)) !!},
                    backgroundColor: 'rgba(59, 130, 246, 0.7)',
                    borderColor: 'rgba(59, 130, 246, 1)',
                    borderWidth: 1,
                    borderRadius: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: { precision: 0 }
                    }
                }
            }
        });
    }

    // Chart 2: Gender Distribution
    const genderChartCtx = document.getElementById('genderChart')?.getContext('2d');
    if (genderChartCtx) {
        new Chart(genderChartCtx, {
            type: 'doughnut',
            data: {
                labels: ['Laki-laki', 'Perempuan'],
                datasets: [{
                    label: 'Pengunjung',
                    data: [{{ $visitorGender['Laki-laki'] ?? 0 }}, {{ $visitorGender['Perempuan'] ?? 0 }}],
                    backgroundColor: [
                        'rgba(59, 130, 246, 0.8)',
                        'rgba(236, 72, 153, 0.8)'
                    ],
                    borderColor: [
                        '#FFFFFF',
                        '#FFFFFF'
                    ],
                    borderWidth: 2,
                    hoverOffset: 8
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            font: { size: 14, family: "'Inter', sans-serif" },
                            padding: 20
                        }
                    },
                },
                cutout: '60%'
            }
        });
    }

    // Chart 3: City Distribution
    const cityChartCtx = document.getElementById('cityChart')?.getContext('2d');
    if (cityChartCtx) {
        new Chart(cityChartCtx, {
            type: 'bar',
            data: {
                labels: {!! json_encode($cityCounts->keys()) !!},
                datasets: [{
                    label: 'Jumlah Pengunjung',
                    data: {!! json_encode($cityCounts->values()) !!},
                    backgroundColor: 'rgba(22, 163, 74, 0.7)',
                    borderColor: 'rgba(22, 163, 74, 1)',
                    borderWidth: 1,
                    borderRadius: 4
                }]
            },
            options: {
                indexAxis: 'y', // Horizontal bar chart
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    x: {
                        beginAtZero: true,
                        ticks: { precision: 0 }
                    }
                }
            }
        });
    }
});
</script>
@endsection
