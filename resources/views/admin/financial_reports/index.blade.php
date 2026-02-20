@extends('layouts.admin')

@section('content')
<div class="space-y-8 pb-12">
    {{-- HEADER --}}
    <header class="flex flex-col xl:flex-row justify-between items-start xl:items-center gap-6 animate__animated animate__fadeInDown">
        <div>
            <h1 class="text-4xl font-black text-slate-900 tracking-tighter">
                Laporan Informasi Publik
            </h1>
            <p class="text-slate-500 mt-1 font-medium flex items-center gap-2">
                <i class="fas fa-file-invoice-dollar text-blue-500"></i>
                Kelola transparansi data LHKPN, LAKIP, dan Keuangan.
            </p>
        </div>
        
        <div class="flex flex-wrap items-center gap-3 no-print">
            <div class="flex items-center bg-white p-1.5 rounded-2xl shadow-sm border border-slate-200">
                <a href="{{ route('admin.financial-reports.export-excel') }}" class="flex items-center gap-2 px-4 py-2 text-slate-700 font-bold text-sm hover:bg-indigo-50 hover:text-indigo-600 rounded-xl transition-all">
                    <i class="fas fa-file-excel text-indigo-500"></i>
                    <span>Excel</span>
                </a>
                <div class="w-px h-4 bg-slate-200 mx-1"></div>
                <a href="{{ route('admin.financial-reports.export-pdf') }}" target="_blank" class="flex items-center gap-2 px-4 py-2 text-slate-700 font-bold text-sm hover:bg-rose-50 hover:text-rose-600 rounded-xl transition-all">
                    <i class="fas fa-file-pdf text-rose-500"></i>
                    <span>PDF</span>
                </a>
            </div>

            <a href="{{ route('admin.financial-reports.create') }}" class="flex items-center gap-2 bg-blue-600 text-white font-black px-6 py-3 rounded-2xl shadow-lg shadow-blue-200 hover:bg-blue-700 transition-all active:scale-95">
                <i class="fas fa-plus"></i>
                <span>Tambah Laporan</span>
            </a>
        </div>
    </header>

    {{-- FILTERS --}}
    <form action="{{ route('admin.financial-reports.index') }}" method="GET" class="animate__animated animate__fadeInUp no-print">
        <div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-100 space-y-6">
            <div class="flex flex-col lg:flex-row gap-4">
                <div class="flex-grow relative group">
                    <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-slate-300 group-focus-within:text-blue-500 transition-colors"></i>
                    <input type="text" name="search" value="{{ request('search') }}" class="w-full pl-11 pr-4 py-3.5 bg-slate-50 border-2 border-slate-50 rounded-2xl focus:bg-white focus:border-blue-500 focus:ring-0 font-bold text-slate-700 placeholder-slate-300" placeholder="Cari judul laporan...">
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <select name="category" class="rounded-2xl border-2 border-slate-50 bg-slate-50 font-bold text-slate-600 focus:border-blue-500 focus:ring-0">
                        <option value="">Semua Kategori</option>
                        <option value="LHKPN" {{ request('category') == 'LHKPN' ? 'selected' : '' }}>LHKPN</option>
                        <option value="LAKIP" {{ request('category') == 'LAKIP' ? 'selected' : '' }}>LAKIP</option>
                        <option value="Keuangan" {{ request('category') == 'Keuangan' ? 'selected' : '' }}>Keuangan</option>
                    </select>
                    <button type="submit" class="bg-slate-900 text-white font-black rounded-2xl hover:bg-blue-600 transition-all px-6">Filter</button>
                </div>
            </div>
        </div>
    </form>

    {{-- BULK ACTION & TABLE --}}
    <form id="bulkDeleteForm" action="{{ route('admin.financial-reports.bulk-delete') }}" method="POST">
        @csrf
        <div class="flex justify-between items-center mb-4 px-2 no-print">
            <div class="flex items-center gap-3 bg-white px-4 py-2 rounded-xl border border-slate-200 shadow-sm">
                <input type="checkbox" id="selectAll" class="w-5 h-5 rounded border-slate-300 text-blue-600 focus:ring-blue-500 cursor-pointer">
                <label for="selectAll" class="text-sm font-black text-slate-700 cursor-pointer uppercase tracking-widest">Pilih Semua</label>
                <div class="w-px h-4 bg-slate-200 mx-2"></div>
                <span class="text-xs font-bold text-blue-500"><span id="checkedCount">0</span> dipilih</span>
            </div>
            <button type="button" onclick="confirmBulkDelete()" class="px-5 py-2.5 bg-red-50 text-red-600 font-black rounded-xl border border-red-100 hover:bg-red-600 hover:text-white transition-all text-sm shadow-sm">
                <i class="fas fa-trash-alt mr-2"></i> Hapus Terpilih
            </button>
        </div>

        <div class="bg-white rounded-[2rem] shadow-xl shadow-slate-200/50 border border-slate-100 overflow-hidden overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead>
                    <tr class="bg-slate-50/50 text-slate-400 border-b border-slate-100">
                        <th class="p-6 w-10"></th>
                        <th class="p-6 font-black uppercase tracking-widest text-[10px]">Informasi Laporan</th>
                        <th class="p-6 font-black uppercase tracking-widest text-[10px]">Kategori</th>
                        <th class="p-6 font-black uppercase tracking-widest text-[10px] text-center">Tahun</th>
                        <th class="p-6 font-black uppercase tracking-widest text-[10px] text-center">Akses</th>
                        <th class="p-6 font-black uppercase tracking-widest text-[10px] text-center">Opsi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($reports as $report)
                    <tr class="group hover:bg-blue-50/30 transition-all duration-300">
                        <td class="p-6">
                            <input type="checkbox" name="ids[]" value="{{ $report->id }}" class="report-checkbox w-5 h-5 rounded border-slate-200 text-blue-600 focus:ring-blue-500 cursor-pointer">
                        </td>
                        <td class="p-6">
                            <div class="font-black text-slate-800 text-lg leading-tight group-hover:text-blue-600 transition-colors">{{ $report->title }}</div>
                            <p class="text-xs text-slate-400 mt-1 line-clamp-1 italic">{{ $report->description ?? 'Tidak ada deskripsi.' }}</p>
                        </td>
                        <td class="p-6">
                            <span class="px-3 py-1.5 rounded-xl bg-blue-50 text-blue-600 text-[10px] font-black uppercase tracking-widest border border-blue-100">
                                {{ $report->category }}
                            </span>
                        </td>
                        <td class="p-6 text-center">
                            <div class="text-lg font-black text-slate-700">{{ $report->year }}</div>
                        </td>
                        <td class="p-6 text-center">
                            @if($report->is_published)
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-emerald-50 text-emerald-600 rounded-full text-[10px] font-black uppercase border border-emerald-100">
                                    <i class="fas fa-globe-asia"></i> Publik
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-slate-100 text-slate-400 rounded-full text-[10px] font-black uppercase border border-slate-200">
                                    <i class="fas fa-lock"></i> Draft
                                </span>
                            @endif
                        </td>
                        <td class="p-6 text-center">
                            <div class="flex justify-center items-center gap-2">
                                <a href="{{ Storage::url($report->file_path) }}" target="_blank" class="w-10 h-10 rounded-xl bg-white border border-slate-100 text-blue-600 hover:bg-blue-600 hover:text-white transition-all flex items-center justify-center shadow-sm">
                                    <i class="fas fa-external-link-alt text-sm"></i>
                                </a>
                                <a href="{{ route('admin.financial-reports.edit', $report->id) }}" class="w-10 h-10 rounded-xl bg-white border border-slate-100 text-amber-600 hover:bg-amber-600 hover:text-white transition-all flex items-center justify-center shadow-sm">
                                    <i class="fas fa-pencil-alt text-sm"></i>
                                </a>
                                <button type="button" onclick="confirmDelete('{{ $report->id }}', '{{ $report->title }}')" class="w-10 h-10 rounded-xl bg-white border border-slate-100 text-slate-300 hover:text-red-600 transition-all flex items-center justify-center">
                                    <i class="fas fa-trash-alt text-sm"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="py-32 text-center">
                            <i class="fas fa-folder-open text-6xl text-slate-100 mb-4"></i>
                            <h3 class="text-xl font-black text-slate-800">Belum ada laporan</h3>
                            <p class="text-slate-400 mt-1">Silakan tambah laporan baru atau sesuaikan filter Anda.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </form>

    <div class="pt-6">
        {{ $reports->links() }}
    </div>
