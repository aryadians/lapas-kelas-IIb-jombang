@extends('layouts.admin')

@section('content')
<div class="space-y-6">
    
    {{-- Header --}}
    <div class="flex flex-col md:flex-row justify-between items-center gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">🗂️ Database Warga Binaan</h1>
            <p class="text-slate-500 text-sm mt-1">Kelola data WBP, lokasi sel, dan masa tahanan.</p>
        </div>
        <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3 w-full sm:w-auto">
            <div class="bg-white border border-slate-200 px-4 py-2.5 rounded-xl shadow-sm flex items-center gap-3 transform hover:-translate-y-1 transition-transform duration-300">
                <div class="p-2 bg-blue-100 text-blue-600 rounded-lg">
                    <i class="fa-solid fa-users text-lg"></i>
                </div>
                <div>
                    <p class="text-xs font-bold text-slate-400 uppercase">Total WBP</p>
                    <p class="text-2xl font-black text-slate-800">{{ $wbps->total() }}</p>
                </div>
            </div>
            <a href="{{ route('admin.wbp.create') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white py-3 px-5 rounded-xl shadow-lg hover:shadow-indigo-500/50 font-semibold flex items-center justify-center gap-2 transform hover:-translate-y-1 transition-all duration-300">
                <i class="fa-solid fa-plus"></i>
                <span>Tambah WBP</span>
            </a>
        </div>
    </div>

    {{-- Content Card --}}
    <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-slate-200">
        
        <div class="p-5 border-b border-slate-100 bg-slate-50/50 flex flex-col md:flex-row justify-between items-center gap-4">
            
            <form id="import-form" action="{{ route('admin.wbp.import') }}" method="POST" enctype="multipart/form-data" class="flex w-full md:w-auto items-center gap-3">
                @csrf
                <div class="relative flex-1 md:w-80">
                    <input type="file" name="file" id="file-input" class="hidden" required accept=".xlsx,.xls,.csv,.txt">
                    <label for="file-input" id="file-input-label" class="w-full cursor-pointer bg-white border border-slate-300 rounded-lg flex items-center shadow-sm transition-all duration-300 hover:shadow-md hover:border-indigo-300">
                        <div class="bg-slate-100 h-full p-3 rounded-l-lg border-r border-slate-300">
                            <i class="fa-solid fa-file-excel text-slate-500 text-lg"></i>
                        </div>
                        <span id="file-name" class="flex-1 px-3 text-sm text-slate-500 truncate">
                            Pilih file Excel atau CSV...
                        </span>
                        <span class="text-xs bg-indigo-600 text-white font-semibold py-1 px-3 rounded-full mr-2 shadow-sm">
                            Browse
                        </span>
                    </label>
                </div>
                <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white p-3 rounded-lg transition shadow-lg hover:shadow-indigo-500/50 flex-shrink-0 transform hover:-translate-y-0.5" title="Upload & Replace Data">
                    <i class="fa-solid fa-cloud-arrow-up text-lg"></i>
                </button>
            </form>

            <form method="GET" class="relative w-full md:w-72">
                <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </span>
                <input type="text" name="search" value="{{ request('search') }}" class="w-full pl-10 pr-4 py-2.5 bg-white border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition shadow-sm" placeholder="Cari Nama / No. Reg...">
            </form>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-slate-100 text-slate-600 uppercase text-xs font-bold tracking-wider">
                    <tr>
                        <th class="p-4">Identitas WBP</th>
                        <th class="p-4 text-center">Lokasi</th>
                        <th class="p-4">Masa Tahanan</th>
                        <th class="p-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($wbps as $wbp)
                    <tr class="hover:bg-indigo-50/50 transition duration-150 group">
                        <td class="p-4 align-top">
                            <div class="flex items-start gap-3">
                                <div class="mt-1 bg-slate-200 h-8 w-8 rounded-full flex items-center justify-center text-slate-500 text-xs"><i class="fa-solid fa-user"></i></div>
                                <div>
                                    <a href="{{ route('admin.wbp.show', $wbp->id) }}" class="font-bold text-slate-800 text-sm hover:text-indigo-600 transition-colors">{{ $wbp->nama }}</a>
                                    <div class="flex items-center gap-2 mt-1">
                                        <span class="text-xs font-mono bg-slate-200 text-slate-600 px-1.5 py-0.5 rounded border border-slate-300">{{ $wbp->no_registrasi }}</span>
                                        @if($wbp->nama_panggilan && $wbp->nama_panggilan != '-')
                                            <span class="text-xs text-amber-700 bg-amber-100 px-1.5 py-0.5 rounded border border-amber-200">Alias: {{ $wbp->nama_panggilan }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td class="p-4 align-middle text-center">
                            <div class="inline-flex divide-x divide-slate-200 border border-slate-200 rounded-lg bg-white shadow-sm">
                                <div class="px-3 py-1"><span class="block text-[10px] text-slate-400 font-bold uppercase">Blok</span><span class="font-bold text-indigo-600">{{ $wbp->blok ?? '-' }}</span></div>
                                <div class="px-3 py-1"><span class="block text-[10px] text-slate-400 font-bold uppercase">Kamar</span><span class="font-bold text-emerald-600">{{ $wbp->kamar ?? '-' }}</span></div>
                            </div>
                        </td>
                        <td class="p-4 align-middle">
                            <div class="space-y-1 text-xs">
                                <div class="flex justify-between w-40"><span class="text-slate-500">Masuk:</span><span class="font-medium text-slate-700">{{ $wbp->tanggal_masuk ? \Carbon\Carbon::parse($wbp->tanggal_masuk)->format('d/m/Y') : '-' }}</span></div>
                                <div class="flex justify-between w-40"><span class="text-slate-500">Ekspirasi:</span><span class="font-bold text-red-600">{{ $wbp->tanggal_ekspirasi ? \Carbon\Carbon::parse($wbp->tanggal_ekspirasi)->format('d/m/Y') : '-' }}</span></div>
                            </div>
                        </td>
                        <td class="p-4 align-middle text-center">
                            <div class="flex justify-center items-center gap-2">
                                <a href="{{ route('admin.wbp.history', $wbp->id) }}" class="action-btn bg-slate-100 hover:bg-slate-200 text-slate-500" title="Riwayat"><i class="fa-solid fa-clock-rotate-left"></i></a>
                                <a href="{{ route('admin.wbp.edit', $wbp->id) }}" class="action-btn bg-blue-100 hover:bg-blue-200 text-blue-600" title="Edit"><i class="fa-solid fa-pencil"></i></a>
                                <form action="{{ route('admin.wbp.destroy', $wbp->id) }}" method="POST" class="delete-form">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="action-btn bg-red-100 hover:bg-red-200 text-red-600" title="Hapus"><i class="fa-solid fa-trash-alt"></i></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="p-12 text-center text-slate-400 bg-slate-50/30">
                            <div class="flex flex-col items-center"><i class="fa-regular fa-folder-open text-4xl mb-3 opacity-50"></i><p class="text-sm font-medium">Data WBP belum tersedia.</p><p class="text-xs mt-1">Silahkan upload file CSV atau tambah data manual.</p></div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-4 border-t border-slate-100 bg-slate-50/50">
            {{ $wbps->links() }}
        </div>
    </div>
</div>

<style>
.action-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 32px;
    height: 32px;
    border-radius: 0.5rem;
    transition: all 0.3s ease;
    transform-style: preserve-3d;
}
.action-btn:hover {
    transform: translateY(-2px) scale(1.1);
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
}
</style>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    // --- File Input UI ---
    const fileInput = document.getElementById('file-input');
    const fileNameSpan = document.getElementById('file-name');
    if (fileInput) {
        fileInput.addEventListener('change', function() {
            if (this.files.length > 0) {
                fileNameSpan.textContent = this.files[0].name;
            } else {
                fileNameSpan.textContent = 'Pilih file Excel atau CSV untuk diimpor...';
            }
        });
    }

    // --- AJAX Form Submission for Import ---
    const importForm = document.getElementById('import-form');
    if (importForm) {
        importForm.addEventListener('submit', function (e) {
            e.preventDefault();

            const formData = new FormData(this);
            const file = formData.get('file');

            if (!file || file.size === 0) {
                Swal.fire({ ...swalTheme, icon: 'error', title: 'Oops...', text: 'Silakan pilih file terlebih dahulu!' });
                return;
            }
            
            Swal.fire({
                ...swalTheme,
                title: 'Mengimpor Data...',
                html: '<div class="flex flex-col items-center"><div class="w-16 h-16 border-4 border-dashed rounded-full animate-spin border-indigo-500"></div><p class="mt-4 text-sm text-slate-500">Mohon tunggu, data sedang diproses.</p></div>',
                showConfirmButton: false,
                allowOutsideClick: false,
            });

            fetch('{{ route("admin.wbp.import") }}', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json',
                },
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire({
                        ...swalTheme,
                        icon: 'success',
                        title: 'Import Berhasil',
                        text: data.message,
                        confirmButtonText: 'Selesai & Muat Ulang'
                    }).then(() => {
                        window.location.reload();
                    });
                } else {
                    Swal.fire({ ...swalTheme, icon: 'error', title: 'Import Gagal', text: data.message });
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire({ ...swalTheme, icon: 'error', title: 'Terjadi Kesalahan', text: 'Tidak dapat terhubung ke server. Silakan coba lagi.' });
            });
        });
    }
    
    // --- SweetAlert for Delete Confirmation ---
    const deleteForms = document.querySelectorAll('.delete-form');
    deleteForms.forEach(form => {
        form.addEventListener('submit', function (e) {
            e.preventDefault();
            Swal.fire({
                ...swalTheme,
                icon: 'warning',
                title: 'Anda Yakin?',
                text: "Data WBP ini akan dihapus secara permanen.",
                showCancelButton: true,
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal',
                customClass: {
                    ...swalTheme.customClass,
                    confirmButton: 'px-5 py-2.5 bg-red-600 hover:bg-red-700 text-white font-semibold rounded-lg transition-all duration-200 mx-1.5 shadow-lg shadow-red-500/30 focus:outline-none focus:ring-4 focus:ring-red-300',
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });
});
</script>
@endpush