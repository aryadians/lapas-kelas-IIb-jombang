@extends('layouts.admin')

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
            <h1 class="text-4xl font-extrabold text-gradient">
                Pendaftaran Kunjungan
            </h1>
            <p class="text-slate-500 mt-2 font-medium">Manajemen data kunjungan real-time.</p>
        </div>
        <div class="flex items-center gap-3">
            <button onclick="window.print()" class="group flex items-center gap-2 bg-white text-slate-600 font-bold px-5 py-2.5 rounded-xl shadow-sm border border-slate-200 hover:border-slate-300 hover:bg-slate-50 transition-all active:scale-95">
                <i class="fas fa-print text-slate-400 group-hover:text-slate-600"></i>
                <span>Cetak</span>
            </button>
            <a href="{{ route('admin.kunjungan.verifikasi') }}" class="flex items-center gap-2 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-bold px-6 py-2.5 rounded-xl shadow-lg shadow-blue-500/20 transition-all hover:-translate-y-0.5 active:scale-95">
                <i class="fas fa-qrcode"></i>
                <span>Scan QR</span>
            </a>
        </div>
    </header>

    {{-- ALERT MESSAGES --}}
    @if(session('success'))
    <div class="animate__animated animate__bounceIn bg-emerald-50 border-l-4 border-emerald-500 p-4 rounded-r-xl shadow-sm flex items-start gap-3">
        <div class="mt-0.5"><i class="fas fa-check-circle text-emerald-500 text-xl"></i></div>
        <div>
            <h3 class="font-bold text-emerald-800">Berhasil!</h3>
            <p class="text-emerald-700 text-sm">{{ session('success') }}</p>
        </div>
    </div>
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
                        <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>❌ Ditolak</option>
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
                            @if($kunjungan->status == 'approved')
                                <span class="px-2.5 py-1 rounded-lg bg-emerald-100 text-emerald-700 text-xs font-bold flex items-center gap-1 w-fit">
                                    <i class="fas fa-check-circle"></i> Disetujui
                                </span>
                            @elseif($kunjungan->status == 'rejected')
                                <span class="px-2.5 py-1 rounded-lg bg-red-100 text-red-700 text-xs font-bold flex items-center gap-1 w-fit">
                                    <i class="fas fa-times-circle"></i> Ditolak
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
                        <td class="px-6 py-4">
                            <div class="flex items-center justify-center gap-2">
                                <a href="{{ route('admin.kunjungan.show', $kunjungan->id) }}" class="w-8 h-8 rounded-lg bg-slate-100 text-slate-600 hover:bg-blue-500 hover:text-white flex items-center justify-center transition-all shadow-sm" title="Detail">
                                    <i class="fas fa-eye"></i>
                                </a>
                                @if($kunjungan->status == 'pending')
                                    <button type="button" onclick="submitSingleAction('{{ route('admin.kunjungan.update', $kunjungan->id) }}', 'approved', 'PATCH')" class="w-8 h-8 rounded-lg bg-emerald-100 text-emerald-600 hover:bg-emerald-500 hover:text-white flex items-center justify-center transition-all shadow-sm" title="Setujui">
                                        <i class="fas fa-check"></i>
                                    </button>
                                    <button type="button" onclick="submitSingleAction('{{ route('admin.kunjungan.update', $kunjungan->id) }}', 'rejected', 'PATCH')" class="w-8 h-8 rounded-lg bg-amber-100 text-amber-600 hover:bg-amber-500 hover:text-white flex items-center justify-center transition-all shadow-sm" title="Tolak">
                                        <i class="fas fa-times"></i>
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

{{-- HIDDEN FORM FOR SINGLE ACTION --}}
<form id="single-action-form" method="POST" class="hidden">
    @csrf
    <input type="hidden" name="_method" id="single_method">
    <input type="hidden" name="status" id="single_status">
</form>

