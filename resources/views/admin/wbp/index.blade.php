@extends('layouts.admin')

@section('title', 'Database Warga Binaan')

@section('content')
<div class="space-y-6 pb-12">

    {{-- HERO HEADER --}}
    <div class="relative bg-gradient-to-br from-slate-900 via-indigo-950 to-purple-950 rounded-3xl overflow-hidden shadow-2xl">
        <div class="absolute inset-0 pointer-events-none overflow-hidden">
            <div class="absolute -top-20 -right-20 w-80 h-80 bg-indigo-400 rounded-full blur-[90px] opacity-10"></div>
            <div class="absolute -bottom-16 -left-16 w-60 h-60 bg-purple-400 rounded-full blur-[80px] opacity-10"></div>
        </div>
        <div class="relative z-10 px-8 py-7 flex flex-col md:flex-row items-start md:items-center justify-between gap-6">
            <div>
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/10 border border-white/20 text-indigo-200 text-xs font-bold uppercase tracking-widest mb-3">
                    <i class="fas fa-database"></i> Data Master
                </div>
                <h1 class="text-3xl md:text-4xl font-black text-white tracking-tight">Database Warga Binaan</h1>
                <p class="text-indigo-100/60 mt-1 text-sm">Kelola data WBP, lokasi sel, dan masa tahanan.</p>
            </div>
            <div class="flex flex-wrap items-center gap-3">
                {{-- Stat --}}
                <div class="bg-white/10 border border-white/20 rounded-2xl px-5 py-3 text-center">
                    <p class="text-2xl font-black text-white">{{ $wbps->total() }}</p>
                    <p class="text-[10px] text-indigo-200 font-bold uppercase tracking-widest mt-0.5">
                        {{ $status === 'Semua' ? 'Total WBP' : ($status === 'Aktif' ? 'WBP Aktif' : 'WBP Bebas') }}
                    </p>
                </div>
                {{-- Add Button --}}
                <a href="{{ route('admin.wbp.create') }}"
                    class="inline-flex items-center gap-2 bg-white text-indigo-700 hover:bg-indigo-50 font-black px-5 py-3 rounded-2xl shadow-xl transition-all hover:-translate-y-0.5 active:scale-95">
                    <i class="fas fa-plus"></i>
                    Tambah WBP
                </a>
            </div>
        </div>
    </div>

    {{-- TABS STATUS --}}
    <div class="flex items-center gap-2 bg-slate-100 p-1.5 rounded-2xl w-fit flex-wrap">
        <a href="{{ route('admin.wbp.index', ['status' => 'Aktif', 'search' => request('search')]) }}" 
            class="px-6 py-2 rounded-xl text-sm font-black transition-all {{ $status === 'Aktif' ? 'bg-white text-indigo-600 shadow-sm' : 'text-slate-500 hover:text-slate-700' }}">
            WBP Aktif
        </a>
        <a href="{{ route('admin.wbp.index', ['status' => 'Mapenaling', 'search' => request('search')]) }}" 
            class="px-6 py-2 rounded-xl text-sm font-black transition-all {{ $status === 'Mapenaling' ? 'bg-white text-amber-600 shadow-sm' : 'text-slate-500 hover:text-slate-700' }}">
            Mapenaling
        </a>
        <a href="{{ route('admin.wbp.index', ['status' => 'Strap Cell', 'search' => request('search')]) }}" 
            class="px-6 py-2 rounded-xl text-sm font-black transition-all {{ $status === 'Strap Cell' ? 'bg-white text-red-600 shadow-sm' : 'text-slate-500 hover:text-slate-700' }}">
            Strap Cell
        </a>
        <a href="{{ route('admin.wbp.index', ['status' => 'Sidang TPP', 'search' => request('search')]) }}" 
            class="px-6 py-2 rounded-xl text-sm font-black transition-all {{ $status === 'Sidang TPP' ? 'bg-white text-orange-600 shadow-sm' : 'text-slate-500 hover:text-slate-700' }}">
            Sidang TPP
        </a>
        <a href="{{ route('admin.wbp.index', ['status' => 'Bebas', 'search' => request('search')]) }}" 
            class="px-6 py-2 rounded-xl text-sm font-black transition-all {{ $status === 'Bebas' ? 'bg-white text-rose-600 shadow-sm' : 'text-slate-500 hover:text-slate-700' }}">
            WBP Bebas / Ekspirasi
        </a>
        <a href="{{ route('admin.wbp.index', ['status' => 'Semua', 'search' => request('search')]) }}" 
            class="px-6 py-2 rounded-xl text-sm font-black transition-all {{ $status === 'Semua' ? 'bg-white text-slate-800 shadow-sm' : 'text-slate-500 hover:text-slate-700' }}">
            Semua
        </a>
    </div>

    {{-- CONTENT CARD --}}
    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">

        {{-- Toolbar: Import + Search --}}
        <div class="px-6 py-4 border-b border-slate-100 flex flex-col lg:flex-row items-start lg:items-center gap-4">

            {{-- Select All + Bulk Badge --}}
            <div class="flex items-center gap-3 flex-shrink-0">
                <label class="flex items-center gap-2 cursor-pointer group">
                    <input type="checkbox" id="select-all" 
                        class="w-5 h-5 rounded-lg border-2 border-slate-200 text-indigo-600 focus:ring-indigo-500 transition-all cursor-pointer">
                    <span class="text-xs font-bold text-slate-500 group-hover:text-slate-700 transition-colors uppercase tracking-wider">Pilih Semua</span>
                </label>
                <div id="selection-badge" class="hidden animate__animated animate__fadeIn">
                    <span class="bg-indigo-100 text-indigo-700 text-[10px] font-black px-2.5 py-1 rounded-full border border-indigo-200">
                        <span id="selected-count">0</span> Terpilih
                    </span>
                </div>
            </div>

            {{-- Import Form --}}
            <form id="import-form" action="{{ route('admin.wbp.import') }}" method="POST"
                enctype="multipart/form-data" class="flex items-center gap-2 flex-1 min-w-0">
                @csrf
                <div class="relative flex-1 min-w-0">
                    <input type="file" name="file" id="file-input" class="hidden" required accept=".xlsx,.xls,.csv,.txt">
                    <label for="file-input"
                        class="flex items-center w-full cursor-pointer bg-slate-50 border-2 border-dashed border-slate-200 hover:border-indigo-400 hover:bg-indigo-50/50 rounded-xl transition-all group">
                        <div class="p-2.5 mx-2">
                            <i class="fas fa-file-excel text-emerald-500 text-base group-hover:scale-110 transition-transform"></i>
                        </div>
                        <span id="file-name" class="flex-1 text-sm text-slate-400 font-medium truncate">
                            Pilih file Excel / CSV untuk diimpor...
                        </span>
                        <span class="text-xs bg-indigo-600 text-white font-bold py-1.5 px-3 rounded-lg mr-2 flex-shrink-0">
                            Browse
                        </span>
                    </label>
                </div>
                <button type="submit"
                    class="flex-shrink-0 inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white font-bold px-4 py-2.5 rounded-xl shadow-md hover:shadow-indigo-500/30 transition-all active:scale-95 text-sm"
                    title="Upload & Import Data">
                    <i class="fas fa-cloud-arrow-up"></i>
                    <span class="hidden sm:inline">Import</span>
                </button>
            </form>

            {{-- Search --}}
            <form method="GET" class="flex items-center gap-2 w-full lg:w-72 flex-shrink-0">
                <div class="relative flex-1">
                    <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
                    <input type="text" name="search" value="{{ request('search') }}"
                        placeholder="Cari Nama atau No. Registrasi..."
                        class="w-full pl-9 pr-4 py-2.5 border-2 border-slate-100 bg-slate-50 rounded-xl text-sm font-medium text-slate-700 placeholder-slate-400 focus:border-indigo-400 focus:outline-none focus:bg-white transition-all">
                </div>
                @if(request('search'))
                <a href="{{ route('admin.wbp.index') }}"
                    class="flex-shrink-0 w-10 h-10 flex items-center justify-center rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-500 transition-all">
                    <i class="fas fa-times text-xs"></i>
                </a>
                @endif
            </form>
        </div>

        {{-- TABLE --}}
        <div class="overflow-x-auto">
            @forelse($wbps as $wbp)
            @php
                $sisa = $wbp->tanggal_ekspirasi
                    ? \Carbon\Carbon::parse($wbp->tanggal_ekspirasi)->diffInDays(now(), false)
                    : null;
                $isExpired = $sisa !== null && $sisa > 0;
                $isNearExpiry = $sisa !== null && $sisa > -90 && !$isExpired;

                // Avatar color from name
                $colors = ['indigo','purple','blue','emerald','rose','amber','cyan','teal'];
                $color = $colors[abs(crc32($wbp->nama)) % count($colors)];
            @endphp
            <div class="flex flex-col sm:flex-row items-start sm:items-center gap-4 px-6 py-4 border-b border-slate-50 hover:bg-slate-50/80 transition-colors group">

                {{-- Checkbox --}}
                <div class="flex-shrink-0">
                    <input type="checkbox" class="wbp-checkbox w-5 h-5 rounded-lg border-2 border-slate-200 text-indigo-600 focus:ring-indigo-500 transition-all cursor-pointer" value="{{ $wbp->id }}">
                </div>

                {{-- Avatar --}}
                <div class="flex-shrink-0 w-11 h-11 rounded-2xl bg-{{ $color }}-100 text-{{ $color }}-600 flex items-center justify-center font-black text-base shadow-sm">
                    {{ strtoupper(substr($wbp->nama, 0, 1)) }}
                </div>

                {{-- Identitas --}}
                <div class="flex-1 min-w-0">
                    <div class="flex items-center gap-2 flex-wrap">
                        <a href="{{ route('admin.wbp.show', $wbp->id) }}"
                            class="font-black text-slate-800 hover:text-indigo-600 transition-colors text-sm leading-tight">
                            {{ $wbp->nama }}
                        </a>
                        @if($wbp->nama_panggilan && $wbp->nama_panggilan != '-')
                        <span class="text-[10px] font-bold bg-amber-100 text-amber-700 border border-amber-200 px-2 py-0.5 rounded-full">
                            {{ $wbp->nama_panggilan }}
                        </span>
                        @endif
                    </div>
                    <div class="flex items-center gap-2 mt-1 flex-wrap">
                        <span class="text-[11px] font-mono bg-slate-100 text-slate-600 border border-slate-200 px-2 py-0.5 rounded-lg">
                            {{ $wbp->no_registrasi }}
                        </span>
                        {{-- Lokasi inline --}}
                        @if($wbp->blok || $wbp->lokasi_sel)
                        <span class="inline-flex items-center gap-1 text-[11px] font-bold text-indigo-600 bg-indigo-50 border border-indigo-100 px-2 py-0.5 rounded-lg">
                            <i class="fas fa-door-open text-[9px]"></i>
                            Blok {{ $wbp->blok ?? '-' }} / Sel {{ $wbp->lokasi_sel ?? '-' }}
                        </span>
                        @endif
                        @if($wbp->kode_tahanan)
                        <span class="inline-flex items-center gap-1 text-[11px] font-bold text-teal-600 bg-teal-50 border border-teal-100 px-2 py-0.5 rounded-lg">
                            <i class="fas fa-tag text-[9px]"></i>
                            {{ $wbp->kode_tahanan }}
                        </span>
                        @endif
                        {{-- Status Badge --}}
                        <span class="inline-flex items-center gap-1 text-[11px] font-black uppercase tracking-widest px-2 py-0.5 rounded-lg border {{ $wbp->status === 'Aktif' ? 'text-emerald-600 bg-emerald-50 border-emerald-100' : 'text-rose-600 bg-rose-50 border-rose-100' }}">
                            {{ $wbp->status }}
                        </span>
                        @if($wbp->activeRestriction)
                        <span class="inline-flex items-center gap-1 text-[11px] font-black uppercase tracking-widest px-2 py-0.5 rounded-lg border text-amber-700 bg-amber-50 border-amber-200" title="{{ \Carbon\Carbon::parse($wbp->activeRestriction->start_date)->format('d/m/Y') }} - {{ \Carbon\Carbon::parse($wbp->activeRestriction->end_date)->format('d/m/Y') }}">
                            <i class="fas fa-ban text-[9px]"></i> {{ $wbp->activeRestriction->type }}
                        </span>
                        @endif
                    </div>
                </div>

                {{-- Masa Tahanan --}}
                <div class="flex items-center gap-3 flex-shrink-0">
                    <div class="text-xs space-y-0.5 text-right hidden md:block">
                        <div class="text-slate-400">
                            Masuk: <span class="font-semibold text-slate-600">{{ $wbp->tanggal_masuk ? \Carbon\Carbon::parse($wbp->tanggal_masuk)->format('d/m/Y') : '-' }}</span>
                        </div>
                        <div class="text-slate-400">
                            Ekspirasi:
                            <span class="font-bold {{ $isExpired ? 'text-red-600' : ($isNearExpiry ? 'text-amber-600' : 'text-slate-600') }}">
                                {{ $wbp->tanggal_ekspirasi ? \Carbon\Carbon::parse($wbp->tanggal_ekspirasi)->format('d/m/Y') : '-' }}
                            </span>
                        </div>
                    </div>
                    @if($isExpired)
                    <span class="hidden md:inline-flex text-[9px] font-black bg-red-100 text-red-600 border border-red-200 px-2 py-1 rounded-full uppercase tracking-widest">Habis</span>
                    @elseif($isNearExpiry)
                    <span class="hidden md:inline-flex text-[9px] font-black bg-amber-100 text-amber-600 border border-amber-200 px-2 py-1 rounded-full uppercase tracking-widest">Segera</span>
                    @endif
                </div>

                {{-- Actions --}}
                <div class="flex items-center gap-1.5 flex-shrink-0">
                    <a href="{{ route('admin.wbp.history', $wbp->id) }}"
                        class="inline-flex items-center justify-center w-9 h-9 rounded-xl bg-slate-100 hover:bg-slate-600 border-2 border-slate-200 hover:border-slate-600 text-slate-500 hover:text-white transition-all duration-200 hover:shadow-md hover:-translate-y-0.5 active:scale-95"
                        title="Riwayat Kunjungan">
                        <i class="fas fa-clock-rotate-left text-xs"></i>
                    </a>
                    <a href="{{ route('admin.wbp.edit', $wbp->id) }}"
                        class="inline-flex items-center justify-center w-9 h-9 rounded-xl bg-blue-50 hover:bg-blue-500 border-2 border-blue-200 hover:border-blue-500 text-blue-600 hover:text-white transition-all duration-200 hover:shadow-md hover:shadow-blue-500/30 hover:-translate-y-0.5 active:scale-95"
                        title="Edit WBP">
                        <i class="fas fa-pencil text-xs"></i>
                    </a>
                    <form action="{{ route('admin.wbp.destroy', $wbp->id) }}" method="POST" class="delete-form">
                        @csrf @method('DELETE')
                        <button type="submit"
                            class="inline-flex items-center justify-center w-9 h-9 rounded-xl bg-red-50 hover:bg-red-500 border-2 border-red-200 hover:border-red-500 text-red-600 hover:text-white transition-all duration-200 hover:shadow-md hover:shadow-red-500/30 hover:-translate-y-0.5 active:scale-95"
                            title="Hapus WBP">
                            <i class="fas fa-trash-alt text-xs"></i>
                        </button>
                    </form>
                </div>
            </div>
            @empty
            <div class="py-20 text-center">
                <div class="w-16 h-16 bg-slate-100 rounded-3xl flex items-center justify-center text-slate-300 text-3xl mx-auto mb-3">
                    <i class="fas fa-database"></i>
                </div>
                <h3 class="font-black text-slate-700 mb-1">Data WBP Kosong</h3>
                <p class="text-slate-400 text-sm">Belum ada data. Silakan upload file CSV atau tambah manual.</p>
            </div>
            @endforelse
        </div>

        {{-- Pagination --}}
        @if($wbps->hasPages())
        <div class="px-6 py-4 border-t border-slate-100">
            {{ $wbps->links() }}
        </div>
        @endif
    </div>

    {{-- FLOATING BULK ACTION BAR --}}
    <div id="bulk-action-bar" 
        class="fixed bottom-8 left-1/2 -translate-x-1/2 z-50 translate-y-32 opacity-0 invisible transition-all duration-500 ease-out">
        <div class="bg-slate-900/90 backdrop-blur-xl border border-white/10 px-6 py-4 rounded-3xl shadow-[0_20px_50px_rgba(0,0,0,0.3)] flex items-center gap-6">
            <div class="flex items-center gap-3 pr-6 border-r border-white/10">
                <div class="w-10 h-10 rounded-2xl bg-indigo-500/20 text-indigo-400 flex items-center justify-center font-black">
                    <span id="bulk-selected-count">0</span>
                </div>
                <div>
                    <p class="text-white font-black text-sm leading-none">WBP Terpilih</p>
                    <p class="text-indigo-300/50 text-[10px] font-bold uppercase tracking-widest mt-1">Aksi Massal</p>
                </div>
            </div>
            
            <div class="flex items-center gap-2">
                @if(in_array($status, ['Mapenaling', 'Strap Cell', 'Sidang TPP']))
                <button type="button" onclick="removeRestriction()"
                    class="group flex items-center gap-2 bg-emerald-500 hover:bg-emerald-600 text-white font-black px-5 py-2.5 rounded-2xl transition-all hover:-translate-y-0.5 active:scale-95 shadow-lg shadow-emerald-500/20">
                    <i class="fas fa-unlock text-emerald-200 group-hover:scale-110 transition-transform"></i>
                    <span class="text-sm">Cabut Pembatasan</span>
                </button>
                <button type="button" onclick="broadcastRestriction()"
                    class="group flex items-center gap-2 bg-blue-500 hover:bg-blue-600 text-white font-black px-5 py-2.5 rounded-2xl transition-all hover:-translate-y-0.5 active:scale-95 shadow-lg shadow-blue-500/20">
                    <i class="fas fa-bullhorn text-blue-200 group-hover:scale-110 transition-transform"></i>
                    <span class="text-sm">Broadcast WA/Email</span>
                </button>
                @else
                <button type="button" onclick="openRestrictionModal()"
                    class="group flex items-center gap-2 bg-amber-500 hover:bg-amber-600 text-white font-black px-5 py-2.5 rounded-2xl transition-all hover:-translate-y-0.5 active:scale-95 shadow-lg shadow-amber-500/20">
                    <i class="fas fa-ban text-amber-200 group-hover:scale-110 transition-transform"></i>
                    <span class="text-sm">Set Pembatasan</span>
                </button>
                <button type="button" onclick="bulkUpdateStatus('Aktif')"
                    class="group flex items-center gap-2 bg-emerald-500 hover:bg-emerald-600 text-white font-black px-5 py-2.5 rounded-2xl transition-all hover:-translate-y-0.5 active:scale-95 shadow-lg shadow-emerald-500/20">
                    <i class="fas fa-check-circle text-emerald-200 group-hover:scale-110 transition-transform"></i>
                    <span class="text-sm">Set Aktif</span>
                </button>
                <button type="button" onclick="bulkUpdateStatus('Bebas')"
                    class="group flex items-center gap-2 bg-rose-500 hover:bg-rose-600 text-white font-black px-5 py-2.5 rounded-2xl transition-all hover:-translate-y-0.5 active:scale-95 shadow-lg shadow-rose-500/20">
                    <i class="fas fa-sign-out-alt text-rose-200 group-hover:scale-110 transition-transform"></i>
                    <span class="text-sm">Set Bebas</span>
                </button>
                @endif
                <button type="button" id="cancel-selection"
                    class="flex items-center justify-center w-10 h-10 rounded-2xl bg-white/5 hover:bg-white/10 text-white/40 hover:text-white transition-all">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {

    // --- Bulk Selection Logic ---
    const selectAll = document.getElementById('select-all');
    const wbpCheckboxes = document.querySelectorAll('.wbp-checkbox');
    const bulkBar = document.getElementById('bulk-action-bar');
    const selectedCountBadge = document.getElementById('selection-badge');
    const selectedCountText = document.getElementById('selected-count');
    const bulkSelectedCountText = document.getElementById('bulk-selected-count');
    const cancelSelection = document.getElementById('cancel-selection');

    function updateBulkUI() {
        const checked = document.querySelectorAll('.wbp-checkbox:checked');
        const count = checked.length;

        selectedCountText.textContent = count;
        bulkSelectedCountText.textContent = count;

        if (count > 0) {
            bulkBar.classList.remove('translate-y-32', 'opacity-0', 'invisible');
            selectedCountBadge.classList.remove('hidden');
        } else {
            bulkBar.classList.add('translate-y-32', 'opacity-0', 'invisible');
            selectedCountBadge.classList.add('hidden');
            selectAll.checked = false;
        }
    }

    if (selectAll) {
        selectAll.addEventListener('change', function() {
            wbpCheckboxes.forEach(cb => cb.checked = this.checked);
            updateBulkUI();
        });
    }

    wbpCheckboxes.forEach(cb => {
        cb.addEventListener('change', updateBulkUI);
    });

    if (cancelSelection) {
        cancelSelection.addEventListener('click', function() {
            wbpCheckboxes.forEach(cb => cb.checked = false);
            if(selectAll) selectAll.checked = false;
            updateBulkUI();
        });
    }

    // --- Bulk Update Action ---
    window.bulkUpdateStatus = function(status) {
        const selectedIds = Array.from(document.querySelectorAll('.wbp-checkbox:checked')).map(cb => cb.value);
        
        if (selectedIds.length === 0) return;

        Swal.fire({
            title: `Set Status ${status}?`,
            text: `${selectedIds.length} data WBP akan diubah statusnya menjadi ${status}.`,
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Ya, Lanjutkan',
            cancelButtonText: 'Batal',
            customClass: {
                popup: 'rounded-3xl',
                confirmButton: `px-6 py-2.5 ${status === 'Aktif' ? 'bg-emerald-600' : 'bg-rose-600'} text-white font-bold rounded-xl mr-2`,
                cancelButton: 'px-6 py-2.5 bg-slate-200 text-slate-700 font-bold rounded-xl'
            },
            buttonsStyling: false
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    title: 'Memproses...',
                    didOpen: () => Swal.showLoading(),
                    allowOutsideClick: false,
                    customClass: { popup: 'rounded-3xl' }
                });

                fetch('{{ route("admin.wbp.bulk-update-status") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        ids: selectedIds,
                        status: status
                    })
                })
                .then(r => r.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: data.message,
                            customClass: { popup: 'rounded-3xl' }
                        }).then(() => window.location.reload());
                    } else {
                        Swal.fire({ icon: 'error', title: 'Gagal', text: data.message, customClass: { popup: 'rounded-3xl' } });
                    }
                })
                .catch(err => {
                    Swal.fire({ icon: 'error', title: 'Error', text: 'Terjadi kesalahan sistem.', customClass: { popup: 'rounded-3xl' } });
                });
            }
        });
    };

    // --- Restriction Actions ---
    window.openRestrictionModal = function() {
        const selectedIds = Array.from(document.querySelectorAll('.wbp-checkbox:checked')).map(cb => cb.value);
        if (selectedIds.length === 0) return;

        Swal.fire({
            title: 'Set Pembatasan Kunjungan',
            html: `
                <div class="text-left space-y-4">
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-1">Jenis Pembatasan</label>
                        <select id="swal-type" class="w-full border-2 border-slate-200 rounded-xl px-4 py-2.5 focus:border-indigo-500 outline-none">
                            <option value="Mapenaling">Mapenaling</option>
                            <option value="Strap Cell">Strap Cell</option>
                            <option value="Sidang TPP">Sidang TPP</option>
                            <option value="Lainnya">Lainnya</option>
                        </select>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-1">Tgl Mulai</label>
                            <input type="date" id="swal-start" class="w-full border-2 border-slate-200 rounded-xl px-4 py-2.5 focus:border-indigo-500 outline-none" value="{{ now()->format('Y-m-d') }}">
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-1">Tgl Selesai</label>
                            <input type="date" id="swal-end" class="w-full border-2 border-slate-200 rounded-xl px-4 py-2.5 focus:border-indigo-500 outline-none">
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-1">Keterangan (Opsional)</label>
                        <textarea id="swal-reason" rows="2" class="w-full border-2 border-slate-200 rounded-xl px-4 py-2.5 focus:border-indigo-500 outline-none" placeholder="Alasan pembatasan..."></textarea>
                    </div>
                </div>
            `,
            showCancelButton: true,
            confirmButtonText: 'Simpan',
            cancelButtonText: 'Batal',
            customClass: { popup: 'rounded-3xl', confirmButton: 'px-6 py-2.5 bg-indigo-600 text-white font-bold rounded-xl mr-2', cancelButton: 'px-6 py-2.5 bg-slate-200 text-slate-700 font-bold rounded-xl' },
            buttonsStyling: false,
            preConfirm: () => {
                const type = document.getElementById('swal-type').value;
                const start_date = document.getElementById('swal-start').value;
                const end_date = document.getElementById('swal-end').value;
                const reason = document.getElementById('swal-reason').value;

                if (!start_date || !end_date) { Swal.showValidationMessage('Tanggal wajib diisi!'); return false; }
                if (end_date < start_date) { Swal.showValidationMessage('Tanggal selesai tidak valid!'); return false; }
                return { type, start_date, end_date, reason };
            }
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({ title: 'Memproses...', didOpen: () => Swal.showLoading(), allowOutsideClick: false, customClass: { popup: 'rounded-3xl' }});
                fetch('{{ route("admin.wbp.set-restriction") }}', { method: 'POST', headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json' }, body: JSON.stringify({ ids: selectedIds, ...result.value }) })
                .then(r => r.json()).then(res => { if(res.success) Swal.fire({ icon: 'success', title: 'Berhasil', text: res.message, customClass: { popup: 'rounded-3xl' } }).then(() => window.location.reload()); else Swal.fire({ icon: 'error', title: 'Gagal', text: res.message, customClass: { popup: 'rounded-3xl' } }); }).catch(() => Swal.fire({ icon: 'error', title: 'Error', text: 'Server error.', customClass: { popup: 'rounded-3xl' } }));
            }
        });
    };

    window.removeRestriction = function() {
        const selectedIds = Array.from(document.querySelectorAll('.wbp-checkbox:checked')).map(cb => cb.value);
        if (selectedIds.length === 0) return;

        Swal.fire({
            title: 'Cabut Pembatasan?', text: `${selectedIds.length} WBP akan dicabut dari daftar pembatasan.`, icon: 'warning', showCancelButton: true, confirmButtonText: 'Ya', cancelButtonText: 'Batal', customClass: { popup: 'rounded-3xl', confirmButton: 'px-6 py-2.5 bg-emerald-600 text-white font-bold rounded-xl mr-2', cancelButton: 'px-6 py-2.5 bg-slate-200 text-slate-700 font-bold rounded-xl' }, buttonsStyling: false
        }).then(r => {
            if(r.isConfirmed) {
                Swal.fire({ title: 'Memproses...', didOpen: () => Swal.showLoading(), allowOutsideClick: false, customClass: { popup: 'rounded-3xl' }});
                fetch('{{ route("admin.wbp.remove-restriction") }}', { method: 'POST', headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json' }, body: JSON.stringify({ ids: selectedIds }) })
                .then(r => r.json()).then(res => { if(res.success) Swal.fire({ icon: 'success', title: 'Berhasil', text: res.message, customClass: { popup: 'rounded-3xl' } }).then(() => window.location.reload()); else Swal.fire({ icon: 'error', title: 'Gagal', text: res.message, customClass: { popup: 'rounded-3xl' } }); }).catch(() => Swal.fire({ icon: 'error', title: 'Error', text: 'Server error.', customClass: { popup: 'rounded-3xl' } }));
            }
        });
    };

    window.broadcastRestriction = function() {
        const selectedIds = Array.from(document.querySelectorAll('.wbp-checkbox:checked')).map(cb => cb.value);
        if (selectedIds.length === 0) return;

        Swal.fire({
            title: 'Kirim Broadcast Batal Kunjungan?', text: `Membatalkan otomatis kunjungan dan mengirimkan WA/Email untuk ${selectedIds.length} WBP.`, icon: 'info', showCancelButton: true, confirmButtonText: 'Ya, Broadcast', cancelButtonText: 'Batal', customClass: { popup: 'rounded-3xl', confirmButton: 'px-6 py-2.5 bg-blue-600 text-white font-bold rounded-xl mr-2', cancelButton: 'px-6 py-2.5 bg-slate-200 text-slate-700 font-bold rounded-xl' }, buttonsStyling: false
        }).then(r => {
            if(r.isConfirmed) {
                Swal.fire({ title: 'Menyusun Antrean Broadcast...', didOpen: () => Swal.showLoading(), allowOutsideClick: false, customClass: { popup: 'rounded-3xl' }});
                fetch('{{ route("admin.wbp.broadcast-restriction") }}', { method: 'POST', headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json' }, body: JSON.stringify({ ids: selectedIds }) })
                .then(r => r.json()).then(res => { if(res.success) Swal.fire({ icon: 'success', title: 'Berhasil', text: res.message, customClass: { popup: 'rounded-3xl' } }).then(() => window.location.reload()); else Swal.fire({ icon: 'error', title: 'Gagal', text: res.message, customClass: { popup: 'rounded-3xl' } }); }).catch(() => Swal.fire({ icon: 'error', title: 'Error', text: 'Server error.', customClass: { popup: 'rounded-3xl' } }));
            }
        });
    };

    // --- File Input Label Update ---
    const fileInput = document.getElementById('file-input');
    const fileNameSpan = document.getElementById('file-name');
    if (fileInput) {
        fileInput.addEventListener('change', function() {
            fileNameSpan.textContent = this.files.length > 0
                ? this.files[0].name
                : 'Pilih file Excel / CSV untuk diimpor...';
        });
    }

    // --- AJAX Import with SweetAlert ---
    const importForm = document.getElementById('import-form');
    if (importForm) {
        importForm.addEventListener('submit', function (e) {
            e.preventDefault();
            const formData = new FormData(this);
            const file = formData.get('file');
            if (!file || file.size === 0) {
                Swal.fire({ icon: 'error', title: 'Pilih File Dulu', text: 'Silakan pilih file CSV/Excel terlebih dahulu!', customClass: { popup: 'rounded-3xl' } });
                return;
            }

            Swal.fire({
                title: 'Mengimpor Data...',
                html: '<div class="flex flex-col items-center"><div class="w-14 h-14 border-4 border-dashed rounded-full animate-spin border-indigo-500"></div><p class="mt-4 text-sm text-slate-500">Mohon tunggu, data sedang diproses.</p></div>',
                showConfirmButton: false,
                allowOutsideClick: false,
                customClass: { popup: 'rounded-3xl' }
            });

            fetch('{{ route("admin.wbp.import") }}', {
                method: 'POST',
                body: formData,
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json' },
            })
            .then(r => r.json())
            .then(data => {
                if (data.success) {
                    Swal.fire({
                        icon: 'success', title: 'Import Berhasil', text: data.message,
                        confirmButtonText: 'Selesai & Muat Ulang',
                        customClass: { popup: 'rounded-3xl', confirmButton: 'px-5 py-2.5 bg-indigo-600 text-white font-bold rounded-xl' },
                        buttonsStyling: false
                    }).then(() => window.location.reload());
                } else {
                    Swal.fire({ icon: 'error', title: 'Import Gagal', text: data.message, customClass: { popup: 'rounded-3xl' } });
                }
            })
            .catch(() => {
                Swal.fire({ icon: 'error', title: 'Kesalahan Koneksi', text: 'Tidak dapat terhubung ke server.', customClass: { popup: 'rounded-3xl' } });
            });
        });
    }

    // --- Delete Confirmation ---
    document.querySelectorAll('.delete-form').forEach(form => {
        form.addEventListener('submit', function (e) {
            e.preventDefault();
            Swal.fire({
                icon: 'warning',
                title: 'Hapus WBP?',
                text: 'Data WBP ini akan dihapus secara permanen.',
                showCancelButton: true,
                confirmButtonText: '<i class="fas fa-trash-alt mr-1"></i> Hapus',
                cancelButtonText: 'Batal',
                customClass: {
                    popup: 'rounded-3xl shadow-2xl',
                    confirmButton: 'px-5 py-2.5 bg-red-600 hover:bg-red-700 text-white font-bold rounded-xl mr-2 transition-all',
                    cancelButton: 'px-5 py-2.5 bg-slate-200 text-slate-700 font-bold rounded-xl transition-all',
                },
                buttonsStyling: false
            }).then(r => { if (r.isConfirmed) form.submit(); });
        });
    });
});
</script>
@endpush