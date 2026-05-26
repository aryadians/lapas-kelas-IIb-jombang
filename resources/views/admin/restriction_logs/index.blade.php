@extends('layouts.admin')

@section('content')
<div class="space-y-6 pb-12" x-data="broadcastLogApp()">

    {{-- HERO HEADER --}}
    <div class="relative bg-gradient-to-br from-slate-900 via-indigo-950 to-violet-950 rounded-3xl overflow-hidden shadow-2xl">
        <div class="absolute inset-0 pointer-events-none overflow-hidden">
            <div class="absolute -top-20 -right-20 w-80 h-80 bg-indigo-400 rounded-full blur-[90px] opacity-10"></div>
            <div class="absolute -bottom-16 -left-16 w-60 h-60 bg-violet-400 rounded-full blur-[80px] opacity-10"></div>
        </div>
        <div class="relative z-10 px-8 py-7 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/10 border border-white/20 text-indigo-200 text-xs font-bold uppercase tracking-widest mb-3">
                    <i class="fas fa-history"></i> Audit Trail
                </div>
                <h1 class="text-3xl font-black text-white tracking-tight">Log Broadcast Pembatasan</h1>
                <p class="text-indigo-100/60 mt-1 text-sm">Riwayat seluruh eksekusi broadcast pembatalan kunjungan WBP — manual maupun otomatis.</p>
            </div>
            <div class="flex flex-wrap gap-3">
                {{-- Run Manual --}}
                <button @click="runManual()"
                    :disabled="isRunning"
                    class="flex items-center gap-2 px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 disabled:opacity-60 disabled:cursor-not-allowed text-white text-sm font-bold rounded-xl shadow-lg transition-all">
                    <i class="fas fa-play" :class="isRunning ? 'animate-spin' : ''"></i>
                    <span x-text="isRunning ? 'Sedang Berjalan...' : 'Jalankan Manual Sekarang'"></span>
                </button>
                <a href="{{ route('admin.wbp.index') }}" class="flex items-center gap-2 px-5 py-2.5 bg-white/10 hover:bg-white/20 text-white text-sm font-bold rounded-xl border border-white/20 transition-all">
                    <i class="fas fa-users"></i> Halaman WBP
                </a>
            </div>
        </div>
    </div>

    {{-- STATS CARDS --}}
    <div class="grid grid-cols-2 lg:grid-cols-5 gap-4">
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-5 flex flex-col gap-1">
            <span class="text-xs font-bold text-slate-400 uppercase tracking-widest">Total Log</span>
            <span class="text-3xl font-black text-slate-800">{{ number_format($stats['total']) }}</span>
        </div>
        <div class="bg-white rounded-2xl border border-emerald-100 shadow-sm p-5 flex flex-col gap-1">
            <span class="text-xs font-bold text-emerald-400 uppercase tracking-widest">Sukses</span>
            <span class="text-3xl font-black text-emerald-700">{{ number_format($stats['success']) }}</span>
        </div>
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-5 flex flex-col gap-1">
            <span class="text-xs font-bold text-slate-400 uppercase tracking-widest">Tanpa Dampak</span>
            <span class="text-3xl font-black text-slate-600">{{ number_format($stats['no_impact']) }}</span>
        </div>
        <div class="bg-white rounded-2xl border border-red-100 shadow-sm p-5 flex flex-col gap-1">
            <span class="text-xs font-bold text-red-400 uppercase tracking-widest">Gagal/Error</span>
            <span class="text-3xl font-black text-red-700">{{ number_format($stats['failed']) }}</span>
        </div>
        <div class="bg-white rounded-2xl border border-orange-100 shadow-sm p-5 flex flex-col gap-1 col-span-2 lg:col-span-1">
            <span class="text-xs font-bold text-orange-400 uppercase tracking-widest">Total Dibatalkan</span>
            <span class="text-3xl font-black text-orange-700">{{ number_format($stats['total_cancelled']) }}</span>
        </div>
    </div>

    {{-- FILTER BAR --}}
    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-5">
        <form method="GET" action="{{ route('admin.restriction-logs.index') }}" class="flex flex-wrap gap-3 items-end">
            <div class="flex flex-col gap-1">
                <label class="text-xs font-bold text-slate-500 uppercase">Tanggal</label>
                <input type="date" name="tanggal" value="{{ request('tanggal') }}"
                    class="p-2.5 bg-slate-50 border-2 border-slate-100 rounded-xl text-sm font-medium text-slate-700 focus:border-indigo-500 focus:ring-0">
            </div>
            <div class="flex flex-col gap-1">
                <label class="text-xs font-bold text-slate-500 uppercase">Status</label>
                <select name="status" class="p-2.5 bg-slate-50 border-2 border-slate-100 rounded-xl text-sm font-medium text-slate-700 focus:border-indigo-500 focus:ring-0">
                    <option value="">Semua Status</option>
                    <option value="success" {{ request('status') === 'success' ? 'selected' : '' }}>Sukses</option>
                    <option value="no_impact" {{ request('status') === 'no_impact' ? 'selected' : '' }}>Tidak Ada Dampak</option>
                    <option value="partial_error" {{ request('status') === 'partial_error' ? 'selected' : '' }}>Sebagian Error</option>
                    <option value="failed" {{ request('status') === 'failed' ? 'selected' : '' }}>Gagal</option>
                </select>
            </div>
            <div class="flex flex-col gap-1">
                <label class="text-xs font-bold text-slate-500 uppercase">Dipicu Oleh</label>
                <select name="triggered_by" class="p-2.5 bg-slate-50 border-2 border-slate-100 rounded-xl text-sm font-medium text-slate-700 focus:border-indigo-500 focus:ring-0">
                    <option value="">Semua</option>
                    <option value="scheduler" {{ request('triggered_by') === 'scheduler' ? 'selected' : '' }}>Otomatis (Scheduler)</option>
                    <option value="manual" {{ request('triggered_by') === 'manual' ? 'selected' : '' }}>Manual</option>
                </select>
            </div>
            <button type="submit" class="px-5 py-2.5 bg-indigo-600 text-white text-sm font-bold rounded-xl hover:bg-indigo-700 transition-all flex items-center gap-2">
                <i class="fas fa-filter"></i> Filter
            </button>
            @if(request()->hasAny(['tanggal', 'status', 'triggered_by']))
            <a href="{{ route('admin.restriction-logs.index') }}" class="px-5 py-2.5 bg-slate-100 text-slate-600 text-sm font-bold rounded-xl hover:bg-slate-200 transition-all flex items-center gap-2">
                <i class="fas fa-times"></i> Reset
            </a>
            @endif
        </form>
    </div>

    {{-- BULK ACTION BAR (muncul ketika ada yang dicentang) --}}
    <div x-show="selectedIds.length > 0" x-transition
        class="fixed bottom-6 left-1/2 -translate-x-1/2 z-50 bg-slate-900 text-white rounded-2xl shadow-2xl px-6 py-4 flex items-center gap-4 border border-white/10">
        <div class="flex items-center gap-2">
            <div class="w-8 h-8 bg-red-500 rounded-lg flex items-center justify-center">
                <i class="fas fa-trash text-sm"></i>
            </div>
            <span class="font-bold text-sm"><span x-text="selectedIds.length"></span> log dipilih</span>
        </div>
        <div class="w-px h-8 bg-white/20"></div>
        <button @click="bulkDelete()"
            :disabled="isDeleting"
            class="flex items-center gap-2 px-4 py-2 bg-red-600 hover:bg-red-700 disabled:opacity-60 text-sm font-bold rounded-xl transition-all">
            <i class="fas fa-trash-alt"></i>
            <span x-text="isDeleting ? 'Menghapus...' : 'Hapus yang Dipilih'"></span>
        </button>
        <button @click="selectedIds = []" class="flex items-center gap-2 px-4 py-2 bg-white/10 hover:bg-white/20 text-sm font-medium rounded-xl transition-all">
            <i class="fas fa-times"></i> Batal
        </button>
    </div>

    {{-- LOG TABLE --}}
    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
        <div class="bg-slate-50 px-6 py-4 border-b border-slate-100 flex items-center justify-between flex-wrap gap-3">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 bg-indigo-600 rounded-xl flex items-center justify-center text-white">
                    <i class="fas fa-list-alt text-sm"></i>
                </div>
                <div>
                    <h2 class="font-black text-slate-800 text-sm uppercase tracking-tight">Riwayat Broadcast</h2>
                    <p class="text-slate-400 text-xs">{{ $logs->total() }} log ditemukan</p>
                </div>
            </div>
            {{-- Select All --}}
            <label class="flex items-center gap-2 text-sm text-slate-600 font-medium cursor-pointer select-none">
                <input type="checkbox" @change="toggleAll($event)" :checked="allSelected"
                    class="w-4 h-4 rounded border-slate-300 text-indigo-600 focus:ring-indigo-500">
                Pilih Semua di Halaman Ini
            </label>
        </div>

        @if($logs->isEmpty())
        <div class="py-20 text-center">
            <div class="w-16 h-16 bg-slate-100 rounded-2xl flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-history text-slate-400 text-2xl"></i>
            </div>
            <p class="text-slate-500 font-bold">Belum Ada Log</p>
            <p class="text-slate-400 text-sm mt-1">Jalankan broadcast manual atau tunggu scheduler tengah malam.</p>
        </div>
        @else
        <div class="divide-y divide-slate-50">
            @foreach($logs as $log)
            <div class="px-6 py-4 hover:bg-slate-50/50 transition-colors flex items-start gap-4" :class="selectedIds.includes({{ $log->id }}) ? 'bg-indigo-50/50' : ''">
                {{-- Checkbox --}}
                <div class="pt-1 flex-shrink-0">
                    <input type="checkbox" :value="{{ $log->id }}"
                        @change="toggleSelect({{ $log->id }})"
                        :checked="selectedIds.includes({{ $log->id }})"
                        class="w-4 h-4 rounded border-slate-300 text-indigo-600 focus:ring-indigo-500 cursor-pointer">
                </div>

                {{-- Icon Trigger --}}
                <div class="flex-shrink-0 mt-0.5">
                    @if($log->triggered_by === 'scheduler')
                    <div class="w-10 h-10 bg-blue-100 rounded-xl flex items-center justify-center text-blue-600">
                        <i class="fas fa-robot text-sm"></i>
                    </div>
                    @else
                    <div class="w-10 h-10 bg-purple-100 rounded-xl flex items-center justify-center text-purple-600">
                        <i class="fas fa-user-cog text-sm"></i>
                    </div>
                    @endif
                </div>

                {{-- Content --}}
                <div class="flex-grow min-w-0">
                    <div class="flex flex-wrap items-center gap-2 mb-2">
                        {!! $log->status_badge !!}
                        {!! $log->triggered_by_badge !!}
                        <span class="text-xs text-slate-400 ml-auto">
                            <i class="fas fa-clock mr-1"></i>
                            {{ $log->created_at->timezone('Asia/Jakarta')->format('d M Y, H:i:s') }}
                            <span class="text-slate-300 mx-1">·</span>
                            {{ $log->created_at->diffForHumans() }}
                        </span>
                    </div>

                    <div class="flex flex-wrap gap-4 text-sm">
                        <div class="flex items-center gap-1.5 text-slate-600">
                            <i class="fas fa-users text-slate-400 text-xs"></i>
                            <span class="font-bold text-slate-800">{{ $log->total_wbp_processed }}</span>
                            <span class="text-slate-400">WBP diproses</span>
                        </div>
                        <div class="flex items-center gap-1.5 text-slate-600">
                            <i class="fas fa-ban text-red-400 text-xs"></i>
                            <span class="font-bold text-red-700">{{ $log->total_kunjungan_cancelled }}</span>
                            <span class="text-slate-400">kunjungan dibatalkan</span>
                        </div>
                        <div class="flex items-center gap-1.5 text-slate-600">
                            <i class="fab fa-whatsapp text-emerald-400 text-xs"></i>
                            <span class="font-bold text-emerald-700">{{ $log->total_notifications_queued }}</span>
                            <span class="text-slate-400">notif antri</span>
                        </div>
                        <div class="flex items-center gap-1.5 text-slate-500 text-xs">
                            <i class="fas fa-list text-slate-300"></i>
                            {{ $log->details_count }} detail
                        </div>
                    </div>

                    @if($log->notes)
                    <p class="text-xs text-slate-400 mt-2 leading-relaxed">{{ Str::limit($log->notes, 120) }}</p>
                    @endif
                </div>

                {{-- Actions --}}
                <div class="flex-shrink-0 flex items-center gap-2">
                    <a href="{{ route('admin.restriction-logs.show', $log->id) }}"
                        class="flex items-center gap-1.5 px-3 py-1.5 bg-indigo-50 hover:bg-indigo-100 text-indigo-700 text-xs font-bold rounded-lg transition-all">
                        <i class="fas fa-eye"></i> Detail
                    </a>
                </div>
            </div>
            @endforeach
        </div>

        {{-- PAGINATION --}}
        <div class="px-6 py-4 border-t border-slate-100">
            {{ $logs->links() }}
        </div>
        @endif
    </div>

