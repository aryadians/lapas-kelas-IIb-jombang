@extends('layouts.main')

@section('content')
<div class="min-h-screen bg-slate-50 flex flex-col items-center justify-center p-4">
    
    <div class="bg-white rounded-3xl shadow-2xl p-8 max-w-lg w-full border border-slate-200 animate-fade-in-up">
        
        <div class="text-center mb-8">
            <div class="w-20 h-20 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4 text-blue-600 shadow-lg">
                <i class="fa-solid fa-magnifying-glass text-3xl"></i>
            </div>
            <h1 class="text-2xl font-extrabold text-slate-800">Cek Status Kunjungan</h1>
            <p class="text-slate-500 mt-2">Masukkan Kode Booking atau NIK Anda untuk melihat status dan tiket.</p>
        </div>

        @if(session('error'))
            <div class="bg-red-50 text-red-600 p-4 rounded-xl mb-6 text-center text-sm font-semibold border border-red-200 animate-shake">
                <i class="fa-solid fa-circle-exclamation mr-2"></i> {{ session('error') }}
            </div>
        @endif

        <form action="{{ route('kunjungan.cek_status') }}" method="GET" class="space-y-6">
            <div class="relative group">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                    <i class="fa-solid fa-barcode text-slate-400 group-focus-within:text-blue-500 transition-colors"></i>
                </div>
                <input type="text" name="keyword" class="w-full pl-11 pr-4 py-4 bg-slate-50 border-2 border-slate-200 rounded-xl focus:border-blue-500 focus:ring-0 focus:bg-white transition-all font-semibold text-lg text-slate-800 placeholder-slate-400" placeholder="Kode Booking / NIK" required autofocus>
            </div>

            <button type="submit" class="w-full bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-bold py-4 rounded-xl shadow-lg hover:shadow-blue-500/30 transition-all transform hover:-translate-y-1 active:scale-95 flex items-center justify-center gap-2">
                Cari Data <i class="fa-solid fa-arrow-right"></i>
            </button>
        </form>

        <div class="mt-8 text-center">
            <a href="{{ route('kunjungan.create') }}" class="text-sm text-slate-500 hover:text-blue-600 font-semibold transition-colors">
                <i class="fa-solid fa-plus-circle mr-1"></i> Belum daftar? Daftar disini
            </a>
        </div>
    </div>

    <div class="mt-8 text-center text-slate-400 text-xs">
        &copy; {{ date('Y') }} Lapas Kelas IIB Jombang. All rights reserved.
    </div>
</div>

<style>
    @keyframes fadeInUp {
        from { opacity: 0; transform: translate3d(0, 40px, 0); }
        to { opacity: 1; transform: translate3d(0, 0, 0); }
    }
    .animate-fade-in-up { animation: fadeInUp 0.5s ease-out; }
    
    @keyframes shake {
        0%, 100% { transform: translateX(0); }
        10%, 30%, 50%, 70%, 90% { transform: translateX(-5px); }
        20%, 40%, 60%, 80% { transform: translateX(5px); }
    }
    .animate-shake { animation: shake 0.5s; }
</style>
@endsection
