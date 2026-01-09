<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin Panel - Lapas Kelas IIB Jombang</title>
    <link rel="icon" href="{{ asset('img/logo.png') }}" type="image/png">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
    
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <link rel="stylesheet" type="text/css" href="https://unpkg.com/trix@2.0.8/dist/trix.css">

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script type="text/javascript" src="https://unpkg.com/trix@2.0.8/dist/trix.umd.min.js"></script>
    <script src="//unpkg.com/alpinejs" defer></script>

    <style>
        body { font-family: 'Inter', sans-serif; }
        /* Print Styles */
        @media print {
            .no-print { display: none !important; }
            .print-break { page-break-before: always; }
            body { font-size: 12px; }
            .print-header { display: block !important; }
            .sidebar, .navbar, .footer { display: none !important; }
            .main-content { margin: 0; padding: 0; }
        }
        
        /* Custom Scrollbar for Sidebar */
        .sidebar-scroll::-webkit-scrollbar { width: 6px; }
        .sidebar-scroll::-webkit-scrollbar-track { background: #0f172a; }
        .sidebar-scroll::-webkit-scrollbar-thumb { background: #334155; border-radius: 3px; }
    </style>
</head>
<body class="bg-gray-100" x-data="{ sidebarOpen: false }">

    <div class="flex h-screen overflow-hidden">
        
        <div x-show="sidebarOpen" @click="sidebarOpen = false" class="fixed inset-0 z-40 bg-black bg-opacity-50 md:hidden" 
             x-transition:enter="transition-opacity ease-linear duration-300" x-transition:enter-start="opacity-0" 
             x-transition:enter-end="opacity-100" x-transition:leave="transition-opacity ease-linear duration-300" 
             x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"></div>
        
        <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'" 
               class="sidebar fixed inset-y-0 left-0 z-50 w-72 bg-slate-900 text-white flex flex-col shadow-2xl transition-transform duration-300 md:translate-x-0 md:static md:inset-0 border-r border-slate-800">
            
            <div class="h-24 flex items-center px-6 bg-slate-950 border-b border-slate-800 flex-shrink-0">
                <img src="{{ asset('img/logo.png') }}" alt="Logo" class="h-12 w-auto mr-3" onerror="this.style.display='none'">
                <div>
                    <h1 class="font-bold text-lg tracking-wide leading-tight">ADMIN PANEL</h1>
                    <p class="text-[10px] text-yellow-500 uppercase font-bold tracking-wider mt-1">Lapas Kelas IIB Jombang</p>
                </div>
            </div>

            <nav class="flex-1 px-4 py-6 space-y-2 overflow-y-auto sidebar-scroll">
                @php $userRole = Auth::user()->role ?? 'user'; @endphp

                <p class="px-4 text-xs font-bold text-slate-500 uppercase tracking-wider mb-3">Menu Utama</p>
                
                <a href="{{ route('dashboard') }}" 
                   class="flex items-center px-4 py-3 {{ request()->routeIs('dashboard') ? 'bg-blue-600 text-white shadow-lg shadow-blue-900/50' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }} rounded-xl transition-all duration-200 group">
                    <svg class="w-5 h-5 mr-3 {{ request()->routeIs('dashboard') ? 'text-white' : 'text-slate-500 group-hover:text-white' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                    <span class="font-medium">Dashboard</span>
                </a>

                @if(in_array($userRole, ['super_admin', 'admin_humas']))
                <a href="{{ route('news.index') }}" 
                   class="flex items-center px-4 py-3 {{ request()->routeIs('news.*') ? 'bg-blue-600 text-white shadow-lg shadow-blue-900/50' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }} rounded-xl transition-all duration-200 group">
                    <svg class="w-5 h-5 mr-3 {{ request()->routeIs('news.*') ? 'text-white' : 'text-slate-500 group-hover:text-white' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path></svg>
                    <span class="font-medium">Kelola Berita</span>
                </a>
                @endif

                @if(in_array($userRole, ['super_admin', 'admin_humas']))
                <a href="{{ route('announcements.index') }}" 
                   class="flex items-center px-4 py-3 {{ request()->routeIs('announcements.*') ? 'bg-blue-600 text-white shadow-lg shadow-blue-900/50' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }} rounded-xl transition-all duration-200 group">
                    <svg class="w-5 h-5 mr-3 {{ request()->routeIs('announcements.*') ? 'text-white' : 'text-slate-500 group-hover:text-white' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"></path></svg>
                    <span class="font-medium">Kelola Pengumuman</span>
                </a>
                @endif

                @if(in_array($userRole, ['super_admin', 'admin_registrasi']))
                <a href="{{ route('admin.kunjungan.index') }}" 
                   class="flex items-center px-4 py-3 {{ request()->routeIs('admin.kunjungan.*') ? 'bg-blue-600 text-white shadow-lg shadow-blue-900/50' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }} rounded-xl transition-all duration-200 group">
                    <svg class="w-5 h-5 mr-3 {{ request()->routeIs('admin.kunjungan.*') ? 'text-white' : 'text-slate-500 group-hover:text-white' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    <span class="font-medium">Kelola Kunjungan</span>
                </a>
                @endif

                @if(in_array($userRole, ['super_admin', 'admin_umum', 'admin']))
                <a href="{{ route('admin.users.index') }}" 
                   class="flex items-center px-4 py-3 {{ request()->routeIs('admin.users.*') ? 'bg-blue-600 text-white shadow-lg shadow-blue-900/50' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }} rounded-xl transition-all duration-200 group">
                    <svg class="w-5 h-5 mr-3 {{ request()->routeIs('admin.users.*') ? 'text-white' : 'text-slate-500 group-hover:text-white' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17.982 18.725A7.488 7.488 0 0012 15.75a7.488 7.488 0 00-5.982 2.975m11.963 0a9 9 0 10-11.963 0m11.963 0A8.966 8.966 0 0112 21a8.966 8.966 0 01-5.982-2.275M15 9.75a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                    <span class="font-medium">Manajemen Pengguna</span>
                </a>
                @endif

                @if(in_array($userRole, ['super_admin', 'admin_umum', 'admin', 'admin_registrasi']))
                <a href="{{ route('admin.wbp.index') }}" 
                   class="flex items-center px-4 py-3 {{ request()->routeIs('admin.wbp.*') ? 'bg-blue-600 text-white shadow-lg shadow-blue-900/50' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }} rounded-xl transition-all duration-200 group">
                    <svg class="w-5 h-5 mr-3 {{ request()->routeIs('admin.wbp.*') ? 'text-white' : 'text-slate-500 group-hover:text-white' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                    <span class="font-medium">Data Warga Binaan</span>
                </a>
                @endif

            </nav>

            <div class="p-6 border-t border-slate-800 bg-slate-900">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" onclick="confirmLogout(event)" class="flex items-center justify-center w-full px-4 py-3 text-sm font-bold text-white bg-gradient-to-r from-red-600 to-red-700 hover:from-red-500 hover:to-red-600 rounded-lg transition-all duration-200 shadow-md hover:shadow-red-900/30 transform hover:-translate-y-0.5">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                        KELUAR SISTEM
                    </button>
                </form>
            </div>
        </aside>

        <div class="flex-1 flex flex-col overflow-hidden">
            
            <header class="navbar flex justify-between items-center py-4 px-8 bg-white shadow-sm border-b border-gray-200 z-30">
                <div class="flex items-center">
                    <button @click="sidebarOpen = !sidebarOpen" class="md:hidden mr-4 p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-blue-500">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>
                    <h2 class="text-xl md:text-2xl font-bold text-slate-800 tracking-tight">Sistem Informasi Lapas</h2>
                </div>
                
                <div class="flex items-center space-x-4">
                    <div class="text-right hidden sm:block">
                        <p class="text-sm font-bold text-slate-900">{{ Auth::user()->name ?? 'Administrator' }}</p>
                        @php
                            $roleConfig = [
                                'super_admin' => 'Super Admin',
                                'admin_humas' => 'Admin Humas',
                                'admin_registrasi' => 'Admin Registrasi',
                                'admin_umum' => 'Admin Umum',
                                'admin' => 'Admin',
                                'user' => 'User',
                            ];
                            $userRole = Auth::user()->role ?? 'user';
                            $roleLabel = $roleConfig[$userRole] ?? ucfirst(str_replace('_', ' ', $userRole));
                        @endphp
                        <p class="text-[10px] text-slate-500 font-bold uppercase tracking-wide">{{ $roleLabel }}</p>
                    </div>
                    <div class="h-10 w-10 rounded-full bg-slate-900 text-white flex items-center justify-center font-bold text-lg border-2 border-yellow-500 shadow-md">
                        {{ substr(Auth::user()->name ?? 'A', 0, 1) }}
                    </div>
                </div>
            </header>

            <main class="main-content flex-1 overflow-x-hidden overflow-y-auto bg-gray-50 p-6 md:p-8">
                @yield('content')
            </main>
        </div>
    </div>

    <script>
    // =================================================================================
    // SWEETALERT2 THEME CONFIG
    // =================================================================================
    const swalTheme = {
        customClass: {
            popup: 'bg-white rounded-2xl shadow-2xl border border-slate-200 transform transition-all duration-300',
            title: 'text-slate-800 text-2xl font-bold pt-6',
            htmlContainer: 'text-slate-500 text-base px-6 pb-4',
            confirmButton: 'px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg transition-all duration-300 mx-2 shadow-lg hover:shadow-blue-500/50 transform hover:-translate-y-0.5',
            cancelButton: 'px-6 py-3 bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold rounded-lg transition-all duration-300 mx-2 transform hover:-translate-y-0.5',
            icon: 'mt-6 scale-110'
        },
        buttonsStyling: false,
        backdrop: 'rgba(15, 23, 42, 0.7)',
        showClass: {
            popup: 'animate__animated animate__fadeInUp animate__faster'
        },
        hideClass: {
            popup: 'animate__animated animate__fadeOutDown animate__faster'
        }
    };

    // =================================================================================
    // LOGOUT CONFIRMATION (NEW FEATURE)
    // =================================================================================
    function confirmLogout(event) {
        event.preventDefault();
        const form = event.target.closest('form');
        
        Swal.fire({
            ...swalTheme,
            title: 'Keluar Sistem?',
            text: "Sesi Anda saat ini akan diakhiri.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, Keluar',
            cancelButtonText: 'Batal',
            reverseButtons: true, // Tombol confirm di sebelah kanan (opsional, tergantung preferensi)
            customClass: { 
                ...swalTheme.customClass,
                // Override warna tombol confirm jadi MERAH (Danger)
                confirmButton: 'px-6 py-2.5 bg-red-600 hover:bg-red-700 text-white font-bold rounded-lg transition-all duration-200 mx-1.5 shadow-lg shadow-red-500/30 focus:outline-none focus:ring-4 focus:ring-red-300'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                // Tampilkan loading state sebelum submit
                Swal.fire({
                    title: 'Sedang Keluar...',
                    html: 'Mohon tunggu sebentar',
                    timerProgressBar: true,
                    didOpen: () => {
                        Swal.showLoading();
                    },
                    allowOutsideClick: false,
                    ...swalTheme
                });
                
                setTimeout(() => {
                    form.submit();
                }, 500); // Delay sedikit untuk estetika
            }
        });
    }

    // Helper functions for alerts (Delete, Update, Bulk Actions)
    function confirmDelete(event) {
        event.preventDefault();
        const form = event.target.closest('form');
        Swal.fire({
            ...swalTheme,
            title: 'Hapus Data?',
            text: "Data yang dihapus tidak dapat dikembalikan!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal',
            customClass: { 
                ...swalTheme.customClass,
                confirmButton: 'px-5 py-2.5 bg-red-600 hover:bg-red-700 text-white font-semibold rounded-lg transition-all duration-200 mx-1.5 focus:outline-none focus:ring-4 focus:ring-red-300',
            }
        }).then((result) => {
            if (result.isConfirmed) form.submit();
        });
    }

    function confirmUpdate(event, status, itemName = '') {
        event.preventDefault();
        const form = event.target.closest('form');
        const isApproved = status === 'approved';
        
        Swal.fire({
            ...swalTheme,
            title: isApproved ? 'Setujui Kunjungan?' : 'Tolak Kunjungan?',
            html: `Anda akan <b>${isApproved ? 'menyetujui' : 'menolak'}</b> kunjungan untuk "<span class="font-semibold">${itemName}</span>".`,
            icon: isApproved ? 'question' : 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, Lanjutkan',
            cancelButtonText: 'Batal',
            customClass: {
                ...swalTheme.customClass,
                confirmButton: isApproved 
                    ? 'px-5 py-2.5 bg-green-600 hover:bg-green-700 text-white font-semibold rounded-lg transition-all duration-200 mx-1.5 focus:outline-none focus:ring-4 focus:ring-green-300' 
                    : 'px-5 py-2.5 bg-yellow-500 hover:bg-yellow-600 text-white font-semibold rounded-lg transition-all duration-200 mx-1.5 focus:outline-none focus:ring-4 focus:ring-yellow-300',
            }
        }).then((result) => {
            if (result.isConfirmed) form.submit();
        });
    }
    
    function confirmBulkAction(event, action, status = null) {
        event.preventDefault();
        const button = event.target.closest('button');
        const form = document.getElementById('bulk-action-form');
        if (!form) return;

        const selectedIds = Array.from(form.querySelectorAll('input[name="ids[]"]:checked')).map(cb => cb.value);

        if (selectedIds.length === 0) {
            Swal.fire({ ...swalTheme, title: 'Tidak Ada Data', text: 'Pilih data terlebih dahulu.', icon: 'info' });
            return;
        }

        let config = {};
        if (action === 'delete') {
            config = {
                title: `Hapus ${selectedIds.length} Item?`,
                text: 'Aksi ini bersifat permanen.',
                icon: 'warning',
                confirmButtonText: 'Ya, Hapus Semua!',
                confirmButtonClass: 'px-5 py-2.5 bg-red-600 hover:bg-red-700 text-white font-semibold rounded-lg transition-all duration-200 mx-1.5 focus:outline-none focus:ring-4 focus:ring-red-300'
            };
        } else if (action === 'update') {
            const isApproved = status === 'approved';
            config = {
                title: `Update ${selectedIds.length} Data?`,
                text: `Status akan diubah menjadi "${status}".`,
                icon: 'info',
                confirmButtonText: 'Ya, Update!',
                confirmButtonClass: isApproved 
                    ? 'px-5 py-2.5 bg-green-600 hover:bg-green-700 text-white font-semibold rounded-lg transition-all duration-200 mx-1.5 focus:outline-none focus:ring-4 focus:ring-green-300'
                    : 'px-5 py-2.5 bg-yellow-500 hover:bg-yellow-600 text-white font-semibold rounded-lg transition-all duration-200 mx-1.5 focus:outline-none focus:ring-4 focus:ring-yellow-300'
            };
        }

        Swal.fire({
            ...swalTheme,
            title: config.title,
            text: config.text,
            icon: config.icon,
            showCancelButton: true,
            confirmButtonText: config.confirmButtonText,
            cancelButtonText: 'Batal',
            customClass: { ...swalTheme.customClass, confirmButton: config.confirmButtonClass }
        }).then((result) => {
            if (result.isConfirmed) {
                form.action = button.getAttribute('formaction');
                form.querySelectorAll('input[name="_method"], input[name="status"]').forEach(el => el.remove());

                if (action === 'update') {
                    const statusInput = document.createElement('input');
                    statusInput.type = 'hidden';
                    statusInput.name = 'status';
                    statusInput.value = status;
                    form.appendChild(statusInput);
                }
                form.submit();
            }
        });
    }
    </script>
    @stack('scripts')
</body>
</html>