</div>

@push('scripts')
<script>
function broadcastLogApp() {
    return {
        selectedIds: [],
        isDeleting: false,
        isRunning: false,

        get allSelected() {
            const pageIds = @json($logs->pluck('id'));
            return pageIds.length > 0 && pageIds.every(id => this.selectedIds.includes(id));
        },

        toggleAll(event) {
            const pageIds = @json($logs->pluck('id'));
            if (event.target.checked) {
                pageIds.forEach(id => {
                    if (!this.selectedIds.includes(id)) this.selectedIds.push(id);
                });
            } else {
                this.selectedIds = this.selectedIds.filter(id => !pageIds.includes(id));
            }
        },

        toggleSelect(id) {
            if (this.selectedIds.includes(id)) {
                this.selectedIds = this.selectedIds.filter(i => i !== id);
            } else {
                this.selectedIds.push(id);
            }
        },

        async bulkDelete() {
            if (this.selectedIds.length === 0) return;

            const confirmed = await Swal.fire({
                title: `Hapus ${this.selectedIds.length} Log?`,
                text: 'Data log dan seluruh detailnya akan dihapus permanen. Tindakan ini tidak bisa dibatalkan.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc2626',
                cancelButtonColor: '#64748b',
                confirmButtonText: '<i class="fas fa-trash-alt mr-1"></i> Ya, Hapus',
                cancelButtonText: 'Batal',
            });

            if (!confirmed.isConfirmed) return;

            this.isDeleting = true;
            try {
                const response = await fetch('{{ route("admin.restriction-logs.bulk-destroy") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    },
                    body: JSON.stringify({ ids: this.selectedIds }),
                });

                const result = await response.json();
                if (result.success) {
                    await Swal.fire({
                        icon: 'success',
                        title: 'Berhasil',
                        text: result.message,
                        timer: 2000,
                        showConfirmButton: false,
                    });
                    window.location.reload();
                } else {
                    Swal.fire('Gagal', result.message, 'error');
                }
            } catch (e) {
                Swal.fire('Error', 'Terjadi kesalahan jaringan.', 'error');
            } finally {
                this.isDeleting = false;
            }
        },

        async runManual() {
            const confirmed = await Swal.fire({
                title: 'Jalankan Broadcast Sekarang?',
                text: 'Sistem akan mencari semua kunjungan aktif yang terdampak pembatasan dan membatalkannya secara otomatis.',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#4f46e5',
                cancelButtonColor: '#64748b',
                confirmButtonText: '<i class="fas fa-play mr-1"></i> Jalankan',
                cancelButtonText: 'Batal',
            });

            if (!confirmed.isConfirmed) return;

            this.isRunning = true;
            try {
                const response = await fetch('{{ route("admin.wbp.broadcast-restriction") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    },
                    body: JSON.stringify({ ids: [] }),
                });

                // Jika tidak ada WBP yang dipilih, gunakan command artisan via endpoint khusus
                // Untuk sementara, reload setelah 2 detik
                const result = await response.json();
                await Swal.fire({
                    icon: result.success ? 'success' : 'error',
                    title: result.success ? 'Selesai' : 'Gagal',
                    text: result.message,
                    confirmButtonText: 'Lihat Log Terbaru',
                }).then(() => window.location.reload());

            } catch (e) {
                Swal.fire('Error', 'Gagal menghubungi server.', 'error');
            } finally {
                this.isRunning = false;
            }
        },
    }
}
</script>
@endpush
@endsection
