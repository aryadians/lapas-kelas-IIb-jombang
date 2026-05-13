@extends('layouts.main')

@section('title', 'Alur & Usulan Integrasi')

@section('content')

@push('styles')
<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
<style>
    .glass-card {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(226, 232, 240, 0.8);
        transition: all 0.3s ease;
    }
    .glass-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 20px 40px -10px rgba(59, 130, 246, 0.15);
        border-color: rgba(59, 130, 246, 0.3);
    }
    
    .step-circle {
        position: relative;
        z-index: 10;
        background: linear-gradient(135deg, #2563eb, #1e40af);
        box-shadow: 0 10px 25px -5px rgba(37, 99, 235, 0.5);
    }
    
    .step-line {
        position: absolute;
        top: 2rem;
        left: 3rem;
        bottom: -2rem;
        width: 2px;
        background: linear-gradient(to bottom, #93c5fd, transparent);
        z-index: 0;
    }
    
    @media (max-width: 768px) {
        .step-line {
            left: 2rem;
        }
    }
</style>
@endpush

{{-- HERO SECTION --}}
<section class="relative bg-gradient-to-br from-slate-900 via-blue-900 to-indigo-950 text-white pt-32 pb-24 overflow-hidden">
    <div class="absolute inset-0 bg-[url('https://images.unsplash.com/photo-1450101499163-c8848c66ca85?auto=format&fit=crop&w=1920&q=80')] bg-cover bg-center blur-sm opacity-20"></div>
    <div class="absolute inset-0 bg-gradient-to-b from-transparent to-slate-900/90"></div>
    
    <div class="absolute top-20 right-10 w-64 h-64 bg-blue-500/20 rounded-full blur-3xl animate-pulse"></div>
    <div class="absolute bottom-10 left-10 w-48 h-48 bg-yellow-500/10 rounded-full blur-3xl"></div>

    <div class="container mx-auto px-6 relative z-10 text-center max-w-4xl" data-aos="zoom-in">
        <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-white/10 border border-white/20 text-yellow-300 text-sm font-bold uppercase tracking-widest mb-6">
            <i class="fas fa-file-signature"></i> Layanan Integrasi
        </div>
        <h1 class="text-4xl md:text-6xl font-black mb-6 leading-tight tracking-tight">
            Alur & Informasi Usulan <span class="text-transparent bg-clip-text bg-gradient-to-r from-yellow-300 to-yellow-500">Integrasi WBP</span>
        </h1>
        <p class="text-lg md:text-xl text-slate-300 leading-relaxed">
            Pusat informasi mengenai prosedur, persyaratan, dan alur pengajuan Pembebasan Bersyarat (PB), Cuti Bersyarat (CB), Cuti Menjelang Bebas (CMB), dan Asimilasi.
        </p>
    </div>
</section>

{{-- INFORMASI BANTUAN WA --}}
<section class="relative z-20 -mt-12 mb-16">
    <div class="container mx-auto px-6 max-w-5xl">
        <div class="bg-white rounded-3xl shadow-2xl p-8 md:p-10 flex flex-col md:flex-row items-center justify-between gap-8 border border-slate-100" data-aos="fade-up">
            <div class="flex items-center gap-6">
                <div class="w-20 h-20 rounded-2xl bg-gradient-to-br from-emerald-400 to-emerald-600 flex items-center justify-center text-white text-3xl shadow-lg shadow-emerald-500/30 flex-shrink-0">
                    <i class="fab fa-whatsapp"></i>
                </div>
                <div>
                    <h3 class="text-2xl font-black text-slate-800 mb-2">Butuh Bantuan Integrasi?</h3>
                    <p class="text-slate-600">Hubungi petugas kami untuk pertanyaan seputar syarat, status usulan, atau layanan integrasi lainnya.</p>
                </div>
            </div>
            <a href="https://wa.me/6281234567890" target="_blank" class="w-full md:w-auto px-8 py-4 bg-emerald-500 hover:bg-emerald-600 text-white font-bold rounded-2xl transition-all shadow-lg hover:shadow-emerald-500/40 hover:-translate-y-1 flex items-center justify-center gap-3 text-lg">
                <i class="fab fa-whatsapp text-xl"></i> Chat Sekarang
            </a>
        </div>
    </div>
</section>

{{-- ALUR INTEGRASI --}}
<section class="py-20 bg-slate-50 relative overflow-hidden">
    {{-- Decorative Background Elements --}}
    <div class="absolute top-0 left-0 w-full h-24 bg-gradient-to-b from-white to-transparent opacity-50"></div>
    
    <div class="container mx-auto px-6 max-w-5xl">
        <div class="text-center mb-20" data-aos="fade-up">
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-blue-100 text-blue-700 text-xs font-bold uppercase tracking-widest mb-4">
                <i class="fas fa-project-diagram"></i> Visualisasi Alur
            </div>
            <h2 class="text-3xl md:text-5xl font-black text-slate-900 mb-4">Prosedur Pengajuan</h2>
            <div class="w-24 h-2 bg-gradient-to-r from-blue-600 to-indigo-700 mx-auto rounded-full"></div>
            <p class="mt-6 text-slate-600 max-w-2xl mx-auto text-lg">
                Proses transparan dan terukur untuk memastikan hak-hak WBP terpenuhi sesuai regulasi yang berlaku.
            </p>
        </div>

        <div class="relative space-y-12">
            {{-- Step 1 --}}
            <div class="relative flex items-start gap-6 md:gap-12" data-aos="fade-left" data-aos-delay="100">
                {{-- Arrow Connector --}}
                <div class="absolute top-16 left-6 md:left-10 bottom-[-3rem] w-1 bg-gradient-to-b from-blue-500 via-blue-300 to-transparent z-0 hidden md:flex items-center justify-center">
                    <div class="absolute bottom-0 w-4 h-4 border-b-4 border-r-4 border-blue-300 rotate-45 transform -translate-x-[1.5px]"></div>
                </div>

                <div class="w-12 h-12 md:w-20 md:h-20 flex-shrink-0 step-circle rounded-2xl flex flex-col items-center justify-center text-white relative z-10">
                    <span class="text-[10px] md:text-xs font-black opacity-50 uppercase mb-1">Tahap 1</span>
                    <i class="fas fa-folder-open text-xl md:text-3xl"></i>
                </div>
                <div class="glass-card flex-1 rounded-[2rem] p-6 md:p-10 border-l-4 border-blue-600">
                    <h3 class="text-xl md:text-2xl font-black text-slate-800 mb-4 flex items-center gap-3">
                        Lengkapi Berkas Administrasi
                    </h3>
                    <p class="text-slate-600 leading-relaxed mb-6 text-base md:text-lg">Keluarga (Penjamin) menyiapkan dokumen wajib: Fotokopi KTP, KK, Surat Jaminan Keluarga, dan Surat Keterangan Domisili dari Desa/Kelurahan.</p>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <div class="flex items-center gap-3 bg-white p-3 rounded-xl border border-slate-100 shadow-sm">
                            <i class="fas fa-check-circle text-emerald-500"></i>
                            <span class="text-sm font-bold text-slate-700">Legalisir Lurah/Camat</span>
                        </div>
                        <div class="flex items-center gap-3 bg-white p-3 rounded-xl border border-slate-100 shadow-sm">
                            <i class="fas fa-check-circle text-emerald-500"></i>
                            <span class="text-sm font-bold text-slate-700">KTP Penjamin Aktif</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Step 2 --}}
            <div class="relative flex items-start gap-6 md:gap-12" data-aos="fade-left" data-aos-delay="200">
                {{-- Arrow Connector --}}
                <div class="absolute top-16 left-6 md:left-10 bottom-[-3rem] w-1 bg-gradient-to-b from-blue-400 via-blue-200 to-transparent z-0 hidden md:block">
                    <div class="absolute bottom-0 w-4 h-4 border-b-4 border-r-4 border-blue-200 rotate-45 transform -translate-x-[1.5px]"></div>
                </div>

                <div class="w-12 h-12 md:w-20 md:h-20 flex-shrink-0 step-circle rounded-2xl flex flex-col items-center justify-center text-white relative z-10">
                    <span class="text-[10px] md:text-xs font-black opacity-50 uppercase mb-1">Tahap 2</span>
                    <i class="fas fa-user-check text-xl md:text-3xl"></i>
                </div>
                <div class="glass-card flex-1 rounded-[2rem] p-6 md:p-10 border-l-4 border-blue-400">
                    <h3 class="text-xl md:text-2xl font-black text-slate-800 mb-4">Penilaian Melalui SPPN</h3>
                    <p class="text-slate-600 leading-relaxed text-base md:text-lg">Petugas melakukan penilaian perilaku melalui instrumen SPPN. WBP wajib menunjukkan perubahan perilaku positif dan aktif dalam program pembinaan.</p>
                </div>
            </div>

            {{-- Step 3 --}}
            <div class="relative flex items-start gap-6 md:gap-12" data-aos="fade-left" data-aos-delay="300">
                {{-- Arrow Connector --}}
                <div class="absolute top-16 left-6 md:left-10 bottom-[-3rem] w-1 bg-gradient-to-b from-blue-300 via-emerald-200 to-transparent z-0 hidden md:block">
                    <div class="absolute bottom-0 w-4 h-4 border-b-4 border-r-4 border-emerald-200 rotate-45 transform -translate-x-[1.5px]"></div>
                </div>

                <div class="w-12 h-12 md:w-20 md:h-20 flex-shrink-0 step-circle rounded-2xl flex flex-col items-center justify-center text-white relative z-10">
                    <span class="text-[10px] md:text-xs font-black opacity-50 uppercase mb-1">Tahap 3</span>
                    <i class="fas fa-gavel text-xl md:text-3xl"></i>
                </div>
                <div class="glass-card flex-1 rounded-[2rem] p-6 md:p-10 border-l-4 border-blue-300">
                    <h3 class="text-xl md:text-2xl font-black text-slate-800 mb-4">Sidang Tim TPP</h3>
                    <p class="text-slate-600 leading-relaxed text-base md:text-lg">Usulan Integrasi dibahas secara kolektif dalam Sidang Tim Pengamat Pemasyarakatan (TPP) untuk mendapatkan rekomendasi persetujuan.</p>
                </div>
            </div>

            {{-- Step 4 --}}
            <div class="relative flex items-start gap-6 md:gap-12" data-aos="fade-left" data-aos-delay="400">
                <div class="w-12 h-12 md:w-20 md:h-20 flex-shrink-0 bg-gradient-to-br from-emerald-500 to-teal-600 rounded-2xl flex flex-col items-center justify-center text-white relative z-10 shadow-lg shadow-emerald-500/30">
                    <span class="text-[10px] md:text-xs font-black opacity-50 uppercase mb-1">Final</span>
                    <i class="fas fa-file-contract text-xl md:text-3xl"></i>
                </div>
                <div class="glass-card flex-1 rounded-[2rem] p-6 md:p-10 border-l-4 border-emerald-500 bg-emerald-50/30">
                    <h3 class="text-xl md:text-2xl font-black text-emerald-900 mb-4">Penerbitan SK Integrasi</h3>
                    <p class="text-emerald-800/80 leading-relaxed text-base md:text-lg">Data dikirim secara daring melalui Sistem Database Pemasyarakatan (SDP) ke Pusat untuk penerbitan SK Pembebasan Bersyarat atau Cuti Bersyarat.</p>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- JENIS INTEGRASI --}}
