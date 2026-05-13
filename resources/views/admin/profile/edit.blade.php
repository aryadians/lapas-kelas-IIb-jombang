@extends('layouts.admin')

@section('content')
<div class="max-w-3xl mx-auto pb-12 animate__animated animate__fadeIn">
    <header class="mb-8">
        <h1 class="text-3xl font-extrabold text-slate-800">Edit Profil Anda</h1>
        <p class="text-slate-500 mt-1 font-medium">Perbarui informasi profil dan kata sandi Anda.</p>
    </header>

    @if(session('success'))
    <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 p-4 rounded-xl mb-6 font-bold flex items-center gap-3">
        <i class="fas fa-check-circle"></i> {{ session('success') }}
    </div>
    @endif

    <div class="bg-white rounded-3xl shadow-lg border border-slate-100 p-8">
        <form action="{{ route('admin.profile.update') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
            @csrf
            @method('PATCH')

            <div class="flex items-center gap-6">
                <div id="avatarPreview" class="w-24 h-24 rounded-2xl bg-slate-100 border-4 border-white shadow-lg overflow-hidden flex items-center justify-center text-slate-400">
                    @if($user->avatar)
                        <img src="{{ $user->avatar }}" class="w-full h-full object-cover">
                    @else
                        <i class="fas fa-user text-3xl"></i>
                    @endif
                </div>
                <label class="bg-slate-100 text-slate-700 font-bold px-5 py-3 rounded-xl cursor-pointer hover:bg-slate-200 transition-all">
                    Ganti Foto
                    <input type="file" name="avatar" class="hidden" accept="image/*" onchange="previewAvatar(this)">
                </label>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-2">
                    <label class="text-xs font-bold text-slate-500 uppercase tracking-wider">Nama</label>
                    <input type="text" name="name" value="{{ old('name', $user->name) }}" class="w-full p-3 bg-slate-50 border-2 border-slate-100 rounded-xl font-bold text-slate-700" required>
                </div>
                <div class="space-y-2">
                    <label class="text-xs font-bold text-slate-500 uppercase tracking-wider">Email</label>
                    <input type="email" name="email" value="{{ old('email', $user->email) }}" class="w-full p-3 bg-slate-50 border-2 border-slate-100 rounded-xl font-bold text-slate-700" required>
                </div>
            </div>

            <div class="space-y-2">
                <label class="text-xs font-bold text-slate-500 uppercase tracking-wider">Password Baru</label>
                <div class="relative">
                    <input type="password" name="password" id="password" class="w-full p-3 pr-12 bg-slate-50 border-2 border-slate-100 rounded-xl font-bold text-slate-700" placeholder="Kosongkan jika tidak ingin mengubah">
                    <button type="button" onclick="togglePassword('password')" class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-400"><i class="fas fa-eye" id="togglePasswordIcon"></i></button>
                </div>
            </div>

            <div class="space-y-2">
                <label class="text-xs font-bold text-slate-500 uppercase tracking-wider">Konfirmasi Password Baru</label>
                <div class="relative">
                    <input type="password" name="password_confirmation" id="password_confirmation" class="w-full p-3 pr-12 bg-slate-50 border-2 border-slate-100 rounded-xl font-bold text-slate-700">
                    <button type="button" onclick="togglePassword('password_confirmation')" class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-400"><i class="fas fa-eye" id="togglePasswordConfirmationIcon"></i></button>
                </div>
            </div>

            <button type="submit" class="w-full py-4 bg-blue-600 text-white font-black rounded-xl hover:bg-blue-700 transition-all">Simpan Profil</button>
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