</div>

<form id="deleteForm" method="POST" class="hidden">
    @csrf
    @method('DELETE')
</form>

@push('scripts')
<script>
    const updateCount = () => {
        const count = document.querySelectorAll('.report-checkbox:checked').length;
        document.getElementById('checkedCount').innerText = count;
    };

    document.querySelectorAll('.report-checkbox').forEach(cb => cb.addEventListener('change', updateCount));

    document.getElementById('selectAll').addEventListener('change', function() {
        document.querySelectorAll('.report-checkbox').forEach(cb => cb.checked = this.checked);
        updateCount();
    });

    function confirmDelete(id, title) {
        Swal.fire({
            ...swalTheme,
            title: 'Hapus Laporan?',
            html: `Hapus file laporan <b>${title}</b>?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Hapus',
            customClass: { ...swalTheme.customClass, confirmButton: 'px-6 py-3 bg-red-600 text-white font-black rounded-xl mx-2' }
        }).then((result) => {
            if (result.isConfirmed) {
                const form = document.getElementById('deleteForm');
                form.action = `/admin/financial-reports/${id}`;
                form.submit();
            }
        });
    }

    function confirmBulkDelete() {
        const count = document.querySelectorAll('.report-checkbox:checked').length;
        if(count === 0) return;

        Swal.fire({
            ...swalTheme,
            title: `Hapus ${count} Laporan?`,
            text: "Data akan dihapus permanen.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, Hapus Semua!',
            customClass: { ...swalTheme.customClass, confirmButton: 'px-8 py-4 bg-red-600 text-white font-black rounded-2xl shadow-xl shadow-red-100' }
        }).then((result) => {
            if (result.isConfirmed) document.getElementById('bulkDeleteForm').submit();
        });
    }
</script>
@endpush
@endsection
