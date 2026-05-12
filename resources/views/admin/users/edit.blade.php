@extends('layouts.admin')

@section('content')
{{-- Load Animate.css --}}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>

<style>
    /* 3D Card Effect */
    .card-3d {
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        transform-style: preserve-3d;
        backface-visibility: hidden;
    }
    
    /* Modern Gradient Text */
    .text-gradient {
        background-clip: text;
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-image: linear-gradient(to right, #1e293b, #2563eb);
    }

    /* Glassmorphism */
    .glass-panel {
        background: rgba(255, 255, 255, 0.9);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.5);
        box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.05);
    }

    /* Radio Card Active State */
    input[type="radio"]:checked + div {
        border-color: #3b82f6;
        background-color: #eff6ff;
        transform: translateY(-2px);
        box-shadow: 0 4px 6px -1px rgba(59, 130, 246, 0.1);
    }
</style>

<div class="max-w-4xl mx-auto pb-12 space-y-8 perspective-1000">

    {{-- HEADER --}}
    <header class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 animate__animated animate__fadeInDown">
        <div>
            <h1 class="text-3xl font-extrabold text-gradient">Edit Pengguna</h1>
            <p class="text-slate-500 mt-1 font-medium">Perbarui informasi profil dan hak akses pengguna.</p>
        </div>
        <a href="{{ route('admin.users.index') }}" class="group inline-flex items-center gap-2 bg-white text-slate-600 font-bold py-2.5 px-5 rounded-xl shadow-sm border border-slate-200 hover:border-slate-300 hover:bg-slate-50 transition-all active:scale-95">
            <i class="fas fa-arrow-left text-slate-400 group-hover:text-slate-600 transition-colors"></i>
            <span>Kembali</span>
        </a>
    </header>

    {{-- FORM EDIT --}}
    <div class="card-3d bg-white rounded-3xl shadow-xl border border-slate-100 overflow-hidden animate__animated animate__fadeInUp delay-100">
        
        {{-- Form Header --}}
        <div class="bg-gradient-to-r from-slate-50 to-blue-50 p-8 border-b border-slate-100 flex items-center gap-4">
            <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center text-white shadow-lg transform rotate-3">
                <span class="text-2xl font-bold">{{ substr($user->name, 0, 1) }}</span>
            </div>
            <div>
                <h2 class="text-xl font-bold text-slate-800">Profil: {{ $user->name }}</h2>
                <p class="text-slate-500 text-sm">Terakhir diperbarui: {{ $user->updated_at->diffForHumans() }}</p>
            </div>
        </div>

        <form action="{{ route('admin.users.update', $user->id) }}" method="POST" id="editUserForm" class="p-8 space-y-8">
            @csrf
            @method('PATCH')

            {{-- 1. Informasi Dasar --}}
            <div class="space-y-6">
                <div class="flex items-center gap-2 mb-4 border-b border-slate-100 pb-2">
                    <div class="p-2 bg-blue-100 rounded-lg text-blue-600"><i class="fas fa-id-card"></i></div>
                    <h3 class="text-lg font-bold text-slate-700">Informasi Dasar</h3>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-2">
                        <label for="name" class="text-xs font-bold text-slate-500 uppercase tracking-wider ml-1">Nama Lengkap</label>
                        <div class="relative group">
                            <i class="fas fa-user absolute left-4 top-4 text-slate-400 group-focus-within:text-blue-500 transition-colors"></i>
                            <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" 
                                class="w-full pl-12 pr-4 py-3.5 bg-slate-50 border-2 border-slate-100 rounded-xl focus:bg-white focus:border-blue-500 focus:ring-0 transition-all font-medium text-slate-700" 
                                required>
                        </div>
                        @error('name') <p class="text-red-500 text-xs font-bold ml-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="space-y-2">
                        <label for="email" class="text-xs font-bold text-slate-500 uppercase tracking-wider ml-1">Alamat Email</label>
                        <div class="relative group">
                            <i class="fas fa-envelope absolute left-4 top-4 text-slate-400 group-focus-within:text-blue-500 transition-colors"></i>
                            <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" 
                                class="w-full pl-12 pr-4 py-3.5 bg-slate-50 border-2 border-slate-100 rounded-xl focus:bg-white focus:border-blue-500 focus:ring-0 transition-all font-medium text-slate-700" 
                                required>
                        </div>
                        @error('email') <p class="text-red-500 text-xs font-bold ml-1">{{ $message }}</p> @enderror
                    </div>
                </div>
            </div>

            {{-- 2. Hak Akses (Role) --}}
            <div class="space-y-6">
                <div class="flex items-center gap-2 mb-4 border-b border-slate-100 pb-2">
                    <div class="p-2 bg-purple-100 rounded-lg text-purple-600"><i class="fas fa-user-shield"></i></div>
                    <h3 class="text-lg font-bold text-slate-700">Hak Akses (Role)</h3>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @php
                        $roles = [
                            'super_admin' => ['label' => 'Super Admin', 'icon' => 'fa-crown', 'color' => 'text-red-500', 'desc' => 'Akses penuh ke seluruh sistem.'],
                            'admin_humas' => ['label' => 'Admin Humas', 'icon' => 'fa-bullhorn', 'color' => 'text-blue-500', 'desc' => 'Mengelola berita & pengumuman.'],
                            'admin_registrasi' => ['label' => 'Admin Registrasi', 'icon' => 'fa-clipboard-list', 'color' => 'text-purple-500', 'desc' => 'Verifikasi pendaftaran kunjungan.'],
                        ];
                    @endphp

                    @foreach($roles as $roleValue => $data)
                    <label class="cursor-pointer relative group">
                        <input type="radio" name="role" value="{{ $roleValue }}" class="peer sr-only" {{ old('role', $user->role) == $roleValue ? 'checked' : '' }}>
                        <div class="p-4 rounded-2xl border-2 border-slate-100 bg-white hover:border-blue-200 transition-all duration-300 h-full">
                            <div class="flex items-center gap-3 mb-2">
                                <div class="w-8 h-8 rounded-lg bg-slate-50 flex items-center justify-center {{ $data['color'] }}">
                                    <i class="fas {{ $data['icon'] }}"></i>
                                </div>
                                <span class="font-bold text-slate-700 text-sm">{{ $data['label'] }}</span>
                            </div>
                            <p class="text-xs text-slate-400 pl-11">{{ $data['desc'] }}</p>
                            
                            {{-- Checkmark Icon (Hidden by default, shown when checked) --}}
                            <div class="absolute top-4 right-4 text-blue-500 opacity-0 peer-checked:opacity-100 transition-opacity">
                                <i class="fas fa-check-circle"></i>
                            </div>
                        </div>
                    </label>
                    @endforeach
                </div>
                @error('role') <p class="text-red-500 text-xs font-bold ml-1">{{ $message }}</p> @enderror
            </div>

            {{-- 3. Keamanan (Password) --}}
            <div class="space-y-6">
                <div class="flex items-center gap-2 mb-4 border-b border-slate-100 pb-2">
                    <div class="p-2 bg-amber-100 rounded-lg text-amber-600"><i class="fas fa-lock"></i></div>
                    <h3 class="text-lg font-bold text-slate-700">Keamanan</h3>
                </div>

                <div class="bg-amber-50/50 border border-amber-100 rounded-xl p-4 flex items-start gap-3 mb-6">
                    <i class="fas fa-info-circle text-amber-500 mt-0.5"></i>
                    <p class="text-sm text-amber-800">
                        Kosongkan bagian ini jika Anda tidak ingin mengubah kata sandi pengguna.
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-2">
                        <label for="password" class="text-xs font-bold text-slate-500 uppercase tracking-wider ml-1">Password Baru</label>
                        <div class="relative group">
                            <i class="fas fa-key absolute left-4 top-4 text-slate-400 group-focus-within:text-blue-500 transition-colors"></i>
                            <input type="password" name="password" id="password" 
                                class="w-full pl-12 pr-4 py-3.5 bg-slate-50 border-2 border-slate-100 rounded-xl focus:bg-white focus:border-blue-500 focus:ring-0 transition-all font-medium text-slate-700" 
                                placeholder="••••••••">
                        </div>
                        @error('password') <p class="text-red-500 text-xs font-bold ml-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="space-y-2">
                        <label for="password_confirmation" class="text-xs font-bold text-slate-500 uppercase tracking-wider ml-1">Konfirmasi Password</label>
                        <div class="relative group">
                            <i class="fas fa-check-double absolute left-4 top-4 text-slate-400 group-focus-within:text-blue-500 transition-colors"></i>
                            <input type="password" name="password_confirmation" id="password_confirmation" 
                                class="w-full pl-12 pr-4 py-3.5 bg-slate-50 border-2 border-slate-100 rounded-xl focus:bg-white focus:border-blue-500 focus:ring-0 transition-all font-medium text-slate-700" 
                                placeholder="••••••••">
                        </div>
                    </div>
                </div>
            </div>

            {{-- Action Buttons --}}
            <div class="pt-8 border-t border-slate-100 flex justify-end gap-4">
                <a href="{{ route('admin.users.index') }}" class="px-6 py-3.5 bg-slate-100 hover:bg-slate-200 text-slate-600 font-bold rounded-xl transition-all active:scale-95">
                    Batal
                </a>
                <button type="submit" onclick="confirmEdit(event)" class="px-8 py-3.5 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-bold rounded-xl shadow-lg shadow-blue-500/30 transition-all transform hover:-translate-y-1 active:scale-95 flex items-center gap-2">
                    <i class="fas fa-save"></i> Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>

