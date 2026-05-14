@extends('layouts.admin')

@section('title', 'Dashboard Disiplin WBP')

@section('content')
<div class="space-y-6">
    <div class="bg-gradient-to-br from-indigo-900 to-slate-900 rounded-3xl p-8 text-white shadow-xl">
        <h1 class="text-3xl font-black">Dashboard Kedisiplinan WBP</h1>
        <p class="text-indigo-200">Monitoring pelanggaran dan status pembatasan kunjungan.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        {{-- Chart 1: Per Tipe --}}
        <div class="bg-white p-6 rounded-3xl border shadow-sm">
            <h3 class="font-bold text-slate-700 mb-4">Statistik Berdasarkan Jenis</h3>
            <canvas id="typeChart"></canvas>
        </div>

        {{-- Chart 2: Monthly Trends --}}
        <div class="bg-white p-6 rounded-3xl border shadow-sm col-span-2">
            <h3 class="font-bold text-slate-700 mb-4">Tren Pembatasan Per Bulan</h3>
            <canvas id="monthlyChart"></canvas>
        </div>
    </div>

    {{-- Top Violators --}}
    <div class="bg-white p-6 rounded-3xl border shadow-sm">
        <h3 class="font-bold text-slate-700 mb-4">Top 10 WBP Sering Dibatasi</h3>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="text-slate-400 text-xs border-b">
                        <th class="py-3">WBP</th>
                        <th class="py-3">Total Pelanggaran</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($topViolators as $v)
                    <tr>
                        <td class="py-3 font-bold">{{ $v->wbp->nama ?? 'N/A' }}</td>
                        <td class="py-3 text-red-500 font-black">{{ $v->total_restrictions }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Stats By Type
    const typeCtx = document.getElementById('typeChart').getContext('2d');
    new Chart(typeCtx, {
        type: 'pie',
        data: {
            labels: {!! json_encode($statsByType->keys()) !!},
            datasets: [{ data: {!! json_encode($statsByType->values()) !!}, backgroundColor: ['#F59E0B', '#EF4444', '#F97316', '#6366F1'] }]
        }
    });

    // Monthly Trends
    const monthCtx = document.getElementById('monthlyChart').getContext('2d');
    new Chart(monthCtx, {
        type: 'bar',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
            datasets: [{ label: 'Jumlah Kasus', data: {!! json_encode(array_values($monthlyData->toArray())) !!}, backgroundColor: '#6366F1' }]
        }
    });
</script>
@endsection
