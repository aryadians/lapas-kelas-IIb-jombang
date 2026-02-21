@extends('layouts.admin')

@section('title', 'Kelola Pengumuman')

@section('content')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<div class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50/20 to-slate-100 space-y-6 pb-12">

    {{-- HEADER --}}
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
        <div class="flex items-center gap-4">
            <div class="w-14 h-14 bg-gradient-to-br from-blue-600 to-indigo-700 rounded-2xl flex items-center justify-center shadow-xl shadow-blue-500/20 flex-shrink-0">
                <i class="fas fa-bullhorn text-2xl text-white"></i>
            </div>
            <div>
                <h1 class="text-2xl md:text-3xl font-black text-slate-800 tracking-tight">Kelola Pengumuman</h1>
                <p class="text-slate-400 text-sm font-medium">Informasi penting untuk pegawai & pengunjung</p>
            </div>
        </div>
        <div class="flex items-center gap-3">
            <button onclick="window.print()"
                class="inline-flex items-center gap-2 bg-white text-slate-600 font-bold px-4 py-2.5 rounded-2xl shadow-sm border border-slate-200 hover:bg-slate-50 transition-all active:scale-95 text-sm">
                <i class="fas fa-print text-slate-400"></i> Cetak
            </button>
            <a href="{{ route('announcements.create') }}"
                class="inline-flex items-center gap-2 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-bold py-2.5 px-5 rounded-2xl shadow-lg shadow-blue-500/30 transition-all hover:-translate-y-0.5 active:scale-95 text-sm">
                <i class="fas fa-plus"></i> Buat Pengumuman
            </a>
        </div>
    </div>

    {{-- FLASH --}}
    @if(session('success'))
    <div class="bg-emerald-50 border border-emerald-200 rounded-2xl p-4 flex items-center gap-3">
        <div class="w-9 h-9 bg-emerald-100 rounded-xl flex items-center justify-center flex-shrink-0">
            <i class="fas fa-check-circle text-emerald-500"></i>
        </div>
        <p class="text-emerald-700 font-semibold text-sm">{{ session('success') }}</p>
    </div>
    @endif

    {{-- STAT CARDS --}}
    @php
        $total  = $announcements->total();
        $published = \App\Models\Announcement::where('status', 'published')->count();
        $draft  = \App\Models\Announcement::where('status', 'draft')->count();
    @endphp
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-5 flex items-center gap-4">
            <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center text-blue-600 text-xl flex-shrink-0">
                <i class="fas fa-list"></i>
            </div>
            <div>
                <p class="text-xs text-slate-400 font-bold uppercase tracking-widest">Total</p>
                <p class="text-2xl font-black text-slate-800">{{ $total }}</p>
            </div>
        </div>
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-5 flex items-center gap-4">
            <div class="w-12 h-12 bg-emerald-100 rounded-xl flex items-center justify-center text-emerald-600 text-xl flex-shrink-0">
                <i class="fas fa-globe"></i>
            </div>
            <div>
                <p class="text-xs text-slate-400 font-bold uppercase tracking-widest">Diterbitkan</p>
                <p class="text-2xl font-black text-slate-800">{{ $published }}</p>
            </div>
        </div>
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-5 flex items-center gap-4">
            <div class="w-12 h-12 bg-amber-100 rounded-xl flex items-center justify-center text-amber-600 text-xl flex-shrink-0">
                <i class="fas fa-file-alt"></i>
            </div>
            <div>
                <p class="text-xs text-slate-400 font-bold uppercase tracking-widest">Draft</p>
                <p class="text-2xl font-black text-slate-800">{{ $draft }}</p>
            </div>
        </div>
    </div>

    {{-- SEARCH --}}
    <form method="GET" action="{{ route('announcements.index') }}">
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-4">
            <div class="flex flex-col sm:flex-row gap-3">
                <div class="relative flex-1">
                    <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"></i>
                    <input type="text" name="search" value="{{ request('search') }}"
                        placeholder="Cari judul pengumuman..."
                        class="w-full pl-11 pr-4 py-3 bg-slate-50 border-2 border-slate-100 rounded-xl text-sm font-medium text-slate-700 placeholder-slate-400 focus:bg-white focus:border-blue-500 focus:outline-none transition-all">
                </div>
                <button type="submit"
                    class="inline-flex items-center gap-2 px-5 py-3 bg-slate-800 hover:bg-slate-900 text-white font-bold rounded-xl text-sm transition-all active:scale-95">
                    <i class="fas fa-filter"></i> Filter
                </button>
                @if(request('search'))
                <a href="{{ route('announcements.index') }}"
                    class="inline-flex items-center gap-2 px-5 py-3 bg-white border-2 border-slate-200 hover:bg-slate-50 text-slate-600 font-bold rounded-xl text-sm transition-all active:scale-95">
                    <i class="fas fa-times"></i> Reset
                </a>
                @endif
            </div>
        </div>
    </form>

    {{-- LIST --}}
    <div class="space-y-3">
        @forelse($announcements as $idx => $item)
        @php
            $statusConfig = match($item->status ?? 'draft') {
                'published' => ['bg' => 'bg-emerald-100', 'text' => 'text-emerald-700', 'dot' => 'bg-emerald-400', 'label' => 'Published'],
                default     => ['bg' => 'bg-amber-100',   'text' => 'text-amber-700',   'dot' => 'bg-amber-400',   'label' => 'Draft'],
            };
        @endphp
        <div class="group bg-white rounded-2xl border border-slate-100 shadow-sm hover:shadow-md hover:-translate-y-0.5 transition-all duration-200 overflow-hidden">
            <div class="flex items-stretch">
                {{-- Tanggal Panel --}}
                <div class="flex-shrink-0 w-20 bg-gradient-to-b from-blue-600 to-indigo-700 flex flex-col items-center justify-center text-white py-4">
                    <span class="text-2xl font-black leading-none">{{ $item->date->format('d') }}</span>
                    <span class="text-[10px] font-bold uppercase tracking-widest opacity-80">{{ $item->date->format('M') }}</span>
                    <span class="text-[9px] opacity-60 mt-0.5">{{ $item->date->format('Y') }}</span>
                </div>

                {{-- Content --}}
                <div class="flex-1 p-5 min-w-0">
                    <div class="flex flex-col sm:flex-row sm:items-start gap-3">
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center gap-2 mb-1.5 flex-wrap">
                                {{-- Badge Status --}}
                                <span class="inline-flex items-center gap-1.5 text-[11px] font-black px-2.5 py-0.5 rounded-full {{ $statusConfig['bg'] }} {{ $statusConfig['text'] }}">
                                    <span class="w-1.5 h-1.5 rounded-full {{ $statusConfig['dot'] }}"></span>
                                    {{ $statusConfig['label'] }}
                                </span>
                                {{-- Nomor urut --}}
                                <span class="text-[11px] text-slate-300 font-bold">#{{ $announcements->firstItem() + $idx }}</span>
                            </div>
                            <h3 class="text-base font-black text-slate-800 leading-snug group-hover:text-blue-600 transition-colors line-clamp-1 mb-1">
                                {{ $item->title }}
                            </h3>
                            <p class="text-slate-500 text-sm leading-relaxed line-clamp-2">
                                {{ Str::limit(strip_tags($item->content), 150) }}
                            </p>
                            <div class="flex items-center gap-3 mt-2 text-xs text-slate-400">
                                <span class="flex items-center gap-1">
                                    <i class="far fa-clock"></i> {{ $item->created_at->diffForHumans() }}
                                </span>
                                <span class="flex items-center gap-1">
                                    <i class="fas fa-calendar-day"></i> Berlaku: {{ $item->date->isoFormat('D MMM Y') }}
                                </span>
                            </div>
                        </div>

                        {{-- Actions --}}
                        <div class="flex items-center gap-1.5 sm:flex-col sm:items-end">
                            <a href="{{ route('announcements.show', $item->id) }}"
                                class="w-9 h-9 rounded-xl bg-slate-100 hover:bg-blue-100 hover:text-blue-600 flex items-center justify-center text-slate-500 text-sm transition-all" title="Lihat">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('announcements.edit', $item->id) }}"
                                class="w-9 h-9 rounded-xl bg-slate-100 hover:bg-indigo-100 hover:text-indigo-600 flex items-center justify-center text-slate-500 text-sm transition-all" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <button onclick="confirmDelete(event, '{{ $item->id }}', '{{ addslashes($item->title) }}')"
                                class="w-9 h-9 rounded-xl bg-slate-100 hover:bg-red-100 hover:text-red-600 flex items-center justify-center text-slate-500 text-sm transition-all" title="Hapus">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                            <form id="delete-form-{{ $item->id }}" action="{{ route('announcements.destroy', $item->id) }}" method="POST" class="hidden">
                                @csrf @method('DELETE')
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm py-20 text-center">
            <div class="w-20 h-20 bg-slate-100 rounded-3xl flex items-center justify-center text-slate-300 text-4xl mx-auto mb-4">
                <i class="fas fa-bullhorn"></i>
            </div>
            <h3 class="text-xl font-black text-slate-700 mb-2">Belum Ada Pengumuman</h3>
            <p class="text-slate-400 text-sm mb-6">Pengumuman yang dibuat akan muncul di sini.</p>
            <a href="{{ route('announcements.create') }}"
                class="inline-flex items-center gap-2 px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-2xl shadow-lg shadow-blue-500/30 transition-all active:scale-95">
                <i class="fas fa-plus"></i> Buat Sekarang
            </a>
        </div>
        @endforelse
    </div>

    {{-- PAGINATION --}}
    @if($announcements->hasPages())
    <div class="mt-4">
        {{ $announcements->links() }}
    </div>
    @endif

</div>

<script>
    function confirmDelete(event, id, title) {
        event.preventDefault();
        Swal.fire({
            customClass: {
                popup: 'rounded-3xl shadow-2xl',
                confirmButton: 'rounded-xl px-6 py-3 font-bold bg-red-600 text-white mr-2',
                cancelButton: 'rounded-xl px-6 py-3 font-bold bg-slate-200 text-slate-600'
            },
            buttonsStyling: false,
            title: 'Hapus Pengumuman?',
            html: `Anda akan menghapus <strong>"${title}"</strong>.<br><span class="text-sm text-gray-500">Tindakan ini tidak dapat dibatalkan.</span>`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: '<i class="fas fa-trash-alt mr-1"></i> Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then(result => {
            if (result.isConfirmed) document.getElementById(`delete-form-${id}`).submit();
        });
    }
</script>
@endsection