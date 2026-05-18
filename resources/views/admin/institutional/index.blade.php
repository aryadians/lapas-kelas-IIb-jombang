@extends('layouts.admin')

@section('title', 'Manajemen Informasi Lembaga')

@section('content')
<div class="space-y-6 pb-12">
    {{-- HEADER --}}
    <div class="bg-gradient-to-br from-slate-900 via-indigo-950 to-purple-950 rounded-[2.5rem] p-10 text-white shadow-2xl relative overflow-hidden group">
        <div class="absolute top-0 right-0 w-64 h-64 bg-blue-500/10 rounded-full blur-3xl -mt-20 -mr-20 group-hover:bg-blue-500/20 transition-all duration-700"></div>
        <div class="relative z-10 flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
            <div>
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/10 border border-white/20 text-blue-200 text-[10px] font-black uppercase tracking-[0.2em] mb-4">
                    <i class="fas fa-sync-alt animate-spin-slow"></i> Real-time Sync Active
                </div>
                <h1 class="text-4xl font-black tracking-tight">Informasi Lembaga</h1>
                <p class="text-indigo-200/70 mt-2 font-medium max-w-xl text-lg">Kelola profil resmi institusi yang tampil di halaman depan secara dinamis.</p>
            </div>
            <div class="flex items-center gap-4">
                <div class="bg-white/10 backdrop-blur-md border border-white/20 rounded-3xl p-6 hidden lg:block text-center">
                    <p class="text-3xl font-black text-white">{{ count($infos) }}</p>
                    <p class="text-[10px] font-bold text-blue-200 uppercase tracking-widest mt-1">Total Seksi</p>
                </div>
                <a href="{{ route('admin.institutional.create') }}" class="flex items-center gap-2 px-6 py-4 bg-white text-indigo-900 font-black rounded-2xl shadow-xl hover:-translate-y-1 hover:shadow-2xl transition-all">
                    <i class="fas fa-plus"></i> Tambah Baru
                </a>
            </div>
        </div>
    </div>

    {{-- LIST --}}
    <div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-xl overflow-hidden animate__animated animate__fadeInUp">
        
        {{-- Toolbar: Select All --}}
        <div class="px-8 py-5 border-b border-slate-100 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <label class="flex items-center gap-2 cursor-pointer group">
                    <input type="checkbox" id="select-all" class="w-5 h-5 rounded-lg border-2 border-slate-200 text-indigo-600 focus:ring-indigo-500 transition-all cursor-pointer">
                    <span class="text-xs font-bold text-slate-500 group-hover:text-slate-700 transition-colors uppercase tracking-wider">Pilih Semua</span>
                </label>
                <div id="selection-badge" class="hidden animate__animated animate__fadeIn">
                    <span class="bg-indigo-100 text-indigo-700 text-[10px] font-black px-2.5 py-1 rounded-full border border-indigo-200">
                        <span id="selected-count">0</span> Terpilih
                    </span>
                </div>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="bg-slate-50/80 text-slate-500 uppercase text-[10px] font-black tracking-[0.15em]">
                    <tr>
                        <th class="px-8 py-5 w-12 text-center"><i class="fas fa-check text-slate-300"></i></th>
                        <th class="px-8 py-5">Identitas Informasi</th>
                        <th class="px-8 py-5">Preview Konten</th>
                        <th class="px-8 py-5 text-center min-w-[150px]">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach($infos as $info)
                    <tr class="hover:bg-slate-50/50 transition-all group">
                        <td class="px-8 py-6 text-center">
                            <input type="checkbox" class="info-checkbox w-5 h-5 rounded-lg border-2 border-slate-200 text-indigo-600 focus:ring-indigo-500 transition-all cursor-pointer" value="{{ $info->id }}">
                        </td>
                        <td class="px-8 py-6">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 rounded-2xl bg-slate-100 text-slate-500 flex items-center justify-center group-hover:bg-blue-600 group-hover:text-white transition-all shadow-sm">
                                    <i class="fas {{ $info->key === 'visi' ? 'fa-eye' : ($info->key === 'misi' ? 'fa-bullseye' : 'fa-landmark') }} text-lg"></i>
                                </div>
                                <div>
                                    <p class="font-black text-slate-800 text-base leading-tight uppercase">{{ $info->title }}</p>
                                    <span class="text-[10px] font-mono text-slate-400 bg-white px-2 py-0.5 rounded border border-slate-200 mt-1.5 inline-block tracking-tighter">KEY: {{ $info->key }} | TYPE: {{ strtoupper($info->type) }}</span>
                                </div>
                            </div>
                        </td>
                        <td class="px-8 py-6">
                            <div class="text-slate-500 max-w-lg">
                                <div class="line-clamp-3 leading-relaxed text-xs italic font-medium">
                                    {!! strip_tags($info->content) !!}
                                </div>
                            </div>
                        </td>
                        <td class="px-8 py-6 text-center">
                            <div class="inline-flex items-center gap-2">
                                <a href="{{ route('admin.institutional.edit', $info->id) }}" 
                                   class="inline-flex items-center justify-center w-10 h-10 rounded-2xl bg-white border-2 border-slate-100 text-slate-600 hover:bg-blue-600 hover:text-white hover:border-blue-600 transition-all shadow-sm active:scale-95" title="Edit">
                                    <i class="fas fa-pencil"></i>
                                </a>
                                <form action="{{ route('admin.institutional.destroy', $info->id) }}" method="POST" class="delete-form inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="inline-flex items-center justify-center w-10 h-10 rounded-2xl bg-white border-2 border-slate-100 text-rose-500 hover:bg-rose-500 hover:text-white hover:border-rose-500 transition-all shadow-sm active:scale-95" title="Hapus">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{-- FLOATING BULK ACTION BAR --}}
    <div id="bulk-action-bar" 
        class="fixed bottom-8 left-1/2 -translate-x-1/2 z-50 translate-y-32 opacity-0 invisible transition-all duration-500 ease-out">
        <div class="bg-slate-900/90 backdrop-blur-xl border border-white/10 px-6 py-4 rounded-3xl shadow-[0_20px_50px_rgba(0,0,0,0.3)] flex items-center gap-6">
            <div class="flex items-center gap-3 pr-6 border-r border-white/10">
                <div class="w-10 h-10 rounded-2xl bg-rose-500/20 text-rose-400 flex items-center justify-center font-black">
                    <span id="bulk-selected-count">0</span>
                </div>
                <div>
                    <p class="text-white font-black text-sm leading-none">Terpilih</p>
                    <p class="text-rose-300/50 text-[10px] font-bold uppercase tracking-widest mt-1">Aksi Massal</p>
                </div>
            </div>
            
            <div class="flex items-center gap-2">
                <button type="button" onclick="bulkDelete()"
                    class="group flex items-center gap-2 bg-rose-600 hover:bg-rose-700 text-white font-black px-5 py-2.5 rounded-2xl transition-all hover:-translate-y-0.5 active:scale-95 shadow-lg shadow-rose-600/30">
                    <i class="fas fa-trash-alt text-rose-200 group-hover:scale-110 transition-transform"></i>
                    <span class="text-sm">Hapus Massal</span>
                </button>
                <button type="button" id="cancel-selection"
                    class="flex items-center justify-center w-10 h-10 rounded-2xl bg-white/5 hover:bg-white/10 text-white/40 hover:text-white transition-all">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
    </div>
