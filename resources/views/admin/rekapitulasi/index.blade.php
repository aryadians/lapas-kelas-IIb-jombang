@extends('layouts.admin')

@section('content')
<div class="space-y-8">
    <div class="relative bg-gradient-to-r from-slate-900 via-blue-900 to-indigo-900 rounded-[2rem] p-8 md:p-10 text-white shadow-2xl">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-4xl md:text-5xl font-extrabold tracking-tight leading-tight">Rekapitulasi Kunjungan</h1>
                <p class="text-blue-100/80 mt-3 text-lg font-light max-w-xl leading-relaxed">
                    Analisis data kunjungan, demografi pengunjung, dan WBP paling sering dikunjungi.
                </p>
            </div>
            <div class="flex-shrink-0">
                <!-- Custom Dropdown with Alpine.js -->
                <div x-data="{ open: false, selected: '{{ ucfirst(request('registration_type', 'all')) }}' }" class="relative">
                    <!-- Label -->
                    <label for="registration_type_filter" class="text-sm font-medium text-blue-200">Jenis Pendaftaran</label>
                    
                    <!-- Dropdown Button -->
                    <button @click="open = !open" id="registration_type_filter" class="flex items-center justify-between w-48 mt-1 px-4 py-2 bg-slate-800/50 border border-slate-700 text-white rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-opacity-75 transition-transform transform hover:scale-105">
                        <span x-text="selected"></span>
                        <svg class="w-5 h-5 ml-2 -mr-1 text-slate-400" fill="currentColor" viewBox="0 0 20 20" :class="{'rotate-180': open}">
                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </button>

                    <!-- Dropdown Panel -->
                    <div x-show="open"
                         @click.away="open = false"
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="transform opacity-0 scale-95"
                         x-transition:enter-end="transform opacity-100 scale-100"
                         x-transition:leave="transition ease-in duration-150"
                         x-transition:leave-start="transform opacity-100 scale-100"
                         x-transition:leave-end="transform opacity-0 scale-95"
                         class="absolute z-10 w-48 mt-2 origin-top-right bg-slate-800 rounded-md shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none"
                         style="display: none;">
                        <div class="py-1">
                            <a href="{{ route('admin.rekapitulasi', ['registration_type' => 'all']) }}" class="block px-4 py-2 text-sm text-slate-300 hover:bg-blue-600 hover:text-white">Semua</a>
                            <a href="{{ route('admin.rekapitulasi', ['registration_type' => 'online']) }}" class="block px-4 py-2 text-sm text-slate-300 hover:bg-blue-600 hover:text-white">Online</a>
                            <a href="{{ route('admin.rekapitulasi', ['registration_type' => 'offline']) }}" class="block px-4 py-2 text-sm text-slate-300 hover:bg-blue-600 hover:text-white">Offline</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        {{-- Gender Chart --}}
        <div class="glass-panel p-6 rounded-2xl shadow-sm">
            <h3 class="text-xl font-bold text-slate-800 mb-2">Demografi Pengunjung Utama</h3>
            <p class="text-sm text-slate-500 mb-6">Berdasarkan gender pendaftar (tidak termasuk pengikut).</p>
            <div class="h-80 w-full">
                <canvas id="genderChart"></canvas>
            </div>
        </div>

        {{-- Busiest Session Chart --}}
        <div class="glass-panel p-6 rounded-2xl shadow-sm">
            <h3 class="text-xl font-bold text-slate-800 mb-2">Sesi Kunjungan Terpadat</h3>
            <p class="text-sm text-slate-500 mb-6">Berdasarkan jumlah pendaftar yang disetujui per sesi.</p>
            <div class="h-80 w-full">
                <canvas id="busiestSessionChart"></canvas>
            </div>
        </div>
    </div>

    <div class="mt-8">
        {{-- Most Visited WBP Table --}}
        <div class="glass-panel p-6 rounded-2xl shadow-sm">
            <h3 class="text-xl font-bold text-slate-800 mb-4">Top 10 WBP Paling Sering Dikunjungi</h3>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-200">
                    <thead class="bg-slate-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">#</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Nama WBP</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">No. Registrasi</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Blok/Kamar</th>
                            <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-slate-500 uppercase tracking-wider">Jml Kunjungan</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-slate-200">
                        @forelse ($mostVisitedWbp as $wbp)
                            <tr class="hover:bg-slate-50 transition-colors duration-150">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-slate-600">{{ $loop->iteration }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-800 font-semibold">{{ $wbp->nama }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-500 font-mono">{{ $wbp->no_registrasi }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-500">{{ $wbp->blok ?? '-' }} / {{ $wbp->kamar ?? '-'}}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-md text-blue-600 font-black text-center">{{ $wbp->visit_count }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-10 text-slate-500">
                                    <div class="flex flex-col items-center">
                                        <i class="fas fa-box-open text-4xl text-slate-300 mb-3"></i>
                                        <span>Data kunjungan (approved) belum tersedia.</span>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', () => {
    // Chart 1: Gender
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

    // Chart 2: Busiest Sessions
    const busiestSessionCtx = document.getElementById('busiestSessionChart')?.getContext('2d');
    if (busiestSessionCtx) {
        new Chart(busiestSessionCtx, {
            type: 'bar',
            data: {
                labels: {!! json_encode($sessionCounts->keys()) !!},
                datasets: [{
                    label: 'Jumlah Kunjungan',
                    data: {!! json_encode($sessionCounts->values()) !!},
                    backgroundColor: 'rgba(22, 163, 74, 0.7)',
                    borderColor: 'rgba(22, 163, 74, 1)',
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
});
</script>
@endsection
