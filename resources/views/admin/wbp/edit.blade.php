@extends('layouts.admin')

@section('content')
<div class="space-y-8 animated-form">

    <div class="form-group">
        <a href="{{ route('admin.wbp.index') }}" class="inline-flex items-center gap-2 text-sm text-slate-500 hover:text-indigo-600 mb-2">
            <i class="fa-solid fa-chevron-left"></i>
            <span>Kembali ke Daftar</span>
        </a>
        <h1 class="text-3xl font-bold text-slate-800">📝 Edit Data Warga Binaan</h1>
        <p class="text-slate-500 text-sm mt-1">Perbarui informasi untuk WBP: <span class="font-bold">{{ $wbp->nama }}</span>.</p>
    </div>

    <div class="bg-white rounded-2xl shadow-2xl border border-slate-200 form-group">
        <form action="{{ route('admin.wbp.update', $wbp->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="p-8">
                <div class="space-y-8">
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="relative form-group">
                            <label for="nama" class="block text-sm font-medium text-slate-700 mb-2">Nama Lengkap <span class="text-red-500">*</span></label>
                            <div class="relative">
                                <i class="fa-solid fa-user absolute left-3.5 top-1/2 -translate-y-1/2 transform text-slate-400"></i>
                                <input type="text" id="nama" name="nama" class="form-input" value="{{ old('nama', $wbp->nama) }}" required placeholder="Contoh: John Doe">
                            </div>
                            @error('nama') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div class="relative form-group">
                            <label for="no_registrasi" class="block text-sm font-medium text-slate-700 mb-2">No. Registrasi <span class="text-red-500">*</span></label>
                            <div class="relative">
                                <i class="fa-solid fa-id-card absolute left-3.5 top-1/2 -translate-y-1/2 transform text-slate-400"></i>
                                <input type="text" id="no_registrasi" name="no_registrasi" class="form-input" value="{{ old('no_registrasi', $wbp->no_registrasi) }}" required placeholder="Contoh: WBP-JMB-2024-001">
                            </div>
                            @error('no_registrasi') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div class="relative form-group">
                        <label for="nama_panggilan" class="block text-sm font-medium text-slate-700 mb-2">Nama Panggilan (Alias)</label>
                        <div class="relative">
                            <i class="fa-solid fa-signature absolute left-3.5 top-1/2 -translate-y-1/2 transform text-slate-400"></i>
                            <input type="text" id="nama_panggilan" name="nama_panggilan" class="form-input" value="{{ old('nama_panggilan', $wbp->nama_panggilan) }}" placeholder="Contoh: Johnny">
                        </div>
                        @error('nama_panggilan') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="relative form-group">
                            <label for="tanggal_masuk" class="block text-sm font-medium text-slate-700 mb-2">Tanggal Masuk</label>
                            <div class="relative">
                                <i class="fa-solid fa-calendar-day absolute left-3.5 top-1/2 -translate-y-1/2 transform text-slate-400"></i>
                                <input type="date" id="tanggal_masuk" name="tanggal_masuk" class="form-input" value="{{ old('tanggal_masuk', $wbp->tanggal_masuk ? \Carbon\Carbon::parse($wbp->tanggal_masuk)->format('Y-m-d') : '') }}">
                            </div>
                            @error('tanggal_masuk') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div class="relative form-group">
                            <label for="tanggal_ekspirasi" class="block text-sm font-medium text-slate-700 mb-2">Tanggal Ekspirasi</label>
                            <div class="relative">
                                <i class="fa-solid fa-calendar-times absolute left-3.5 top-1/2 -translate-y-1/2 transform text-slate-400"></i>
                                <input type="date" id="tanggal_ekspirasi" name="tanggal_ekspirasi" class="form-input" value="{{ old('tanggal_ekspirasi', $wbp->tanggal_ekspirasi ? \Carbon\Carbon::parse($wbp->tanggal_ekspirasi)->format('Y-m-d') : '') }}">
                            </div>
                            @error('tanggal_ekspirasi') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="relative form-group">
                            <label for="blok" class="block text-sm font-medium text-slate-700 mb-2">Blok</label>
                            <div class="relative">
                                <i class="fa-solid fa-building-columns absolute left-3.5 top-1/2 -translate-y-1/2 transform text-slate-400"></i>
                                <input type="text" id="blok" name="blok" class="form-input" value="{{ old('blok', $wbp->blok) }}" placeholder="Contoh: A">
                            </div>
                            @error('blok') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div class="relative form-group">
                            <label for="kamar" class="block text-sm font-medium text-slate-700 mb-2">Kamar</label>
                            <div class="relative">
                                <i class="fa-solid fa-door-closed absolute left-3.5 top-1/2 -translate-y-1/2 transform text-slate-400"></i>
                                <input type="text" id="kamar" name="kamar" class="form-input" value="{{ old('kamar', $wbp->kamar) }}" placeholder="Contoh: 101">
                            </div>
                            @error('kamar') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>

                </div>
            </div>

            <div class="flex justify-end items-center gap-4 p-6 bg-slate-50/50 border-t border-slate-200 rounded-b-2xl form-group">
                <a href="{{ route('admin.wbp.index') }}" class="text-sm text-slate-600 hover:text-slate-800 font-semibold px-6 py-2.5 rounded-lg transition-colors">Batal</a>
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2.5 px-8 rounded-lg shadow-lg hover:shadow-blue-500/50 transform hover:-translate-y-1 transition-all duration-300">
                    <i class="fa-solid fa-sync-alt mr-2"></i>
                    Update Data
                </button>
            </div>
        </form>
    </div>