{{-- SCRIPT --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    // Konfigurasi Animasi SweetAlert
    const swal3DConfig = {
        showClass: { popup: 'animate__animated animate__zoomInDown animate__faster' },
        hideClass: { popup: 'animate__animated animate__zoomOutUp animate__faster' },
        customClass: {
            popup: 'rounded-3xl shadow-2xl border-4 border-white/50 backdrop-blur-xl',
            title: 'text-2xl font-black text-slate-800',
            confirmButton: 'rounded-xl px-6 py-3 font-bold shadow-lg bg-blue-600 text-white mr-2',
            cancelButton: 'rounded-xl px-6 py-3 font-bold shadow-lg bg-slate-200 text-slate-600'
        },
        buttonsStyling: false
    };

    function confirmEdit(event) {
        event.preventDefault();
        const form = document.getElementById('editUserForm');
        
        Swal.fire({
            ...swal3DConfig,
            title: 'Simpan Perubahan?',
            text: "Pastikan data yang Anda masukkan sudah benar.",
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Ya, Simpan',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                // Tampilkan loading state
                Swal.fire({
                    title: 'Menyimpan...',
                    text: 'Mohon tunggu sebentar.',
                    allowOutsideClick: false,
                    showConfirmButton: false,
                    willOpen: () => {
                        Swal.showLoading();
                    }
                });
                form.submit();
            }
        });
    }
</script>
@endsection