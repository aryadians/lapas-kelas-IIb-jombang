@extends('layouts.admin')

@section('title', 'Manajemen Galeri')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 bg-white p-6 rounded-2xl shadow-sm border border-slate-100">
        <div>
            <h1 class="text-2xl font-bold border-b-4 border-blue-500 pb-1 inline-block text-slate-800">
                <i class="fas fa-camera mr-2 text-blue-500"></i>Manajemen Galeri
            </h1>
            <p class="text-slate-500 mt-2 text-sm">Kelola foto-foto kegiatan untuk ditampilkan di halaman publik.</p>
        </div>
        <a href="{{ route('admin.galeri.create') }}" class="inline-flex justify-center items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white font-bold py-2.5 px-5 rounded-xl transition-all shadow-md hover:shadow-lg active:scale-95">
            <i class="fas fa-plus"></i> Tambah Foto
        </a>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
        <div class="p-6 border-b border-slate-100 bg-slate-50/50 flex justify-between items-center">
            <h2 class="text-lg font-bold text-slate-800">Daftar Foto Galeri</h2>
            <span class="bg-blue-100 text-blue-700 py-1 px-3 rounded-full text-xs font-bold">{{ $galeris->count() }} Item</span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 text-slate-500 text-xs uppercase tracking-wider">
                        <th class="p-4 font-semibold border-y border-slate-100 w-16 text-center">Urutan</th>
                        <th class="p-4 font-semibold border-y border-slate-100">Preview</th>
                        <th class="p-4 font-semibold border-y border-slate-100">Judul</th>
                        <th class="p-4 font-semibold border-y border-slate-100 text-center">Status</th>
                        <th class="p-4 font-semibold border-y border-slate-100 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($galeris as $galeri)
                        <tr class="hover:bg-slate-50/70 transition-colors">
                            <td class="p-4 text-center"><span class="w-8 h-8 rounded-full bg-slate-100 flex items-center justify-center font-bold text-slate-600 border mx-auto">{{ $galeri->order_index }}</span></td>
                            <td class="p-4">
                                <img src="{{ $galeri->image_path }}" class="w-20 h-20 object-cover rounded-xl border border-slate-200">
                            </td>
                            <td class="p-4 font-bold text-slate-800">{{ $galeri->title ?: 'Tanpa Judul' }}</td>
                            <td class="p-4 text-center">
                                <span class="px-3 py-1 rounded-full text-[10px] font-black uppercase {{ $galeri->is_active ? 'bg-emerald-100 text-emerald-700' : 'bg-slate-100 text-slate-500' }}">
                                    {{ $galeri->is_active ? 'Aktif' : 'Nonaktif' }}
                                </span>
                            </td>
                            <td class="p-4 text-right flex justify-end gap-2">
                                <a href="{{ route('admin.galeri.edit', $galeri->id) }}" class="p-2 bg-amber-50 text-amber-600 rounded-lg"><i class="fas fa-edit"></i></a>
                                <form action="{{ route('admin.galeri.destroy', $galeri->id) }}" method="POST" class="inline">
                                    @csrf @method('DELETE')
                                    <button class="p-2 bg-rose-50 text-rose-600 rounded-lg"><i class="fas fa-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="p-12 text-center text-slate-400">Belum ada foto galeri.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
