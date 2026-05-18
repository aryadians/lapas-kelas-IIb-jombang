@extends('layouts.admin')

@section('title', 'Manajemen Informasi Lembaga')

@section('content')
<div class="space-y-6 pb-12">
    {{-- HEADER --}}
    <div class="bg-gradient-to-br from-slate-900 via-indigo-950 to-purple-950 rounded-3xl p-8 text-white shadow-2xl">
        <h1 class="text-3xl font-black tracking-tight">Informasi Lembaga</h1>
        <p class="text-indigo-200 mt-2">Kelola Visi, Misi, Tugas & Fungsi, serta informasi institusi lainnya.</p>
    </div>

    {{-- LIST --}}
    <div class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="bg-slate-50 text-slate-500 uppercase text-[10px] font-black tracking-widest">
                    <tr>
                        <th class="px-6 py-4">Informasi</th>
                        <th class="px-6 py-4">Konten</th>
                        <th class="px-6 py-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach($infos as $info)
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="px-6 py-4 font-bold text-slate-700">
                            {{ $info->title }}
                            <div class="text-[9px] text-slate-400 font-mono mt-1">KEY: {{ $info->key }}</div>
                        </td>
                        <td class="px-6 py-4 text-slate-500 max-w-md">
                            <div class="line-clamp-2">
                                {!! strip_tags($info->content) !!}
                            </div>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <a href="{{ route('admin.institutional.edit', $info->id) }}" 
                               class="inline-flex items-center justify-center w-10 h-10 rounded-xl bg-blue-50 text-blue-600 hover:bg-blue-600 hover:text-white transition-all shadow-sm border border-blue-100">
                                <i class="fas fa-pencil"></i>
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
