@extends('layouts.admin')

@section('title', 'Manajemen Banner')

@section('content')
<div class="space-y-6">

    {{-- Header Section --}}
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 bg-white p-6 rounded-2xl shadow-sm border border-slate-100">
        <div>
            <h1 class="text-2xl font-bold border-b-4 border-blue-500 pb-1 inline-block text-slate-800">
                <i class="fas fa-images mr-2 text-blue-500"></i>Manajemen Banner Homepage
            </h1>
            <p class="text-slate-500 mt-2 text-sm">Atur gambar dan video slideshow yang tampil di halaman utama publik.</p>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('admin.banners.create') }}" class="inline-flex justify-center items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white font-bold py-2.5 px-5 rounded-xl transition-all shadow-md hover:shadow-lg active:scale-95">
                <i class="fas fa-plus"></i> Tambah Banner
            </a>
        </div>
    </div>

    {{-- Alerts --}}
    @if(session('success'))
        <div class="bg-emerald-50 border-l-4 border-emerald-500 p-4 rounded-xl shadow-sm" role="alert">
            <div class="flex items-center">
                <i class="fas fa-check-circle text-emerald-500 text-xl mr-3"></i>
                <p class="text-emerald-700 font-medium">{{ session('success') }}</p>
            </div>
        </div>
    @endif

    {{-- Banners List --}}
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
        <div class="p-6 border-b border-slate-100 bg-slate-50/50 flex justify-between items-center">
            <h2 class="text-lg font-bold text-slate-800">Daftar Banner/Slideshow</h2>
            <span class="bg-blue-100 text-blue-700 py-1 px-3 rounded-full text-xs font-bold">{{ $banners->count() }} Item</span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 text-slate-500 text-xs uppercase tracking-wider">
                        <th class="p-4 font-semibold border-y border-slate-100 w-16 text-center">Urutan</th>
                        <th class="p-4 font-semibold border-y border-slate-100">Preview / Media</th>
                        <th class="p-4 font-semibold border-y border-slate-100">Judul / Detail</th>
                        <th class="p-4 font-semibold border-y border-slate-100 text-center">Status</th>
                        <th class="p-4 font-semibold border-y border-slate-100 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($banners as $banner)
                        <tr class="hover:bg-slate-50/70 transition-colors group">
                            {{-- Urutan --}}
                            <td class="p-4 text-center">
                                <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-slate-100 text-slate-600 font-bold border border-slate-200">
                                    {{ $banner->order_index }}
                                </span>
                            </td>

                            {{-- Media Preview --}}
                            <td class="p-4">
                                <div class="w-40 h-24 rounded-lg overflow-hidden border-2 border-slate-200 shadow-sm relative group-hover:border-blue-300 transition-colors">
                                    @if($banner->type === 'image')
                                        <img src="{{ Storage::url($banner->file_path) }}" alt="{{ $banner->title }}" class="w-full h-full object-cover">
                                        <div class="absolute top-1 right-1 bg-black/60 text-white text-[10px] px-2 py-0.5 rounded font-bold backdrop-blur-sm">
                                            <i class="fas fa-image mr-1"></i> IMG
                                        </div>
                                    @elseif($banner->type === 'video')
                                        <video src="{{ Storage::url($banner->file_path) }}" class="w-full h-full object-cover" muted loop onmouseover="this.play()" onmouseout="this.pause()"></video>
                                        <div class="absolute inset-0 flex items-center justify-center bg-black/20 pointer-events-none">
                                            <i class="fas fa-play-circle text-white/80 text-3xl drop-shadow-md"></i>
                                        </div>
                                        <div class="absolute top-1 right-1 bg-rose-500/80 text-white text-[10px] px-2 py-0.5 rounded font-bold backdrop-blur-sm">
                                            <i class="fas fa-video mr-1"></i> VID
                                        </div>
                                    @endif
                                </div>
                            </td>

                            {{-- Detail --}}
                            <td class="p-4">
                                <div class="font-bold text-slate-800 text-base mb-1">{{ $banner->title ?: 'Tanpa Judul' }}</div>
                                <div class="text-xs text-slate-500 flex items-center gap-3">
                                    <span class="inline-flex items-center gap-1"><i class="fas fa-calendar-alt opacity-70"></i> Dibuat: {{ $banner->created_at->format('d M Y') }}</span>
                                </div>
                            </td>

                            {{-- Status --}}
                            <td class="p-4 text-center">
                                @if($banner->is_active)
                                    <span class="inline-flex border border-emerald-200 bg-emerald-100 text-emerald-700 text-xs px-3 py-1 rounded-full font-bold">
                                        <i class="fas fa-eye mr-1.5 mt-0.5"></i> Aktif Tampil
                                    </span>
                                @else
                                    <span class="inline-flex border border-slate-200 bg-slate-100 text-slate-500 text-xs px-3 py-1 rounded-full font-bold">
                                        <i class="fas fa-eye-slash mr-1.5 mt-0.5"></i> Disembunyikan
                                    </span>
                                @endif
                            </td>

                            {{-- Aksi --}}
                            <td class="p-4 text-right">
                                <div class="flex justify-end gap-2">
                                    <a href="{{ route('admin.banners.edit', $banner->id) }}" class="inline-flex items-center justify-center w-9 h-9 rounded-lg bg-amber-50 text-amber-600 hover:bg-amber-500 hover:text-white hover:shadow-md transition-all border border-amber-200">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    
                                    <form action="{{ route('admin.banners.destroy', $banner->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus banner ini permanent? File media juga akan terhapus.')" class="inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="inline-flex items-center justify-center w-9 h-9 rounded-lg bg-rose-50 text-rose-600 hover:bg-rose-500 hover:text-white hover:shadow-md transition-all border border-rose-200">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="p-12 text-center border-y border-slate-100">
                                <div class="bg-slate-50 inline-block p-6 rounded-2xl border-2 border-dashed border-slate-200">
                                    <div class="text-slate-300 mb-3 text-5xl">
                                        <i class="fas fa-photo-video"></i>
                                    </div>
                                    <h3 class="text-lg font-bold text-slate-700 mb-1">Belum Ada Banner</h3>
                                    <p class="text-slate-500 text-sm">Tambahkan banner baru untuk ditampilkan di slideshow beranda.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
