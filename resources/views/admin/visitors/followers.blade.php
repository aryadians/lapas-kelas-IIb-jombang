@extends('layouts.admin')

@section('content')
{{-- Load Animate.css, FontAwesome, & Lightbox --}}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>

<div class="space-y-6 pb-16">

    {{-- HERO HEADER --}}
    <div class="relative bg-gradient-to-br from-slate-900 via-indigo-950 to-slate-900 rounded-3xl overflow-hidden shadow-2xl no-print">
        <div class="absolute inset-0 pointer-events-none overflow-hidden">
            <div class="absolute -top-20 -right-20 w-80 h-80 bg-indigo-400 rounded-full blur-[90px] opacity-10"></div>
            <div class="absolute -bottom-16 -left-16 w-60 h-60 bg-blue-400 rounded-full blur-[80px] opacity-10"></div>
        </div>
        <div class="relative z-10 px-8 py-7 flex flex-col md:flex-row items-start md:items-center justify-between gap-6">
            <div>
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/10 border border-white/20 text-indigo-200 text-xs font-bold uppercase tracking-widest mb-3">
                    <i class="fas fa-user-friends"></i> Relasi Pengunjung
                </div>
                <h1 class="text-3xl md:text-4xl font-black text-white tracking-tight">Database Pengikut</h1>
                <p class="text-indigo-100/60 mt-1 text-sm">Daftar keluarga/pendamping yang menyertai pengunjung utama.</p>
            </div>
            <div class="flex flex-wrap items-center gap-3">
                <div class="bg-white/10 border border-white/20 rounded-2xl px-5 py-3 text-center">
                    <p class="text-2xl font-black text-white">{{ $followers->total() }}</p>
                    <p class="text-[10px] text-indigo-200 font-bold uppercase tracking-widest mt-0.5">Total Pengikut</p>
                </div>
                {{-- Export buttons --}}
                <div class="flex items-center bg-white/10 border border-white/20 rounded-2xl p-1">
                    <a href="{{ route('admin.visitors.followers.export-excel') }}"
                        class="flex items-center gap-1.5 px-4 py-2 rounded-xl text-indigo-200 hover:bg-white/10 font-bold text-sm transition-all no-print">
                        <i class="fas fa-file-excel text-emerald-400"></i> Excel
                    </a>
                    <div class="w-px h-4 bg-white/20 mx-1"></div>
                    <a href="{{ route('admin.visitors.followers.export-pdf') }}" target="_blank"
                        class="flex items-center gap-1.5 px-4 py-2 rounded-xl text-indigo-200 hover:bg-white/10 font-bold text-sm transition-all no-print">
                        <i class="fas fa-file-pdf text-rose-400"></i> PDF
                    </a>
                </div>
                {{-- Delete All --}}
                <button type="button" onclick="confirmDeleteAllFollowers()"
                    class="flex items-center gap-2 bg-red-500/20 border border-red-400/30 text-red-200 hover:bg-red-500 hover:text-white font-bold px-4 py-2.5 rounded-2xl transition-all active:scale-95 text-sm no-print">
                    <i class="fas fa-trash-alt"></i> Kosongkan
                </button>
            </div>
        </div>
    </div>

    {{-- SUB-NAV --}}
    <div class="flex gap-2 p-1 bg-slate-100 rounded-2xl w-fit no-print">
        <a href="{{ route('admin.visitors.index', ['limit' => request('limit')]) }}" class="px-6 py-2.5 rounded-xl text-sm font-bold text-slate-500 hover:text-slate-700 transition-all">
            <i class="fas fa-users mr-2"></i> Database Pengunjung
        </a>
        <div class="bg-white px-6 py-2.5 rounded-xl text-sm font-black text-indigo-600 shadow-sm">
            <i class="fas fa-user-friends mr-2"></i> Database Pengikut
        </div>
    </div>

    {{-- FILTERS --}}
    <form action="{{ route('admin.visitors.followers') }}" method="GET" class="no-print">
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-5">
            <div class="flex flex-col lg:flex-row gap-3">
                <div class="flex-1 relative">
                    <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-sm"></i>
                    <input type="text" name="search" value="{{ request('search') }}"
                        class="w-full pl-11 pr-4 py-3 bg-slate-50 border-2 border-slate-100 rounded-xl focus:bg-white focus:border-indigo-400 focus:outline-none font-medium text-slate-700 placeholder-slate-400 transition-all text-sm"
                        placeholder="Cari Nama Pengikut atau NIK...">
                </div>
                <div class="relative lg:w-44">
                    <select name="limit" onchange="this.form.submit()" class="w-full pl-4 pr-8 py-3 bg-slate-50 border-2 border-slate-100 rounded-xl focus:border-indigo-400 focus:outline-none font-bold text-slate-600 cursor-pointer text-sm appearance-none transition-all">
                        <option value="15" {{ request('limit', '15') == '15' ? 'selected' : '' }}>15 data</option>
                        <option value="50" {{ request('limit') == '50' ? 'selected' : '' }}>50 data</option>
                        <option value="100" {{ request('limit') == '100' ? 'selected' : '' }}>100 data</option>
                        <option value="all" {{ request('limit') == 'all' ? 'selected' : '' }}>Tampilkan Semua</option>
                    </select>
                    <i class="fas fa-chevron-down absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 text-xs pointer-events-none"></i>
                </div>
                <div class="flex gap-2">
                    <button type="submit" class="px-8 py-3 bg-slate-900 hover:bg-indigo-600 text-white font-black rounded-xl transition-all shadow-md active:scale-95 text-sm flex items-center gap-2">
                        <i class="fas fa-search"></i> Cari
                    </button>
                    @if(request('search'))
                    <a href="{{ route('admin.visitors.followers', ['limit' => request('limit')]) }}" class="px-4 py-3 bg-slate-100 hover:bg-slate-200 text-slate-600 font-bold rounded-xl transition-all active:scale-95 text-sm flex items-center">
                        <i class="fas fa-times"></i>
                    </a>
                    @endif
                </div>
            </div>
        </div>
    </form>

    {{-- BULK ACTION BAR --}}
    <form id="bulkDeleteForm" action="{{ route('admin.visitors.followers.bulk-delete') }}" method="POST" class="space-y-6">
        @csrf
        <div class="flex flex-col sm:flex-row justify-between items-center gap-3 no-print">
            <div class="flex items-center gap-3 bg-white px-5 py-2.5 rounded-2xl border border-slate-200 shadow-sm">
                <input type="checkbox" id="selectAll" class="w-4 h-4 rounded-lg border-slate-300 text-indigo-600 focus:ring-indigo-500 cursor-pointer">
                <label for="selectAll" class="text-xs font-black text-slate-700 cursor-pointer uppercase tracking-widest">Pilih Semua</label>
                <div class="w-px h-4 bg-slate-200"></div>
                <span class="text-xs font-black text-indigo-600"><span id="checkedCount">0</span> Terpilih</span>
            </div>
            <button type="button" onclick="confirmBulkDelete()"
                class="w-full sm:w-auto px-5 py-2.5 bg-white text-red-600 font-bold rounded-2xl border-2 border-red-100 hover:bg-red-600 hover:text-white hover:border-red-600 transition-all flex items-center justify-center gap-2 text-sm active:scale-95 shadow-sm">
                <i class="fas fa-trash-alt"></i> Hapus Massal
            </button>
        </div>

        {{-- TABLE CARD --}}
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left">
                    <thead class="bg-slate-50 border-b border-slate-100">
                        <tr>
                            <th class="px-5 py-3.5 w-10 no-print"></th>
                            <th class="px-5 py-3.5 font-black uppercase tracking-widest text-[10px] text-slate-400">Identitas Pengikut</th>        
                            <th class="px-5 py-3.5 font-black uppercase tracking-widest text-[10px] text-slate-400">Hubungan & Visitor</th>
                            <th class="px-5 py-3.5 font-black uppercase tracking-widest text-[10px] text-slate-400">Tujuan WBP</th>
                            <th class="px-5 py-3.5 font-black uppercase tracking-widest text-[10px] text-slate-400">Barang Bawaan</th>    
                            <th class="px-5 py-3.5 font-black uppercase tracking-widest text-[10px] text-slate-400 text-center">Dokumen</th>
                            <th class="px-5 py-3.5 font-black uppercase tracking-widest text-[10px] text-slate-400 text-center">Tgl Terdaftar</th> 
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @forelse ($followers as $follower)
                        <tr class="group hover:bg-indigo-50/30 transition-colors">
                            <td class="px-5 py-4 no-print">
                                <input type="checkbox" name="ids[]" value="{{ $follower->id }}" class="follower-checkbox w-4 h-4 rounded-lg border-slate-300 text-indigo-600 focus:ring-indigo-500 cursor-pointer">
                            </td>
                            <td class="px-5 py-4">
                                <div class="flex items-center gap-4">
                                    <div class="w-10 h-10 rounded-full bg-slate-100 flex items-center justify-center text-slate-400 font-black shadow-sm group-hover:scale-105 transition-transform">
                                        <i class="fas fa-user text-xs"></i>
                                    </div>
                                    <div>
                                        <p class="font-black text-slate-800 leading-tight">{{ $follower->nama }}</p>
                                        <p class="text-[10px] font-mono text-slate-400 mt-1 tracking-wider">{{ $follower->nik ?: '-' }}</p>      
                                    </div>
                                </div>
                            </td>
                            <td class="px-5 py-4">
                                <div class="space-y-1">
                                    <span class="inline-flex items-center px-2 py-0.5 rounded bg-indigo-50 text-indigo-700 text-[9px] font-black uppercase tracking-widest border border-indigo-100">
                                        {{ $follower->hubungan ?: '—' }}
                                    </span>
                                    <p class="text-[10px] font-bold text-slate-500 italic">
                                        By: {{ optional($follower->kunjungan->profilPengunjung)->nama ?: '—' }}
                                    </p>
                                </div>
                            </td>
                            <td class="px-5 py-4">
                                <div class="flex items-center gap-2">
                                    <div class="w-1.5 h-1.5 rounded-full bg-teal-400"></div>
                                    <p class="text-xs font-black text-slate-700">{{ optional($follower->kunjungan->wbp)->nama ?: '—' }}</p>
                                </div>
                            </td>
                            <td class="px-5 py-4">
                                <p class="text-xs text-slate-500 font-medium italic truncate max-w-[150px]">{{ $follower->barang_bawaan ?: 'Nihil' }}</p>
                            </td>                            <td class="px-5 py-4 text-center">
                                @if($follower->foto_ktp)
                                    <button type="button" onclick="showFollowerKtp('{{ $follower->foto_ktp_url }}', '{{ $follower->nama }}')"
                                        class="inline-flex items-center gap-1.5 px-3 py-2 bg-white border-2 border-slate-100 hover:bg-indigo-500 hover:border-indigo-500 hover:text-white text-indigo-600 rounded-xl text-xs font-black transition-all shadow-sm active:scale-95 no-print">
                                        <i class="fas fa-id-card"></i> KTP
                                    </button>
                                @else
                                    <span class="text-[10px] text-slate-300 font-black uppercase">Nihil</span>
                                @endif
                            </td>
                            <td class="px-5 py-4 text-center">
                                <p class="text-xs font-bold text-slate-500">{{ $follower->created_at ? $follower->created_at->format('d/m/Y') : '—' }}</p>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="py-20 text-center">
                                <div class="w-16 h-16 bg-slate-100 rounded-3xl flex items-center justify-center text-slate-300 text-3xl mx-auto mb-3">
                                    <i class="fas fa-user-friends"></i>
                                </div>
                                <h3 class="font-black text-slate-700 mb-1">Database Pengikut Kosong</h3>
                                <p class="text-slate-400 text-sm">Belum ada data pengikut yang terekam.</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </form>

    {{-- PAGINATION --}}
    @if ($followers->hasPages())
    <div class="pt-6">
        {{ $followers->links() }}
    </div>
    @endif

