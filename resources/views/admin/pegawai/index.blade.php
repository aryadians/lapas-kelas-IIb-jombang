@extends('layouts.admin')

@section('title', 'Manajemen Pegawai')

@section('content')
<div class="space-y-6">

    {{-- Header Section --}}
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 bg-white p-6 rounded-2xl shadow-sm border border-slate-100">
        <div>
            <h1 class="text-2xl font-bold border-b-4 border-blue-500 pb-1 inline-block text-slate-800">
                <i class="fas fa-users-cog mr-2 text-blue-500"></i>Manajemen Pegawai Profil
            </h1>
            <p class="text-slate-500 mt-2 text-sm">Kelola data Kalapas dan Pejabat Struktural untuk ditampilkan di halaman profil publik.</p>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('admin.pegawai.create') }}" class="inline-flex justify-center items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white font-bold py-2.5 px-5 rounded-xl transition-all shadow-md hover:shadow-lg active:scale-95">
                <i class="fas fa-plus"></i> Tambah Pegawai
            </a>
        </div>
    </div>

    {{-- Pegawai List --}}
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
        <div class="p-6 border-b border-slate-100 bg-slate-50/50 flex justify-between items-center">
            <h2 class="text-lg font-bold text-slate-800">Daftar Pegawai Struktural</h2>
            <span class="bg-blue-100 text-blue-700 py-1 px-3 rounded-full text-xs font-bold">{{ $pegawais->count() }} Orang</span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 text-slate-500 text-xs uppercase tracking-wider">
                        <th class="p-4 font-semibold border-y border-slate-100 w-16 text-center">Urutan</th>
                        <th class="p-4 font-semibold border-y border-slate-100">Foto</th>
                        <th class="p-4 font-semibold border-y border-slate-100">Nama / Jabatan</th>
                        <th class="p-4 font-semibold border-y border-slate-100 text-center">Eselon / Level</th>
                        <th class="p-4 font-semibold border-y border-slate-100 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($pegawais as $pegawai)
                        <tr class="hover:bg-slate-50/70 transition-colors group">
                            {{-- Urutan --}}
                            <td class="p-4 text-center">
                                <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-slate-100 text-slate-600 font-bold border border-slate-200">
                                    {{ $pegawai->order_index }}
                                </span>
                            </td>

                            {{-- Foto --}}
                            <td class="p-4">
                                <div class="w-12 h-12 rounded-full overflow-hidden border-2 border-slate-200 shadow-sm relative group-hover:border-blue-300 transition-colors bg-slate-100">
                                    @if($pegawai->foto)
                                        <img src="{{ $pegawai->foto }}" alt="{{ $pegawai->nama }}" class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center bg-slate-200 text-slate-400">
                                            <i class="fas fa-user text-xl"></i>
                                        </div>
                                    @endif
                                </div>
                            </td>

                            {{-- Detail --}}
                            <td class="p-4">
                                <div class="font-bold text-slate-800 text-base mb-1">{{ $pegawai->nama }}</div>
                                <div class="text-xs font-bold text-blue-600 uppercase tracking-wider">{{ $pegawai->jabatan }}</div>
                                @if($pegawai->seksi)
                                    <div class="text-[10px] text-slate-500 mt-1 italic">{{ $pegawai->seksi }}</div>
                                @endif
                            </td>

                            {{-- Level --}}
                            <td class="p-4 text-center">
                                @if($pegawai->level === 'kalapas')
                                    <span class="inline-flex border border-yellow-200 bg-yellow-100 text-yellow-700 text-[10px] px-3 py-1 rounded-full font-black uppercase tracking-widest">
                                        <i class="fas fa-crown mr-1.5 mt-0.5"></i> Kalapas
                                    </span>
                                @elseif($pegawai->level === 'eselon_4')
                                    <span class="inline-flex border border-blue-200 bg-blue-100 text-blue-700 text-[10px] px-3 py-1 rounded-full font-black uppercase tracking-widest">
                                        Eselon IV
                                    </span>
                                @else
                                    <span class="inline-flex border border-slate-200 bg-slate-100 text-slate-600 text-[10px] px-3 py-1 rounded-full font-black uppercase tracking-widest">
                                        Eselon V
                                    </span>
                                @endif
                            </td>

                            {{-- Aksi --}}
                            <td class="p-4 text-right">
                                <div class="flex justify-end gap-2">
                                    <a href="{{ route('admin.pegawai.edit', $pegawai->id) }}" class="inline-flex items-center justify-center w-9 h-9 rounded-lg bg-amber-50 text-amber-600 hover:bg-amber-500 hover:text-white hover:shadow-md transition-all border border-amber-200">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    
                                    <form id="delete-form-{{ $pegawai->id }}" action="{{ route('admin.pegawai.destroy', $pegawai->id) }}" method="POST" class="hidden">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                    <button type="button" onclick="confirmDeletePegawai('{{ $pegawai->id }}', '{{ $pegawai->nama }}')" class="inline-flex items-center justify-center w-9 h-9 rounded-lg bg-rose-50 text-rose-600 hover:bg-rose-500 hover:text-white hover:shadow-md transition-all border border-rose-200">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="p-12 text-center border-y border-slate-100">
                                <div class="bg-slate-50 inline-block p-6 rounded-2xl border-2 border-dashed border-slate-200">
                                    <div class="text-slate-300 mb-3 text-5xl">
                                        <i class="fas fa-user-tie"></i>
                                    </div>
                                    <h3 class="text-lg font-bold text-slate-700 mb-1">Belum Ada Data Pegawai</h3>
                                    <p class="text-slate-500 text-sm">Tambahkan data pejabat struktural untuk ditampilkan di profil.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function confirmDeletePegawai(id, nama) {
        Swal.fire({
            ...swalTheme,
            icon: 'warning',
            title: 'Hapus Data Pegawai?',
            html: `Apakah Anda yakin ingin menghapus data <b>${nama}</b>?`,
            showCancelButton: true,
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal',
            customClass: {
                ...swalTheme.customClass,
                confirmButton: 'px-5 py-2.5 bg-red-600 hover:bg-red-700 text-white font-bold rounded-lg transition-all duration-200 mx-1.5 shadow-lg shadow-red-500/30 focus:outline-none focus:ring-4 focus:ring-red-300'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById(`delete-form-${id}`).submit();
            }
        });
    }
</script>
@endpush
@endsection
