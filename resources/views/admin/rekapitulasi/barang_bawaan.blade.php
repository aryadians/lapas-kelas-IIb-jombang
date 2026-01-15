@extends('layouts.admin')

@section('content')
<div class="space-y-8">
    <div class="relative bg-gradient-to-r from-slate-900 via-teal-900 to-cyan-900 rounded-[2rem] p-8 md:p-10 text-white shadow-2xl">
        <div>
            <h1 class="text-4xl md:text-5xl font-extrabold tracking-tight leading-tight">Analisis Barang Bawaan</h1>
            <p class="text-teal-100/80 mt-3 text-lg font-light max-w-xl leading-relaxed">
                Frekuensi barang yang dibawa oleh pengunjung. Data diambil dari kunjungan yang disetujui.
            </p>
        </div>
    </div>

    <div class="mt-8">
        <div class="glass-panel p-6 rounded-2xl shadow-sm">
            <h3 class="text-xl font-bold text-slate-800 mb-4">Top 20 Barang Bawaan Paling Sering</h3>
            <div class="h-[600px] w-full">
                <canvas id="itemsChart"></canvas>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', () => {
    const itemsChartCtx = document.getElementById('itemsChart')?.getContext('2d');
    if (itemsChartCtx) {
        new Chart(itemsChartCtx, {
            type: 'bar',
            data: {
                labels: {!! json_encode($itemCounts->keys()) !!},
                datasets: [{
                    label: 'Jumlah',
                    data: {!! json_encode($itemCounts->values()) !!},
                    backgroundColor: 'rgba(13, 148, 136, 0.7)',
                    borderColor: 'rgba(13, 148, 136, 1)',
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
