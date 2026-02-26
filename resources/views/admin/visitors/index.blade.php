@extends('layouts.admin')

@section('content')
{{-- Load Animate.css, FontAwesome, & Lightbox --}}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
<script src="https://cdnjs.cloudflare.com/ajax/libs/fslightbox/3.4.1/index.min.js"></script>

<style>
    .custom-scrollbar::-webkit-scrollbar { width: 6px; }
    .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
    .custom-scrollbar::-webkit-scrollbar-thumb { background: #e2e8f0; border-radius: 10px; }
    @media print {
        .no-print { display: none !important; }
        body { background: white !important; }
    }
</style>

<div class="space-y-6 pb-16">

    {{-- HERO HEADER --}}
    <div class="relative bg-gradient-to-br from-slate-900 via-teal-950 to-cyan-950 rounded-3xl overflow-hidden shadow-2xl no-print">
        <div class="absolute inset-0 pointer-events-none overflow-hidden">
            <div class="absolute -top-20 -right-20 w-80 h-80 bg-teal-400 rounded-full blur-[90px] opacity-10"></div>
            <div class="absolute -bottom-16 -left-16 w-60 h-60 bg-cyan-400 rounded-full blur-[80px] opacity-10"></div>
        </div>
        <div class="relative z-10 px-8 py-7 flex flex-col md:flex-row items-start md:items-center justify-between gap-6">
            <div>
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/10 border border-white/20 text-teal-200 text-xs font-bold uppercase tracking-widest mb-3">
                    <i class="fas fa-users"></i> Pusat Data Terpadu
                </div>
                <h1 class="text-3xl md:text-4xl font-black text-white tracking-tight">Database Pengunjung</h1>
                <p class="text-teal-100/60 mt-1 text-sm">Rekapitulasi profil seluruh pengunjung terdaftar.</p>
            </div>
            <div class="flex flex-wrap items-center gap-3">
                {{-- Stats --}}
                <div class="bg-white/10 border border-white/20 rounded-2xl px-5 py-3 text-center">
                    <p class="text-2xl font-black text-white">{{ $visitors->total() }}</p>
                    <p class="text-[10px] text-teal-200 font-bold uppercase tracking-widest mt-0.5">Total Profil</p>
                </div>
                {{-- Export buttons --}}
                <div class="flex items-center bg-white/10 border border-white/20 rounded-2xl p-1">
                    <a href="{{ route('admin.visitors.export-excel') }}"
                        class="flex items-center gap-1.5 px-4 py-2 rounded-xl text-teal-200 hover:bg-white/10 font-bold text-sm transition-all no-print">
                        <i class="fas fa-file-excel text-emerald-400"></i> Excel
                    </a>
                    <div class="w-px h-4 bg-white/20 mx-1"></div>
                    <a href="{{ route('admin.visitors.export-pdf') }}" target="_blank"
                        class="flex items-center gap-1.5 px-4 py-2 rounded-xl text-teal-200 hover:bg-white/10 font-bold text-sm transition-all no-print">
                        <i class="fas fa-file-pdf text-rose-400"></i> PDF
                    </a>
                </div>
                {{-- Delete All --}}
                <button type="button" onclick="confirmDeleteAll()"
                    class="flex items-center gap-2 bg-red-500/20 border border-red-400/30 text-red-200 hover:bg-red-500 hover:text-white font-bold px-4 py-2.5 rounded-2xl transition-all active:scale-95 text-sm no-print">
                    <i class="fas fa-trash-alt"></i> Kosongkan
                </button>
            </div>
        </div>
    </div>

    {{-- FILTERS --}}
    <form action="{{ route('admin.visitors.index') }}" method="GET" class="no-print">
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-5">
            <div class="flex flex-col lg:flex-row gap-3">
                {{-- Search --}}
                <div class="flex-1 relative">
                    <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-sm"></i>
                    <input type="text" name="search" value="{{ request('search') }}"
                        class="w-full pl-11 pr-4 py-3 bg-slate-50 border-2 border-slate-100 rounded-xl focus:bg-white focus:border-teal-400 focus:outline-none font-medium text-slate-700 placeholder-slate-400 transition-all text-sm"
                        placeholder="Cari Nama Pengunjung atau NIK...">
                </div>
                {{-- Sort --}}
                <div class="relative lg:w-60">
                    <select name="sort" class="w-full pl-4 pr-8 py-3 bg-slate-50 border-2 border-slate-100 rounded-xl focus:border-teal-400 focus:outline-none font-bold text-slate-600 cursor-pointer text-sm appearance-none transition-all">
                        <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>🆕 Terbaru (Profil)</option>
                        <option value="latest_visit" {{ request('sort') == 'latest_visit' ? 'selected' : '' }}>📅 Kunjungan Terakhir</option>
                        <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>⏳ Terlama</option>
                        <option value="most_visited" {{ request('sort') == 'most_visited' ? 'selected' : '' }}>🔥 Teraktif</option>
                    </select>
                    <i class="fas fa-chevron-down absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 text-xs pointer-events-none"></i>
                </div>
                {{-- Wilayah --}}
                <div class="relative lg:w-56">
                    <i class="fas fa-map-marker-alt absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
                    <input type="text" name="wilayah" value="{{ request('wilayah') }}"
                        class="w-full pl-10 pr-4 py-3 bg-slate-50 border-2 border-slate-100 rounded-xl focus:border-teal-400 focus:outline-none font-medium text-slate-600 placeholder-slate-400 text-sm transition-all"
                        placeholder="Wilayah domisili...">
                </div>
                {{-- Foto --}}
                <div class="relative lg:w-52">
                    <select name="has_foto" class="w-full pl-4 pr-8 py-3 bg-slate-50 border-2 border-slate-100 rounded-xl focus:border-teal-400 focus:outline-none font-bold text-slate-600 cursor-pointer text-sm appearance-none transition-all">
                        <option value="">Semua Dokumen</option>
                        <option value="yes" {{ request('has_foto') == 'yes' ? 'selected' : '' }}>✅ Ada KTP</option>
                        <option value="no" {{ request('has_foto') == 'no' ? 'selected' : '' }}>❌ Tanpa KTP</option>
                    </select>
                    <i class="fas fa-chevron-down absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 text-xs pointer-events-none"></i>
                </div>
                {{-- Buttons --}}
                <div class="flex gap-2">
                    <button type="submit" class="px-5 py-3 bg-slate-900 hover:bg-teal-600 text-white font-black rounded-xl transition-all shadow-md active:scale-95 text-sm flex items-center gap-2">
                        <i class="fas fa-filter"></i> Filter
                    </button>
                    @if(request()->anyFilled(['search','sort','wilayah','has_foto']))
                    <a href="{{ route('admin.visitors.index') }}" class="px-4 py-3 bg-slate-100 hover:bg-slate-200 text-slate-600 font-bold rounded-xl transition-all active:scale-95 text-sm flex items-center">
                        <i class="fas fa-times"></i>
                    </a>
                    @endif
                </div>
            </div>
        </div>
    </form>

    {{-- BULK ACTION BAR --}}
    <form id="bulkDeleteForm" action="{{ route('admin.visitors.bulk-delete') }}" method="POST" class="space-y-6">
        @csrf
        <div class="flex flex-col sm:flex-row justify-between items-center gap-3 no-print">
            <div class="flex items-center gap-3 bg-white px-5 py-2.5 rounded-2xl border border-slate-200 shadow-sm">
                <input type="checkbox" id="selectAll" class="w-4 h-4 rounded-lg border-slate-300 text-teal-600 focus:ring-teal-500 cursor-pointer">
                <label for="selectAll" class="text-xs font-black text-slate-700 cursor-pointer uppercase tracking-widest">Pilih Semua</label>
                <div class="w-px h-4 bg-slate-200"></div>
                <span class="text-xs font-black text-teal-600"><span id="checkedCount">0</span> Terpilih</span>
            </div>
            <button type="button" onclick="confirmBulkDelete()"
                class="w-full sm:w-auto px-5 py-2.5 bg-white text-red-600 font-bold rounded-2xl border-2 border-red-100 hover:bg-red-600 hover:text-white hover:border-red-600 transition-all flex items-center justify-center gap-2 text-sm active:scale-95 shadow-sm">
                <i class="fas fa-trash-alt"></i> Hapus Massal
            </button>
        </div>

        {{-- TABLE CARD --}}
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
            <div class="overflow-x-auto custom-scrollbar">
                <table class="w-full text-sm text-left">
                    <thead class="bg-slate-50 border-b border-slate-100">
                        <tr>
                            <th class="px-5 py-3.5 w-10 no-print"></th>
                            <th class="px-5 py-3.5 font-black uppercase tracking-widest text-[10px] text-slate-400">Identitas Pengunjung</th>
                            <th class="px-5 py-3.5 font-black uppercase tracking-widest text-[10px] text-slate-400">Kontak & Domisili</th>
                            <th class="px-5 py-3.5 font-black uppercase tracking-widest text-[10px] text-slate-400">Riwayat Terakhir</th>
                            <th class="px-5 py-3.5 font-black uppercase tracking-widest text-[10px] text-slate-400 text-center">Dokumen</th>
                            <th class="px-5 py-3.5 font-black uppercase tracking-widest text-[10px] text-slate-400 text-center">Kunjungan</th>
                            <th class="px-5 py-3.5 font-black uppercase tracking-widest text-[10px] text-slate-400 text-center no-print w-16">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @forelse ($visitors as $index => $visitor)
                        @php
                            $colors = ['teal','blue','indigo','purple','rose','amber','cyan','emerald'];
                            $avatarColor = $colors[abs(crc32($visitor->nama)) % count($colors)];
                        @endphp
                        <tr class="group hover:bg-teal-50/40 transition-colors">
                            {{-- Checkbox --}}
                            <td class="px-5 py-4 no-print">
                                <input type="checkbox" name="ids[]" value="{{ $visitor->id }}" class="visitor-checkbox w-4 h-4 rounded-lg border-slate-300 text-teal-600 focus:ring-teal-500 cursor-pointer">
                            </td>
                            {{-- Identitas --}}
                            <td class="px-5 py-4">
                                <div class="flex items-center gap-4">
                                    <div class="w-11 h-11 rounded-2xl bg-{{ $avatarColor }}-100 text-{{ $avatarColor }}-600 flex items-center justify-center font-black text-base shadow-sm flex-shrink-0 group-hover:scale-105 transition-transform">
                                        {{ strtoupper(substr($visitor->nama, 0, 1)) }}
                                    </div>
                                    <div>
                                        <button type="button" onclick="showHistory('{{ $visitor->id }}')"
                                            class="font-black text-slate-800 text-sm hover:text-teal-600 transition-colors text-left leading-tight block">
                                            {{ $visitor->nama }}
                                        </button>
                                        <div class="flex items-center gap-1.5 mt-1 flex-wrap">
                                            <span class="text-[10px] font-mono bg-slate-100 text-slate-500 px-2 py-0.5 rounded-lg" title="{{ $visitor->nik }}">
                                                {{ substr($visitor->nik, 0, 6) . '******' . substr($visitor->nik, -4) }}
                                            </span>
                                            <span class="text-[10px] font-bold text-slate-400 border border-slate-100 px-2 py-0.5 rounded-lg capitalize">{{ $visitor->jenis_kelamin }}</span>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            {{-- Kontak --}}
                            <td class="px-5 py-4">
                                <div class="space-y-1.5">
                                    @if($visitor->nomor_hp)
                                    <a href="https://wa.me/{{ preg_replace('/^0/', '62', $visitor->nomor_hp) }}" target="_blank"
                                        class="flex items-center gap-1.5 text-emerald-600 font-bold text-xs hover:underline">
                                        <i class="fab fa-whatsapp text-sm"></i> {{ $visitor->nomor_hp }}
                                    </a>
                                    @endif
                                    <div class="flex items-start gap-1.5 text-xs text-slate-400 font-medium">
                                        <i class="fas fa-map-marker-alt text-slate-300 mt-0.5 text-[10px]"></i>
                                        <span class="max-w-[180px] leading-tight">{{ $visitor->alamat }}</span>
                                    </div>
                                </div>
                            </td>
                            {{-- Riwayat Terakhir --}}
                            <td class="px-5 py-4">
                                <div class="bg-slate-50 px-3 py-2.5 rounded-xl border border-slate-100 group-hover:bg-white group-hover:border-teal-200 transition-all">
                                    <p class="text-[9px] font-black text-teal-500 uppercase tracking-widest mb-1">WBP Dituju:</p>
                                    <p class="text-xs font-black text-slate-800 leading-tight">{{ $visitor->last_wbp }}</p>
                                    @if($visitor->last_visit)
                                    <p class="text-[10px] text-slate-400 mt-1.5 flex items-center gap-1">
                                        <i class="far fa-clock"></i> {{ $visitor->last_visit->format('d M Y') }}
                                    </p>
                                    @endif
                                </div>
                            </td>
                            {{-- Dokumen KTP --}}
                            <td class="px-5 py-4 text-center">
                                @if($visitor->foto_ktp)
                                @php
                                    $fotoUrl = \Illuminate\Support\Str::startsWith($visitor->foto_ktp, 'data:')
                                        ? $visitor->foto_ktp
                                        : asset('storage/' . $visitor->foto_ktp);
                                @endphp
                                <button type="button" onclick="showKtpModal('{{ $fotoUrl }}', '{{ $visitor->nama }}')"
                                    class="inline-flex items-center gap-1.5 px-3 py-2 bg-white border-2 border-slate-100 hover:bg-teal-500 hover:border-teal-500 hover:text-white text-teal-600 rounded-xl text-xs font-black transition-all shadow-sm hover:shadow-teal-500/30 no-print active:scale-95">
                                    <i class="fas fa-id-card"></i> KTP
                                </button>
                                @else
                                <span class="text-[10px] text-slate-300 font-black uppercase">Nihil</span>
                                @endif
                            </td>
                            {{-- Frekuensi --}}
                            <td class="px-5 py-4 text-center">
                                <span class="text-xl font-black text-slate-800">{{ $visitor->total_kunjungan ?? 0 }}</span>
                                <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mt-0.5">kunjungan</p>
                            </td>
                            {{-- Aksi --}}
                            <td class="px-5 py-4 text-center no-print">
                                <button type="button" onclick="confirmDelete('{{ $visitor->id }}', '{{ $visitor->nama }}')"
                                    class="w-9 h-9 rounded-xl bg-red-50 hover:bg-red-500 border-2 border-red-100 hover:border-red-500 text-red-500 hover:text-white flex items-center justify-center mx-auto transition-all hover:shadow-md hover:shadow-red-500/30 hover:-translate-y-0.5 active:scale-95">
                                    <i class="fas fa-trash-alt text-xs"></i>
                                </button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="py-20 text-center">
                                <div class="w-16 h-16 bg-slate-100 rounded-3xl flex items-center justify-center text-slate-300 text-3xl mx-auto mb-3">
                                    <i class="fas fa-users-slash"></i>
                                </div>
                                <h3 class="font-black text-slate-700 mb-1">Database Masih Kosong</h3>
                                <p class="text-slate-400 text-sm">Belum ada data profil pengunjung yang terekam.</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </form>

    {{-- PAGINATION --}}
    @if ($visitors->hasPages())
    <div class="pt-6">
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
<div id="historyModal" class="fixed inset-0 z-[110] hidden overflow-y-auto no-print" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 bg-slate-950/70 backdrop-blur-md transition-opacity duration-500" aria-hidden="true" onclick="closeHistory()"></div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
        <div class="inline-block align-bottom bg-white rounded-[3rem] text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-4xl w-full border border-white/20 animate__animated animate__zoomIn animate__faster">
            <div class="bg-white px-10 py-8 border-b border-slate-50 flex justify-between items-center">
                <div>
                    <p class="text-[10px] font-black text-blue-500 uppercase tracking-[0.3em] mb-1.5">Intelijen Aktivitas</p>
                    <h3 class="text-3xl font-black text-slate-800 tracking-tighter" id="modal-title">
                        Riwayat: <span id="historyNama" class="text-blue-600"></span>
                    </h3>
                </div>
                <button type="button" onclick="closeHistory()" class="w-12 h-12 rounded-2xl bg-slate-50 text-slate-400 hover:text-slate-900 hover:bg-slate-100 transition-all flex items-center justify-center shadow-inner">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>
            <div class="bg-white px-10 py-10 max-h-[60vh] overflow-y-auto custom-scrollbar">
                <div id="historyLoading" class="flex flex-col items-center justify-center py-20">
                    <div class="w-20 h-20 border-[6px] border-blue-50 border-t-blue-600 rounded-full animate-spin shadow-lg"></div>
                    <p class="mt-6 text-xs font-black text-slate-400 uppercase tracking-[0.2em]">Sinkronisasi Data...</p>
                </div>
                <div id="historyContent" class="hidden">
                    <table class="w-full text-sm text-left">
                        <thead>
                            <tr class="text-slate-400 border-b border-slate-100">
                                <th class="px-4 py-5 font-black uppercase text-[10px] tracking-widest">Waktu Kunjungan</th>
                                <th class="px-4 py-5 font-black uppercase text-[10px] tracking-widest text-center">Status Alur</th>
                                <th class="px-4 py-5 font-black uppercase text-[10px] tracking-widest">WBP Dituju</th>
                                <th class="px-4 py-5 font-black uppercase text-[10px] tracking-widest">Bawaan</th>
                            </tr>
                        </thead>
                        <tbody id="historyTableBody" class="divide-y divide-slate-50">
                            {{-- Data via AJAX --}}
                        </tbody>
                    </table>
                    <div id="noHistory" class="hidden py-32 text-center">
                        <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-4 border border-slate-100">
                            <i class="fas fa-folder-open text-3xl text-slate-200"></i>
                        </div>
                        <p class="text-slate-400 font-black uppercase text-xs tracking-widest">Data Kosong</p>
                    </div>
                </div>
            </div>
            <div class="bg-slate-50 px-10 py-8 flex justify-end">
                <button type="button" onclick="closeHistory()" class="px-10 py-4 bg-slate-900 text-white font-black rounded-[1.25rem] hover:bg-blue-600 transition-all active:scale-95 shadow-2xl shadow-slate-300">
                    Tutup Laporan
                </button>
            </div>
        </div>
    </div>
</div>

{{-- MODAL LIHAT KTP --}}
<div id="ktpModal" class="fixed inset-0 z-[120] hidden overflow-y-auto no-print" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 bg-slate-950/90 backdrop-blur-xl transition-opacity duration-500" aria-hidden="true" onclick="closeKtpModal()"></div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
        <div class="inline-block align-bottom bg-white rounded-[3.5rem] text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-xl w-full animate__animated animate__fadeInUp animate__faster">
            <div class="bg-white px-10 py-8 border-b border-slate-50 flex justify-between items-center">
                <div>
                    <p class="text-[10px] font-black text-emerald-500 uppercase tracking-[0.3em] mb-1.5">Security Check</p>
                    <h3 class="text-2xl font-black text-slate-800 tracking-tighter">
                        KTP: <span id="ktpModalNama" class="text-emerald-600"></span>
                    </h3>
                </div>
                <button type="button" onclick="closeKtpModal()" class="w-12 h-12 rounded-2xl bg-slate-50 text-slate-400 hover:text-slate-900 hover:bg-slate-100 transition-all flex items-center justify-center">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>
            <div class="p-10 text-center bg-slate-100/30">
                <div class="relative inline-block group">
                    <img id="ktpModalImg" src="" class="max-w-full h-auto rounded-[2.5rem] shadow-2xl mx-auto border-[12px] border-white transition-transform duration-700 group-hover:scale-105" alt="KTP">
                    <div class="absolute inset-0 rounded-[2.5rem] ring-1 ring-black/5 pointer-events-none"></div>
                </div>
            </div>
            <div class="bg-white px-10 py-8 flex flex-col sm:flex-row gap-4">
                <a id="ktpDownloadBtn" href="" download="" class="flex-[2] inline-flex justify-center items-center gap-3 bg-slate-900 hover:bg-blue-600 text-white font-black py-5 px-8 rounded-2xl shadow-2xl shadow-slate-200 transition-all active:scale-95 group">
                    <i class="fas fa-download group-hover:animate-bounce"></i>
                    <span>Download File KTP</span>
                </a>
                <button type="button" onclick="closeKtpModal()" class="flex-1 px-8 py-5 bg-slate-100 text-slate-600 font-black rounded-2xl hover:bg-slate-200 transition-all active:scale-95">
                    Kembali
                </button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Stats Update Logic
    const updateCount = () => {
        const count = document.querySelectorAll('.visitor-checkbox:checked').length;
        const countEl = document.getElementById('checkedCount');
        if(countEl) {
            countEl.innerText = count;
            countEl.parentElement.classList.toggle('bg-blue-50', count > 0);
            countEl.parentElement.classList.toggle('text-blue-600', count > 0);
        }
    };

    document.querySelectorAll('.visitor-checkbox').forEach(cb => {
        cb.addEventListener('change', updateCount);
    });

    const selectAllCb = document.getElementById('selectAll');
    if(selectAllCb) {
        selectAllCb.addEventListener('change', function() {
            document.querySelectorAll('.visitor-checkbox').forEach(cb => cb.checked = this.checked);
            updateCount();
        });
    }

    function showKtpModal(src, nama) {
        const modal = document.getElementById('ktpModal');
        const img = document.getElementById('ktpModalImg');
        const namaSpan = document.getElementById('ktpModalNama');
        const downloadBtn = document.getElementById('ktpDownloadBtn');

        img.src = src;
        namaSpan.innerText = nama;
        downloadBtn.href = src;
        downloadBtn.download = `KTP_${nama.replace(/\s+/g, '_')}.jpg`;

        modal.classList.remove('hidden');
        document.body.classList.add('overflow-hidden');
    }

    function closeKtpModal() {
        document.getElementById('ktpModal').classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
    }

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

                if (!data.history || data.history.length === 0) {
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
                            <tr class="group border-b border-slate-50 hover:bg-slate-50/50 transition-colors">
                                <td class="px-4 py-6 font-black text-slate-700 text-xs tracking-tight">${date}</td>
                                <td class="px-4 py-6 text-center">${statusBadge}</td>
                                <td class="px-4 py-6">
                                    <div class="font-black text-slate-800 text-sm leading-tight">${item.wbp ? item.wbp.nama : '-'}</div>
                                    <div class="text-[9px] font-black text-slate-400 uppercase mt-1 tracking-widest">${item.wbp ? item.wbp.no_registrasi : ''}</div>
                                </td>
                                <td class="px-4 py-6 text-slate-500 text-xs font-bold">${item.barang_bawaan || '<span class="opacity-30">Nihil</span>'}</td>
                            </tr>
                        `;
                        tableBody.innerHTML += row;
                    });
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire({ ...swalTheme, icon: 'error', title: 'Gagal!', text: 'Gagal sinkronisasi data riwayat.' });
                closeHistory();
            });
    }

    function getStatusBadge(status) {
        const statuses = {
            'pending': 'bg-amber-100 text-amber-700',
            'approved': 'bg-emerald-100 text-emerald-700',
            'rejected': 'bg-rose-100 text-rose-700',
            'completed': 'bg-blue-100 text-blue-700',
            'on_queue': 'bg-indigo-100 text-indigo-700',
            'called': 'bg-purple-100 text-purple-700',
            'in_progress': 'bg-sky-100 text-sky-700'
        };
        const colorClass = statuses[status.toLowerCase()] || 'bg-slate-100 text-slate-700';
        return `<span class="px-3 py-1.5 rounded-xl text-[9px] font-black uppercase tracking-[0.1em] ${colorClass} border border-black/5 shadow-sm inline-block">${status}</span>`;
    }

    function closeHistory() {
        document.getElementById('historyModal').classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
    }

    function confirmDeleteAll() {
        Swal.fire({
            ...swalTheme,
            title: '⚠️ FORMAT DATABASE?',
            html: `<div class="text-center space-y-4 p-2">
                    <p class="font-bold text-slate-700 text-lg">Hapus seluruh <span class="text-red-600 underline">DATABASE PROFIL</span>?</p>
                    <div class="bg-red-50 p-4 rounded-2xl border border-red-100 text-left">
                        <ul class="text-xs text-red-700 space-y-2 font-medium">
                            <li class="flex items-start gap-2"><i class="fas fa-exclamation-triangle mt-0.5"></i> Seluruh profil pengunjung akan dihapus permanen.</li>
                            <li class="flex items-start gap-2"><i class="fas fa-exclamation-triangle mt-0.5"></i> Riwayat kunjungan tidak terhapus tapi kehilangan identitas profil.</li>
                            <li class="flex items-start gap-2"><i class="fas fa-exclamation-triangle mt-0.5"></i> Aksi ini mustahil dibatalkan (Irreversible).</li>
                        </ul>
                    </div>
                   </div>`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, Kosongkan Sekarang',
            cancelButtonText: 'Batalkan',
            customClass: {
                ...swalTheme.customClass,
                confirmButton: 'px-10 py-4 bg-red-600 hover:bg-red-700 text-white font-black rounded-2xl transition-all duration-300 mx-2 shadow-2xl shadow-red-200'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                const form = document.getElementById('deleteForm');
                form.action = "{{ route('admin.visitors.delete-all') }}";
                form.submit();
            }
        });
    }

    function confirmDelete(id, nama) {
        Swal.fire({
            ...swalTheme,
            title: 'Hapus Profil?',
            html: `Hapus profil pengunjung <b>${nama}</b> secara permanen?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Hapus',
            cancelButtonText: 'Batal',
            customClass: {
                ...swalTheme.customClass,
                confirmButton: 'px-8 py-3 bg-red-600 text-white font-black rounded-xl mx-2 shadow-lg shadow-red-100'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                const form = document.getElementById('deleteForm');
                form.action = '/admin/pengunjung/' + id;
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
                title: 'Data Belum Dipilih',
                text: 'Silakan beri centang pada data yang ingin dihapus.',
                confirmButtonText: 'Mengerti'
            });
            return;
        }

        Swal.fire({
            ...swalTheme,
            title: `Hapus ${checked.length} Profil Terpilih?`,
            text: "Seluruh data yang dicentang akan dimusnahkan permanen.",
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
</script>
@endpush
@endsection