</div>

{{-- MODAL LIHAT KTP --}}
<div id="followerKtpModal" class="fixed inset-0 z-[120] hidden overflow-y-auto no-print" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 bg-slate-950/90 backdrop-blur-xl transition-opacity duration-500" aria-hidden="true" onclick="closeFollowerKtpModal()"></div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
        <div class="inline-block align-bottom bg-white rounded-[3.5rem] text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-xl w-full animate__animated animate__fadeInUp animate__faster">
            <div class="bg-white px-10 py-8 border-b border-slate-50 flex justify-between items-center">
                <div>
                    <p class="text-[10px] font-black text-indigo-500 uppercase tracking-[0.3em] mb-1.5">Identitas Pengikut</p>
                    <h3 class="text-2xl font-black text-slate-800 tracking-tighter">
                        KTP: <span id="followerKtpNama" class="text-indigo-600"></span>
                    </h3>
                </div>
                <button type="button" onclick="closeFollowerKtpModal()" class="w-12 h-12 rounded-2xl bg-slate-50 text-slate-400 hover:text-slate-900 hover:bg-slate-100 transition-all flex items-center justify-center">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>
            <div class="p-10 text-center bg-slate-100/30">
                <div class="relative inline-block group">
                    <img id="followerKtpImg" src="" class="max-w-full h-auto rounded-[2.5rem] shadow-2xl mx-auto border-[12px] border-white transition-transform duration-700 group-hover:scale-105" alt="KTP Pengikut">
                    <div class="absolute inset-0 rounded-[2.5rem] ring-1 ring-black/5 pointer-events-none"></div>
                </div>
            </div>
            <div class="bg-white px-10 py-8 flex justify-end gap-3">
                <a id="ktpDownloadBtn" href="" download="" class="px-8 py-5 bg-indigo-600 text-white font-black rounded-2xl hover:bg-indigo-700 transition-all active:scale-95 flex items-center gap-2">
                    <i class="fas fa-download"></i> Unduh
                </a>
                <button type="button" onclick="closeFollowerKtpModal()" class="px-8 py-5 bg-slate-100 text-slate-600 font-black rounded-2xl hover:bg-slate-200 transition-all active:scale-95">
                    Tutup
                </button>
            </div>
        </div>
    </div>
