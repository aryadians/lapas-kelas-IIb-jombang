@extends('layouts.admin')

@section('content')
<div x-data class="space-y-8">

    {{-- HEADER --}}
    <div class="flex flex-col md:flex-row justify-between items-start gap-6">
        <div>
            <h1 class="text-3xl font-bold text-slate-800">📊 Laporan Survey IKM</h1>
            <p class="text-slate-500 text-sm mt-1">Analisis dan kelola feedback dari pengunjung.</p>
        </div>
        <div class="flex items-center gap-3 p-4 rounded-xl bg-white border border-slate-200 shadow-lg">
            <div class="text-yellow-500 text-3xl">
                <i class="fa-solid fa-star"></i>
            </div>
            <div>
                <p class="text-xs font-bold text-slate-400 uppercase">Rating Rata-Rata</p>
                <p class="text-2xl font-black text-slate-800">{{ number_format($averageRating, 2) }} / 4.00</p>
            </div>
        </div>
    </div>

    {{-- STATS CARDS & CHART --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        {{-- Chart --}}
        <div class="lg:col-span-1 bg-white rounded-2xl shadow-2xl border border-slate-200 p-6 flex flex-col justify-center items-center transform hover:scale-[1.03] transition-transform duration-500">
            <h3 class="font-bold text-slate-700 text-center mb-4">Distribusi Penilaian</h3>
            <div class="relative w-full h-64">
                <canvas id="surveyChart"></canvas>
            </div>
        </div>

        {{-- Stats --}}
        <div class="lg:col-span-2 grid grid-cols-2 md:grid-cols-4 gap-6">
            @php
                $ratings = [
                    ['label' => 'Sangat Baik', 'value' => $stats->sangat_baik, 'icon' => 'fa-star', 'color' => 'green'],
                    ['label' => 'Baik', 'value' => $stats->baik, 'icon' => 'fa-thumbs-up', 'color' => 'blue'],
                    ['label' => 'Cukup', 'value' => $stats->cukup, 'icon' => 'fa-meh', 'color' => 'amber'],
                    ['label' => 'Buruk', 'value' => $stats->buruk, 'icon' => 'fa-thumbs-down', 'color' => 'red'],
                ];
            @endphp
            @foreach($ratings as $rating)
            <div class="bg-white rounded-2xl shadow-xl border border-slate-200 p-6 flex flex-col justify-between items-center text-center transform hover:-translate-y-2 transition-transform duration-300">
                <div class="w-16 h-16 rounded-full bg-{{$rating['color']}}-100 text-{{$rating['color']}}-500 flex items-center justify-center text-3xl mb-4">
                    <i class="fa-solid {{$rating['icon']}}"></i>
                </div>
                <p class="text-4xl font-extrabold text-slate-800">{{ $rating['value'] }}</p>
                <p class="text-sm font-bold text-slate-500 mt-1">{{ $rating['label'] }}</p>
            </div>
            @endforeach
        </div>
    </div>
    
    {{-- TABLE & FILTER --}}
    <div class="bg-white rounded-2xl shadow-2xl border border-slate-200 overflow-hidden">
        <div class="p-5 border-b border-slate-200 bg-slate-50/50 flex flex-col md:flex-row justify-between items-center gap-4">
            <h3 class="font-bold text-slate-700 text-lg">Semua Feedback Pengunjung</h3>
            <form method="GET" class="flex items-center gap-3">
                <div class="relative w-full md:w-64">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400"><i class="fa-solid fa-magnifying-glass"></i></span>
                    <input type="text" name="search" value="{{ request('search') }}" class="w-full pl-10 pr-4 py-2 bg-white border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500 transition" placeholder="Cari di saran...">
                </div>
                <div class="relative w-full md:w-48">
                    <select name="rating" class="w-full pl-3 pr-8 py-2 bg-white border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500 transition" onchange="this.form.submit()">
                        <option value="">Semua Rating</option>
                        <option value="4" @selected(request('rating') == 4)>Sangat Baik (4)</option>
                        <option value="3" @selected(request('rating') == 3)>Baik (3)</option>
                        <option value="2" @selected(request('rating') == 2)>Cukup (2)</option>
                        <option value="1" @selected(request('rating') == 1)>Buruk (1)</option>
                    </select>
                </div>
                <a href="{{ route('admin.surveys.index') }}" class="text-slate-500 hover:text-indigo-600 p-2" title="Reset Filter"><i class="fa-solid fa-rotate-left"></i></a>
            </form>
        </div>

        <div class="overflow-x-auto">
            @if($surveys->isEmpty())
                <div class="text-center py-24 text-slate-500">
                    <i class="fa-solid fa-comment-slash text-5xl mb-4"></i>
                    <h3 class="text-xl font-bold">Belum Ada Data Survey</h3>
                    <p class="text-sm mt-1">Data feedback dari pengunjung akan muncul disini.</p>
                </div>
            @else
                <table class="w-full text-left">
                    <thead class="bg-slate-100 text-slate-600 uppercase text-xs font-bold tracking-wider">
                        <tr>
                            <th class="p-4">Penilaian</th>
                            <th class="p-4">Saran & Kritik</th>
                            <th class="p-4">Waktu</th>
                            <th class="p-4 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach($surveys as $survey)
                        <tr class="hover:bg-slate-50/50 transition duration-150">
                            <td class="p-4 w-48 align-top">
                                @php
                                    $ratingInfo = match((int)$survey->rating) {
                                        4 => ['label' => 'Sangat Baik', 'color' => 'green', 'icon' => 'fa-star'],
                                        3 => ['label' => 'Baik', 'color' => 'blue', 'icon' => 'fa-thumbs-up'],
                                        2 => ['label' => 'Cukup', 'color' => 'amber', 'icon' => 'fa-meh'],
                                        1 => ['label' => 'Buruk', 'color' => 'red', 'icon' => 'fa-thumbs-down'],
                                        default => ['label' => 'N/A', 'color' => 'slate', 'icon' => 'fa-question-circle'],
                                    };
                                @endphp
                                <div class="flex items-center gap-3">
                                    <span class="text-xl text-{{$ratingInfo['color']}}-500"><i class="fa-solid {{$ratingInfo['icon']}}"></i></span>
                                    <span class="font-semibold text-sm text-slate-800">{{ $ratingInfo['label'] }}</span>
                                </div>
                            </td>
                            <td class="p-4 max-w-lg">
                                <p class="text-sm text-slate-700 leading-relaxed">{{ $survey->saran ?: 'Tidak ada saran.' }}</p>
                            </td>
                            <td class="p-4 text-xs text-slate-500 align-top whitespace-nowrap">
                                {{ $survey->created_at->diffForHumans() }}<br>
                                <span class="font-mono">{{ $survey->created_at->format('d/m/y H:i') }}</span>
                            </td>
                            <td class="p-4 text-center align-middle">
                                <form action="{{ route('admin.surveys.destroy', $survey->id) }}" method="POST" onsubmit="confirmDelete(event)">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="w-10 h-10 rounded-lg bg-red-100 hover:bg-red-200 text-red-600 transition-all duration-300 transform hover:scale-110" title="Hapus">
                                        <i class="fa-solid fa-trash-alt"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>

        @if($surveys->hasPages())
        <div class="p-4 border-t border-slate-200 bg-slate-50">
            {{ $surveys->links() }}
        </div>
        @endif
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const stats = @json($stats);
    const labels = ['Sangat Baik', 'Baik', 'Cukup', 'Buruk'];
    const data = [stats.sangat_baik, stats.baik, stats.cukup, stats.buruk];

    const ctx = document.getElementById('surveyChart');
    if (ctx) {
        new Chart(ctx.getContext('2d'), {
            type: 'doughnut',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Jumlah Penilaian',
                    data: data,
                    backgroundColor: ['#22c55e', '#3b82f6', '#f59e0b', '#ef4444'],
                    borderColor: '#ffffff',
                    borderWidth: 4,
                    hoverOffset: 16,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '70%',
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            padding: 20,
                            font: { family: 'Inter', size: 12 },
                            usePointStyle: true,
                            pointStyle: 'circle',
                        }
                    },
                    tooltip: {
                        padding: 12,
                        boxPadding: 5,
                        titleFont: { weight: 'bold', family: 'Inter' },
                        bodyFont: { family: 'Inter' },
                    }
                },
                animation: {
                    animateRotate: true,
                    animateScale: true,
                    duration: 1000,
                }
            }
        });
    }
});
</script>
@endpush
