@extends('layouts.admin')

@section('title', 'Laporan Informasi Publik')

@section('content')
<div class="space-y-6 pb-12">

    {{-- HERO HEADER --}}
    <div class="relative bg-gradient-to-br from-slate-900 via-blue-950 to-indigo-950 rounded-3xl overflow-hidden shadow-2xl">
        <div class="absolute inset-0 pointer-events-none overflow-hidden">
            <div class="absolute -top-20 -right-20 w-72 h-72 bg-blue-400 rounded-full blur-[80px] opacity-10"></div>
            <div class="absolute -bottom-12 -left-12 w-56 h-56 bg-indigo-400 rounded-full blur-[70px] opacity-10"></div>
        </div>
        <div class="relative z-10 px-8 py-7 flex flex-col md:flex-row items-start md:items-center justify-between gap-5">
            <div>
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/10 border border-white/20 text-blue-200 text-xs font-bold uppercase tracking-widest mb-3">
                    <i class="fas fa-file-invoice-dollar"></i> Transparansi Publik
                </div>
                <h1 class="text-3xl md:text-4xl font-black text-white tracking-tight">Laporan Informasi Publik</h1>
                <p class="text-blue-100/60 mt-1 text-sm">Kelola dokumen LHKPN, LAKIP, dan Keuangan.</p>
            </div>
            <div class="flex items-center gap-3 flex-wrap">
                <div class="flex items-center bg-white/10 border border-white/20 rounded-2xl p-1">
                    <a href="{{ route('admin.financial-reports.export-excel') }}"
                        class="flex items-center gap-1.5 px-4 py-2 rounded-xl text-blue-200 hover:bg-white/10 font-bold text-sm transition-all">
                        <i class="fas fa-file-excel text-emerald-400"></i> Excel
                    </a>
                    <div class="w-px h-4 bg-white/20 mx-1"></div>
                    <a href="{{ route('admin.financial-reports.export-pdf') }}" target="_blank"
                        class="flex items-center gap-1.5 px-4 py-2 rounded-xl text-blue-200 hover:bg-white/10 font-bold text-sm transition-all">
                        <i class="fas fa-file-pdf text-rose-400"></i> PDF
                    </a>
                </div>
                <a href="{{ route('admin.financial-reports.create') }}"
                    class="inline-flex items-center gap-2 bg-white text-indigo-700 hover:bg-indigo-50 font-black px-5 py-2.5 rounded-2xl shadow-xl transition-all hover:-translate-y-0.5 active:scale-95 text-sm">
                    <i class="fas fa-plus"></i> Tambah Laporan
                </a>
            </div>
        </div>
    </div>

    {{-- FILTER --}}
    <form action="{{ route('admin.financial-reports.index') }}" method="GET">
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-4 flex flex-col sm:flex-row gap-3">
            <div class="flex-1 relative">
                <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-sm"></i>
                <input type="text" name="search" value="{{ request('search') }}"
                    placeholder="Cari judul laporan..."
                    class="w-full pl-11 pr-4 py-3 bg-slate-50 border-2 border-slate-100 rounded-xl text-sm font-medium text-slate-700 placeholder-slate-400 focus:border-blue-400 focus:outline-none focus:bg-white transition-all">
            </div>
            <div class="relative sm:w-48">
                <select name="category"
                    class="w-full pl-4 pr-8 py-3 bg-slate-50 border-2 border-slate-100 rounded-xl text-sm font-bold text-slate-600 focus:border-blue-400 focus:outline-none appearance-none cursor-pointer transition-all">
                    <option value="">Semua Kategori</option>
                    <option value="LHKPN" {{ request('category') == 'LHKPN' ? 'selected' : '' }}>LHKPN</option>
                    <option value="LAKIP" {{ request('category') == 'LAKIP' ? 'selected' : '' }}>LAKIP</option>
                    <option value="Keuangan" {{ request('category') == 'Keuangan' ? 'selected' : '' }}>Keuangan</option>
                </select>
                <i class="fas fa-chevron-down absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 text-xs pointer-events-none"></i>
            </div>
            <div class="flex gap-2">
                <button type="submit" class="px-5 py-3 bg-slate-900 hover:bg-blue-600 text-white font-black rounded-xl transition-all shadow-md active:scale-95 text-sm flex items-center gap-2">
                    <i class="fas fa-filter"></i> Filter
                </button>
                @if(request()->anyFilled(['search','category']))
                <a href="{{ route('admin.financial-reports.index') }}" class="px-4 py-3 bg-slate-100 hover:bg-slate-200 text-slate-600 font-bold rounded-xl transition-all text-sm flex items-center">
                    <i class="fas fa-times"></i>
                </a>
                @endif
            </div>
        </div>
    </form>

    {{-- BULK + TABLE --}}
    <form id="bulkDeleteForm" action="{{ route('admin.financial-reports.bulk-delete') }}" method="POST">
        @csrf
        {{-- Bulk Bar --}}
        <div class="flex justify-between items-center mb-3 px-1">
            <div class="flex items-center gap-2.5 bg-white px-4 py-2.5 rounded-2xl border border-slate-200 shadow-sm">
                <input type="checkbox" id="selectAll" class="w-4 h-4 rounded border-slate-300 text-blue-600 focus:ring-blue-500 cursor-pointer">
                <label for="selectAll" class="text-xs font-black text-slate-700 cursor-pointer uppercase tracking-widest">Pilih Semua</label>
                <div class="w-px h-4 bg-slate-200"></div>
                <span class="text-xs font-bold text-blue-500"><span id="checkedCount">0</span> dipilih</span>
            </div>
            <button type="button" onclick="confirmBulkDelete()"
                class="px-4 py-2.5 bg-red-50 text-red-600 font-bold rounded-xl border border-red-100 hover:bg-red-600 hover:text-white transition-all text-sm shadow-sm active:scale-95 flex items-center gap-2">
                <i class="fas fa-trash-alt"></i> Hapus Terpilih
            </button>
        </div>

        {{-- Table --}}
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="bg-slate-50 border-b border-slate-100">
                    <tr>
                        <th class="px-5 py-3.5 w-10"></th>
                        <th class="px-5 py-3.5 font-black uppercase tracking-widest text-[10px] text-slate-400">Informasi Laporan</th>
                        <th class="px-5 py-3.5 font-black uppercase tracking-widest text-[10px] text-slate-400">Kategori</th>
                        <th class="px-5 py-3.5 font-black uppercase tracking-widest text-[10px] text-slate-400 text-center">Tahun</th>
                        <th class="px-5 py-3.5 font-black uppercase tracking-widest text-[10px] text-slate-400 text-center">Akses</th>
                        <th class="px-5 py-3.5 font-black uppercase tracking-widest text-[10px] text-slate-400 text-center w-28">Opsi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($reports as $report)
                    <tr class="group hover:bg-blue-50/30 transition-colors">
                        <td class="px-5 py-4">
                            <input type="checkbox" name="ids[]" value="{{ $report->id }}" class="report-checkbox w-4 h-4 rounded border-slate-300 text-blue-600 focus:ring-blue-500 cursor-pointer">
                        </td>
                        <td class="px-5 py-4">
                            <div class="font-black text-slate-800 text-sm leading-tight group-hover:text-blue-600 transition-colors">{{ $report->title }}</div>
                            <p class="text-xs text-slate-400 mt-1 line-clamp-1 italic">{{ $report->description ?? 'Tidak ada deskripsi.' }}</p>
                        </td>
                        <td class="px-5 py-4">
                            @php
                                $catColors = ['LHKPN'=>'bg-violet-100 text-violet-700 border-violet-200','LAKIP'=>'bg-blue-100 text-blue-700 border-blue-200','Keuangan'=>'bg-emerald-100 text-emerald-700 border-emerald-200'];
                                $cc = $catColors[$report->category] ?? 'bg-slate-100 text-slate-600 border-slate-200';
                            @endphp
                            <span class="px-2.5 py-1 rounded-xl {{ $cc }} text-[10px] font-black uppercase tracking-widest border">{{ $report->category }}</span>
                        </td>
                        <td class="px-5 py-4 text-center">
                            <span class="text-base font-black text-slate-700">{{ $report->year }}</span>
                        </td>
                        <td class="px-5 py-4 text-center">
                            @if($report->is_published)
                            <span class="inline-flex items-center gap-1 px-2.5 py-1 bg-emerald-50 text-emerald-600 rounded-full text-[10px] font-black uppercase border border-emerald-100">
                                <i class="fas fa-globe-asia text-[9px]"></i> Publik
                            </span>
                            @else
                            <span class="inline-flex items-center gap-1 px-2.5 py-1 bg-slate-100 text-slate-400 rounded-full text-[10px] font-black uppercase border border-slate-200">
                                <i class="fas fa-lock text-[9px]"></i> Draft
                            </span>
                            @endif
                        </td>
                        <td class="px-5 py-4 text-center">
                            <div class="flex justify-center items-center gap-1.5">
                                <a href="{{ Storage::url($report->file_path) }}" target="_blank"
                                    class="w-9 h-9 rounded-xl bg-blue-50 hover:bg-blue-600 border-2 border-blue-100 hover:border-blue-600 text-blue-600 hover:text-white transition-all flex items-center justify-center hover:shadow-md hover:shadow-blue-500/30 hover:-translate-y-0.5 active:scale-95">
                                    <i class="fas fa-external-link-alt text-xs"></i>
                                </a>
                                <a href="{{ route('admin.financial-reports.edit', $report->id) }}"
                                    class="w-9 h-9 rounded-xl bg-amber-50 hover:bg-amber-500 border-2 border-amber-100 hover:border-amber-500 text-amber-600 hover:text-white transition-all flex items-center justify-center hover:shadow-md hover:shadow-amber-500/30 hover:-translate-y-0.5 active:scale-95">
                                    <i class="fas fa-pencil-alt text-xs"></i>
                                </a>
                                <button type="button" onclick="confirmDelete('{{ $report->id }}', '{{ addslashes($report->title) }}')"
                                    class="w-9 h-9 rounded-xl bg-red-50 hover:bg-red-500 border-2 border-red-100 hover:border-red-500 text-red-500 hover:text-white transition-all flex items-center justify-center hover:shadow-md hover:shadow-red-500/30 hover:-translate-y-0.5 active:scale-95">
                                    <i class="fas fa-trash-alt text-xs"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="py-16 text-center">
                            <div class="w-14 h-14 bg-slate-100 rounded-3xl flex items-center justify-center text-slate-300 text-2xl mx-auto mb-3">
                                <i class="fas fa-folder-open"></i>
                            </div>
                            <h3 class="font-black text-slate-700 mb-1">Belum ada laporan</h3>
                            <p class="text-slate-400 text-sm">Silakan tambah laporan baru atau sesuaikan filter.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </form>

    @if($reports->hasPages())
    <div class="pt-2">{{ $reports->links() }}</div>
    @endif