{{-- SCRIPT --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
// --- 1. LOGIC CHECKBOX ---
document.addEventListener('DOMContentLoaded', function() {
    const selectAll = document.getElementById('selectAll');
    const checkboxes = document.querySelectorAll('.kunjungan-checkbox');
    const bulkBar = document.getElementById('bulkActionBar');
    const countSpan = document.getElementById('selectedCount');

    function toggleBulkBar() {
        const count = document.querySelectorAll('.kunjungan-checkbox:checked').length;
        countSpan.textContent = count;
        if(count > 0) {
            bulkBar.classList.remove('hidden');
            bulkBar.classList.add('flex');
        } else {
            bulkBar.classList.add('hidden');
            bulkBar.classList.remove('flex');
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
            if(!this.checked) selectAll.checked = false;
            toggleBulkBar();
        });
    });
});

// --- 2. LOGIC BULK ACTION ---
function submitBulkAction(actionType) {
    const form = document.getElementById('bulk-action-form');
    const count = document.querySelectorAll('.kunjungan-checkbox:checked').length;

    if(count === 0) return;

    let url, title, text, btnColor, btnText;

    if(actionType === 'delete') {
        url = "{{ route('admin.kunjungan.bulk-delete') }}";
        title = `Hapus ${count} Data?`;
        text = "Data yang dihapus tidak dapat dikembalikan!";
        btnColor = '#ef4444';
        btnText = 'Ya, Hapus!';
    } else {
        url = "{{ route('admin.kunjungan.bulk-update') }}";
        title = actionType === 'approved' ? `Setujui ${count} Data?` : `Tolak ${count} Data?`;
        text = `Status data akan diubah menjadi ${actionType}.`;
        btnColor = actionType === 'approved' ? '#10b981' : '#f59e0b';
        btnText = 'Ya, Lanjutkan';
        
        // Hapus input status lama jika ada
        const oldInput = document.getElementById('bulk_status_input');
        if(oldInput) oldInput.remove();

        // Tambah input status baru
        const input = document.createElement('input');
        input.type = 'hidden';
        input.name = 'status';
        input.value = actionType;
        input.id = 'bulk_status_input';
        form.appendChild(input);
    }

    Swal.fire({
        title: title,
        text: text,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: btnColor,
        cancelButtonColor: '#64748b',
        confirmButtonText: btnText,
        cancelButtonText: 'Batal',
        showClass: { popup: 'animate__animated animate__zoomInDown' },
        hideClass: { popup: 'animate__animated animate__zoomOutUp' }
    }).then((result) => {
        if (result.isConfirmed) {
            form.action = url;
            form.submit();
        }
    });
}

// --- 3. LOGIC SINGLE ACTION ---
function submitSingleAction(url, actionType, method) {
    const form = document.getElementById('single-action-form');
    const methodInput = document.getElementById('single_method');
    const statusInput = document.getElementById('single_status');

    let title, text, btnColor;

    if(actionType === 'delete') {
        title = 'Hapus Data?';
        text = "Data akan dihapus permanen.";
        btnColor = '#ef4444';
    } else {
        title = actionType === 'approved' ? 'Setujui Kunjungan?' : 'Tolak Kunjungan?';
        text = "Notifikasi email akan dikirim ke pengunjung.";
        btnColor = actionType === 'approved' ? '#10b981' : '#f59e0b';
    }

    Swal.fire({
        title: title,
        text: text,
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: btnColor,
        cancelButtonColor: '#64748b',
        confirmButtonText: 'Ya, Proses',
        showClass: { popup: 'animate__animated animate__zoomInDown' },
        hideClass: { popup: 'animate__animated animate__zoomOutUp' }
    }).then((result) => {
        if (result.isConfirmed) {
            form.action = url;
            methodInput.value = method;
            statusInput.value = actionType === 'delete' ? '' : actionType;
            form.submit();
        }
    });
}
</script>
@endsection