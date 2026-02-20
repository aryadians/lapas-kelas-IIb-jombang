@extends('layouts.admin')

@section('content')
{{-- Load Animate.css, FontAwesome, & Lightbox --}}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
<script src="https://cdnjs.cloudflare.com/ajax/libs/fslightbox/3.4.1/index.min.js"></script>

<style>
    /* Premium UI Enhancements */
    .card-3d {
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        transform-style: preserve-3d;
    }
    .card-3d:hover {
        transform: translateY(-5px);
        box-shadow: 0 20px 40px -15px rgba(0, 0, 0, 0.1);
    }
    
    .text-gradient {
        background-clip: text;
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-image: linear-gradient(135deg, #0f172a 0%, #2563eb 100%);
    }

    .glass-panel {
        background: rgba(255, 255, 255, 0.7);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.5);
    }

    .custom-scrollbar::-webkit-scrollbar { width: 6px; }
    .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
    .custom-scrollbar::-webkit-scrollbar-thumb { background: #e2e8f0; border-radius: 10px; }

    @media print {
        .no-print { display: none !important; }
        body { background: white !important; padding: 0 !important; }
        .glass-panel { border: none !important; background: transparent !important; }
    }
</style>

<div class="space-y-10 pb-16">

    {{-- HEADER --}}
    <header class="flex flex-col xl:flex-row justify-between items-start xl:items-center gap-6 animate__animated animate__fadeInDown">
        <div>
            <h1 class="text-4xl md:text-5xl font-black text-gradient tracking-tighter">
                Database Pengunjung
            </h1>
            <div class="flex items-center gap-3 mt-2">
                <span class="flex items-center gap-1.5 px-3 py-1 bg-blue-50 text-blue-600 rounded-full text-xs font-bold border border-blue-100">
                    <i class="fas fa-database"></i>
                    Pusat Data Terpadu
                </span>
                <span class="text-slate-400 text-sm font-medium">Rekapitulasi profil seluruh pengunjung terdaftar</span>
            </div>
        </div>
        
        <div class="flex flex-wrap items-center gap-3 no-print">
            {{-- Group Laporan --}}
            <div class="flex items-center bg-white p-1.5 rounded-2xl shadow-sm border border-slate-200">
                <a href="{{ route('admin.visitors.export-excel') }}" class="flex items-center gap-2 px-5 py-2.5 text-slate-700 font-bold text-sm hover:bg-indigo-50 hover:text-indigo-600 rounded-xl transition-all">
                    <i class="fas fa-file-excel text-indigo-500"></i>
                    <span>Excel</span>
                </a>
                <div class="w-px h-5 bg-slate-200 mx-1"></div>
                <a href="{{ route('admin.visitors.export-pdf') }}" target="_blank" class="flex items-center gap-2 px-5 py-2.5 text-slate-700 font-bold text-sm hover:bg-rose-50 hover:text-rose-600 rounded-xl transition-all">
                    <i class="fas fa-file-pdf text-rose-500"></i>
                    <span>PDF</span>
                </a>
            </div>

            {{-- Destructive Action --}}
            <button type="button" onclick="confirmDeleteAll()" class="flex items-center gap-2 bg-white border-2 border-red-100 text-red-600 font-black px-6 py-3 rounded-2xl shadow-sm hover:bg-red-600 hover:text-white hover:border-red-600 transition-all active:scale-95 group">
                <i class="fas fa-trash-sweep group-hover:animate-bounce"></i>
                <span>Kosongkan Database</span>
            </button>
        </div>
    </header>

    {{-- FILTERS --}}
    <form action="{{ route('admin.visitors.index') }}" method="GET" class="animate__animated animate__fadeInUp no-print">
        <div class="bg-slate-200/30 rounded-[2.5rem] p-2 shadow-inner border border-white/50">
            <div class="bg-white rounded-[2rem] p-8 shadow-sm space-y-8">
                {{-- Row 1: Search & Sort --}}
                <div class="flex flex-col lg:flex-row gap-6">
                    <div class="flex-grow relative group">
                        <div class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none">
                            <i class="fas fa-search text-slate-300 group-focus-within:text-blue-500 transition-colors"></i>
                        </div>
                        <input type="text" name="search" value="{{ request('search') }}" 
                            class="w-full pl-12 pr-6 py-4 bg-slate-50 border-2 border-slate-100 rounded-2xl focus:bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all font-bold text-slate-700 placeholder-slate-300" 
                            placeholder="Cari Nama Pengunjung atau NIK (Min. 3 karakter)...">
                    </div>
                    <div class="w-full lg:w-72">
                        <select name="sort" class="w-full p-4 bg-slate-50 border-2 border-slate-100 rounded-2xl focus:border-blue-500 focus:ring-0 font-bold text-slate-600 cursor-pointer transition-all">
                            <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>🆕 Pendaftaran Terbaru</option>
                            <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>⏳ Data Terlama</option>
                            <option value="most_visited" {{ request('sort') == 'most_visited' ? 'selected' : '' }}>🔥 Pengunjung Teraktif</option>
                        </select>
                    </div>
                </div>

                {{-- Row 2: Advanced Filters --}}
                <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6 pt-8 border-t border-slate-50">
                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ml-2">Wilayah Domisili</label>
                        <div class="relative group">
                            <i class="fas fa-map-marker-alt absolute left-4 top-1/2 -translate-y-1/2 text-slate-300 group-focus-within:text-blue-500 transition-colors"></i>
                            <input type="text" name="wilayah" value="{{ request('wilayah') }}" 
                                class="w-full pl-11 p-3.5 bg-slate-50 border-2 border-slate-100 rounded-xl focus:bg-white focus:border-blue-500 focus:ring-0 font-bold text-slate-600 placeholder-slate-200" 
                                placeholder="Contoh: Jombang, Surabaya...">
                        </div>
                    </div>
                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ml-2">Kelengkapan Berkas</label>
                        <select name="has_foto" class="w-full p-3.5 bg-slate-50 border-2 border-slate-100 rounded-xl focus:bg-white focus:border-blue-500 focus:ring-0 font-bold text-slate-600 cursor-pointer">
                            <option value="">Semua Status Dokumen</option>
                            <option value="yes" {{ request('has_foto') == 'yes' ? 'selected' : '' }}>✅ Foto KTP Tersedia</option>
                            <option value="no" {{ request('has_foto') == 'no' ? 'selected' : '' }}>❌ Foto Belum Diunggah</option>
                        </select>
                    </div>
                    <div class="flex items-end gap-3">
                        <button type="submit" class="flex-grow py-3.5 bg-slate-900 text-white font-black rounded-xl hover:bg-blue-600 transition-all shadow-lg active:scale-95 flex items-center justify-center gap-2">
                            <i class="fas fa-filter text-sm"></i> Filter Data
                        </button>
                        <a href="{{ route('admin.visitors.index') }}" class="px-6 py-3.5 bg-slate-100 text-slate-600 font-bold rounded-xl hover:bg-slate-200 transition-all active:scale-95 text-center">
                            Reset
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </form>

    {{-- BULK ACTION BAR --}}
    <form id="bulkDeleteForm" action="{{ route('admin.visitors.bulk-delete') }}" method="POST" class="space-y-6">
        @csrf
        <div class="flex flex-col sm:flex-row justify-between items-center gap-4 no-print">
            <div class="flex items-center gap-4 bg-white px-6 py-3 rounded-2xl border border-slate-200 shadow-sm">
                <div class="flex items-center gap-3">
                    <input type="checkbox" id="selectAll" class="w-5 h-5 rounded-lg border-slate-300 text-blue-600 focus:ring-blue-500 cursor-pointer transition-all">
                    <label for="selectAll" class="text-sm font-black text-slate-700 cursor-pointer uppercase tracking-widest">Pilih Semua</label>
                </div>
                <div class="w-px h-5 bg-slate-200"></div>
                <span class="text-xs font-black text-blue-500 uppercase"><span id="checkedCount">0</span> Item Terpilih</span>
            </div>
            
            <button type="button" onclick="confirmBulkDelete()" class="w-full sm:w-auto px-8 py-3.5 bg-white text-red-600 font-black rounded-2xl border-2 border-red-50 hover:bg-red-600 hover:text-white hover:border-red-600 transition-all flex items-center justify-center gap-2 text-sm active:scale-95 shadow-sm">
                <i class="fas fa-trash-alt"></i> Hapus Massal
            </button>
        </div>

        {{-- TABLE CARD --}}
        <div class="bg-white rounded-[2.5rem] shadow-2xl shadow-slate-200/50 border border-slate-100 overflow-hidden animate__animated animate__fadeIn">
            <div class="overflow-x-auto custom-scrollbar">
                <table class="w-full text-sm text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50/80 text-slate-400 border-b border-slate-100">
                            <th class="p-6 w-10 no-print"></th>
                            <th class="p-6 font-black uppercase tracking-widest text-[10px]">Identitas Pengunjung</th>
                            <th class="p-6 font-black uppercase tracking-widest text-[10px]">Kontak & Domisili</th>
                            <th class="p-6 font-black uppercase tracking-widest text-[10px]">Riwayat Terakhir</th>
                            <th class="p-6 font-black uppercase tracking-widest text-[10px] text-center">Dokumen</th>
                            <th class="p-6 font-black uppercase tracking-widest text-[10px] text-center">Frekuensi</th>
                            <th class="p-6 font-black uppercase tracking-widest text-[10px] text-center no-print w-20">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @forelse ($visitors as $index => $visitor)
                        <tr class="group hover:bg-blue-50/40 transition-all duration-300">
                            <td class="p-6 no-print">
                                <input type="checkbox" name="ids[]" value="{{ $visitor->id }}" class="visitor-checkbox w-5 h-5 rounded-lg border-slate-200 text-blue-600 focus:ring-blue-500 cursor-pointer transition-all">
                            </td>
                            <td class="p-6">
                                <div class="flex items-center gap-5">
                                    <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-slate-800 to-slate-900 text-white flex items-center justify-center font-black text-xl shadow-xl group-hover:scale-110 group-hover:rotate-3 transition-all duration-500">
                                        {{ substr($visitor->nama, 0, 1) }}
                                    </div>
                                    <div>
                                        <button type="button" onclick="showHistory('{{ $visitor->id }}')" class="font-black text-slate-800 text-lg hover:text-blue-600 transition-colors text-left block leading-tight">
                                            {{ $visitor->nama }}
                                        </button>
                                        <div class="flex items-center gap-2 mt-2">
                                            <span class="text-[10px] font-black bg-slate-100 text-slate-500 px-2.5 py-1 rounded-lg uppercase tracking-tight" title="{{ $visitor->nik }}">
                                                {{ substr($visitor->nik, 0, 6) . '******' . substr($visitor->nik, -4) }}
                                            </span>
                                            <span class="text-[10px] font-bold text-slate-400 px-2 py-1 border border-slate-100 rounded-lg capitalize">{{ $visitor->jenis_kelamin }}</span>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="p-6">
                                <div class="space-y-2">
                                    @if($visitor->nomor_hp)
                                        <a href="https://wa.me/{{ preg_replace('/^0/', '62', $visitor->nomor_hp) }}" target="_blank" class="flex items-center gap-2 text-emerald-600 font-black text-sm hover:underline">
                                            <div class="w-6 h-6 rounded-full bg-emerald-50 flex items-center justify-center">
                                                <i class="fab fa-whatsapp text-xs"></i>
                                            </div>
                                            {{ $visitor->nomor_hp }}
                                        </a>
                                    @endif
                                    <div class="flex items-start gap-2 text-xs text-slate-400 font-medium leading-relaxed">
                                        <i class="fas fa-map-marker-alt text-slate-300 mt-0.5"></i>
                                        <span class="max-w-[200px]">{{ $visitor->alamat }}</span>
                                    </div>
                                </div>
                            </td>
                            <td class="p-6">
                                <div class="bg-blue-50/50 p-4 rounded-2xl border border-blue-100/50 group-hover:bg-white group-hover:border-blue-200 transition-all">
                                    <p class="text-[9px] font-black text-blue-400 uppercase tracking-[0.2em] mb-1.5">Tujuan WBP:</p>
                                    <p class="text-sm font-black text-slate-800 leading-tight">{{ $visitor->last_wbp }}</p>
                                    @if($visitor->last_visit)
                                        <p class="text-[10px] text-slate-400 mt-2 flex items-center gap-1.5">
                                            <i class="far fa-clock"></i>
                                            {{ $visitor->last_visit->format('d M Y') }}
                                        </p>
                                    @endif
                                </div>
                            </td>
                            <td class="p-6 text-center">
                                @if($visitor->foto_ktp)
                                    @php
                                        $fotoUrl = \Illuminate\Support\Str::startsWith($visitor->foto_ktp, 'data:') 
                                            ? $visitor->foto_ktp 
                                            : asset('storage/' . $visitor->foto_ktp);
                                    @endphp
                                    <button type="button" 
                                        onclick="showKtpModal('{{ $fotoUrl }}', '{{ $visitor->nama }}')" 
                                        class="inline-flex items-center gap-2 px-5 py-2.5 bg-white border-2 border-slate-100 text-blue-600 rounded-xl text-xs font-black hover:bg-blue-600 hover:text-white hover:border-blue-600 transition-all shadow-sm no-print">
                                        <i class="fas fa-id-card"></i> Lihat Berkas
                                    </button>
                                @else
                                    <div class="inline-flex flex-col items-center opacity-25">
                                        <i class="fas fa-file-excel text-xl mb-1"></i>
                                        <span class="text-[9px] font-black uppercase">Nihil</span>
                                    </div>
                                @endif
                            </td>
                            <td class="p-6 text-center">
                                <div class="inline-flex flex-col items-center gap-1">
                                    <div class="text-2xl font-black text-slate-800">{{ $visitor->total_kunjungan ?? 0 }}</div>
                                    <span class="text-[9px] font-black text-slate-400 uppercase tracking-widest">Kunjungan</span>
                                </div>
                            </td>
                            <td class="p-6 text-center no-print">
                                <button type="button" onclick="confirmDelete('{{ $visitor->id }}', '{{ $visitor->nama }}')" 
                                    class="w-11 h-11 rounded-2xl bg-white border border-slate-100 text-slate-300 hover:text-red-600 hover:border-red-100 hover:bg-red-50 hover:shadow-lg hover:shadow-red-100 transition-all flex items-center justify-center active:scale-90">
                                    <i class="fas fa-trash-alt text-sm"></i>
                                </button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="py-40 text-center">
                                <div class="relative w-40 h-40 mx-auto mb-8">
                                    <div class="absolute inset-0 bg-blue-100 rounded-full animate-ping opacity-10"></div>
                                    <div class="relative w-40 h-40 bg-white rounded-full flex items-center justify-center shadow-2xl border border-slate-50">
                                        <i class="fas fa-users-slash text-6xl text-slate-100"></i>
                                    </div>
                                </div>
                                <h3 class="text-3xl font-black text-slate-800 tracking-tighter">Database Masih Kosong</h3>
                                <p class="text-slate-400 mt-3 font-medium max-w-sm mx-auto leading-relaxed text-base">Belum ada data profil pengunjung yang terekam dalam sistem saat ini.</p>
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
