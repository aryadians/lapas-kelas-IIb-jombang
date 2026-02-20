@extends('layouts.admin')

@php
    use App\Enums\KunjunganStatus;
@endphp

@section('content')
{{-- Load Animate.css & FontAwesome --}}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>

<style>
    /* Modern UI Refinements */
    .glass-card {
        background: rgba(255, 255, 255, 0.8);
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
        border: 1px solid rgba(255, 255, 255, 0.3);
        box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.07);
    }
    
    .badge-status {
        @apply px-3 py-1.5 rounded-full text-[10px] font-black uppercase tracking-wider flex items-center gap-1.5 w-fit shadow-sm border;
    }

    /* Animation Delay */
    .delay-1 { animation-delay: 0.1s; }
    .delay-2 { animation-delay: 0.2s; }
    .delay-3 { animation-delay: 0.3s; }

    /* Custom Scrollbar for Table */
    .custom-scrollbar::-webkit-scrollbar { height: 6px; }
    .custom-scrollbar::-webkit-scrollbar-track { background: #f1f5f9; }
    .custom-scrollbar::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
    
    .antrian-pill {
        @apply bg-slate-900 text-white font-black px-3 py-1 rounded-lg text-sm shadow-lg shadow-slate-900/20 border border-slate-800;
    }

    /* PREMIUM ACTION BUTTONS */
    .btn-action-premium {
        @apply w-10 h-10 rounded-2xl flex items-center justify-center transition-all duration-300 border shadow-sm relative overflow-hidden group/btn active:scale-90;
    }
    
    .btn-view { @apply bg-white text-blue-500 border-blue-100 hover:bg-blue-500 hover:text-white hover:border-blue-500 hover:shadow-blue-200; }
    .btn-edit { @apply bg-white text-emerald-500 border-emerald-100 hover:bg-emerald-500 hover:text-white hover:border-emerald-500 hover:shadow-emerald-200; }
    .btn-done { @apply bg-white text-indigo-500 border-indigo-100 hover:bg-indigo-500 hover:text-white hover:border-indigo-500 hover:shadow-indigo-200; }
    .btn-delete { @apply bg-white text-red-500 border-red-100 hover:bg-red-500 hover:text-white hover:border-red-500 hover:shadow-red-200; }

    .btn-action-premium i { @apply transition-transform duration-300 group-hover/btn:scale-110; }
</style>

<div class="space-y-10 pb-16">

    {{-- HEADER & QUICK ACTIONS --}}
    <header class="flex flex-col xl:flex-row justify-between items-start xl:items-center gap-6 animate__animated animate__fadeInDown">
        <div class="space-y-1">
            <div class="flex items-center gap-2 text-blue-600 font-bold text-xs uppercase tracking-widest">
                <i class="fas fa-list-ul"></i>
                <span>Manajemen Data</span>
            </div>
            <h1 class="text-4xl font-black text-slate-900 tracking-tighter">
                Daftar Kunjungan
            </h1>
            <div class="flex items-center gap-2 text-slate-500 font-medium">
                <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                Monitoring data kunjungan secara real-time
            </div>
        </div>
        
        <div class="flex flex-wrap items-center gap-3 w-full xl:w-auto">
            <div class="flex items-center gap-2 bg-white p-1.5 rounded-2xl shadow-sm border border-slate-200">
                <button onclick="window.print()" class="p-2.5 text-slate-500 hover:text-blue-600 hover:bg-blue-50 rounded-xl transition-all" title="Cetak Laporan">
                    <i class="fas fa-print text-lg"></i>
                </button>
                <div class="w-px h-6 bg-slate-200"></div>
                <button type="button" id="openExportModal" class="flex items-center gap-2 px-4 py-2.5 text-emerald-600 font-bold text-sm hover:bg-emerald-50 rounded-xl transition-all">
                    <i class="fas fa-file-excel"></i>
                    <span>Export</span>
                </button>
            </div>

            <div class="flex items-center gap-2">
                <a href="{{ route('admin.kunjungan.verifikasi') }}" class="flex items-center gap-2 bg-slate-900 hover:bg-black text-white px-6 py-3.5 rounded-2xl shadow-xl shadow-slate-900/20 transition-all active:scale-95 text-sm font-bold uppercase tracking-tight">
                    <i class="fas fa-qrcode text-lg text-blue-400"></i>
                    <span>Scan QR</span>
                </a>

                <a href="{{ route('admin.kunjungan.createOffline') }}" class="flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-6 py-3.5 rounded-2xl shadow-xl shadow-blue-600/20 transition-all active:scale-95 text-sm font-bold uppercase tracking-tight">
                    <i class="fas fa-plus-circle text-lg"></i>
                    <span>Daftar Offline</span>
                </a>
            </div>
        </div>
    </header>

    {{-- STATS GRID --}}
    <div x-data="dashboardStats()" x-init="init()" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 no-print">
        <div class="bg-white p-6 rounded-[2rem] shadow-xl shadow-slate-200/50 border border-slate-100 flex items-center gap-5 group hover:-translate-y-1 transition-all duration-300 animate__animated animate__fadeInUp delay-1">
            <div class="w-14 h-14 rounded-2xl bg-blue-50 flex items-center justify-center text-blue-600 group-hover:scale-110 transition-transform shadow-inner text-xl">
                <i class="fas fa-calendar-day"></i>
            </div>
            <div>
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Kunjungan Hari Ini</p>
                <p class="text-3xl font-black text-slate-900 tracking-tighter" x-text="stats.total">{{ $statsToday['total'] }}</p>
            </div>
        </div>

        <div class="bg-white p-6 rounded-[2rem] shadow-xl shadow-slate-200/50 border border-slate-100 flex items-center gap-5 group hover:-translate-y-1 transition-all duration-300 animate__animated animate__fadeInUp delay-2">
            <div class="w-14 h-14 rounded-2xl bg-amber-50 flex items-center justify-center text-amber-600 group-hover:scale-110 transition-transform shadow-inner text-xl">
                <i class="fas fa-clock"></i>
            </div>
            <div>
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Perlu Verifikasi</p>
                <p class="text-3xl font-black text-slate-900 tracking-tighter" x-text="stats.pending">{{ $statsToday['pending'] }}</p>
            </div>
        </div>

        <div class="bg-white p-6 rounded-[2rem] shadow-xl shadow-slate-200/50 border border-slate-100 flex items-center gap-5 group hover:-translate-y-1 transition-all duration-300 animate__animated animate__fadeInUp delay-3">
            <div class="w-14 h-14 rounded-2xl bg-indigo-50 flex items-center justify-center text-indigo-600 group-hover:scale-110 transition-transform shadow-inner text-xl">
                <i class="fas fa-user-friends"></i>
            </div>
            <div>
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Sedang Dilayani</p>
                <p class="text-3xl font-black text-slate-900 tracking-tighter" x-text="stats.serving">{{ $statsToday['serving'] }}</p>
            </div>
        </div>

        <div class="bg-white p-6 rounded-[2rem] shadow-xl shadow-slate-200/50 border border-slate-100 flex items-center gap-5 group hover:-translate-y-1 transition-all duration-300 animate__animated animate__fadeInUp delay-4">
            <div class="w-14 h-14 rounded-2xl bg-emerald-50 flex items-center justify-center text-emerald-600 group-hover:scale-110 transition-transform shadow-inner text-xl">
                <i class="fas fa-users"></i>
            </div>
            <div>
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Sisa Kuota Offline</p>
                <p class="text-3xl font-black text-slate-900 tracking-tighter" x-text="stats.sisa_kuota_total">0</p>
            </div>
        </div>
    </div>

    {{-- FILTER SECTION --}}
    <div class="bg-white rounded-[2.5rem] shadow-2xl shadow-slate-200/60 border border-slate-100 p-8 animate__animated animate__fadeInUp">
        <form action="{{ route('admin.kunjungan.index') }}" method="GET" class="space-y-8">
            <div class="flex flex-col lg:flex-row gap-6">
                <div class="flex-grow relative group">
                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ml-4 mb-2 block">Pencarian Data</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none">
                            <i class="fas fa-search text-slate-300 group-focus-within:text-blue-500 transition-colors"></i>
                        </div>
                        <input type="text" name="search" value="{{ request('search') }}" 
                            class="w-full pl-14 pr-6 py-4 bg-slate-50 border-2 border-slate-50 rounded-2xl focus:bg-white focus:border-blue-500 focus:ring-0 transition-all font-bold text-slate-700 placeholder-slate-300" 
                            placeholder="Cari Nama Pengunjung, NIK, atau Nama WBP...">
                    </div>
                </div>
                
                <div class="lg:w-72">
                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ml-4 mb-2 block">Filter Tanggal</label>
                    <input type="date" name="tanggal_kunjungan" value="{{ request('tanggal_kunjungan') }}" 
                        class="w-full px-6 py-4 bg-slate-50 border-2 border-slate-50 rounded-2xl focus:bg-white focus:border-blue-500 focus:ring-0 font-bold text-slate-600">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 pt-6 border-t border-slate-50">
                <div class="space-y-2">
                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-4 block">Status Kunjungan</label>
                    <select name="status" class="w-full px-6 py-4 bg-slate-50 border-2 border-slate-50 rounded-2xl focus:bg-white focus:border-blue-500 focus:ring-0 font-bold text-slate-600 transition-all">
                        <option value="">Semua Status</option>
                        @foreach([
                            'pending' => '⏳ Menunggu',
                            'approved' => '✅ Disetujui',
                            'called' => '📣 Dipanggil',
                            'in_progress' => '▶️ Sedang Berlangsung',
                            'rejected' => '❌ Ditolak',
                            'completed' => '🏁 Selesai'
                        ] as $val => $label)
                            <option value="{{ $val }}" {{ request('status') == $val ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="space-y-2">
                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-4 block">Sesi Waktu</label>
                    <select name="sesi" class="w-full px-6 py-4 bg-slate-50 border-2 border-slate-50 rounded-2xl focus:bg-white focus:border-blue-500 focus:ring-0 font-bold text-slate-600 transition-all">
                        <option value="">Semua Sesi</option>
                        <option value="pagi" {{ request('sesi') == 'pagi' ? 'selected' : '' }}>🌅 Sesi Pagi</option>
                        <option value="siang" {{ request('sesi') == 'siang' ? 'selected' : '' }}>☀️ Sesi Siang</option>
                    </select>
                </div>

                <div class="flex items-end gap-3">
                    <button type="submit" class="flex-grow bg-slate-900 hover:bg-black text-white font-black py-4 rounded-2xl shadow-xl shadow-slate-900/20 transition-all active:scale-95 uppercase tracking-widest text-xs">
                        Terapkan Filter
                    </button>
                    <a href="{{ route('admin.kunjungan.index') }}" class="px-6 py-4 bg-slate-100 text-slate-500 hover:bg-slate-200 font-bold rounded-2xl transition-all active:scale-95" title="Reset Filter">
                        <i class="fas fa-undo"></i>
                    </a>
                </div>
            </div>
        </form>
    </div>

    {{-- BULK & TABLE SECTION --}}
    <form id="bulk-action-form" method="POST" class="space-y-6">
        @csrf
        
        <div class="flex flex-col md:flex-row items-center justify-between gap-4 px-4">
            <div class="flex items-center gap-4 bg-white px-6 py-3 rounded-2xl shadow-sm border border-slate-100">
                <input type="checkbox" id="selectAll" class="w-5 h-5 rounded-lg border-2 border-slate-200 text-blue-600 focus:ring-blue-500 cursor-pointer transition-all">
                <label for="selectAll" class="font-black text-slate-700 text-xs uppercase tracking-widest cursor-pointer select-none">Pilih Semua</label>
            </div>

            <div id="bulkActionBar" class="hidden animate__animated animate__fadeInRight flex flex-wrap items-center gap-2 bg-slate-900 p-1.5 rounded-2xl shadow-2xl">
                <div class="px-4 py-2 border-r border-slate-700">
                    <span class="text-[10px] font-black text-blue-400 uppercase tracking-widest"><span id="selectedCount">0</span> Item</span>
                </div>
                
                @foreach([
                    ['type' => 'approved', 'color' => 'emerald', 'icon' => 'check', 'label' => 'Setuju'],
                    ['type' => 'rejected', 'color' => 'amber', 'icon' => 'times', 'label' => 'Tolak'],
                    ['type' => 'completed', 'color' => 'blue', 'icon' => 'flag-checkered', 'label' => 'Selesai'],
                    ['type' => 'delete', 'color' => 'red', 'icon' => 'trash-alt', 'label' => 'Hapus']
                ] as $btn)
                    <button type="button" onclick="submitBulkAction('{{ $btn['type'] }}')" 
                        class="flex items-center gap-2 px-4 py-2 hover:bg-slate-800 text-{{ $btn['color'] }}-400 hover:text-{{ $btn['color'] }}-300 text-[10px] font-black uppercase tracking-widest rounded-xl transition-all">
                        <i class="fas fa-{{ $btn['icon'] }}"></i> {{ $btn['label'] }}
                    </button>
                @endforeach
            </div>
        </div>

        <div class="bg-white rounded-[2.5rem] shadow-xl shadow-slate-200/50 border border-slate-100 overflow-hidden animate__animated animate__fadeInUp">
            <div class="overflow-x-auto custom-scrollbar">
                <table class="w-full text-sm text-left">
                    <thead>
                        <tr class="bg-slate-50/50 border-b border-slate-100 uppercase tracking-widest text-[10px] font-black text-slate-400">
                            <th class="p-6 w-10"></th>
                            <th class="px-6 py-5">Informasi Pengunjung</th>
                            <th class="px-6 py-5">Tujuan (WBP)</th>
                            <th class="px-6 py-5">Jadwal & Sesi</th>
                            <th class="px-6 py-5">Status</th>
                            <th class="px-6 py-5 text-center">No. Antrian</th>
                            <th class="px-6 py-5 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @forelse ($kunjungans as $kunjungan)
                        <tr class="group hover:bg-slate-50/50 transition-colors">
                            <td class="p-6">
                                <input type="checkbox" name="ids[]" class="kunjungan-checkbox w-5 h-5 rounded-lg border-2 border-slate-200 text-blue-600 focus:ring-blue-500 cursor-pointer transition-all" value="{{ $kunjungan->id }}">
                            </td>
                            <td class="px-6 py-6">
                                <div class="space-y-1.5">
                                    <div class="font-black text-slate-800 text-base tracking-tight leading-none">{{ $kunjungan->nama_pengunjung }}</div>
                                    <div class="flex items-center gap-2 text-[11px] font-bold text-slate-400 uppercase tracking-wider">
                                        <i class="fas fa-id-card text-slate-300"></i> {{ $kunjungan->nik_ktp }}
                                    </div>
                                    @if(!empty($kunjungan->foto_ktp_url))
                                        <a data-fslightbox="gallery" href="{{ $kunjungan->foto_ktp_url }}" 
                                           class="inline-flex items-center gap-1.5 px-3 py-1 bg-slate-100 text-slate-600 rounded-lg text-[10px] font-black uppercase tracking-tighter hover:bg-slate-900 hover:text-white transition-all no-print">
                                            <i class="fas fa-camera"></i> KTP
                                        </a>
                                    @endif
                                </div>
                            </td>
                            <td class="px-6 py-6">
                                <div class="space-y-1">
                                    <div class="font-black text-slate-700 tracking-tight">{{ $kunjungan->wbp->nama ?? 'N/A' }}</div>
                                    <div class="text-[10px] font-black text-slate-400 uppercase bg-slate-50 px-2 py-0.5 rounded border border-slate-100 w-fit">{{ $kunjungan->hubungan }}</div>
                                </div>
                            </td>
                            <td class="px-6 py-6">
                                <div class="space-y-1">
                                    <div class="font-black text-slate-700 tracking-tight">{{ \Carbon\Carbon::parse($kunjungan->tanggal_kunjungan)->translatedFormat('d M Y') }}</div>
                                    <div class="flex items-center gap-1.5">
                                        @if($kunjungan->sesi == 'pagi')
                                            <span class="w-2 h-2 rounded-full bg-orange-400"></span>
                                            <span class="text-[10px] font-black text-orange-600 uppercase">Sesi Pagi</span>
                                        @else
                                            <span class="w-2 h-2 rounded-full bg-blue-400"></span>
                                            <span class="text-[10px] font-black text-blue-600 uppercase">Sesi Siang</span>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-6">
                                @php
                                    $statusConfig = [
                                        KunjunganStatus::APPROVED->value => ['bg' => 'emerald-50', 'text' => 'emerald-600', 'border' => 'emerald-100', 'icon' => 'check-circle', 'label' => 'Disetujui'],
                                        KunjunganStatus::CALLED->value => ['bg' => 'yellow-50', 'text' => 'yellow-700', 'border' => 'yellow-100', 'icon' => 'bullhorn', 'label' => 'Dipanggil'],
                                        KunjunganStatus::IN_PROGRESS->value => ['bg' => 'sky-50', 'text' => 'sky-700', 'border' => 'sky-100', 'icon' => 'hourglass-start', 'label' => 'Melayani'],
                                        KunjunganStatus::REJECTED->value => ['bg' => 'red-50', 'text' => 'red-600', 'border' => 'red-100', 'icon' => 'times-circle', 'label' => 'Ditolak'],
                                        KunjunganStatus::COMPLETED->value => ['bg' => 'slate-50', 'text' => 'slate-600', 'border' => 'slate-100', 'icon' => 'flag-checkered', 'label' => 'Selesai'],
                                        KunjunganStatus::PENDING->value => ['bg' => 'amber-50', 'text' => 'amber-700', 'border' => 'amber-100', 'icon' => 'clock', 'label' => 'Menunggu']
                                    ];
                                    $conf = $statusConfig[$kunjungan->status->value] ?? $statusConfig['pending'];
                                @endphp
                                <span class="badge-status bg-{{ $conf['bg'] }} text-{{ $conf['text'] }} border-{{ $conf['border'] }}">
                                    <i class="fas fa-{{ $conf['icon'] }}"></i> {{ $conf['label'] }}
                                </span>
                            </td>
                            <td class="px-6 py-6 text-center">
                                @if($kunjungan->nomor_antrian_harian)
                                    <div class="antrian-pill inline-block">
                                        {{ $kunjungan->registration_type === 'offline' ? 'B' : 'A' }}-{{ str_pad($kunjungan->nomor_antrian_harian, 3, '0', STR_PAD_LEFT) }}
                                    </div>
                                @else
                                    <span class="text-[10px] font-black text-slate-300 italic">N/A</span>
                                @endif
                            </td>
                            <td class="px-6 py-6 no-print">
                                <div class="flex items-center justify-center gap-2">
                                    {{-- VIEW --}}
                                    <a href="{{ route('admin.kunjungan.show', $kunjungan->id) }}" class="btn-action-premium btn-view" title="Detail">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    
                                    @if($kunjungan->status == KunjunganStatus::PENDING)
                                        {{-- VERIFY --}}
                                        <a href="{{ route('admin.kunjungan.edit', $kunjungan->id) }}" class="btn-action-premium btn-edit" title="Verifikasi">
                                            <i class="fas fa-user-check"></i>
                                        </a>
                                    @elseif(in_array($kunjungan->status, [KunjunganStatus::APPROVED, KunjunganStatus::CALLED, KunjunganStatus::IN_PROGRESS]))
                                        {{-- DONE --}}
                                        <button type="button" onclick="submitSingleAction('{{ route('admin.kunjungan.update', $kunjungan->id) }}', 'completed', 'PATCH')" 
                                            class="btn-action-premium btn-done" title="Selesai">
                                            <i class="fas fa-check-double"></i>
                                        </button>
                                    @endif

                                    {{-- DELETE --}}
                                    <button type="button" onclick="submitSingleAction('{{ route('admin.kunjungan.destroy', $kunjungan->id) }}', 'delete', 'DELETE')" 
                                        class="btn-action-premium btn-delete" title="Hapus">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="py-32 text-center">
                                <div class="w-20 h-20 bg-slate-50 rounded-[2rem] flex items-center justify-center mx-auto border-2 border-dashed border-slate-200 mb-6 text-slate-200">
                                    <i class="fas fa-search text-3xl"></i>
                                </div>
                                <h3 class="text-lg font-black text-slate-800 tracking-tight uppercase">Data Tidak Ditemukan</h3>
                                <p class="text-slate-400 mt-1 font-bold text-xs">Sesuaikan kata kunci atau filter pencarian Anda.</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </form>

    {{-- PAGINATION --}}
    @if ($kunjungans->hasPages())
    <div class="flex justify-center pt-10">
        <div class="bg-white p-3 rounded-3xl shadow-xl shadow-slate-200/50 border border-slate-100">
            {{ $kunjungans->links() }}
        </div>
    </div>
    @endif

</div>

{{-- EXPORT MODAL --}}
<div id="exportModal" class="fixed inset-0 z-50 hidden overflow-y-auto no-print" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 bg-slate-900/90 backdrop-blur-sm transition-opacity" aria-hidden="true"></div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
        <div class="inline-block align-bottom bg-white rounded-[3rem] text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg w-full border border-slate-100">
            <div class="bg-white px-10 py-8 border-b border-slate-50 flex justify-between items-center">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-2xl bg-emerald-50 flex items-center justify-center text-emerald-600 shadow-inner">
                        <i class="fas fa-file-export text-xl"></i>
                    </div>
                    <div>
                        <h3 class="text-2xl font-black text-slate-800 tracking-tighter">Export Data</h3>
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Pilih parameter laporan</p>
                    </div>
                </div>
                <button type="button" id="closeExportModal" class="w-10 h-10 rounded-full hover:bg-slate-100 flex items-center justify-center transition-colors">
                    <i class="fas fa-times text-slate-400"></i>
                </button>
            </div>
            <div class="px-10 py-10">
                <form id="exportForm" action="{{ route('admin.kunjungan.export') }}" method="GET">
                    <div class="space-y-8">
                        <div>
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3 ml-4">Format Dokumen</label>
                            <div class="grid grid-cols-2 gap-4">
                                <label class="cursor-pointer">
                                    <input type="radio" name="type" value="excel" class="peer sr-only" checked>
                                    <div class="p-4 bg-slate-50 border-2 border-slate-50 rounded-2xl text-center font-bold text-slate-500 peer-checked:border-emerald-500 peer-checked:bg-emerald-50 peer-checked:text-emerald-600 transition-all">
                                        <i class="fas fa-file-excel mb-2 text-xl block"></i> Excel
                                    </div>
                                </label>
                                <label class="cursor-pointer">
                                    <input type="radio" name="type" value="csv" class="peer sr-only">
                                    <div class="p-4 bg-slate-50 border-2 border-slate-50 rounded-2xl text-center font-bold text-slate-500 peer-checked:border-emerald-500 peer-checked:bg-emerald-50 peer-checked:text-emerald-600 transition-all">
                                        <i class="fas fa-file-csv mb-2 text-xl block"></i> CSV
                                    </div>
                                </label>
                            </div>
                        </div>
                        
                        <div>
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3 ml-4">Rentang Waktu</label>
                            <select id="modal_export_period" name="period" class="w-full px-6 py-4 bg-slate-50 border-2 border-slate-50 rounded-2xl focus:bg-white focus:border-emerald-500 focus:ring-0 transition-all font-bold text-slate-600">
                                <option value="all">Seluruh Riwayat</option>
                                <option value="day">Harian</option>
                                <option value="week">Mingguan</option>
                                <option value="month">Bulanan</option>
                            </select>
                        </div>

                        <div id="modal_export_date_container" class="hidden animate__animated animate__fadeIn">
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3 ml-4">Pilih Tanggal Acuan</label>
                            <input type="date" name="date" class="w-full px-6 py-4 bg-slate-50 border-2 border-slate-50 rounded-2xl focus:bg-white focus:border-emerald-500 focus:ring-0 transition-all font-bold text-slate-600" value="{{ date('Y-m-d') }}">
                        </div>
                    </div>
                </form>
            </div>
            <div class="bg-slate-50 px-10 py-8 flex flex-col gap-3">
                <button type="submit" form="exportForm" class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-black py-5 rounded-[1.5rem] shadow-xl shadow-emerald-900/30 transition-all active:scale-95 flex items-center justify-center gap-3 uppercase tracking-widest text-xs">
                    Download Laporan
                </button>
            </div>
        </div>
    </div>
</div>

{{-- HIDDEN FORM FOR SINGLE ACTION --}}
<form id="single-action-form" method="POST" class="hidden">
    @csrf
    <input type="hidden" name="_method" id="single_method">
    <input type="hidden" name="status" id="single_status">
</form>

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/fslightbox/3.4.1/index.min.js"></script>
<script>
// --- LOGIC SINGLE ACTION ---
function submitSingleAction(url, actionType, method) {
    const form = document.getElementById('single-action-form');
    const methodInput = document.getElementById('single_method');
    const statusInput = document.getElementById('single_status');

    let title, text, icon, btnColor, btnText;

    if(actionType === 'delete') {
        title = 'Hapus Data?';
        text = "Data akan dihapus permanen dari sistem.";
        icon = 'warning';
        btnColor = 'px-8 py-3 bg-red-600 hover:bg-red-700 text-white font-black rounded-2xl transition-all shadow-xl shadow-red-500/30 uppercase text-xs tracking-widest';
        btnText = 'Ya, Hapus';
    } else if (actionType === 'completed') {
        title = 'Tandai Selesai?';
        text = "Status kunjungan akan diubah menjadi Selesai.";
        icon = 'question';
        btnColor = 'px-8 py-3 bg-blue-600 hover:bg-blue-700 text-white font-black rounded-2xl transition-all shadow-xl shadow-blue-500/30 uppercase text-xs tracking-widest';
        btnText = 'Ya, Selesaikan';
    } else {
        title = actionType === 'approved' ? 'Setujui?' : 'Tolak?';
        text = "Notifikasi status akan dikirimkan ke pengunjung.";
        icon = 'question';
        btnColor = actionType === 'approved' 
            ? 'px-8 py-3 bg-emerald-600 hover:bg-emerald-700 text-white font-black rounded-2xl transition-all shadow-xl shadow-emerald-500/30 uppercase text-xs tracking-widest' 
            : 'px-8 py-3 bg-amber-500 hover:bg-amber-600 text-white font-black rounded-2xl transition-all shadow-xl shadow-amber-500/30 uppercase text-xs tracking-widest';
        btnText = 'Ya, Lanjutkan';
    }

    Swal.fire({
        ...swalTheme,
        title: title,
        text: text,
        icon: icon,
        showCancelButton: true,
        confirmButtonText: btnText,
        cancelButtonText: 'Batal',
        customClass: {
            ...swalTheme.customClass,
            confirmButton: btnColor,
            cancelButton: 'px-8 py-3 bg-slate-100 text-slate-500 font-bold rounded-2xl hover:bg-slate-200'
        }
    }).then((result) => {
        if (result.isConfirmed) {
            form.action = url;
            methodInput.value = method;
            statusInput.value = actionType === 'delete' ? '' : actionType;
            form.submit();
        }
    });
}

// --- BULK ACTION ---
function submitBulkAction(actionType) {
    const form = document.getElementById('bulk-action-form');
    const count = document.querySelectorAll('.kunjungan-checkbox:checked').length;

    if(count === 0) return;

    let url, title, text, icon, btnColor, btnText;

    if(actionType === 'delete') {
        url = "{{ route('admin.kunjungan.bulk-delete') }}";
        title = `Hapus ${count} Data?`;
        text = "Seluruh data terpilih akan dihapus permanen.";
        icon = 'warning';
        btnColor = 'px-8 py-3 bg-red-600 hover:bg-red-700 text-white font-black rounded-2xl transition-all shadow-xl shadow-red-500/30 uppercase text-xs tracking-widest';
        btnText = 'Ya, Hapus Masal';
    } else {
        url = "{{ route('admin.kunjungan.bulk-update') }}";
        icon = 'question';
        title = `Proses ${count} Data?`;
        text = `Ubah status data terpilih menjadi ${actionType}.`;
        btnColor = 'px-8 py-3 bg-slate-900 hover:bg-black text-white font-black rounded-2xl transition-all shadow-xl shadow-slate-900/30 uppercase text-xs tracking-widest';
        btnText = 'Ya, Update Masal';
        
        const oldInput = document.getElementById('bulk_status_input');
        if(oldInput) oldInput.remove();

        const input = document.createElement('input');
        input.type = 'hidden';
        input.name = 'status';
        input.value = actionType;
        input.id = 'bulk_status_input';
        form.appendChild(input);
    }

    Swal.fire({
        ...swalTheme,
        title: title,
        text: text,
        icon: icon,
        showCancelButton: true,
        confirmButtonText: btnText,
        cancelButtonText: 'Batal',
        customClass: {
            ...swalTheme.customClass,
            confirmButton: btnColor,
            cancelButton: 'px-8 py-3 bg-slate-100 text-slate-500 font-bold rounded-2xl hover:bg-slate-200'
        }
    }).then((result) => {
        if (result.isConfirmed) {
            form.action = url;
            form.submit();
        }
    });
}

document.addEventListener('DOMContentLoaded', function() {
    // CHECKBOX LOGIC
    const selectAll = document.getElementById('selectAll');
    const checkboxes = document.querySelectorAll('.kunjungan-checkbox');
    const bulkBar = document.getElementById('bulkActionBar');
    const countSpan = document.getElementById('selectedCount');

    function toggleBulkBar() {
        const count = document.querySelectorAll('.kunjungan-checkbox:checked').length;
        if(countSpan) countSpan.textContent = count;
        if(bulkBar) {
            if(count > 0) {
                bulkBar.classList.remove('hidden');
                bulkBar.classList.add('flex');
            } else {
                bulkBar.classList.add('hidden');
                bulkBar.classList.remove('flex');
            }
        }
    }

    if(selectAll) {
        selectAll.addEventListener('change', function() {
            checkboxes.forEach(cb => cb.checked = this.checked);
            toggleBulkBar();
        });
    }

    checkboxes.forEach(cb => {
        cb.addEventListener('change', function() {
            if(!this.checked && selectAll) selectAll.checked = false;
            toggleBulkBar();
        });
    });

    // EXPORT MODAL
    const openExportModalBtn = document.getElementById('openExportModal');
    const closeExportModalBtn = document.getElementById('closeExportModal');
    const exportModal = document.getElementById('exportModal');
    const modalExportPeriodSelect = document.getElementById('modal_export_period');
    const modalExportDateContainer = document.getElementById('modal_export_date_container');

    function toggleModalExportDateInput() {
        if (modalExportPeriodSelect && modalExportDateContainer) {
            if (['day', 'week', 'month'].includes(modalExportPeriodSelect.value)) {
                modalExportDateContainer.classList.remove('hidden');
            } else {
                modalExportDateContainer.classList.add('hidden');
            }
        }
    }

    if (openExportModalBtn && exportModal) {
        openExportModalBtn.addEventListener('click', () => {
            exportModal.classList.remove('hidden');
            toggleModalExportDateInput();
        });
    }

    if (closeExportModalBtn && exportModal) {
        closeExportModalBtn.addEventListener('click', () => exportModal.classList.add('hidden'));
    }
    
    if (modalExportPeriodSelect) {
        modalExportPeriodSelect.addEventListener('change', toggleModalExportDateInput);
    }
});

function dashboardStats() {
    return {
        stats: {
            total: {{ $statsToday['total'] }},
            pending: {{ $statsToday['pending'] }},
            serving: {{ $statsToday['serving'] }},
            sisa_kuota_total: 0
        },
        init() {
            this.updateStats();
            setInterval(() => this.updateStats(), 15000);
        },
        updateStats() {
            fetch('{{ route('admin.kunjungan.stats') }}')
                .then(response => response.json())
                .then(data => { this.stats = data; })
                .catch(error => console.error('Error fetching dashboard stats:', error));
        }
    }
}
</script>
@endpush
@endsection
