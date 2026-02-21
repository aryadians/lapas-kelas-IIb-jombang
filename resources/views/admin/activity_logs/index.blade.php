@extends('layouts.admin')

@section('title', 'Log Aktivitas Sistem')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50/30 to-slate-100 p-6 md:p-8">

    {{-- HEADER --}}
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-8">
        <div class="flex items-center gap-4">
            <div class="w-14 h-14 bg-gradient-to-br from-slate-700 to-slate-900 rounded-2xl flex items-center justify-center shadow-xl shadow-slate-900/20">
                <i class="fa-solid fa-list-check text-2xl text-white"></i>
            </div>
            <div>
                <h1 class="text-2xl md:text-3xl font-black text-slate-800 tracking-tight">Log Aktivitas Sistem</h1>
                <p class="text-slate-400 text-sm font-medium">Rekam jejak seluruh aksi petugas & sistem secara real-time</p>
            </div>
        </div>

        {{-- Tombol Aksi (hanya super_admin / admin_registrasi) --}}
        @if(in_array(Auth::user()->role ?? '', ['super_admin', 'admin_registrasi']))
        <div class="flex flex-wrap gap-3">
            {{-- Hapus log lama > 1 bulan --}}
            <form action="{{ route('admin.activity_logs.delete_old') }}" method="POST"
                onsubmit="return confirm('Hapus semua log aktivitas yang berusia lebih dari 1 bulan?\n\nLog yang lebih baru tetap tersimpan.')">
                @csrf
                <button type="submit"
                    class="inline-flex items-center gap-2 bg-amber-500 hover:bg-amber-600 text-white font-bold px-5 py-3 rounded-2xl shadow-lg shadow-amber-400/25 hover:-translate-y-0.5 active:scale-95 transition-all">
                    <i class="fas fa-clock"></i>
                    <span>Hapus Log &gt; 1 Bulan</span>
                </button>
            </form>

            {{-- Hapus semua log --}}
            <form action="{{ route('admin.activity_logs.reset') }}" method="POST"
                onsubmit="return confirm('⚠️ PERHATIAN!\n\nAnda akan menghapus SELURUH log aktivitas sistem.\nTindakan ini tidak dapat dibatalkan.\n\nYakin ingin melanjutkan?')">
                @csrf
                <button type="submit"
                    class="inline-flex items-center gap-2 bg-red-600 hover:bg-red-700 text-white font-bold px-5 py-3 rounded-2xl shadow-lg shadow-red-500/25 hover:-translate-y-0.5 active:scale-95 transition-all">
                    <i class="fas fa-trash-alt"></i>
                    <span>Hapus Semua Log</span>
                </button>
            </form>
        </div>
        @endif

    </div>

    {{-- FLASH MESSAGE --}}
    @if(session('success'))
    <div class="mb-6 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-2xl px-6 py-4 flex items-center gap-3">
        <i class="fas fa-check-circle text-emerald-500 text-lg"></i>
        <span class="font-semibold">{{ session('success') }}</span>
    </div>
    @endif

    {{-- STAT CARDS --}}
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
        <div class="bg-white rounded-2xl p-5 shadow-sm border border-slate-100 flex items-center gap-4">
            <div class="w-10 h-10 bg-blue-100 rounded-xl flex items-center justify-center text-blue-600">
                <i class="fas fa-history"></i>
            </div>
            <div>
                <p class="text-xs text-slate-400 font-bold uppercase">Total Log</p>
                <p class="text-xl font-black text-slate-800">{{ $activityLogs->total() }}</p>
            </div>
        </div>
        <div class="bg-white rounded-2xl p-5 shadow-sm border border-slate-100 flex items-center gap-4">
            <div class="w-10 h-10 bg-violet-100 rounded-xl flex items-center justify-center text-violet-600">
                <i class="fas fa-file-alt"></i>
            </div>
            <div>
                <p class="text-xs text-slate-400 font-bold uppercase">Halaman Ini</p>
                <p class="text-xl font-black text-slate-800">{{ $activityLogs->count() }}</p>
            </div>
        </div>
        <div class="bg-white rounded-2xl p-5 shadow-sm border border-slate-100 flex items-center gap-4">
            <div class="w-10 h-10 bg-amber-100 rounded-xl flex items-center justify-center text-amber-600">
                <i class="fas fa-book-open"></i>
            </div>
            <div>
                <p class="text-xs text-slate-400 font-bold uppercase">Halaman</p>
                <p class="text-xl font-black text-slate-800">{{ $activityLogs->currentPage() }} / {{ $activityLogs->lastPage() }}</p>
            </div>
        </div>
        <div class="bg-white rounded-2xl p-5 shadow-sm border border-slate-100 flex items-center gap-4">
            <div class="w-10 h-10 bg-emerald-100 rounded-xl flex items-center justify-center text-emerald-600">
                <i class="fas fa-calendar-day"></i>
            </div>
            <div>
                <p class="text-xs text-slate-400 font-bold uppercase">Terbaru</p>
                <p class="text-sm font-black text-slate-800">
                    {{ $activityLogs->first()?->created_at?->diffForHumans() ?? '-' }}
                </p>
            </div>
        </div>
    </div>

    {{-- LOG TABLE --}}
    <div class="bg-white rounded-[2rem] shadow-xl shadow-slate-200/50 border border-slate-100 overflow-hidden">

        {{-- Header Tabel --}}
        <div class="bg-slate-50 px-8 py-5 border-b border-slate-100 flex items-center gap-4">
            <div class="w-10 h-10 bg-slate-800 rounded-2xl flex items-center justify-center text-white shadow">
                <i class="fas fa-terminal text-sm"></i>
            </div>
            <div>
                <h2 class="text-base font-black text-slate-800 uppercase tracking-tight">Riwayat Aktivitas</h2>
                <p class="text-slate-400 text-xs font-bold uppercase tracking-widest">Diurutkan dari yang terbaru</p>
            </div>
        </div>

        {{-- Table --}}
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="border-b border-slate-100">
                        <th class="px-6 py-4 text-left text-xs font-black text-slate-400 uppercase tracking-widest w-8">#</th>
                        <th class="px-6 py-4 text-left text-xs font-black text-slate-400 uppercase tracking-widest">Waktu</th>
                        <th class="px-6 py-4 text-left text-xs font-black text-slate-400 uppercase tracking-widest">Pelaku</th>
                        <th class="px-6 py-4 text-left text-xs font-black text-slate-400 uppercase tracking-widest">Aktivitas / Deskripsi</th>
                        <th class="px-6 py-4 text-left text-xs font-black text-slate-400 uppercase tracking-widest">Subjek</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse ($activityLogs as $log)
                    @php
                        $desc = strtolower($log->description ?? '');
                        $isCreate = str_contains($desc, 'created') || str_contains($desc, 'dibuat') || str_contains($desc, 'tambah') || str_contains($desc, 'daftar');
                        $isUpdate = str_contains($desc, 'updated') || str_contains($desc, 'diubah') || str_contains($desc, 'edit') || str_contains($desc, 'update') || str_contains($desc, 'approved') || str_contains($desc, 'rejected');
                        $isDelete = str_contains($desc, 'deleted') || str_contains($desc, 'dihapus') || str_contains($desc, 'reset') || str_contains($desc, 'truncate');
                        $isLogin  = str_contains($desc, 'login') || str_contains($desc, 'logout') || str_contains($desc, 'masuk');

                        if ($isDelete) {
                            $badgeClass = 'bg-red-100 text-red-700';
                            $dotClass   = 'bg-red-500';
                            $icon       = 'fa-trash-alt';
                        } elseif ($isCreate) {
                            $badgeClass = 'bg-emerald-100 text-emerald-700';
                            $dotClass   = 'bg-emerald-500';
                            $icon       = 'fa-plus-circle';
                        } elseif ($isLogin) {
                            $badgeClass = 'bg-blue-100 text-blue-700';
                            $dotClass   = 'bg-blue-500';
                            $icon       = 'fa-sign-in-alt';
                        } elseif ($isUpdate) {
                            $badgeClass = 'bg-amber-100 text-amber-700';
                            $dotClass   = 'bg-amber-500';
                            $icon       = 'fa-pen';
                        } else {
                            $badgeClass = 'bg-slate-100 text-slate-600';
                            $dotClass   = 'bg-slate-400';
                            $icon       = 'fa-circle-info';
                        }
                    @endphp
                    <tr class="hover:bg-slate-50/70 transition-colors group">
                        {{-- Nomor --}}
                        <td class="px-6 py-4 text-xs font-bold text-slate-300">
                            {{ $activityLogs->firstItem() + $loop->index }}
                        </td>

                        {{-- Waktu --}}
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-xs font-bold text-slate-700">{{ $log->created_at->format('d M Y') }}</div>
                            <div class="text-[10px] text-slate-400 font-mono">{{ $log->created_at->format('H:i:s') }}</div>
                            <div class="text-[10px] text-slate-300 mt-0.5">{{ $log->created_at->diffForHumans() }}</div>
                        </td>

                        {{-- Pelaku --}}
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if ($log->causer)
                            <div class="flex items-center gap-2">
                                <div class="w-8 h-8 bg-slate-800 rounded-full flex items-center justify-center text-white text-xs font-black flex-shrink-0">
                                    {{ strtoupper(substr($log->causer->name ?? 'S', 0, 1)) }}
                                </div>
                                <div>
                                    <div class="text-xs font-bold text-slate-700">{{ $log->causer->name ?? '-' }}</div>
                                    <div class="text-[10px] text-slate-400">{{ $log->causer->role ?? 'system' }}</div>
                                </div>
                            </div>
                            @else
                            <div class="flex items-center gap-2">
                                <div class="w-8 h-8 bg-slate-200 rounded-full flex items-center justify-center text-slate-400 text-xs flex-shrink-0">
                                    <i class="fas fa-robot"></i>
                                </div>
                                <span class="text-xs text-slate-400 font-medium">System / Auto</span>
                            </div>
                            @endif
                        </td>

                        {{-- Aktivitas --}}
                        <td class="px-6 py-4 max-w-xs">
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[10px] font-black uppercase tracking-wide {{ $badgeClass }} mb-1">
                                <i class="fas {{ $icon }} text-[9px]"></i>
                                @if($isDelete) Hapus
                                @elseif($isCreate) Tambah
                                @elseif($isLogin) Auth
                                @elseif($isUpdate) Update
                                @else Info
                                @endif
                            </span>
                            <p class="text-xs text-slate-600 font-medium leading-relaxed line-clamp-2">{{ $log->description ?? '-' }}</p>
                        </td>

                        {{-- Subjek --}}
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if ($log->subject)
                            <div class="text-xs font-bold text-slate-700">{{ class_basename($log->subject_type) }}</div>
                            <div class="text-[10px] font-mono text-slate-400">ID: {{ $log->subject_id }}</div>
                            @else
                            <span class="text-xs text-slate-300">—</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-20 text-center">
                            <div class="flex flex-col items-center gap-3">
                                <div class="w-16 h-16 bg-slate-100 rounded-2xl flex items-center justify-center text-slate-300 text-3xl">
                                    <i class="fas fa-history"></i>
                                </div>
                                <p class="text-slate-400 font-semibold">Belum ada log aktivitas tercatat.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if($activityLogs->hasPages())
        <div class="px-8 py-5 border-t border-slate-100 flex items-center justify-between gap-4">
            <p class="text-xs text-slate-400 font-medium">
                Menampilkan <span class="font-black text-slate-700">{{ $activityLogs->firstItem() }}–{{ $activityLogs->lastItem() }}</span>
                dari <span class="font-black text-slate-700">{{ $activityLogs->total() }}</span> entri
            </p>
            <div class="[&_.pagination]:flex [&_.pagination]:gap-1 [&_.page-item_.page-link]:px-3 [&_.page-item_.page-link]:py-1.5 [&_.page-item_.page-link]:rounded-xl [&_.page-item_.page-link]:text-xs [&_.page-item_.page-link]:font-bold [&_.page-item_.page-link]:border [&_.page-item_.page-link]:border-slate-200 [&_.page-item_.page-link]:text-slate-600 [&_.page-item.active_.page-link]:bg-slate-900 [&_.page-item.active_.page-link]:text-white [&_.page-item.active_.page-link]:border-slate-900">
                {{ $activityLogs->links() }}
            </div>
        </div>
        @endif
    </div>
</div>
@endsection