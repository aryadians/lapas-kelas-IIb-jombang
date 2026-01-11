@extends('layouts.admin')

@section('content')
{{-- Load Animate.css & FontAwesome --}}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>

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
</style>

<div class="space-y-8 pb-12">

    {{-- HEADER --}}
    <header class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 animate__animated animate__fadeInDown">
        <div>
            <h1 class="text-4xl font-extrabold text-gradient">
                Database Pengunjung
            </h1>
            <p class="text-slate-500 mt-2 font-medium">Data rekapitulasi pengunjung terdaftar.</p>
        </div>
        <div class="flex items-center gap-3">
            <button onclick="window.print()" class="group flex items-center gap-2 bg-white text-slate-600 font-bold px-5 py-2.5 rounded-xl shadow-sm border border-slate-200 hover:border-slate-300 hover:bg-slate-50 transition-all active:scale-95">
                <i class="fas fa-print text-slate-400 group-hover:text-slate-600"></i>
                <span>Cetak Laporan</span>
            </button>
        </div>
    </header>

    {{-- FORM PENCARIAN --}}
    <form action="{{ route('admin.visitors.index') }}" method="GET" class="animate__animated animate__fadeInUp">
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
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 mt-6 overflow-x-auto animate__animated animate__fadeIn">
        <table class="w-full text-sm text-left text-slate-500">
            <thead class="text-xs text-slate-700 uppercase bg-slate-50">
                <tr>
                    <th scope="col" class="px-6 py-4">No</th>
                    <th scope="col" class="px-6 py-4">Identitas Pengunjung</th>
                    <th scope="col" class="px-6 py-4">Kontak</th>
                    <th scope="col" class="px-6 py-4">Alamat</th>
                    <th scope="col" class="px-6 py-4 text-center">Dokumen</th>
                    <th scope="col" class="px-6 py-4 text-center">Total Kunjungan</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($visitors as $index => $visitor)
                <tr class="bg-white border-b hover:bg-slate-50 transition-colors">
                    <td class="px-6 py-4 font-bold text-slate-600">
                        {{ $visitors->firstItem() + $index }}
                    </td>
                    <td class="px-6 py-4">
                        <div class="font-bold text-slate-800 text-base">{{ $visitor->nama_pengunjung }}</div>
                        <div class="text-xs text-slate-500 bg-slate-100 px-2 py-0.5 rounded inline-block mt-1">
                            NIK: {{ $visitor->nik_ktp }}
                        </div>
                        <div class="text-xs text-slate-400 mt-1">
                            {{ $visitor->jenis_kelamin }}
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex flex-col gap-1">
                            @if($visitor->no_wa_pengunjung)
                                <a href="https://wa.me/{{ preg_replace('/^0/', '62', $visitor->no_wa_pengunjung) }}" target="_blank" class="flex items-center gap-2 text-emerald-600 font-semibold hover:underline">
                                    <i class="fab fa-whatsapp"></i> {{ $visitor->no_wa_pengunjung }}
                                </a>
                            @endif
                            <div class="flex items-center gap-2 text-slate-500 text-xs">
                                <i class="far fa-envelope"></i> {{ $visitor->email_pengunjung }}
                            </div>
                        </div>
                    </td>
                    {{-- MENAMPILKAN ALAMAT --}}
                    <td class="px-6 py-4">
                        <span class="block max-w-xs truncate" title="{{ $visitor->alamat_pengunjung }}">
                            {{ Str::limit($visitor->alamat_pengunjung, 50) }}
                        </span>
                    </td>
                    {{-- MENAMPILKAN FOTO KTP --}}
                    <td class="px-6 py-4 text-center">
                        @if($visitor->foto_ktp)
                            <button onclick="showKtp('{{ asset('storage/' . $visitor->foto_ktp) }}', '{{ $visitor->nama_pengunjung }}')" 
                                    class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-blue-50 text-blue-600 rounded-lg text-xs font-bold hover:bg-blue-100 transition-colors border border-blue-100">
                                <i class="fas fa-id-card"></i> Lihat KTP
                            </button>
                        @else
                            <span class="text-xs text-slate-400 italic">Tidak ada foto</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-center">
                        <span class="px-3 py-1 rounded-full bg-slate-100 text-slate-700 text-xs font-bold">
                            {{ $visitor->total_kunjungan ?? 0 }}x Berkunjung
                        </span>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="py-20 text-center">
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

    {{-- PAGINATION --}}
    @if ($visitors->hasPages())
    <div class="animate__animated animate__fadeInUp">
        {{ $visitors->links() }}
    </div>
    @endif

</div>

{{-- MODAL POPUP LIHAT FOTO KTP --}}
<div id="ktpModal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        {{-- Overlay --}}
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true" onclick="closeKtp()"></div>

        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

        {{-- Modal Panel --}}
        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg w-full">
            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <div class="sm:flex sm:items-start">
                    <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                        <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                            Foto KTP: <span id="ktpNama" class="font-bold text-blue-600"></span>
                        </h3>
                        <div class="mt-4 flex justify-center bg-gray-100 rounded-lg p-2 border border-gray-300 relative group">
                            <img id="ktpImage" src="" alt="Foto KTP" class="max-h-[400px] w-auto rounded shadow-sm object-contain">
                        </div>
                        <p class="text-xs text-slate-400 text-center mt-2">Klik tombol download di bawah untuk menyimpan gambar.</p>
                    </div>
                </div>
            </div>
            <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse gap-2">
                <a id="downloadLink" href="#" download class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none sm:ml-3 sm:w-auto sm:text-sm">
                    <i class="fas fa-download mr-2 mt-1"></i> Download
                </a>
                <button type="button" onclick="closeKtp()" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                    Tutup
                </button>
            </div>
        </div>
    </div>
</div>

{{-- SCRIPT --}}
<script>
    function showKtp(url, nama) {
        document.getElementById('ktpImage').src = url;
        document.getElementById('ktpNama').innerText = nama;
        document.getElementById('downloadLink').href = url;
        document.getElementById('ktpModal').classList.remove('hidden');
    }

    function closeKtp() {
        document.getElementById('ktpModal').classList.add('hidden');
    }
</script>
@endsection