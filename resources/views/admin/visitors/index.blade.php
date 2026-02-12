@extends('layouts.admin')

@section('content')
{{-- Load Animate.css, FontAwesome, & Lightbox --}}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
<script src="https://cdnjs.cloudflare.com/ajax/libs/fslightbox/3.4.1/index.min.js"></script>

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

    /* Print optimization */
    @media print {
        .no-print { display: none !important; }
        .text-gradient { -webkit-text-fill-color: #1e293b !important; }
        .glass-panel { border: none !important; box-shadow: none !important; }
        body { background: white !important; }
    }
</style>

<div class="space-y-8 pb-12">

    {{-- HEADER --}}
    <header class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 animate__animated animate__fadeInDown">
        <div>
            <h1 class="text-4xl font-extrabold text-gradient">
                Database Pengunjung
            </h1>
            <p class="text-slate-500 mt-2 font-medium">Data rekapitulasi profil pengunjung.</p>
        </div>
        <div class="flex items-center flex-wrap gap-3 no-print">
            <a href="{{ route('admin.visitors.export-excel') }}" class="group flex items-center gap-2 bg-indigo-600 text-white font-bold px-5 py-2.5 rounded-xl shadow-lg hover:bg-indigo-700 transition-all active:scale-95">
                <i class="fas fa-file-excel"></i>
                <span>Export Excel</span>
            </a>
            <button onclick="window.print()" class="group flex items-center gap-2 bg-rose-600 text-white font-bold px-5 py-2.5 rounded-xl shadow-lg hover:bg-rose-700 transition-all active:scale-95">
                <i class="fas fa-file-pdf"></i>
                <span>Cetak PDF</span>
            </button>
        </div>
    </header>

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

    {{-- FORM PENCARIAN --}}
    <form action="{{ route('admin.visitors.index') }}" method="GET" class="animate__animated animate__fadeInUp no-print">
        <div class="glass-panel rounded-2xl p-6">
            <div class="flex flex-col md:flex-row gap-4">
                <div class="relative flex-grow group">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <i class="fas fa-search text-slate-400 group-focus-within:text-blue-500 transition-colors"></i>
                    </div>
                    <input type="text" name="search" value="{{ request('search') }}" class="w-full pl-11 pr-4 py-3.5 bg-slate-50 border-2 border-slate-100 rounded-xl focus:bg-white focus:border-blue-500 focus:ring-0 transition-all font-medium text-slate-700 placeholder-slate-400" placeholder="Cari Nama Pengunjung atau NIK...">
                </div>
                <div class="flex gap-3">
                    <button type="submit" class="px-8 py-3.5 bg-slate-800 text-white font-bold rounded-xl hover:bg-slate-900 transition-all shadow-lg active:scale-95 flex items-center gap-2">
                        <i class="fas fa-filter text-sm"></i> Filter
                    </button>
                    <a href="{{ route('admin.visitors.index') }}" class="px-6 py-3.5 bg-white text-slate-600 font-bold rounded-xl border-2 border-slate-200 hover:bg-slate-50 transition-all active:scale-95 text-center">
                        Reset
                    </a>
                </div>
            </div>
        </div>
    </form>

    {{-- TABLE PENGUNJUNG --}}
    <form id="bulkDeleteForm" action="{{ route('admin.visitors.bulk-delete') }}" method="POST">
        @csrf
        <div class="flex justify-between items-center mb-4 px-2 no-print">
            <div class="flex items-center gap-2">
                <input type="checkbox" id="selectAll" class="w-4 h-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                <label for="selectAll" class="text-sm font-medium text-slate-600">Pilih Semua</label>
            </div>
            <button type="button" onclick="confirmBulkDelete()" class="px-4 py-2 bg-red-50 text-red-600 font-bold rounded-lg border border-red-100 hover:bg-red-100 transition-all flex items-center gap-2 text-sm">
                <i class="fas fa-trash-alt"></i> Hapus Terpilih
            </button>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden overflow-x-auto animate__animated animate__fadeIn">
            <table class="w-full text-sm text-left text-slate-500">
                <thead class="text-xs text-slate-700 uppercase bg-slate-50">
                    <tr>
                        <th scope="col" class="px-6 py-4 w-10 no-print"></th>
                        <th scope="col" class="px-6 py-4">No</th>
                        <th scope="col" class="px-6 py-4">Identitas Pengunjung</th>
                        <th scope="col" class="px-6 py-4">Kontak</th>
                        <th scope="col" class="px-6 py-4">Alamat</th>
                        <th scope="col" class="px-6 py-4 text-center">Dokumen</th>
                        <th scope="col" class="px-6 py-4 text-center">Statistik</th>
                        <th scope="col" class="px-6 py-4 text-center no-print">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($visitors as $index => $visitor)
                    <tr class="bg-white border-b hover:bg-slate-50 transition-colors">
                        <td class="px-6 py-4 no-print">
                            <input type="checkbox" name="ids[]" value="{{ $visitor->id }}" class="visitor-checkbox w-4 h-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                        </td>
                        <td class="px-6 py-4 font-bold text-slate-600">
                            {{ $visitors->firstItem() + $index }}
                        </td>
                        <td class="px-6 py-4">
                            <button type="button" onclick="showHistory('{{ $visitor->id }}')" class="font-bold text-slate-800 text-base hover:text-blue-600 transition-colors text-left">
                                {{ $visitor->nama }}
                            </button>
                            <div class="text-xs text-slate-500 bg-slate-100 px-2 py-0.5 rounded inline-block mt-1" title="{{ $visitor->nik }}">
                                NIK: {{ substr($visitor->nik, 0, 6) . '******' . substr($visitor->nik, -4) }}
                            </div>
                            <div class="text-xs text-slate-400 mt-1">
                                {{ $visitor->jenis_kelamin }}
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex flex-col gap-1">
                                @if($visitor->nomor_hp)
                                    <a href="https://wa.me/{{ preg_replace('/^0/', '62', $visitor->nomor_hp) }}" target="_blank" class="flex items-center gap-2 text-emerald-600 font-semibold hover:underline">
                                        <i class="fab fa-whatsapp"></i> {{ $visitor->nomor_hp }}
                                    </a>
                                @endif
                                <div class="flex items-center gap-2 text-slate-500 text-xs">
                                    <i class="far fa-envelope"></i> {{ $visitor->email ?? '-' }}
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="block max-w-xs truncate" title="{{ $visitor->alamat }}">
                                {{ Str::limit($visitor->alamat, 50) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-center">
                            @if($visitor->foto_ktp)
                                @php
                                    $fotoUrl = \Illuminate\Support\Str::startsWith($visitor->foto_ktp, 'data:') 
                                        ? $visitor->foto_ktp 
                                        : asset('storage/' . $visitor->foto_ktp);
                                @endphp
                                <a data-fslightbox="gallery" href="{{ $fotoUrl }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-blue-50 text-blue-600 rounded-lg text-xs font-bold hover:bg-blue-100 transition-colors border border-blue-100 no-print">
                                    <i class="fas fa-id-card"></i> Lihat KTP
                                </a>
                                <span class="hidden print:inline text-xs text-slate-500">Ada Foto KTP</span>
                            @else
                                <span class="text-xs text-slate-400 italic">Tidak ada foto</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-center">
                            <div class="flex flex-col gap-1 items-center">
                                <span class="px-3 py-1 rounded-full bg-slate-100 text-slate-700 text-[10px] font-bold uppercase tracking-wider">
                                    {{ $visitor->total_kunjungan ?? 0 }}x Berkunjung
                                </span>
                                @if($visitor->last_visit)
                                <span class="text-[10px] text-slate-400">
                                    Terakhir: {{ $visitor->last_visit->format('d/m/Y') }}
                                </span>
                                @endif
                            </div>
                        </td>
                        <td class="px-6 py-4 text-center no-print">
                            <button type="button" onclick="confirmDelete('{{ $visitor->id }}', '{{ $visitor->nama }}')" class="text-red-500 hover:text-red-700 transition-colors">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="py-20 text-center">
                            <div class="w-24 h-24 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-4 animate__animated animate__pulse animate__infinite">
                                <i class="fas fa-users-slash text-4xl text-slate-300"></i>
                            </div>
                            <h3 class="text-xl font-bold text-slate-700">Belum ada data pengunjung</h3>
                            <p class="text-slate-500 mt-1">Data akan muncul setelah ada pendaftaran kunjungan.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </form>

    {{-- PAGINATION --}}
    @if ($visitors->hasPages())
    <div class="animate__animated animate__fadeInUp">
        {{ $visitors->links() }}
    </div>
    @endif

</div>

{{-- MODAL HAPUS --}}
<form id="deleteForm" method="POST">
    @csrf
    @method('DELETE')
</form>

{{-- MODAL POPUP RIWAYAT KUNJUNGAN --}}
<div id="historyModal" class="fixed inset-0 z-50 hidden overflow-y-auto no-print" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 bg-slate-900 bg-opacity-75 transition-opacity" aria-hidden="true" onclick="closeHistory()"></div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
        <div class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-4xl w-full border border-slate-200">
            <div class="bg-white px-6 py-5 border-b border-slate-100 flex justify-between items-center">
                <h3 class="text-xl font-bold text-slate-800" id="modal-title">
                    Riwayat Kunjungan: <span id="historyNama" class="text-blue-600"></span>
                </h3>
                <button type="button" onclick="closeHistory()" class="text-slate-400 hover:text-slate-600 transition-colors">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>
            <div class="bg-white px-6 py-6 max-h-[60vh] overflow-y-auto">
                <div id="historyLoading" class="flex justify-center py-10">
                    <div class="animate-spin rounded-full h-10 w-10 border-b-2 border-blue-600"></div>
                </div>
                <div id="historyContent" class="hidden">
                    <table class="w-full text-sm text-left text-slate-500">
                        <thead class="text-xs text-slate-700 uppercase bg-slate-50">
                            <tr>
                                <th class="px-4 py-3">Tanggal</th>
                                <th class="px-4 py-3">Status</th>
                                <th class="px-4 py-3">WBP yang Dikunjungi</th>
                                <th class="px-4 py-3">Barang Bawaan</th>
                            </tr>
                        </thead>
                        <tbody id="historyTableBody">
                            {{-- Data will be injected here via AJAX --}}
                        </tbody>
                    </table>
                    <div id="noHistory" class="hidden py-10 text-center">
                        <p class="text-slate-500 italic">Belum ada riwayat kunjungan.</p>
                    </div>
                </div>
            </div>
            <div class="bg-slate-50 px-6 py-4 flex justify-end">
                <button type="button" onclick="closeHistory()" class="px-5 py-2.5 bg-white text-slate-700 font-bold rounded-xl border-2 border-slate-200 hover:bg-slate-50 transition-all active:scale-95">
                    Tutup
                </button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function showHistory(id) {
        const modal = document.getElementById('historyModal');
        const loading = document.getElementById('historyLoading');
        const content = document.getElementById('historyContent');
        const tableBody = document.getElementById('historyTableBody');
        const noHistory = document.getElementById('noHistory');
        const namaSpan = document.getElementById('historyNama');

        modal.classList.remove('hidden');
        loading.classList.remove('hidden');
        content.classList.add('hidden');
        noHistory.classList.add('hidden');
        tableBody.innerHTML = '';

        fetch(`/admin/pengunjung/${id}/history`)
            .then(response => response.json())
            .then(data => {
                namaSpan.innerText = data.visitor.nama;
                loading.classList.add('hidden');
                content.classList.remove('hidden');

                if (data.history.length === 0) {
                    noHistory.classList.remove('hidden');
                } else {
                    data.history.forEach(item => {
                        const date = new Date(item.tanggal_kunjungan).toLocaleDateString('id-ID', {
                            day: '2-digit',
                            month: 'long',
                            year: 'numeric'
                        });

                        const statusBadge = getStatusBadge(item.status);
                        
                        const row = `
                            <tr class="border-b border-slate-50 hover:bg-slate-50 transition-colors">
                                <td class="px-4 py-3 font-medium text-slate-700">${date}</td>
                                <td class="px-4 py-3">${statusBadge}</td>
                                <td class="px-4 py-3">
                                    <div class="font-bold text-slate-800">${item.wbp ? item.wbp.nama : '-'}</div>
                                    <div class="text-xs text-slate-500">${item.wbp ? item.wbp.no_registrasi : ''}</div>
                                </td>
                                <td class="px-4 py-3 text-slate-600">${item.barang_bawaan || '-'}</td>
                            </tr>
                        `;
                        tableBody.innerHTML += row;
                    });
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire({ ...swalTheme, icon: 'error', title: 'Gagal!', text: 'Gagal mengambil data riwayat.' });
                closeHistory();
            });
    }

    function getStatusBadge(status) {
        const statuses = {
            'pending': 'bg-amber-100 text-amber-700',
            'approved': 'bg-emerald-100 text-emerald-700',
            'rejected': 'bg-rose-100 text-rose-700',
            'completed': 'bg-blue-100 text-blue-700',
            'on_queue': 'bg-indigo-100 text-indigo-700'
        };
        const colorClass = statuses[status.toLowerCase()] || 'bg-slate-100 text-slate-700';
        return `<span class="px-2 py-0.5 rounded-full text-[10px] font-bold uppercase ${colorClass}">${status}</span>`;
    }

    function closeHistory() {
        document.getElementById('historyModal').classList.add('hidden');
    }

    function confirmDelete(id, nama) {
        Swal.fire({
            ...swalTheme,
            title: 'Hapus Data Pengunjung?',
            html: `Apakah Anda yakin ingin menghapus data pengunjung <b>${nama}</b>? <br><span class="text-sm text-red-500">Data ini akan terhapus secara permanen.</span>`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal',
            customClass: {
                ...swalTheme.customClass,
                confirmButton: 'px-6 py-3 bg-red-600 hover:bg-red-700 text-white font-semibold rounded-lg transition-all duration-300 mx-2 shadow-lg hover:shadow-red-500/50'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                const form = document.getElementById('deleteForm');
                form.action = '/pengunjung/' + id;
                form.submit();
            }
        });
    }

    function confirmBulkDelete() {
        const checked = document.querySelectorAll('.visitor-checkbox:checked');
        if (checked.length === 0) {
            Swal.fire({
                ...swalTheme,
                icon: 'info',
                title: 'Tidak Ada Data',
                text: 'Pilih data yang ingin dihapus terlebih dahulu.',
                confirmButtonText: 'Mengerti'
            });
            return;
        }

        Swal.fire({
            ...swalTheme,
            title: `Hapus ${checked.length} Data?`,
            text: "Apakah Anda yakin ingin menghapus data pengunjung yang dipilih? Aksi ini tidak dapat dibatalkan.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, Hapus Semua!',
            cancelButtonText: 'Batal',
            customClass: {
                ...swalTheme.customClass,
                confirmButton: 'px-6 py-3 bg-red-600 hover:bg-red-700 text-white font-semibold rounded-lg transition-all duration-300 mx-2 shadow-lg hover:shadow-red-500/50'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('bulkDeleteForm').submit();
            }
        });
    }

    document.getElementById('selectAll').addEventListener('change', function() {
        const checkboxes = document.querySelectorAll('.visitor-checkbox');
        checkboxes.forEach(cb => cb.checked = this.checked);
    });
</script>
@endpush
@endsection