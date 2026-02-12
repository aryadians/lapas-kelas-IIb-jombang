@extends('layouts.admin')

@php
    use App\Enums\KunjunganStatus;
@endphp

@section('content')
{{-- Load Animate.css & FontAwesome --}}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>

<style>
    /* 3D Card Effect */
    .card-3d {
        transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
        transform-style: preserve-3d;
        backface-visibility: hidden;
    }
    .card-3d:hover {
        transform: translateY(-8px) scale(1.01);
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        z-index: 10;
    }
    
    /* Modern Gradient Text */
    .text-gradient {
        background-clip: text;
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-image: linear-gradient(to right, #1e293b, #3b82f6);
    }

    /* Glassmorphism Panel */
    .glass-panel {
        background: rgba(255, 255, 255, 0.95);
        border: 1px solid rgba(226, 232, 240, 0.8);
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03);
    }
</style>

<div class="space-y-8 pb-12">

    {{-- HEADER --}}
    <header class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 animate__animated animate__fadeInDown">
        <div>
            <h1 class="text-3xl sm:text-4xl font-extrabold text-gradient">
                Pendaftaran Kunjungan
            </h1>
            <p class="text-slate-500 mt-2 font-medium">Manajemen data kunjungan real-time.</p>
        </div>
        <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3 w-full sm:w-auto">
            <button onclick="window.print()" class="group flex items-center justify-center gap-2 bg-white text-slate-600 font-bold px-5 py-2.5 rounded-xl shadow-sm border border-slate-200 hover:border-slate-300 hover:bg-slate-50 transition-all active:scale-95">
                <i class="fas fa-print text-slate-400 group-hover:text-slate-600"></i>
                <span>Cetak</span>
            </button>
            
            {{-- Export Button (Triggers Modal) --}}
            <button type="button" id="openExportModal" class="inline-flex items-center justify-center gap-2 bg-emerald-600 hover:bg-emerald-700 text-white font-bold px-6 py-2.5 rounded-xl shadow-lg shadow-emerald-500/20 transition-all hover:-translate-y-0.5 active:scale-95">
                <i class="fas fa-file-export"></i>
                <span>Export Data</span>
            </button>

            <a href="{{ route('admin.kunjungan.verifikasi') }}" class="flex items-center justify-center gap-2 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-bold px-6 py-2.5 rounded-xl shadow-lg shadow-blue-500/20 transition-all hover:-translate-y-0.5 active:scale-95">
                <i class="fas fa-qrcode"></i>
                <span>Scan QR</span>
            </a>

            <a href="{{ route('admin.kunjungan.createOffline') }}" class="flex items-center justify-center gap-2 bg-gradient-to-r from-yellow-500 to-yellow-600 hover:from-yellow-600 hover:to-yellow-700 text-slate-900 font-bold px-6 py-2.5 rounded-xl shadow-lg shadow-yellow-500/20 transition-all hover:-translate-y-0.5 active:scale-95">
                <i class="fas fa-plus"></i>
                <span>Daftar Offline</span>
            </a>
        </div>
    </header>

    {{-- ALERT MESSAGES --}}
    @if(session('success'))
    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                ...swalTheme,
                icon: 'success',
                title: 'Berhasil!',
                text: "{{ session('success') }}",
                showConfirmButton: false,
                timer: 3000
            });
        });
    </script>
    @endpush
    @endif

    @if(session('error'))
    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                ...swalTheme,
                icon: 'error',
                title: 'Error!',
                text: "{{ session('error') }}",
            });
        });
    </script>
    @endpush
    @endif

    {{-- 1. FORM PENCARIAN (GET METHOD) --}}
    <form action="{{ route('admin.kunjungan.index') }}" method="GET" class="animate__animated animate__fadeInUp">
        <div class="glass-panel rounded-2xl p-6 space-y-6">
            {{-- Search Bar --}}
            <div class="flex flex-col md:flex-row gap-4">
                <div class="relative flex-grow group">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <i class="fas fa-search text-slate-400 group-focus-within:text-blue-500 transition-colors"></i>
                    </div>
                    <input type="text" name="search" value="{{ request('search') }}" class="w-full pl-11 pr-4 py-3.5 bg-slate-50 border-2 border-slate-100 rounded-xl focus:bg-white focus:border-blue-500 focus:ring-0 transition-all font-medium text-slate-700 placeholder-slate-400" placeholder="Cari nama, NIK, atau nama WBP...">
                </div>
                <div class="flex gap-3">
                    <button type="submit" class="px-8 py-3.5 bg-slate-800 text-white font-bold rounded-xl hover:bg-slate-900 transition-all shadow-lg active:scale-95 flex items-center gap-2">
                        <i class="fas fa-filter text-sm"></i> Filter
                    </button>
                    <a href="{{ route('admin.kunjungan.index') }}" class="px-6 py-3.5 bg-white text-slate-600 font-bold rounded-xl border-2 border-slate-200 hover:bg-slate-50 transition-all active:scale-95 text-center">
                        Reset
                    </a>
                </div>
            </div>
            
            {{-- Dropdowns --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 pt-2 border-t border-slate-100">
                <div class="space-y-1">
                    <label class="text-xs font-bold text-slate-400 uppercase tracking-wider ml-1">Tanggal</label>
                    <input type="date" name="tanggal_kunjungan" value="{{ request('tanggal_kunjungan') }}" class="w-full p-2.5 bg-slate-50 border border-slate-200 rounded-lg focus:border-blue-500 focus:ring-0 font-semibold text-slate-600">
                </div>
                <div class="space-y-1">
                    <label class="text-xs font-bold text-slate-400 uppercase tracking-wider ml-1">Status</label>
                    <select name="status" class="w-full p-2.5 bg-slate-50 border border-slate-200 rounded-lg focus:border-blue-500 focus:ring-0 font-semibold text-slate-600">
                        <option value="">Semua</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>⏳ Menunggu</option>
                        <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>✅ Disetujui</option>
                        <option value="called" {{ request('status') == 'called' ? 'selected' : '' }}>📣 Dipanggil</option>
                        <option value="in_progress" {{ request('status') == 'in_progress' ? 'selected' : '' }}>▶️ Berlangsung</option>
                        <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>❌ Ditolak</option>
                        <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>🏁 Selesai</option>
                    </select>
                </div>
                <div class="space-y-1">
                    <label class="text-xs font-bold text-slate-400 uppercase tracking-wider ml-1">Sesi</label>
                    <select name="sesi" class="w-full p-2.5 bg-slate-50 border border-slate-200 rounded-lg focus:border-blue-500 focus:ring-0 font-semibold text-slate-600">
                        <option value="">Semua</option>
                        <option value="pagi" {{ request('sesi') == 'pagi' ? 'selected' : '' }}>🌅 Pagi</option>
                        <option value="siang" {{ request('sesi') == 'siang' ? 'selected' : '' }}>☀️ Siang</option>
                    </select>
                </div>
            </div>
        </div>
    </form>

    {{-- 2. FORM BULK ACTION (POST METHOD) --}}
    <form id="bulk-action-form" method="POST">
        @csrf
        
        {{-- TOOLBAR --}}
        <div class="bg-white p-4 rounded-2xl shadow-sm border border-slate-200 flex flex-wrap items-center justify-between gap-4 animate__animated animate__fadeIn">
            {{-- Checkbox Select All --}}
            <div class="flex items-center gap-3 bg-slate-50 px-4 py-2 rounded-xl border border-slate-100">
                <input type="checkbox" id="selectAll" class="w-5 h-5 rounded text-blue-600 border-gray-300 focus:ring-blue-500 cursor-pointer transition-all">
                <label for="selectAll" class="font-bold text-slate-700 text-sm cursor-pointer select-none">Pilih Semua</label>
            </div>

            {{-- Bulk Buttons --}}
            <div id="bulkActionBar" class="hidden flex items-center gap-3 animate__animated animate__fadeInRight">
                <span class="text-xs font-bold text-slate-400 uppercase mr-2"><span id="selectedCount">0</span> Dipilih</span>
                
                <button type="button" onclick="submitBulkAction('approved')" class="flex items-center gap-2 px-4 py-2 bg-emerald-500 hover:bg-emerald-600 text-white text-sm font-bold rounded-lg shadow-md hover:shadow-lg transition-all active:scale-95">
                    <i class="fas fa-check"></i> Setujui
                </button>
                <button type="button" onclick="submitBulkAction('rejected')" class="flex items-center gap-2 px-4 py-2 bg-amber-500 hover:bg-amber-600 text-white text-sm font-bold rounded-lg shadow-md hover:shadow-lg transition-all active:scale-95">
                    <i class="fas fa-times"></i> Tolak
                </button>
                <button type="button" onclick="submitBulkAction('completed')" class="flex items-center gap-2 px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white text-sm font-bold rounded-lg shadow-md hover:shadow-lg transition-all active:scale-95">
                    <i class="fas fa-flag-checkered"></i> Selesai
                </button>
                <button type="button" onclick="submitBulkAction('delete')" class="flex items-center gap-2 px-4 py-2 bg-red-500 hover:bg-red-600 text-white text-sm font-bold rounded-lg shadow-md hover:shadow-lg transition-all active:scale-95">
                    <i class="fas fa-trash-alt"></i> Hapus
                </button>
            </div>
        </div>

        {{-- TABLE --}}
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 mt-6 overflow-x-auto">
            <table class="w-full text-sm text-left text-slate-500">
                <thead class="text-xs text-slate-700 uppercase bg-slate-50">
                    <tr>
                        <th scope="col" class="p-4">
                            {{-- Checkbox is in the toolbar --}}
                        </th>
                        <th scope="col" class="px-6 py-3">Pengunjung</th>
                        <th scope="col" class="px-6 py-3">Warga Binaan</th>
                        <th scope="col" class="px-6 py-3">Jadwal Kunjungan</th>
                        <th scope="col" class="px-6 py-3">Status</th>
                        <th scope="col" class="px-6 py-3 text-center">Antrian</th>
                        <th scope="col" class="px-6 py-3 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($kunjungans as $kunjungan)
                    <tr class="bg-white border-b hover:bg-slate-50">
                        <td class="w-4 p-4">
                            <input type="checkbox" name="ids[]" class="kunjungan-checkbox w-5 h-5 rounded border-gray-300 text-blue-600 focus:ring-blue-500 cursor-pointer" value="{{ $kunjungan->id }}">
                        </td>
                        <td class="px-6 py-4">
                            <div class="font-bold text-slate-800">{{ $kunjungan->nama_pengunjung }}</div>
                            <div class="text-xs text-slate-500">NIK: {{ $kunjungan->nik_ktp }}</div>
                            
                            {{-- BUTTON LIHAT FOTO KTP (LIGHTBOX) --}}
                            @if(!empty($kunjungan->foto_ktp))
                                <a data-fslightbox="gallery" href="{{ $kunjungan->foto_ktp }}" 
                                   class="text-xs font-semibold text-blue-600 hover:text-blue-800 hover:underline mt-1 flex items-center gap-1 no-print">
                                    <i class="fas fa-id-card"></i> Lihat Foto KTP
                                </a>
                                <span class="hidden print:inline text-xs text-slate-500">Ada Foto KTP</span>
                            @else
                                <span class="text-xs text-gray-400 italic mt-1 block">Foto tidak tersedia</span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                             <div class="font-semibold text-slate-800">{{ $kunjungan->wbp->nama ?? 'WBP Dihapus' }}</div>
                             <div class="text-xs">Hubungan: {{ $kunjungan->hubungan }}</div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="font-semibold">{{ \Carbon\Carbon::parse($kunjungan->tanggal_kunjungan)->translatedFormat('d F Y') }}</div>
                            <div class="text-xs uppercase font-bold text-purple-700">{{ $kunjungan->sesi }}</div>
                        </td>
                        <td class="px-6 py-4">
                            @if($kunjungan->status == KunjunganStatus::APPROVED)
                                <span class="px-2.5 py-1 rounded-lg bg-emerald-100 text-emerald-700 text-xs font-bold flex items-center gap-1 w-fit">
                                    <i class="fas fa-check-circle"></i> Disetujui
                                </span>
                            @elseif($kunjungan->status == KunjunganStatus::CALLED)
                                <span class="px-2.5 py-1 rounded-lg bg-yellow-100 text-yellow-800 text-xs font-bold flex items-center gap-1 w-fit">
                                    <i class="fas fa-bullhorn"></i> Dipanggil
                                </span>
                            @elseif($kunjungan->status == KunjunganStatus::IN_PROGRESS)
                                <span class="px-2.5 py-1 rounded-lg bg-sky-100 text-sky-800 text-xs font-bold flex items-center gap-1 w-fit">
                                    <i class="fas fa-hourglass-start"></i> Berlangsung
                                </span>
                            @elseif($kunjungan->status == KunjunganStatus::REJECTED)
                                <span class="px-2.5 py-1 rounded-lg bg-red-100 text-red-700 text-xs font-bold flex items-center gap-1 w-fit">
                                    <i class="fas fa-times-circle"></i> Ditolak
                                </span>
                            @elseif($kunjungan->status == KunjunganStatus::COMPLETED)
                                <span class="px-2.5 py-1 rounded-lg bg-slate-100 text-slate-600 text-xs font-bold flex items-center gap-1 w-fit">
                                    <i class="fas fa-flag-checkered"></i> Selesai
                                </span>
                            @else
                                <span class="px-2.5 py-1 rounded-lg bg-amber-100 text-amber-700 text-xs font-bold flex items-center gap-1 w-fit">
                                    <i class="fas fa-clock"></i> Menunggu
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-center">
                            @if($kunjungan->nomor_antrian_harian)
                            <span class="text-base font-extrabold bg-slate-200 text-slate-700 px-3 py-1 rounded-lg">#{{ $kunjungan->nomor_antrian_harian }}</span>
                            @else
                            <span class="text-slate-400">-</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 no-print">
                            <div class="flex items-center justify-center gap-2">
                                <a href="{{ route('admin.kunjungan.show', $kunjungan->id) }}" class="w-8 h-8 rounded-lg bg-slate-100 text-slate-600 hover:bg-blue-500 hover:text-white flex items-center justify-center transition-all shadow-sm" title="Detail">
                                    <i class="fas fa-eye"></i>
                                </a>
                                @if($kunjungan->status == KunjunganStatus::PENDING)
                                    <button type="button" onclick="submitSingleAction('{{ route('admin.kunjungan.update', $kunjungan->id) }}', 'approved', 'PATCH')" class="w-8 h-8 rounded-lg bg-emerald-100 text-emerald-600 hover:bg-emerald-500 hover:text-white flex items-center justify-center transition-all shadow-sm" title="Setujui">
                                        <i class="fas fa-check"></i>
                                    </button>
                                    <button type="button" onclick="submitSingleAction('{{ route('admin.kunjungan.update', $kunjungan->id) }}', 'rejected', 'PATCH')" class="w-8 h-8 rounded-lg bg-amber-100 text-amber-600 hover:bg-amber-500 hover:text-white flex items-center justify-center transition-all shadow-sm" title="Tolak">
                                        <i class="fas fa-times"></i>
                                    </button>
                                @elseif($kunjungan->status == KunjunganStatus::APPROVED)
                                    <button type="button" onclick="submitSingleAction('{{ route('admin.kunjungan.update', $kunjungan->id) }}', 'completed', 'PATCH')" class="w-8 h-8 rounded-lg bg-blue-100 text-blue-600 hover:bg-blue-500 hover:text-white flex items-center justify-center transition-all shadow-sm" title="Tandai Selesai">
                                        <i class="fas fa-flag-checkered"></i>
                                    </button>
                                @endif
                                <button type="button" onclick="submitSingleAction('{{ route('admin.kunjungan.destroy', $kunjungan->id) }}', 'delete', 'DELETE')" class="w-8 h-8 rounded-lg bg-red-100 text-red-600 hover:bg-red-500 hover:text-white flex items-center justify-center transition-all shadow-sm" title="Hapus">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="py-20 text-center">
                            <div class="w-24 h-24 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-4 animate__animated animate__pulse animate__infinite">
                                <i class="fas fa-inbox text-4xl text-slate-300"></i>
                            </div>
                            <h3 class="text-xl font-bold text-slate-700">Tidak ada data ditemukan</h3>
                            <p class="text-slate-500 mt-1">Coba ubah filter pencarian Anda.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </form> {{-- END FORM BULK --}}

    {{-- PAGINATION --}}
    @if ($kunjungans->hasPages())
    <div class="animate__animated animate__fadeInUp">
        {{ $kunjungans->links() }}
    </div>
    @endif

</div>

{{-- EXPORT MODAL --}}
<div id="exportModal" class="fixed inset-0 z-50 hidden overflow-y-auto no-print" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 bg-slate-900 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
        <div class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg w-full border border-slate-200">
            <div class="bg-white px-6 py-5 border-b border-slate-100 flex justify-between items-center">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full bg-emerald-100 flex items-center justify-center text-emerald-600">
                        <i class="fas fa-file-export"></i>
                    </div>
                    <h3 class="text-xl font-bold text-slate-800">Export Data Kunjungan</h3>
                </div>
                <button type="button" id="closeExportModal" class="text-slate-400 hover:text-slate-600 transition-colors">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>
            <div class="px-6 py-6">
                <form id="exportForm" action="{{ route('admin.kunjungan.export') }}" method="GET">
                    <div class="space-y-5">
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">Format File</label>
                            <select name="type" class="w-full p-3 bg-slate-50 border-2 border-slate-100 rounded-xl focus:bg-white focus:border-emerald-500 focus:ring-0 transition-all font-medium">
                                <option value="excel">Excel (.xlsx)</option>
                                <option value="csv">CSV (.csv)</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">Periode Export</label>
                            <select id="modal_export_period" name="period" class="w-full p-3 bg-slate-50 border-2 border-slate-100 rounded-xl focus:bg-white focus:border-emerald-500 focus:ring-0 transition-all font-medium">
                                <option value="all">Semua Data</option>
                                <option value="day">Harian</option>
                                <option value="week">Mingguan</option>
                                <option value="month">Bulanan</option>
                            </select>
                        </div>
                        <div id="modal_export_date_container" class="hidden animate__animated animate__fadeIn">
                            <label class="block text-sm font-bold text-slate-700 mb-2">Pilih Tanggal</label>
                            <input type="date" name="date" class="w-full p-3 bg-slate-50 border-2 border-slate-100 rounded-xl focus:bg-white focus:border-emerald-500 focus:ring-0 transition-all font-medium" value="{{ date('Y-m-d') }}">
                        </div>
                    </div>
                </form>
            </div>
            <div class="bg-slate-50 px-6 py-4 flex flex-col sm:flex-row-reverse gap-3">
                <button type="submit" form="exportForm" class="w-full sm:w-auto px-8 py-3 bg-emerald-600 text-white font-bold rounded-xl hover:bg-emerald-700 transition-all shadow-lg active:scale-95 flex items-center justify-center gap-2">
                    <i class="fas fa-download"></i> Download
                </button>
                <button type="button" id="closeExportModalBtn" class="w-full sm:w-auto px-8 py-3 bg-white text-slate-600 font-bold rounded-xl border-2 border-slate-200 hover:bg-slate-50 transition-all active:scale-95">
                    Batal
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
        text = "Data akan dihapus permanen.";
        icon = 'warning';
        btnColor = 'px-6 py-2.5 bg-red-600 hover:bg-red-700 text-white font-bold rounded-lg transition-all duration-200 mx-1.5 shadow-lg shadow-red-500/30';
        btnText = 'Ya, Hapus';
    } else if (actionType === 'completed') {
        title = 'Tandai Selesai?';
        text = "Status akan diubah menjadi Selesai dan link survei akan dikirim.";
        icon = 'question';
        btnColor = 'px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-lg transition-all duration-200 mx-1.5 shadow-lg shadow-blue-500/30';
        btnText = 'Ya, Tandai Selesai';
    } else {
        title = actionType === 'approved' ? 'Setujui Kunjungan?' : 'Tolak Kunjungan?';
        text = "Notifikasi akan dikirim ke pengunjung.";
        icon = 'question';
        btnColor = actionType === 'approved' 
            ? 'px-6 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-lg transition-all duration-200 mx-1.5 shadow-lg shadow-emerald-500/30' 
            : 'px-6 py-2.5 bg-amber-500 hover:bg-amber-600 text-white font-bold rounded-lg transition-all duration-200 mx-1.5 shadow-lg shadow-amber-500/30';
        btnText = 'Ya, Proses';
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
            confirmButton: btnColor
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

// --- 2. LOGIC BULK ACTION ---
function submitBulkAction(actionType) {
    const form = document.getElementById('bulk-action-form');
    const count = document.querySelectorAll('.kunjungan-checkbox:checked').length;

    if(count === 0) return;

    let url, title, text, icon, btnColor, btnText;

    if(actionType === 'delete') {
        url = "{{ route('admin.kunjungan.bulk-delete') }}";
        title = `Hapus ${count} Data?`;
        text = "Data yang dihapus tidak dapat dikembalikan!";
        icon = 'warning';
        btnColor = 'px-6 py-2.5 bg-red-600 hover:bg-red-700 text-white font-bold rounded-lg transition-all duration-200 mx-1.5 shadow-lg shadow-red-500/30';
        btnText = 'Ya, Hapus!';
    } else {
        url = "{{ route('admin.kunjungan.bulk-update') }}";
        icon = 'question';
        if (actionType === 'approved') {
            title = `Setujui ${count} Data?`;
            text = `Status data akan diubah menjadi Disetujui.`;
            btnColor = 'px-6 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-lg transition-all duration-200 mx-1.5 shadow-lg shadow-emerald-500/30';
            btnText = 'Ya, Lanjutkan';
        } else if (actionType === 'rejected') {
            title = `Tolak ${count} Data?`;
            text = `Status data akan diubah menjadi Ditolak.`;
            btnColor = 'px-6 py-2.5 bg-amber-500 hover:bg-amber-600 text-white font-bold rounded-lg transition-all duration-200 mx-1.5 shadow-lg shadow-amber-500/30';
            btnText = 'Ya, Lanjutkan';
        } else { // completed
            title = `Tandai Selesai ${count} Data?`;
            text = `Status data akan diubah menjadi Selesai.`;
            btnColor = 'px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-lg transition-all duration-200 mx-1.5 shadow-lg shadow-blue-500/30';
            btnText = 'Ya, Lanjutkan';
        }
        
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
            confirmButton: btnColor
        }
    }).then((result) => {
        if (result.isConfirmed) {
            form.action = url;
            form.submit();
        }
    });
}


document.addEventListener('DOMContentLoaded', function() {
    // --- 1. LOGIC CHECKBOX ---
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

    // --- EXPORT MODAL LOGIC ---
    const openExportModalBtn = document.getElementById('openExportModal');
    const closeExportModalBtn = document.getElementById('closeExportModal');
    const closeExportModalBtn2 = document.getElementById('closeExportModalBtn');
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
        openExportModalBtn.addEventListener('click', function() {
            exportModal.classList.remove('hidden');
            toggleModalExportDateInput();
        });
    }

    const closeActions = [closeExportModalBtn, closeExportModalBtn2];
    closeActions.forEach(btn => {
        if (btn && exportModal) {
            btn.addEventListener('click', function() {
                exportModal.classList.add('hidden');
            });
        }
    });
    
    if (modalExportPeriodSelect) {
        modalExportPeriodSelect.addEventListener('change', toggleModalExportDateInput);
    }
});
</script>
@endpush
@endsection