</div>

<style>
    .animate-spin-slow { animation: spin 4s linear infinite; }
    @keyframes spin { from { transform: rotate(0deg); } to { transform: rotate(360deg); } }
</style>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    // Single Delete
    document.querySelectorAll('.delete-form').forEach(form => {
        form.addEventListener('submit', function (e) {
            e.preventDefault();
            Swal.fire({
                icon: 'warning',
                title: 'Hapus Informasi?',
                text: 'Data ini akan dihapus secara permanen dari sistem dan halaman publik.',
                showCancelButton: true,
                confirmButtonText: '<i class="fas fa-trash-alt mr-1"></i> Hapus',
                cancelButtonText: 'Batal',
                customClass: {
                    popup: 'rounded-[2rem] border border-slate-100 shadow-2xl',
                    confirmButton: 'px-6 py-2.5 bg-rose-600 hover:bg-rose-700 text-white font-bold rounded-xl mr-2 transition-all',
                    cancelButton: 'px-6 py-2.5 bg-slate-100 text-slate-700 font-bold rounded-xl hover:bg-slate-200 transition-all',
                },
                buttonsStyling: false
            }).then(r => { if (r.isConfirmed) form.submit(); });
        });
    });

    // Bulk Logic
    const selectAll = document.getElementById('select-all');
    const checkboxes = document.querySelectorAll('.info-checkbox');
    const bulkBar = document.getElementById('bulk-action-bar');
    const selCountBadge = document.getElementById('selection-badge');
    const selCountText = document.getElementById('selected-count');
    const bulkCountText = document.getElementById('bulk-selected-count');
    const cancelSel = document.getElementById('cancel-selection');

    function updateBulkUI() {
        const checked = document.querySelectorAll('.info-checkbox:checked');
        const count = checked.length;
        
        if (selCountText) selCountText.textContent = count;
        if (bulkCountText) bulkCountText.textContent = count;

        if (count > 0) {
            bulkBar.classList.remove('translate-y-32', 'opacity-0', 'invisible');
            selCountBadge.classList.remove('hidden');
        } else {
            bulkBar.classList.add('translate-y-32', 'opacity-0', 'invisible');
            selCountBadge.classList.add('hidden');
            if(selectAll) selectAll.checked = false;
        }
    }

    if (selectAll) {
        selectAll.addEventListener('change', function() {
            checkboxes.forEach(cb => cb.checked = this.checked);
            updateBulkUI();
        });
    }

    checkboxes.forEach(cb => cb.addEventListener('change', updateBulkUI));

    if (cancelSel) {
        cancelSel.addEventListener('click', function() {
            checkboxes.forEach(cb => cb.checked = false);
            if(selectAll) selectAll.checked = false;
            updateBulkUI();
        });
    }

    window.bulkDelete = function() {
        const selectedIds = Array.from(document.querySelectorAll('.info-checkbox:checked')).map(cb => cb.value);
        if (selectedIds.length === 0) return;

        Swal.fire({
            title: `Hapus ${selectedIds.length} Data?`,
            text: 'Data yang dipilih akan dihapus permanen.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, Hapus Massal',
            cancelButtonText: 'Batal',
            customClass: {
                popup: 'rounded-[2rem] border border-slate-100 shadow-2xl',
                confirmButton: 'px-6 py-2.5 bg-rose-600 hover:bg-rose-700 text-white font-bold rounded-xl mr-2 transition-all',
                cancelButton: 'px-6 py-2.5 bg-slate-100 text-slate-700 font-bold rounded-xl hover:bg-slate-200 transition-all',
            },
            buttonsStyling: false
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({ title: 'Memproses...', didOpen: () => Swal.showLoading(), allowOutsideClick: false, customClass: { popup: 'rounded-3xl' } });
                fetch('{{ route("admin.institutional.bulk-delete") }}', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json' },
                    body: JSON.stringify({ ids: selectedIds })
                }).then(r => r.json()).then(res => {
                    if(res.success) {
                        Swal.fire({ icon: 'success', title: 'Berhasil', text: res.message, customClass: { popup: 'rounded-3xl' } }).then(() => window.location.reload());
                    } else {
                        Swal.fire({ icon: 'error', title: 'Gagal', text: res.message, customClass: { popup: 'rounded-3xl' } });
                    }
                }).catch(() => Swal.fire({ icon: 'error', title: 'Error', text: 'Terjadi kesalahan server.', customClass: { popup: 'rounded-3xl' } }));
            }
        });
    };
});
</script>
@endpush
@endsection