</div>

<form id="deleteForm" method="POST" class="hidden">@csrf @method('DELETE')</form>

@push('scripts')
<script>
    const updateCount = () => {
        document.getElementById('checkedCount').innerText = document.querySelectorAll('.report-checkbox:checked').length;
    };
    document.querySelectorAll('.report-checkbox').forEach(cb => cb.addEventListener('change', updateCount));
    document.getElementById('selectAll').addEventListener('change', function() {
        document.querySelectorAll('.report-checkbox').forEach(cb => cb.checked = this.checked);
        updateCount();
    });
    function confirmDelete(id, title) {
        Swal.fire({ icon: 'warning', title: 'Hapus Laporan?', html: `Hapus <b>${title}</b>?`, showCancelButton: true, confirmButtonText: 'Hapus', cancelButtonText: 'Batal',
            customClass: { popup:'rounded-3xl', confirmButton:'px-5 py-2.5 bg-red-600 text-white font-bold rounded-xl mx-1', cancelButton:'px-5 py-2.5 bg-slate-100 text-slate-700 font-bold rounded-xl mx-1' }, buttonsStyling: false
        }).then(r => { if(r.isConfirmed){ const f=document.getElementById('deleteForm'); f.action=`/admin/financial-reports/${id}`; f.submit(); } });
    }
    function confirmBulkDelete() {
        const count = document.querySelectorAll('.report-checkbox:checked').length;
        if(!count) return;
        Swal.fire({ icon: 'warning', title: `Hapus ${count} Laporan?`, text: 'Data akan dihapus permanen.', showCancelButton: true, confirmButtonText: 'Ya, Hapus!', cancelButtonText: 'Batal',
            customClass: { popup:'rounded-3xl', confirmButton:'px-5 py-2.5 bg-red-600 text-white font-bold rounded-xl mx-1', cancelButton:'px-5 py-2.5 bg-slate-100 text-slate-700 font-bold rounded-xl mx-1' }, buttonsStyling: false
        }).then(r => { if(r.isConfirmed) document.getElementById('bulkDeleteForm').submit(); });
    }
</script>
@endpush
@endsection
