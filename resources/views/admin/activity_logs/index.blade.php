@extends('layouts.admin')

@section('title', 'Log Aktivitas Sistem')

@section('content')
<div class="space-y-6 pb-12"
    x-data="{
        showDeleteOldModal: false,
        showDeleteAllModal: false,
        submitDeleteOld() { this.$refs.formDeleteOld.submit(); },
        submitDeleteAll() { this.$refs.formDeleteAll.submit(); }
    }">

    {{-- MODAL: Hapus Log > 1 Bulan --}}
    <div x-show="showDeleteOldModal" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
        class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/50 backdrop-blur-sm" @click.self="showDeleteOldModal = false">
        <div x-show="showDeleteOldModal" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 scale-90 translate-y-4"
            x-transition:enter-end="opacity-100 scale-100 translate-y-0" x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-90"
            class="bg-white rounded-3xl shadow-2xl max-w-md w-full p-8 text-center">
            <div class="w-14 h-14 bg-amber-100 rounded-2xl flex items-center justify-center text-amber-500 text-2xl mx-auto mb-4">
                <i class="fas fa-clock"></i>
            </div>
            <h3 class="text-xl font-black text-slate-800 mb-2">Hapus Log Lama?</h3>
            <p class="text-slate-500 text-sm leading-relaxed mb-6">
                Log aktivitas <strong class="text-amber-600">lebih dari 1 bulan</strong> akan dihapus permanen.<br>Log terbaru <span class="font-semibold text-emerald-600">tetap tersimpan</span>.
            </p>
            <div class="flex gap-3">
                <button @click="showDeleteOldModal = false" class="flex-1 px-4 py-3 rounded-2xl border-2 border-slate-200 text-slate-600 font-bold hover:bg-slate-50 transition-all">Batal</button>
                <button @click="submitDeleteOld()" class="flex-1 px-4 py-3 rounded-2xl bg-amber-500 hover:bg-amber-600 text-white font-bold shadow-lg shadow-amber-400/30 transition-all active:scale-95">
                    <i class="fas fa-clock mr-1.5"></i> Ya, Hapus Lama
                </button>
            </div>
        </div>
    </div>

    {{-- MODAL: Hapus Semua Log --}}
    <div x-show="showDeleteAllModal" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
        class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/60 backdrop-blur-sm" @click.self="showDeleteAllModal = false">
        <div x-show="showDeleteAllModal" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 scale-90 translate-y-4"
            x-transition:enter-end="opacity-100 scale-100 translate-y-0" x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-90"
            class="bg-white rounded-3xl shadow-2xl max-w-md w-full p-8 text-center">
            <div class="w-14 h-14 bg-red-100 rounded-2xl flex items-center justify-center text-red-500 text-2xl mx-auto mb-4">
                <i class="fas fa-exclamation-triangle"></i>
            </div>
            <h3 class="text-xl font-black text-slate-800 mb-2">Hapus Semua Log?</h3>
            <div class="bg-red-50 border border-red-200 rounded-2xl px-4 py-2.5 mb-4">
                <p class="text-red-700 text-sm font-bold">⚠️ Tindakan ini tidak dapat dibatalkan!</p>
            </div>
            <p class="text-slate-500 text-sm leading-relaxed mb-6">
                Seluruh riwayat aktivitas akan <strong class="text-red-600">dihapus permanen</strong>, termasuk log terbaru.
            </p>
            <div class="flex gap-3">
                <button @click="showDeleteAllModal = false" class="flex-1 px-4 py-3 rounded-2xl border-2 border-slate-200 text-slate-600 font-bold hover:bg-slate-50 transition-all">Batal</button>
                <button @click="submitDeleteAll()" class="flex-1 px-4 py-3 rounded-2xl bg-red-600 hover:bg-red-700 text-white font-bold shadow-lg shadow-red-500/30 transition-all active:scale-95">
                    <i class="fas fa-trash-alt mr-1.5"></i> Ya, Hapus Semua
                </button>
            </div>
        </div>
    </div>

    {{-- Hidden forms --}}
    @if(in_array(Auth::user()->role ?? '', ['super_admin', 'admin_registrasi']))
    <form x-ref="formDeleteOld" action="{{ route('admin.activity_logs.delete_old') }}" method="POST" class="hidden">@csrf</form>
    <form x-ref="formDeleteAll" action="{{ route('admin.activity_logs.reset') }}" method="POST" class="hidden">@csrf</form>
    @endif

    {{-- HERO HEADER --}}
    <div class="relative bg-gradient-to-br from-slate-900 via-slate-800 to-slate-900 rounded-3xl overflow-hidden shadow-2xl">
        <div class="absolute inset-0 pointer-events-none overflow-hidden">
            <div class="absolute -top-16 -right-16 w-64 h-64 bg-slate-500 rounded-full blur-[80px] opacity-10"></div>
            <div class="absolute -bottom-10 -left-10 w-48 h-48 bg-slate-400 rounded-full blur-[60px] opacity-8"></div>
        </div>
        <div class="relative z-10 px-8 py-7 flex flex-col md:flex-row items-start md:items-center justify-between gap-5">
            <div>
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/10 border border-white/20 text-slate-300 text-xs font-bold uppercase tracking-widest mb-3">
                    <i class="fas fa-terminal"></i> Audit Trail
                </div>
                <h1 class="text-3xl md:text-4xl font-black text-white tracking-tight">Log Aktivitas Sistem</h1>
                <p class="text-slate-400 mt-1 text-sm">Rekam jejak seluruh aksi petugas & sistem secara real-time.</p>
            </div>
            @if(in_array(Auth::user()->role ?? '', ['super_admin', 'admin_registrasi']))
            <div class="flex flex-wrap gap-3">
                <button @click="showDeleteOldModal = true"
                    class="inline-flex items-center gap-2 bg-amber-500 hover:bg-amber-600 text-white font-bold px-4 py-2.5 rounded-2xl shadow-lg shadow-amber-400/25 hover:-translate-y-0.5 active:scale-95 transition-all text-sm">
                    <i class="fas fa-clock"></i> Log > 1 Bulan
                </button>
                <button @click="showDeleteAllModal = true"
                    class="inline-flex items-center gap-2 bg-red-600 hover:bg-red-700 text-white font-bold px-4 py-2.5 rounded-2xl shadow-lg shadow-red-500/25 hover:-translate-y-0.5 active:scale-95 transition-all text-sm">
                    <i class="fas fa-trash-alt"></i> Hapus Semua
                </button>
            </div>
            @endif
        </div>
    </div>

    {{-- FLASH --}}
    @if(session('success'))
    <div class="flex items-center gap-3 bg-emerald-50 border border-emerald-200 text-emerald-800 px-5 py-3.5 rounded-2xl shadow-sm">
        <div class="w-8 h-8 bg-emerald-500 rounded-xl flex items-center justify-center flex-shrink-0">
            <i class="fas fa-check text-white text-sm"></i>
        </div>
        <p class="font-bold text-sm">{{ session('success') }}</p>
    </div>
    @endif

    {{-- STAT CARDS --}}
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        <div class="bg-white rounded-2xl p-4 border border-slate-100 shadow-sm flex items-center gap-3">
            <div class="w-10 h-10 bg-blue-100 rounded-xl flex items-center justify-center text-blue-600 flex-shrink-0">
                <i class="fas fa-history text-sm"></i>
            </div>
            <div>
                <p class="text-[10px] text-slate-400 font-black uppercase tracking-widest">Total Log</p>
                <p class="text-lg font-black text-slate-800">{{ $activityLogs->total() }}</p>
            </div>
        </div>
        <div class="bg-white rounded-2xl p-4 border border-slate-100 shadow-sm flex items-center gap-3">
            <div class="w-10 h-10 bg-violet-100 rounded-xl flex items-center justify-center text-violet-600 flex-shrink-0">
                <i class="fas fa-file-alt text-sm"></i>
            </div>
            <div>
                <p class="text-[10px] text-slate-400 font-black uppercase tracking-widest">Halaman Ini</p>
                <p class="text-lg font-black text-slate-800">{{ $activityLogs->count() }}</p>
            </div>
        </div>
        <div class="bg-white rounded-2xl p-4 border border-slate-100 shadow-sm flex items-center gap-3">
            <div class="w-10 h-10 bg-amber-100 rounded-xl flex items-center justify-center text-amber-600 flex-shrink-0">
                <i class="fas fa-book-open text-sm"></i>
            </div>
            <div>
                <p class="text-[10px] text-slate-400 font-black uppercase tracking-widest">Halaman</p>
                <p class="text-lg font-black text-slate-800">{{ $activityLogs->currentPage() }} / {{ $activityLogs->lastPage() }}</p>
            </div>
        </div>
        <div class="bg-white rounded-2xl p-4 border border-slate-100 shadow-sm flex items-center gap-3">
            <div class="w-10 h-10 bg-emerald-100 rounded-xl flex items-center justify-center text-emerald-600 flex-shrink-0">
                <i class="fas fa-calendar-day text-sm"></i>
            </div>
            <div>
                <p class="text-[10px] text-slate-400 font-black uppercase tracking-widest">Terbaru</p>
                <p class="text-sm font-black text-slate-800">{{ $activityLogs->first()?->created_at?->diffForHumans() ?? '-' }}</p>
            </div>
        </div>
    </div>

    {{-- LOG TABLE --}}
    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
        {{-- Header --}}
        <div class="bg-slate-50 px-6 py-4 border-b border-slate-100 flex items-center gap-3">
            <div class="w-9 h-9 bg-slate-800 rounded-xl flex items-center justify-center text-white">
                <i class="fas fa-terminal text-sm"></i>
            </div>
            <div>
                <h2 class="text-sm font-black text-slate-800 uppercase tracking-tight">Riwayat Aktivitas</h2>
                <p class="text-slate-400 text-[10px] font-bold uppercase tracking-widest">Diurutkan dari yang terbaru</p>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="border-b border-slate-100">
                    <tr>
                        <th class="px-5 py-3.5 text-left text-[10px] font-black text-slate-400 uppercase tracking-widest w-10">#</th>
                        <th class="px-5 py-3.5 text-left text-[10px] font-black text-slate-400 uppercase tracking-widest">Waktu</th>
                        <th class="px-5 py-3.5 text-left text-[10px] font-black text-slate-400 uppercase tracking-widest">Pelaku</th>
                        <th class="px-5 py-3.5 text-left text-[10px] font-black text-slate-400 uppercase tracking-widest">Aktivitas</th>
                        <th class="px-5 py-3.5 text-left text-[10px] font-black text-slate-400 uppercase tracking-widest">Subjek</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse ($activityLogs as $log)
                    @php
                        $desc = strtolower($log->description ?? '');
                        $isCreate = str_contains($desc,'created')||str_contains($desc,'dibuat')||str_contains($desc,'tambah')||str_contains($desc,'daftar');
                        $isUpdate = str_contains($desc,'updated')||str_contains($desc,'diubah')||str_contains($desc,'edit')||str_contains($desc,'update')||str_contains($desc,'approved')||str_contains($desc,'rejected');
                        $isDelete = str_contains($desc,'deleted')||str_contains($desc,'dihapus')||str_contains($desc,'reset')||str_contains($desc,'truncate');
                        $isLogin  = str_contains($desc,'login')||str_contains($desc,'logout')||str_contains($desc,'masuk');
                        if($isDelete)     { $badgeClass='bg-red-100 text-red-700';     $icon='fa-trash-alt';   $label='Hapus'; }
                        elseif($isCreate) { $badgeClass='bg-emerald-100 text-emerald-700'; $icon='fa-plus-circle'; $label='Tambah'; }
                        elseif($isLogin)  { $badgeClass='bg-blue-100 text-blue-700';   $icon='fa-sign-in-alt'; $label='Auth'; }
                        elseif($isUpdate) { $badgeClass='bg-amber-100 text-amber-700'; $icon='fa-pen';          $label='Update'; }
                        else              { $badgeClass='bg-slate-100 text-slate-600';  $icon='fa-circle-info'; $label='Info'; }
                    @endphp
                    <tr class="group hover:bg-slate-50/70 transition-colors">
                        <td class="px-5 py-4 text-xs font-bold text-slate-300">{{ $activityLogs->firstItem() + $loop->index }}</td>
                        <td class="px-5 py-4 whitespace-nowrap">
                            <div class="text-xs font-bold text-slate-700">{{ $log->created_at->format('d M Y') }}</div>
                            <div class="text-[10px] text-slate-400 font-mono">{{ $log->created_at->format('H:i:s') }}</div>
                            <div class="text-[10px] text-slate-300 mt-0.5">{{ $log->created_at->diffForHumans() }}</div>
                        </td>
                        <td class="px-5 py-4 whitespace-nowrap">
                            @if($log->causer)
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
                        <td class="px-5 py-4 max-w-xs">
                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[9px] font-black uppercase tracking-wide {{ $badgeClass }} mb-1">
                                <i class="fas {{ $icon }}"></i> {{ $label }}
                            </span>
                            <p class="text-xs text-slate-600 font-medium leading-relaxed line-clamp-2">{{ $log->description ?? '-' }}</p>
                        </td>
                        <td class="px-5 py-4 whitespace-nowrap">
                            @if($log->subject)
                            <div class="text-xs font-bold text-slate-700">{{ class_basename($log->subject_type) }}</div>
                            <div class="text-[10px] font-mono text-slate-400">ID: {{ $log->subject_id }}</div>
                            @else
                            <span class="text-xs text-slate-300">—</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="py-16 text-center">
                            <div class="w-14 h-14 bg-slate-100 rounded-2xl flex items-center justify-center text-slate-300 text-2xl mx-auto mb-3">
                                <i class="fas fa-history"></i>
                            </div>
                            <p class="text-slate-400 font-semibold text-sm">Belum ada log aktivitas tercatat.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($activityLogs->hasPages())
        <div class="px-6 py-4 border-t border-slate-100 flex items-center justify-between gap-4">
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