@extends('layouts.admin')

@section('title', 'Edit Profil')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
<style>
    .card-3d { transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275); transform-style: preserve-3d; backface-visibility: hidden; }
    .text-gradient { background-clip: text; -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-image: linear-gradient(to right, #1e293b, #2563eb); }
    .input-icon { position: absolute; top: 50%; left: 1rem; transform: translateY(-50%); color: #94a3b8; transition: color 0.2s; }
    .group:focus-within .input-icon { color: #3b82f6; }
</style>

<div class="max-w-4xl mx-auto pb-12 animate__animated animate__fadeIn">
    <header class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-8">
        <div>
            <h1 class="text-3xl font-extrabold text-gradient">Pengaturan Profil</h1>
            <p class="text-slate-500 mt-1 font-medium">Perbarui informasi akun dan keamanan Anda.</p>
        </div>
        <a href="{{ route('dashboard') }}" class="group inline-flex items-center gap-2 bg-white text-slate-600 font-bold py-2.5 px-5 rounded-xl shadow-sm border border-slate-200 hover:border-slate-300 transition-all active:scale-95">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </header>

    @if(session('success'))
    <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 p-4 rounded-xl mb-6 font-bold flex items-center gap-3">
        <i class="fas fa-check-circle"></i> {{ session('success') }}
    </div>
    @endif

    <div class="card-3d bg-white rounded-3xl shadow-xl border border-slate-100 overflow-hidden">
        <div class="bg-gradient-to-r from-slate-50 to-blue-50 p-8 border-b border-slate-100 flex items-center gap-4">
            <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center text-white shadow-lg overflow-hidden transform rotate-3">
                <div id="avatarPreview" class="w-full h-full flex items-center justify-center">
                    @if($user->avatar)
                        <img src="{{ $user->avatar }}" class="w-full h-full object-cover">
                    @else
                        <span class="text-2xl font-bold">{{ substr($user->name, 0, 1) }}</span>
                    @endif
                </div>
            </div>
            <div>
                <h2 class="text-xl font-bold text-slate-800">{{ $user->name }}</h2>
                <p class="text-slate-500 text-sm">Update profil Anda untuk keamanan akun.</p>
            </div>
        </div>

        <form action="{{ route('admin.profile.update') }}" method="POST" enctype="multipart/form-data" class="p-8 space-y-8">
            @csrf
            @method('PATCH')

            <div class="space-y-6">
                <div class="flex items-center gap-2 mb-4 border-b border-slate-100 pb-2">
                    <div class="p-2 bg-blue-100 rounded-lg text-blue-600"><i class="fas fa-camera"></i></div>
                    <h3 class="text-lg font-bold text-slate-700">Foto Profil</h3>
                </div>
                <label class="inline-block bg-slate-100 text-slate-700 font-bold px-6 py-3 rounded-xl cursor-pointer hover:bg-slate-200 transition-all">
                    Pilih Foto Baru
                    <input type="file" name="avatar" class="hidden" accept="image/*" onchange="previewAvatar(this)">
                </label>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-2">
                    <label class="text-xs font-bold text-slate-500 uppercase tracking-wider ml-1">Nama Lengkap</label>
                    <div class="relative group">
                        <i class="fas fa-user input-icon"></i>
                        <input type="text" name="name" value="{{ old('name', $user->name) }}" class="w-full pl-12 pr-4 py-3.5 bg-slate-50 border-2 border-slate-100 rounded-xl font-medium text-slate-700 focus:border-blue-500 focus:bg-white transition-all" required>
                    </div>
                </div>
                <div class="space-y-2">
                    <label class="text-xs font-bold text-slate-500 uppercase tracking-wider ml-1">Email</label>
                    <div class="relative group">
                        <i class="fas fa-envelope input-icon"></i>
                        <input type="email" name="email" value="{{ old('email', $user->email) }}" class="w-full pl-12 pr-4 py-3.5 bg-slate-50 border-2 border-slate-100 rounded-xl font-medium text-slate-700 focus:border-blue-500 focus:bg-white transition-all" required>
                    </div>
                </div>
            </div>

            <div class="space-y-6">
                <div class="flex items-center gap-2 mb-4 border-b border-slate-100 pb-2">
                    <div class="p-2 bg-amber-100 rounded-lg text-amber-600"><i class="fas fa-lock"></i></div>
                    <h3 class="text-lg font-bold text-slate-700">Keamanan</h3>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-2">
                        <label class="text-xs font-bold text-slate-500 uppercase tracking-wider ml-1">Password Baru</label>
                        <div class="relative group">
                            <i class="fas fa-key input-icon"></i>
                            <input type="password" name="password" id="password" class="w-full pl-12 pr-12 py-3.5 bg-slate-50 border-2 border-slate-100 rounded-xl font-medium text-slate-700 focus:border-blue-500 focus:bg-white transition-all" placeholder="••••••••">
                            <button type="button" onclick="togglePassword('password')" class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 hover:text-blue-500"><i class="fas fa-eye" id="togglePasswordIcon"></i></button>
                        </div>
                    </div>
                    <div class="space-y-2">
                        <label class="text-xs font-bold text-slate-500 uppercase tracking-wider ml-1">Konfirmasi Password</label>
                        <div class="relative group">
                            <i class="fas fa-check-double input-icon"></i>
                            <input type="password" name="password_confirmation" id="password_confirmation" class="w-full pl-12 pr-12 py-3.5 bg-slate-50 border-2 border-slate-100 rounded-xl font-medium text-slate-700 focus:border-blue-500 focus:bg-white transition-all" placeholder="••••••••">
                            <button type="button" onclick="togglePassword('password_confirmation')" class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 hover:text-blue-500"><i class="fas fa-eye" id="togglePasswordConfirmationIcon"></i></button>
                        </div>
                    </div>
                </div>
            </div>

            <button type="submit" class="w-full py-4 bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-black rounded-2xl hover:from-blue-700 hover:to-indigo-700 shadow-lg shadow-blue-500/30 transition-all hover:-translate-y-1 active:scale-95">Simpan Profil</button>
        </form>
    </div>
</div>

<script>
    function togglePassword(id) {
        const input = document.getElementById(id);
        const icon = document.getElementById(id === 'password' ? 'togglePasswordIcon' : 'togglePasswordConfirmationIcon');
        if (input.type === "password") {
            input.type = "text";
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
        } else {
            input.type = "password";
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
        }
    }
    function previewAvatar(input) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('avatarPreview').innerHTML = `<img src="${e.target.result}" class="w-full h-full object-cover">`;
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endsection