</div>

<form id="deleteForm" method="POST">
    @csrf
    @method('DELETE')
</form>

@push('scripts')
<script>
    const updateCount = () => {
        const count = document.querySelectorAll('.follower-checkbox:checked').length;
        const countEl = document.getElementById('checkedCount');
        if(countEl) {
            countEl.innerText = count;
            countEl.parentElement.classList.toggle('bg-indigo-50', count > 0);
            countEl.parentElement.classList.toggle('text-indigo-600', count > 0);
        }
    };

    document.querySelectorAll('.follower-checkbox').forEach(cb => {
        cb.addEventListener('change', updateCount);
    });

    const selectAllCb = document.getElementById('selectAll');
    if(selectAllCb) {
        selectAllCb.addEventListener('change', function() {
            document.querySelectorAll('.follower-checkbox').forEach(cb => cb.checked = this.checked);
            updateCount();
        });
    }

    function showFollowerKtp(src, nama) {
        const modal = document.getElementById('followerKtpModal');
        const img = document.getElementById('followerKtpImg');
        const nameText = document.getElementById('followerKtpNama');
        const downloadBtn = document.getElementById('ktpDownloadBtn');
        
        img.src = src;
        nameText.innerText = nama;
        downloadBtn.href = src;
        downloadBtn.download = `KTP_Pengikut_${nama.replace(/\s+/g, '_')}.jpg`;
        
        modal.classList.remove('hidden');
        document.body.classList.add('overflow-hidden');
    }

    function closeFollowerKtpModal() {
        document.getElementById('followerKtpModal').classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
    }

    function confirmBulkDelete() {
        const checked = document.querySelectorAll('.follower-checkbox:checked');
        if (checked.length === 0) {
            Swal.fire({
                ...swalTheme,
                icon: 'info',
                title: 'Data Belum Dipilih',
                text: 'Silakan beri centang pada data yang ingin dihapus.',
                confirmButtonText: 'Mengerti'
            });
            return;
        }

        Swal.fire({
            ...swalTheme,
            title: `Hapus ${checked.length} Pengikut Terpilih?`,
            text: "Data pengikut terpilih akan dihapus dari database profil.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, Hapus Semua!',
            cancelButtonText: 'Batal',
            customClass: {
                ...swalTheme.customClass,
                confirmButton: 'px-10 py-4 bg-red-600 hover:bg-red-700 text-white font-black rounded-2xl shadow-2xl shadow-red-200'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('bulkDeleteForm').submit();
            }
        });
    }

    function confirmDeleteAllFollowers() {
        Swal.fire({
            ...swalTheme,
            title: '⚠️ KOSONGKAN DATABASE PENGIKUT?',
            text: "Seluruh profil pengikut akan dimusnahkan secara permanen.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, Kosongkan!',
            cancelButtonText: 'Batalkan',
            customClass: {
                ...swalTheme.customClass,
                confirmButton: 'px-10 py-4 bg-red-600 hover:bg-red-700 text-white font-black rounded-2xl shadow-2xl shadow-red-200'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                const form = document.getElementById('deleteForm');
                form.action = "{{ route('admin.visitors.followers.delete-all') }}";
                form.submit();
            }
        });
    }
</script>
@endpush

@endsection
