@extends('layouts.main')

@section('content')
<div class="min-h-screen bg-slate-50 pt-24 pb-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-3xl mx-auto">
        
        {{-- HEADER --}}
        <div class="text-center mb-10">
            <div class="inline-flex items-center justify-center w-20 h-20 bg-blue-600 rounded-2xl shadow-xl shadow-blue-200 mb-6 transform -rotate-6 transition-transform hover:rotate-0">
                <i class="fa-solid fa-star-half-stroke text-white text-4xl"></i>
            </div>
            <h1 class="text-3xl md:text-4xl font-black text-slate-900 mb-2">Survei Kepuasan Layanan</h1>
            <p class="text-slate-500 font-medium max-w-md mx-auto">Bantu kami meningkatkan kualitas layanan dengan memberikan penilaian jujur Anda.</p>
        </div>

        <div class="bg-white rounded-[2.5rem] shadow-2xl shadow-slate-200/60 overflow-hidden border border-slate-100 animate__animated animate__fadeInUp">
            
            @if(session('success'))
                <div class="p-12 text-center">
                    <div class="w-24 h-24 bg-emerald-100 text-emerald-600 rounded-full flex items-center justify-center mx-auto mb-6 animate__animated animate__zoomIn">
                        <i class="fa-solid fa-check text-5xl"></i>
                    </div>
                    <h2 class="text-2xl font-bold text-slate-800 mb-2">Terima Kasih!</h2>
                    <p class="text-slate-500 mb-8">{{ session('success') }}</p>
                    <a href="/" class="inline-flex items-center gap-2 bg-slate-900 text-white px-8 py-3 rounded-xl font-bold hover:bg-slate-800 transition-all active:scale-95">
                        <i class="fa-solid fa-house"></i> Kembali ke Beranda
                    </a>
                </div>
            @else
                <form action="{{ route('survey.store') }}" method="POST" class="p-8 md:p-12">
                    @csrf
                    
                    @if($kunjungan)
                        <div class="mb-10 p-4 bg-blue-50 rounded-2xl border border-blue-100 flex items-center gap-4">
                            <div class="w-12 h-12 bg-white rounded-xl flex items-center justify-center text-blue-600 shadow-sm">
                                <i class="fa-solid fa-ticket"></i>
                            </div>
                            <div>
                                <p class="text-[10px] font-bold text-blue-400 uppercase tracking-widest">Kunjungan Terkait</p>
                                <p class="text-slate-700 font-bold">#{{ $kunjungan->kode_kunjungan }} - {{ $kunjungan->nama_pengunjung }}</p>
                            </div>
                        </div>
                    @endif

                    {{-- RATING SECTION --}}
                    <div class="mb-10" x-data="{ rating: 0 }">
                        <label class="block text-sm font-black text-slate-700 uppercase tracking-widest mb-6 text-center">Bagaimana kualitas layanan kami hari ini?</label>
                        
                        <input type="hidden" name="rating" :value="rating">
                        
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                            {{-- Rating 1: Buruk --}}
                            <button type="button" @click="rating = 1" 
                                :class="rating === 1 ? 'border-red-500 bg-red-50 ring-4 ring-red-100' : 'border-slate-100 bg-slate-50 hover:bg-slate-100'"
                                class="p-6 rounded-3xl border-2 transition-all group text-center">
                                <div class="text-4xl mb-3 group-hover:scale-110 transition-transform">😢</div>
                                <span class="block text-xs font-bold text-slate-600 uppercase tracking-wider">Buruk</span>
                            </button>

                            {{-- Rating 2: Cukup --}}
                            <button type="button" @click="rating = 2" 
                                :class="rating === 2 ? 'border-amber-500 bg-amber-50 ring-4 ring-amber-100' : 'border-slate-100 bg-slate-50 hover:bg-slate-100'"
                                class="p-6 rounded-3xl border-2 transition-all group text-center">
                                <div class="text-4xl mb-3 group-hover:scale-110 transition-transform">😐</div>
                                <span class="block text-xs font-bold text-slate-600 uppercase tracking-wider">Cukup</span>
                            </button>

                            {{-- Rating 3: Baik --}}
                            <button type="button" @click="rating = 3" 
                                :class="rating === 3 ? 'border-blue-500 bg-blue-50 ring-4 ring-blue-100' : 'border-slate-100 bg-slate-50 hover:bg-slate-100'"
                                class="p-6 rounded-3xl border-2 transition-all group text-center">
                                <div class="text-4xl mb-3 group-hover:scale-110 transition-transform">😊</div>
                                <span class="block text-xs font-bold text-slate-600 uppercase tracking-wider">Baik</span>
                            </button>

                            {{-- Rating 4: Sangat Baik --}}
                            <button type="button" @click="rating = 4" 
                                :class="rating === 4 ? 'border-emerald-500 bg-emerald-50 ring-4 ring-emerald-100' : 'border-slate-100 bg-slate-50 hover:bg-slate-100'"
                                class="p-6 rounded-3xl border-2 transition-all group text-center">
                                <div class="text-4xl mb-3 group-hover:scale-110 transition-transform">🤩</div>
                                <span class="block text-xs font-bold text-slate-600 uppercase tracking-wider">Sangat Baik</span>
                            </button>
                        </div>
                        @error('rating')
                            <p class="text-red-500 text-xs mt-4 text-center font-bold">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- SUGGESTION SECTION --}}
                    <div class="mb-10">
                        <label for="saran" class="block text-sm font-black text-slate-700 uppercase tracking-widest mb-3">Saran & Kritik (Opsional)</label>
                        <textarea name="saran" id="saran" rows="4" 
                            class="w-full p-5 bg-slate-50 border-2 border-slate-100 rounded-2xl focus:bg-white focus:border-blue-500 focus:ring-0 transition-all font-medium text-slate-700 placeholder-slate-400"
                            placeholder="Apa yang bisa kami tingkatkan untuk pelayanan kedepannya?">{{ old('saran') }}</textarea>
                        @error('saran')
                            <p class="text-red-500 text-xs mt-2 font-bold">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- SUBMIT BUTTON --}}
                    <button type="submit" 
                        class="w-full bg-gradient-to-r from-blue-600 to-indigo-600 text-white py-5 rounded-2xl font-black text-lg shadow-xl shadow-blue-200 hover:shadow-2xl hover:-translate-y-1 transition-all active:scale-95 flex items-center justify-center gap-3">
                        <span>Kirim Penilaian</span>
                        <i class="fa-solid fa-paper-plane"></i>
                    </button>

                    <p class="mt-6 text-center text-xs text-slate-400 font-medium">
                        <i class="fa-solid fa-shield-halved mr-1"></i> Data Anda akan dijaga kerahasiaannya untuk kepentingan peningkatan layanan.
                    </p>
                </form>
            @endif
        </div>

        <div class="mt-12 text-center">
            <a href="/" class="text-slate-400 hover:text-blue-600 text-sm font-bold transition-colors">
                <i class="fa-solid fa-arrow-left mr-2"></i> Kembali ke Beranda
            </a>
        </div>
    </div>
</div>
@endsection