</div>

<style>
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .animated-form .form-group {
        animation: fadeInUp 0.5s ease-out forwards;
        opacity: 0;
    }

    /* Staggered animation delays */
    .animated-form .form-group:nth-child(1) { animation-delay: 0.1s; }
    .animated-form .form-group:nth-child(2) { animation-delay: 0.2s; }
    .animated-form .form-group .form-group:nth-child(1) { animation-delay: 0.3s; }
    .animated-form .form-group .form-group:nth-child(2) { animation-delay: 0.4s; }
    .animated-form .form-group:nth-child(3) { animation-delay: 0.5s; }
    .animated-form .form-group:nth-child(4) .form-group:nth-child(1) { animation-delay: 0.6s; }
    .animated-form .form-group:nth-child(4) .form-group:nth-child(2) { animation-delay: 0.7s; }
    .animated-form .form-group:nth-child(5) .form-group:nth-child(1) { animation-delay: 0.8s; }
    .animated-form .form-group:nth-child(5) .form-group:nth-child(2) { animation-delay: 0.9s; }
    .animated-form .form-group:nth-child(6) { animation-delay: 1s; }

    .form-input {
        width: 100%;
        border: 1px solid #cbd5e1; /* slate-300 */
        border-radius: 0.75rem; /* rounded-xl */
        background-color: #f8fafc; /* slate-50 */
        padding-left: 3rem;
        padding-top: 0.75rem;
        padding-bottom: 0.75rem;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        box-shadow: 0 1px 2px 0 rgba(0,0,0,0.05), inset 0 1px 2px 0 rgba(0,0,0,0.02);
    }
    .form-input:focus {
        --tw-ring-color: rgba(99, 102, 241, 0.4); /* ring-indigo-500/40 */
        border-color: #6366f1; /* indigo-500 */
        background-color: #fff;
        box-shadow: 0 0 0 3px var(--tw-ring-color), 0 4px 12px 0 rgba(99, 102, 241, 0.2);
        transform: translateY(-2px);
    }
    .form-input::placeholder {
        color: #94a3b8; /* slate-400 */
    }
    body {
        background-color: #f1f5f9; /* slate-100 */
    }
</style>
@endsection