<section class="py-20 bg-white border-t border-slate-100">
    <div class="container mx-auto px-6 max-w-6xl">
        <div class="text-center mb-16" data-aos="fade-up">
            <h2 class="text-3xl font-black text-slate-800 mb-4">Jenis Layanan Integrasi</h2>
            <p class="text-slate-500">Layanan ini diberikan tanpa dipungut biaya apapun (GRATIS).</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            {{-- PB --}}
            <div class="bg-white border border-slate-200 rounded-3xl p-8 hover:shadow-xl hover:-translate-y-2 transition-all duration-300" data-aos="fade-up" data-aos-delay="100">
                <div class="w-14 h-14 bg-blue-50 text-blue-600 rounded-2xl flex items-center justify-center text-2xl mb-6">
                    <i class="fas fa-door-open"></i>
                </div>
                <h4 class="text-xl font-black text-slate-800 mb-3">Pembebasan Bersyarat (PB)</h4>
                <p class="text-slate-600 text-sm leading-relaxed mb-4">Diberikan kepada WBP yang telah menjalani minimal 2/3 (dua pertiga) dari masa pidananya, dengan ketentuan 2/3 masa pidana tersebut tidak kurang dari 9 bulan.</p>
            </div>

            {{-- CB --}}
            <div class="bg-white border border-slate-200 rounded-3xl p-8 hover:shadow-xl hover:-translate-y-2 transition-all duration-300" data-aos="fade-up" data-aos-delay="200">
                <div class="w-14 h-14 bg-indigo-50 text-indigo-600 rounded-2xl flex items-center justify-center text-2xl mb-6">
                    <i class="fas fa-home"></i>
                </div>
                <h4 class="text-xl font-black text-slate-800 mb-3">Cuti Bersyarat (CB)</h4>
                <p class="text-slate-600 text-sm leading-relaxed mb-4">Diberikan kepada WBP dengan pidana penjara paling lama 1 tahun 6 bulan, dan telah menjalani paling sedikit 2/3 (dua pertiga) dari masa pidana.</p>
            </div>

            {{-- CMB --}}
            <div class="bg-white border border-slate-200 rounded-3xl p-8 hover:shadow-xl hover:-translate-y-2 transition-all duration-300" data-aos="fade-up" data-aos-delay="300">
                <div class="w-14 h-14 bg-violet-50 text-violet-600 rounded-2xl flex items-center justify-center text-2xl mb-6">
                    <i class="fas fa-calendar-check"></i>
                </div>
                <h4 class="text-xl font-black text-slate-800 mb-3">Cuti Menjelang Bebas (CMB)</h4>
                <p class="text-slate-600 text-sm leading-relaxed mb-4">Diberikan sebesar remisi terakhir, paling lama 6 bulan. Mengkondisikan WBP sebelum kembali sepenuhnya ke masyarakat.</p>
            </div>
        </div>
    </div>
</section>

@endsection

@push('scripts')
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
    AOS.init({ once: true, duration: 800, offset: 50 });
</script>
@endpush
