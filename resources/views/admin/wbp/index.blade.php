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
                    <p class="text-[10px] text-indigo-200 font-bold uppercase tracking-widest mt-0.5">Total WBP</p>
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

    {{-- CONTENT CARD --}}
    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">

        {{-- Toolbar: Import + Search --}}
        <div class="px-6 py-4 border-b border-slate-100 flex flex-col lg:flex-row items-start lg:items-center gap-4">

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
                        @if($wbp->blok || $wbp->kamar)
                        <span class="inline-flex items-center gap-1 text-[11px] font-bold text-indigo-600 bg-indigo-50 border border-indigo-100 px-2 py-0.5 rounded-lg">
                            <i class="fas fa-door-open text-[9px]"></i>
                            Blok {{ $wbp->blok ?? '-' }} / Kamar {{ $wbp->kamar ?? '-' }}
                        </span>
                        @endif
                        @if($wbp->kode_tahanan)
                        <span class="inline-flex items-center gap-1 text-[11px] font-bold text-teal-600 bg-teal-50 border border-teal-100 px-2 py-0.5 rounded-lg">
                            <i class="fas fa-tag text-[9px]"></i>
                            {{ $wbp->kode_tahanan }}
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
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {

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