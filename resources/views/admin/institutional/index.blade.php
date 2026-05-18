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
            <div class="bg-white/10 backdrop-blur-md border border-white/20 rounded-3xl p-6 hidden lg:block text-center">
                <p class="text-3xl font-black text-white">{{ count($infos) }}</p>
                <p class="text-[10px] font-bold text-blue-200 uppercase tracking-widest mt-1">Total Seksi</p>
            </div>
        </div>
    </div>

    {{-- LIST --}}
    <div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-xl overflow-hidden animate__animated animate__fadeInUp">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="bg-slate-50/80 text-slate-500 uppercase text-[10px] font-black tracking-[0.15em]">
                    <tr>
                        <th class="px-8 py-5">Identitas Informasi</th>
                        <th class="px-8 py-5">Preview Konten</th>
                        <th class="px-8 py-5 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach($infos as $info)
                    <tr class="hover:bg-slate-50/50 transition-all group">
                        <td class="px-8 py-6">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 rounded-2xl bg-slate-100 text-slate-500 flex items-center justify-center group-hover:bg-blue-600 group-hover:text-white transition-all shadow-sm">
                                    <i class="fas {{ $info->key === 'visi' ? 'fa-eye' : ($info->key === 'misi' ? 'fa-bullseye' : 'fa-landmark') }} text-lg"></i>
                                </div>
                                <div>
                                    <p class="font-black text-slate-800 text-base leading-tight uppercase">{{ $info->title }}</p>
                                    <span class="text-[10px] font-mono text-slate-400 bg-white px-2 py-0.5 rounded border border-slate-200 mt-1.5 inline-block tracking-tighter">REF: {{ $info->key }}</span>
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
                            <a href="{{ route('admin.institutional.edit', $info->id) }}" 
                               class="inline-flex items-center gap-2 px-6 py-3 rounded-2xl bg-white border-2 border-slate-100 text-slate-600 font-black hover:bg-blue-600 hover:text-white hover:border-blue-600 transition-all shadow-sm active:scale-95 group/btn">
                                <i class="fas fa-pencil text-blue-500 group-hover/btn:text-white transition-colors"></i>
                                <span class="text-xs uppercase tracking-widest">Edit</span>
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<style>
    .animate-spin-slow { animation: spin 4s linear infinite; }
    @keyframes spin { from { transform: rotate(0deg); } to { transform: rotate(360deg); } }
</style>
@endsection
