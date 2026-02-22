@extends('layouts.admin')

@section('title', 'Manajemen Pengguna')

@section('content')
<div class="space-y-6 pb-12">

    {{-- HERO HEADER --}}
    <div class="relative bg-gradient-to-br from-slate-900 via-violet-950 to-purple-950 rounded-3xl overflow-hidden shadow-2xl">
        <div class="absolute inset-0 pointer-events-none overflow-hidden">
            <div class="absolute -top-20 -right-20 w-72 h-72 bg-violet-400 rounded-full blur-[90px] opacity-10"></div>
            <div class="absolute -bottom-12 -left-12 w-56 h-56 bg-purple-400 rounded-full blur-[70px] opacity-10"></div>
        </div>
        <div class="relative z-10 px-8 py-7 flex flex-col md:flex-row items-start md:items-center justify-between gap-5">
            <div>
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/10 border border-white/20 text-violet-200 text-xs font-bold uppercase tracking-widest mb-3">
                    <i class="fas fa-users-cog"></i> Kontrol Akses
                </div>
                <h1 class="text-3xl md:text-4xl font-black text-white tracking-tight">Manajemen Pengguna</h1>
                <p class="text-violet-100/60 mt-1 text-sm">Kelola akun dan hak akses seluruh pengguna sistem.</p>
            </div>
            <div class="flex items-center gap-3">
                <div class="bg-white/10 border border-white/20 rounded-2xl px-5 py-3 text-center">
                    <p class="text-2xl font-black text-white">{{ $users->total() }}</p>
                    <p class="text-[10px] text-violet-200 font-bold uppercase tracking-widest mt-0.5">Total User</p>
                </div>
                <a href="{{ route('admin.users.create') }}"
                    class="inline-flex items-center gap-2 bg-white text-violet-700 hover:bg-violet-50 font-black px-5 py-3 rounded-2xl shadow-xl transition-all hover:-translate-y-0.5 active:scale-95">
                    <i class="fas fa-user-plus"></i> Tambah User
                </a>
            </div>
        </div>
    </div>

    {{-- ALERT --}}
    @if(session('success'))
    <div class="flex items-center gap-3 bg-emerald-50 border border-emerald-200 text-emerald-800 px-5 py-3.5 rounded-2xl shadow-sm">
        <div class="w-8 h-8 bg-emerald-500 rounded-xl flex items-center justify-center flex-shrink-0">
            <i class="fas fa-check text-white text-sm"></i>
        </div>
        <p class="font-bold text-sm">{{ session('success') }}</p>
    </div>
    @endif

    {{-- FILTER --}}
    <form method="GET" action="{{ route('admin.users.index') }}">
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-4 flex flex-col sm:flex-row gap-3">
            <div class="flex-1 relative">
                <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-sm"></i>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama atau email..."
                    class="w-full pl-11 pr-4 py-3 bg-slate-50 border-2 border-slate-100 rounded-xl text-sm font-medium text-slate-700 placeholder-slate-400 focus:border-violet-400 focus:outline-none focus:bg-white transition-all">
            </div>
            <div class="relative sm:w-52">
                <select name="role" class="w-full pl-4 pr-8 py-3 bg-slate-50 border-2 border-slate-100 rounded-xl text-sm font-bold text-slate-600 focus:border-violet-400 focus:outline-none appearance-none cursor-pointer transition-all">
                    <option value="">Semua Role</option>
                    <option value="super_admin"        {{ request('role') == 'super_admin' ? 'selected' : '' }}>👑 Super Admin</option>
                    <option value="admin_humas"        {{ request('role') == 'admin_humas' ? 'selected' : '' }}>📢 Admin Humas</option>
                    <option value="admin_registrasi"   {{ request('role') == 'admin_registrasi' ? 'selected' : '' }}>📝 Admin Registrasi</option>
                    <option value="admin_umum"         {{ request('role') == 'admin_umum' ? 'selected' : '' }}>⚙️ Admin Umum</option>
                    <option value="user"               {{ request('role') == 'user' ? 'selected' : '' }}>👤 User</option>
                </select>
                <i class="fas fa-chevron-down absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 text-xs pointer-events-none"></i>
            </div>
            <div class="flex gap-2">
                <button type="submit" class="px-5 py-3 bg-slate-900 hover:bg-violet-600 text-white font-black rounded-xl transition-all shadow-md active:scale-95 text-sm flex items-center gap-2">
                    <i class="fas fa-filter"></i> Filter
                </button>
                @if(request()->anyFilled(['search','role']))
                <a href="{{ route('admin.users.index') }}" class="px-4 py-3 bg-slate-100 hover:bg-slate-200 text-slate-600 font-bold rounded-xl transition-all text-sm flex items-center">
                    <i class="fas fa-times"></i>
                </a>
                @endif
            </div>
        </div>
    </form>

    {{-- USER CARDS --}}
    @php
        $roleConfig = [
            'super_admin'      => ['bar'=>'bg-red-500',    'bg'=>'bg-red-100',    'text'=>'text-red-700',    'icon'=>'fa-crown',          'label'=>'Super Admin'],
            'admin_humas'      => ['bar'=>'bg-blue-500',   'bg'=>'bg-blue-100',   'text'=>'text-blue-700',   'icon'=>'fa-bullhorn',        'label'=>'Admin Humas'],
            'admin_registrasi' => ['bar'=>'bg-purple-500', 'bg'=>'bg-purple-100', 'text'=>'text-purple-700', 'icon'=>'fa-clipboard-list',  'label'=>'Admin Registrasi'],
            'admin_umum'       => ['bar'=>'bg-emerald-500','bg'=>'bg-emerald-100','text'=>'text-emerald-700','icon'=>'fa-cog',             'label'=>'Admin Umum'],
            'user'             => ['bar'=>'bg-slate-400',  'bg'=>'bg-slate-100',  'text'=>'text-slate-700',  'icon'=>'fa-user',            'label'=>'User'],
        ];
        $avatarColors = ['violet','blue','indigo','rose','emerald','amber','cyan','teal'];
    @endphp

    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-4">
        @forelse($users as $user)
        @php
            $cfg = $roleConfig[$user->role] ?? $roleConfig['user'];
            $avatarColor = $avatarColors[abs(crc32($user->name)) % count($avatarColors)];
        @endphp
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden relative group flex flex-col hover:-translate-y-1 hover:shadow-lg transition-all duration-200">
            {{-- Role bar --}}
            <div class="absolute top-0 left-0 w-full h-1 {{ $cfg['bar'] }}"></div>

            <div class="p-5 flex-grow">
                <div class="flex items-start justify-between mb-4 mt-1">
                    {{-- Avatar --}}
                    <div class="w-14 h-14 rounded-2xl bg-{{ $avatarColor }}-100 text-{{ $avatarColor }}-700 flex items-center justify-center font-black text-xl shadow-sm group-hover:scale-105 transition-transform">
                        {{ strtoupper(substr($user->name, 0, 1)) }}
                    </div>
                    {{-- Actions --}}
                    <div class="flex gap-1.5">
                        <a href="{{ route('admin.users.edit', $user) }}"
                            class="w-8 h-8 rounded-lg bg-blue-50 hover:bg-blue-500 border border-blue-100 hover:border-blue-500 text-blue-600 hover:text-white flex items-center justify-center transition-all active:scale-95" title="Edit">
                            <i class="fas fa-pen text-xs"></i>
                        </a>
                        <button onclick="confirmDelete(event, '{{ $user->id }}', '{{ addslashes($user->name) }}')"
                            class="w-8 h-8 rounded-lg bg-red-50 hover:bg-red-500 border border-red-100 hover:border-red-500 text-red-600 hover:text-white flex items-center justify-center transition-all active:scale-95" title="Hapus">
                            <i class="fas fa-trash text-xs"></i>
                        </button>
                        <form id="delete-form-{{ $user->id }}" action="{{ route('admin.users.destroy', $user) }}" method="POST" class="hidden">
                            @csrf @method('DELETE')
                        </form>
                    </div>
                </div>

                <h3 class="font-black text-slate-800 text-base leading-tight mb-1 line-clamp-1" title="{{ $user->name }}">{{ $user->name }}</h3>
                <p class="text-xs text-slate-400 flex items-center gap-1.5 mb-3 line-clamp-1">
                    <i class="far fa-envelope text-slate-300"></i> {{ $user->email }}
                </p>

                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-[10px] font-black uppercase tracking-wider {{ $cfg['bg'] }} {{ $cfg['text'] }}">
                    <i class="fas {{ $cfg['icon'] }} text-[9px]"></i> {{ $cfg['label'] }}
                </span>
            </div>

            <div class="px-5 py-3 bg-slate-50 border-t border-slate-100 flex justify-between items-center text-xs font-medium text-slate-400">
                <span>Bergabung</span>
                <span class="font-bold text-slate-600">{{ $user->created_at->translatedFormat('d M Y') }}</span>
            </div>
        </div>
        @empty
        <div class="col-span-full text-center py-16">
            <div class="w-16 h-16 bg-slate-100 rounded-3xl flex items-center justify-center text-slate-300 text-3xl mx-auto mb-3">
                <i class="fas fa-users-slash"></i>
            </div>
            <h3 class="font-black text-slate-700 mb-1">Tidak Ada Pengguna</h3>
            <p class="text-slate-400 text-sm">Coba ubah filter atau tambahkan pengguna baru.</p>
        </div>
        @endforelse
    </div>

    @if($users->hasPages())
    <div class="pt-2">{{ $users->links() }}</div>
    @endif
</div>

<script>
    function confirmDelete(event, userId, userName) {
        event.preventDefault();
        Swal.fire({
            title: 'Hapus Pengguna?',
            html: `Hapus <b>${userName}</b>? Tindakan ini tidak dapat dibatalkan.`,
            icon: 'warning', showCancelButton: true,
            confirmButtonText: 'Ya, Hapus!', cancelButtonText: 'Batal',
            customClass: { popup:'rounded-3xl shadow-2xl', confirmButton:'px-5 py-2.5 bg-red-600 text-white font-bold rounded-xl mx-1', cancelButton:'px-5 py-2.5 bg-slate-100 text-slate-700 font-bold rounded-xl mx-1' },
            buttonsStyling: false
        }).then(r => { if(r.isConfirmed) document.getElementById(`delete-form-${userId}`).submit(); });
    }
</script>
@endsection