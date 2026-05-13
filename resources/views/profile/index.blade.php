@extends('layouts.main')

@section('content')

@php
    // DATA DUMMY (Sama seperti sebelumnya)
    $level2 = [
        ['nama' => 'MOCH. ARIEF KAFANIE, A.Md.P., S.H', 'jabatan' => 'Ka. KPLP', 'seksi' => 'Kesatuan Pengamanan Lapas'],
        ['nama' => 'AFIF EKO SUHARIYANTO, S.H., M.H', 'jabatan' => 'Kasubag Tata Usaha', 'seksi' => 'Sub Bagian Tata Usaha'],
        ['nama' => 'RD EPA FATIMAH, A.Md.IP.,S.H', 'jabatan' => 'Kasi Binadik & Giatja', 'seksi' => 'Bimbingan & Kegiatan Kerja'],
        ['nama' => 'WAYAN RIASA, S.H', 'jabatan' => 'Kasi Adm. Kamtib', 'seksi' => 'Administrasi Keamanan & Tata Tertib'],
    ];

    $level3 = [
        ['nama' => 'DANANG PANDU WINOTO, S.Sos', 'jabatan' => 'Kaur Kepeg & Keu'],
        ['nama' => 'LATIFA ISNA DAMAYANTI, S.H', 'jabatan' => 'Kaur Umum'],
        ['nama' => 'GUSTIANSYAH SURYA W, P,S.Tr.Pas.', 'jabatan' => 'Kasubsi Registrasi'],
        ['nama' => 'MOCHAMAD MACHMUDA HARIS, S.H', 'jabatan' => 'Kasubsi Keperawatan'],
        ['nama' => 'BUDI MULYONO, S.H', 'jabatan' => 'Kasubsi Kegiatan Kerja'],
        ['nama' => 'EDY HARIADY, S.H', 'jabatan' => 'Kasubsi Keamanan'],
        ['nama' => 'SAMUD, S.H', 'jabatan' => 'Kasubsi Portatib'],
    ];
@endphp

@push('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    
    <style>
        /* --- 1. ANIMASI TEXT SHIMMER (Warnanya berjalan) --- */
        @keyframes text-shimmer {
            0% { background-position: -200% center; }
            100% { background-position: 200% center; }
        }
        
        .animate-text-shimmer {
            background-size: 200% auto;
            animation: text-shimmer 3s linear infinite;
        }

        /* --- 2. CARD PRO STYLE --- */
        .card-pro {
            background: #ffffff;
            transition: all 0.3s ease-in-out;
            position: relative;
            overflow: hidden;
            border: 1px solid #f1f5f9;
        }
        
        .card-level-2:hover {
            transform: translateY(-8px);
            box-shadow: 0 15px 30px -5px rgba(37, 99, 235, 0.2);
            border-bottom: 4px solid #2563eb;
        }

        .card-level-3:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px -5px rgba(100, 116, 139, 0.2);
            border-bottom: 3px solid #64748b;
        }

        .icon-circle {
            transition: all 0.4s ease;
        }
        .card-pro:hover .icon-circle {
            transform: scale(1.1);
            background-color: #eff6ff;
            color: #2563eb;
        }

        /* --- 3. VIDEO CONTAINER --- */
        .video-container {
            position: relative;
            padding-bottom: 56.25%; /* 16:9 Aspect Ratio */
            height: 0;
            overflow: hidden;
            border-radius: 1.5rem;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
        }
        .video-container iframe {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            border: 0;
        }
    </style>
@endpush
{{-- ================================================================= --}}
{{-- 1. HEADER DENGAN ANIMASI --}}
{{-- ================================================================= --}}
<section class="relative bg-gradient-to-br from-slate-900 via-slate-800 to-slate-900 text-white min-h-[60vh] flex items-center justify-center overflow-hidden pb-44 pt-32">
    
    {{-- Background Pattern (Titik-titik SVG) --}}
    <div class="absolute inset-0 z-0">
        <div class="absolute inset-0 bg-[url('data:image/svg+xml,%3Csvg width=\'60\' height=\'60\' viewBox=\'0 0 60 60\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cg fill=\'none\' fill-rule=\'evenodd\'%3E%3Cg fill=\'%23ffffff\' fill-opacity=\'0.05\'%3E%3Ccircle cx=\'30\' cy=\'30\' r=\'2\'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E')] opacity-30"></div>
        <div class="absolute inset-0 bg-gradient-to-b from-transparent via-slate-900/40 to-slate-900/90"></div>
    </div>

    {{-- Floating Elements (Bola-bola Cahaya) --}}
    <div class="absolute inset-0 overflow-hidden pointer-events-none z-0">
        <div class="absolute top-[10%] left-[10%] w-[500px] h-[500px] bg-blue-500/20 rounded-full blur-[100px] animate-pulse-slow"></div>
        <div class="absolute bottom-[10%] right-[10%] w-[400px] h-[400px] bg-yellow-500/10 rounded-full blur-[100px] animate-pulse-slow" style="animation-delay: 2s;"></div>
    </div>

    {{-- Content --}}
    <div class="container mx-auto px-6 text-center relative z-10" data-aos="zoom-in" data-aos-duration="1000">
        
        {{-- Badge Kecil --}}
        <div class="inline-flex items-center px-5 py-2 rounded-full bg-white/5 backdrop-blur-md border border-white/20 text-sm font-semibold mb-8 text-blue-200 shadow-[0_0_15px_rgba(255,255,255,0.1)]">
            <i class="fas fa-building mr-2 animate-bounce"></i>
            Profil Lembaga
        </div>

        {{-- Judul dengan Animasi Shimmer --}}
        <h1 class="text-5xl md:text-7xl font-black mb-6 tracking-tight leading-tight drop-shadow-2xl">
            Lapas <span class="text-transparent bg-clip-text bg-gradient-to-r from-yellow-300 via-white to-yellow-300 animate-text-shimmer">Kelas IIB Jombang</span>
        </h1>
        
        <p class="text-xl md:text-2xl text-slate-300 max-w-2xl mx-auto leading-relaxed font-light drop-shadow-lg">
            Mengenal lebih dekat Visi, Misi, Tugas & Fungsi, serta jajaran kepemimpinan kami.
        </p>
    </div>
</section>

{{-- ================================================================= --}}
{{-- 2. KEPALA LAPAS (DINAMIS) --}}
{{-- ================================================================= --}}
<section class="relative z-20 -mt-24 pb-16">
    <div class="container mx-auto px-6">
        <div class="max-w-5xl mx-auto">
            @if($kalapas)
            <div class="bg-white/90 backdrop-blur-2xl rounded-[3rem] shadow-[0_20px_50px_rgba(0,0,0,0.15)] p-10 md:p-14 border border-white/50 flex flex-col md:flex-row items-center gap-10 md:gap-16 relative overflow-hidden group hover:shadow-[0_20px_60px_rgba(234,179,8,0.15)] transition-all duration-500" data-aos="zoom-in-up">
                
                {{-- Background Deco Glowing --}}
                <div class="absolute top-0 right-0 w-[40rem] h-[40rem] bg-gradient-to-br from-yellow-500/10 to-transparent rounded-full -mt-[20rem] -mr-[20rem] blur-[80px] pointer-events-none transition-transform duration-700 group-hover:scale-110"></div>
                <div class="absolute bottom-0 left-0 w-[30rem] h-[30rem] bg-gradient-to-tr from-blue-500/10 to-transparent rounded-full -mb-[15rem] -ml-[15rem] blur-[60px] pointer-events-none"></div>

                {{-- Foto Wrapper --}}
                <div class="relative cursor-pointer swing-trigger-foto flex-shrink-0 group/photo z-10" 
                     data-nama="{{ $kalapas->nama }}" 
                     data-jabatan="{{ $kalapas->jabatan }}"
                     data-img="{{ $kalapas->foto }}">
                     
                    {{-- Aura Glow --}}
                    <div class="absolute -inset-4 bg-gradient-to-r from-yellow-400 via-yellow-200 to-yellow-600 rounded-full blur-xl opacity-40 group-hover/photo:opacity-70 group-hover/photo:blur-2xl transition-all duration-500 animate-pulse"></div>

                    {{-- Image Container --}}
                    <div class="w-56 h-56 md:w-64 md:h-64 rounded-full p-2 bg-gradient-to-br from-yellow-300 via-yellow-100 to-yellow-600 shadow-2xl relative transform group-hover/photo:scale-105 transition-transform duration-500">
                        <img src="{{ $kalapas->foto }}" alt="{{ $kalapas->nama }}" class="w-full h-full object-cover rounded-full border-4 border-white shadow-inner">
                        
                        {{-- Crown Icon Badge --}}
                        <div class="absolute bottom-2 right-4 bg-white text-yellow-500 w-14 h-14 flex items-center justify-center rounded-full shadow-xl text-2xl border-2 border-yellow-100 group-hover/photo:animate-bounce">
                            <i class="fas fa-crown"></i>
                        </div>
                    </div>
                </div>

                {{-- Info --}}
                <div class="text-center md:text-left flex-1 relative z-10">
                    <div class="inline-flex items-center px-4 py-1.5 bg-gradient-to-r from-yellow-50 to-white text-yellow-600 rounded-full text-sm font-bold tracking-widest uppercase mb-4 shadow-sm border border-yellow-200/50">
                        <i class="fas fa-star text-xs mr-2"></i> Kalapas
                    </div>
                    <h2 class="text-4xl md:text-5xl font-black text-slate-800 mb-2 leading-tight">
                        @php 
                            $parts = explode(',', $kalapas->nama);
                            $namaUtama = array_shift($parts);
                            $gelar = implode(',', $parts);
                        @endphp
                        {{ $namaUtama }}, <span class="block text-2xl md:text-3xl text-slate-500 mt-1 font-bold">{{ $gelar }}</span>
                    </h2>
                    <p class="text-xl md:text-2xl text-blue-600 font-black tracking-wide uppercase mb-6 drop-shadow-sm">{{ $kalapas->jabatan }}</p>
                    
                    @if($kalapas->quotes)
                    <div class="relative bg-slate-50/50 rounded-2xl p-6 border border-slate-100/50">
                        <i class="fas fa-quote-left text-4xl text-blue-100 absolute top-4 left-4"></i>
                        <p class="text-slate-600 italic leading-relaxed text-lg pl-10 relative z-10 font-medium">
                            "{{ $kalapas->quotes }}"
                        </p>
                    </div>
                    @endif
                </div>
            </div>
            @endif
        </div>
    </div>
</section>

{{-- ================================================================= --}}
{{-- 3. PEJABAT STRUKTURAL (DINAMIS) --}}
{{-- ================================================================= --}}
<section class="py-20 bg-slate-50 relative overflow-hidden">
    {{-- Decorative Background Gradients --}}
    <div class="absolute top-0 right-0 w-[800px] h-[800px] bg-gradient-to-bl from-blue-100/40 to-transparent rounded-full blur-[100px] pointer-events-none -mt-40 -mr-40"></div>
    <div class="absolute bottom-0 left-0 w-[600px] h-[600px] bg-gradient-to-tr from-cyan-100/40 to-transparent rounded-full blur-[80px] pointer-events-none -mb-20 -ml-20"></div>

    <div class="container mx-auto px-6 relative z-10">
        
        {{-- LEVEL 2: PEJABAT MENENGAH (Eselon 4) --}}
        <div class="mb-24">
            <div class="text-center mb-12" data-aos="fade-up">
                <span class="inline-block bg-white text-blue-600 text-sm font-black px-4 py-1.5 rounded-full uppercase tracking-widest shadow-sm border border-blue-100 mb-3">Eselon IV</span>
                <h3 class="text-3xl md:text-4xl font-extrabold text-slate-800">Pejabat Struktural Utama</h3>
                <div class="w-24 h-1.5 bg-gradient-to-r from-blue-400 to-blue-600 mx-auto rounded-full mt-4"></div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                @foreach ($eselon4 as $i => $p)
                <div class="card-pro card-level-2 group bg-white/70 backdrop-blur-xl border border-white/60 rounded-[2rem] p-8 text-center cursor-pointer swing-trigger-icon hover:shadow-[0_20px_40px_rgba(37,99,235,0.1)] transition-all duration-300"
                     data-nama="{{ $p->nama }}" 
                     data-jabatan="{{ $p->jabatan }}"
                     data-level="utama"
                     data-aos="fade-up" 
                     data-aos-delay="{{ $i * 100 }}">
                    
                    <div class="relative w-24 h-24 mx-auto mb-6">
                        <div class="absolute inset-0 bg-blue-400 rounded-full blur-md opacity-20 group-hover:opacity-40 transition-opacity"></div>
                        <div class="icon-circle relative w-full h-full rounded-full bg-gradient-to-br from-white to-blue-50 border-2 border-white shadow-lg flex items-center justify-center text-blue-500 z-10 overflow-hidden">
                            <i class="fas fa-user-tie text-4xl transform group-hover:scale-110 transition-transform duration-300"></i>
                        </div>
                    </div>

                    <h4 class="text-xl font-bold text-slate-800 mb-2 group-hover:text-blue-700 transition-colors">{{ $p->nama }}</h4>
                    <div class="h-px w-12 bg-gradient-to-r from-transparent via-blue-400 to-transparent mx-auto my-4 opacity-50"></div>
                    <p class="text-blue-600 font-extrabold text-sm uppercase tracking-wider mb-2">{{ $p->jabatan }}</p>
                    @if($p->seksi)
                    <p class="text-slate-500 text-sm bg-slate-100/50 py-1.5 px-3 rounded-xl inline-block">{{ $p->seksi }}</p>
                    @endif
                </div>
                @endforeach
            </div>
        </div>

        {{-- LEVEL 3: PEJABAT PENGAWAS (Eselon 5) --}}
        <div>
            <div class="text-center mb-12" data-aos="fade-up">
                <span class="inline-block bg-white text-slate-600 text-sm font-black px-4 py-1.5 rounded-full uppercase tracking-widest shadow-sm border border-slate-200 mb-3">Eselon V</span>
                <h3 class="text-3xl md:text-3xl font-extrabold text-slate-800">Pejabat Pengawas & Pelaksana</h3>
                <div class="w-24 h-1.5 bg-gradient-to-r from-slate-400 to-slate-500 mx-auto rounded-full mt-4"></div>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @foreach ($eselon5 as $i => $p)
                <div class="card-pro card-level-3 group bg-white/60 backdrop-blur-lg border border-white/80 rounded-3xl p-6 text-center cursor-pointer swing-trigger-icon hover:shadow-[0_15px_30px_rgba(100,116,139,0.1)] transition-all duration-300"
                     data-nama="{{ $p->nama }}" 
                     data-jabatan="{{ $p->jabatan }}"
                     data-level="madya"
                     data-aos="zoom-in" 
                     data-aos-delay="{{ $i * 50 }}">
                    
                    <div class="relative w-16 h-16 mx-auto mb-4">
                        <div class="absolute inset-0 bg-slate-300 rounded-full blur-sm opacity-20 group-hover:opacity-40 transition-opacity"></div>
                        <div class="icon-circle relative w-full h-full rounded-full bg-white border border-slate-100 shadow-md flex items-center justify-center text-slate-400 z-10">
                            <i class="fas fa-user-shield text-2xl group-hover:text-slate-700 transition-colors"></i>
                        </div>
                    </div>

                    <h5 class="font-bold text-slate-800 text-sm md:text-base mb-2 group-hover:text-slate-900 transition-colors line-clamp-2">{{ $p->nama }}</h5>
                    <p class="text-slate-500 font-bold text-xs uppercase tracking-widest">{{ $p->jabatan }}</p>
                </div>
                @endforeach
            </div>
        </div>

    </div>
</section>

{{-- ================================================================= --}}
{{-- 2.5 VIDEO, VISI MISI, TUGAS FUNGSI --}}
{{-- ================================================================= --}}
<section class="py-16 bg-white relative border-t border-slate-200 shadow-inner">
    <div class="container mx-auto px-6 max-w-6xl">
        
        {{-- Video Profil --}}
        <div class="mb-24" data-aos="fade-up">
            <div class="text-center mb-10">
                <h3 class="text-3xl md:text-4xl font-black text-slate-800">Video Profil</h3>
                <div class="w-24 h-1.5 bg-gradient-to-r from-blue-400 to-blue-600 mx-auto rounded-full mt-4"></div>
            </div>
            
            {{-- Menggunakan iframe youtube placeholder. Ganti src dengan link youtube asli lapas jombang --}}
            <div class="relative pb-[56.25%] h-0 overflow-hidden rounded-3xl shadow-[0_20px_50px_rgba(0,0,0,0.15)] border-4 border-slate-100 bg-slate-200">
                <iframe src="https://www.youtube.com/embed/b6cium1oOc8?rel=0&showinfo=0" title="Video Profil Lapas Kelas IIB Jombang" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen class="absolute top-0 left-0 w-full h-full border-0"></iframe>
            </div>
        </div>

        {{-- Visi & Misi --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-10 mb-24">
            {{-- Visi --}}
            <div class="bg-gradient-to-br from-blue-900 to-slate-900 rounded-[2rem] p-10 text-white shadow-xl relative overflow-hidden" data-aos="fade-right">
                <div class="absolute top-0 right-0 w-32 h-32 bg-blue-500/20 rounded-full blur-2xl -mt-10 -mr-10"></div>
                <div class="flex items-center gap-4 mb-6 relative z-10">
                    <div class="w-14 h-14 bg-white/10 rounded-2xl flex items-center justify-center backdrop-blur-sm border border-white/20">
                        <i class="fas fa-eye text-2xl text-blue-300"></i>
                    </div>
                    <h3 class="text-3xl font-black text-yellow-400 tracking-tight">Visi</h3>
                </div>
                <p class="text-lg text-blue-50 leading-relaxed relative z-10">
                    Masyarakat memperoleh kepastian hukum. (Contoh Visi Kemenkumham/Kemenimipas, silakan sesuaikan dengan Visi Satker Anda).
                </p>
            </div>

            {{-- Misi --}}
            <div class="bg-gradient-to-br from-yellow-500 to-orange-600 rounded-[2rem] p-10 text-slate-900 shadow-xl relative overflow-hidden" data-aos="fade-left">
                <div class="absolute top-0 right-0 w-32 h-32 bg-white/20 rounded-full blur-2xl -mt-10 -mr-10"></div>
                <div class="flex items-center gap-4 mb-6 relative z-10">
                    <div class="w-14 h-14 bg-white/20 rounded-2xl flex items-center justify-center backdrop-blur-sm border border-white/30">
                        <i class="fas fa-bullseye text-2xl text-slate-900"></i>
                    </div>
                    <h3 class="text-3xl font-black tracking-tight">Misi</h3>
                </div>
                <ul class="space-y-4 text-base md:text-lg font-medium relative z-10">
                    <li class="flex gap-3">
                        <i class="fas fa-check-circle mt-1 opacity-80"></i>
                        <span>Melindungi Hak Asasi Manusia.</span>
                    </li>
                    <li class="flex gap-3">
                        <i class="fas fa-check-circle mt-1 opacity-80"></i>
                        <span>Mewujudkan Pemasyarakatan yang bersih dan melayani.</span>
                    </li>
                    <li class="flex gap-3">
                        <i class="fas fa-check-circle mt-1 opacity-80"></i>
                        <span>Meningkatkan pembinaan kepribadian dan kemandirian.</span>
                    </li>
                </ul>
            </div>
        </div>

        {{-- Tugas & Fungsi --}}
        <div data-aos="fade-up">
            <div class="text-center mb-10">
                <h3 class="text-3xl md:text-4xl font-black text-slate-800">Tugas & Fungsi</h3>
                <p class="text-slate-500 mt-3 max-w-2xl mx-auto">Sesuai dengan peraturan perundang-undangan yang berlaku dalam sistem Pemasyarakatan.</p>
                <div class="w-24 h-1.5 bg-gradient-to-r from-blue-400 to-blue-600 mx-auto rounded-full mt-4"></div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-white border border-slate-200 rounded-3xl p-8 hover:shadow-xl hover:border-blue-300 transition-all duration-300 group cursor-pointer">
                    <div class="w-16 h-16 bg-blue-50 text-blue-600 rounded-2xl flex items-center justify-center text-2xl mb-6 group-hover:scale-110 group-hover:bg-blue-600 group-hover:text-white transition-all">
                        <i class="fas fa-shield-alt"></i>
                    </div>
                    <h4 class="text-xl font-bold text-slate-800 mb-3">Keamanan & Ketertiban</h4>
                    <p class="text-slate-600 text-sm leading-relaxed">Melakukan pencegahan dan penindakan gangguan keamanan serta menjaga ketertiban di lingkungan Lapas.</p>
                </div>

                <div class="bg-white border border-slate-200 rounded-3xl p-8 hover:shadow-xl hover:border-yellow-300 transition-all duration-300 group cursor-pointer">
                    <div class="w-16 h-16 bg-yellow-50 text-yellow-600 rounded-2xl flex items-center justify-center text-2xl mb-6 group-hover:scale-110 group-hover:bg-yellow-500 group-hover:text-white transition-all">
                        <i class="fas fa-hands-helping"></i>
                    </div>
                    <h4 class="text-xl font-bold text-slate-800 mb-3">Pembinaan Narapidana</h4>
                    <p class="text-slate-600 text-sm leading-relaxed">Memberikan bimbingan kepribadian, mental, rohani, serta bimbingan kerja (kemandirian) kepada warga binaan.</p>
                </div>

                <div class="bg-white border border-slate-200 rounded-3xl p-8 hover:shadow-xl hover:border-emerald-300 transition-all duration-300 group cursor-pointer">
                    <div class="w-16 h-16 bg-emerald-50 text-emerald-600 rounded-2xl flex items-center justify-center text-2xl mb-6 group-hover:scale-110 group-hover:bg-emerald-500 group-hover:text-white transition-all">
                        <i class="fas fa-folder-open"></i>
                    </div>
                    <h4 class="text-xl font-bold text-slate-800 mb-3">Administrasi & Perawatan</h4>
                    <p class="text-slate-600 text-sm leading-relaxed">Melaksanakan tata usaha, kepegawaian, keuangan, perlengkapan, serta pelayanan kesehatan narapidana dan tahanan.</p>
                </div>
            </div>
        </div>

        {{-- Hak & Kewajiban WBP --}}
        <div class="mt-24" data-aos="fade-up">
            <div class="text-center mb-10">
                <h3 class="text-3xl md:text-4xl font-black text-slate-800">Hak & Kewajiban WBP</h3>
                <p class="text-slate-500 mt-3 max-w-2xl mx-auto">Informasi mengenai hak dan kewajiban Warga Binaan Pemasyarakatan (WBP) selama menjalani masa pidana.</p>
                <div class="w-24 h-1.5 bg-gradient-to-r from-blue-400 to-blue-600 mx-auto rounded-full mt-4"></div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                {{-- Hak WBP --}}
                <div class="bg-gradient-to-br from-emerald-50 to-green-100 rounded-[2rem] p-8 md:p-10 border border-emerald-200 shadow-xl relative overflow-hidden group hover:-translate-y-2 transition-all duration-300">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-emerald-500/10 rounded-full blur-2xl -mt-10 -mr-10"></div>
                    <div class="flex items-center gap-4 mb-6 relative z-10">
                        <div class="w-14 h-14 bg-emerald-600 rounded-2xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform">
                            <i class="fas fa-hand-holding-heart text-2xl text-white"></i>
                        </div>
                        <h3 class="text-2xl md:text-3xl font-black text-emerald-900 tracking-tight">Hak WBP</h3>
                    </div>
                    <ul class="space-y-4 text-slate-700 relative z-10 font-medium">
                        <li class="flex gap-3">
                            <i class="fas fa-check text-emerald-600 mt-1"></i>
                            <span>Menjalankan ibadah sesuai dengan agama dan kepercayaannya.</span>
                        </li>
                        <li class="flex gap-3">
                            <i class="fas fa-check text-emerald-600 mt-1"></i>
                            <span>Mendapat perawatan jasmani dan rohani.</span>
                        </li>
                        <li class="flex gap-3">
                            <i class="fas fa-check text-emerald-600 mt-1"></i>
                            <span>Mendapat pendidikan, pengajaran, dan kegiatan rekreasional.</span>
                        </li>
                        <li class="flex gap-3">
                            <i class="fas fa-check text-emerald-600 mt-1"></i>
                            <span>Mendapatkan pelayanan kesehatan dan makanan yang layak.</span>
                        </li>
                        <li class="flex gap-3">
                            <i class="fas fa-check text-emerald-600 mt-1"></i>
                            <span>Menerima kunjungan dari keluarga, advokat, atau pihak lain.</span>
                        </li>
                        <li class="flex gap-3">
                            <i class="fas fa-check text-emerald-600 mt-1"></i>
                            <span>Mendapatkan pengurangan masa pidana (Remisi), Asimilasi, Cuti, dan Pembebasan Bersyarat (PB) sesuai syarat yang berlaku.</span>
                        </li>
                    </ul>
                </div>

                {{-- Kewajiban WBP --}}
                <div class="bg-gradient-to-br from-red-50 to-orange-100 rounded-[2rem] p-8 md:p-10 border border-red-200 shadow-xl relative overflow-hidden group hover:-translate-y-2 transition-all duration-300">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-red-500/10 rounded-full blur-2xl -mt-10 -mr-10"></div>
                    <div class="flex items-center gap-4 mb-6 relative z-10">
                        <div class="w-14 h-14 bg-red-600 rounded-2xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform">
                            <i class="fas fa-clipboard-list text-2xl text-white"></i>
                        </div>
                        <h3 class="text-2xl md:text-3xl font-black text-red-900 tracking-tight">Kewajiban WBP</h3>
                    </div>
                    <ul class="space-y-4 text-slate-700 relative z-10 font-medium">
                        <li class="flex gap-3">
                            <i class="fas fa-exclamation-circle text-red-600 mt-1"></i>
                            <span>Menaati tata tertib dan peraturan yang berlaku di dalam Lapas.</span>
                        </li>
                        <li class="flex gap-3">
                            <i class="fas fa-exclamation-circle text-red-600 mt-1"></i>
                            <span>Mengikuti program pembinaan yang diselenggarakan.</span>
                        </li>
                        <li class="flex gap-3">
                            <i class="fas fa-exclamation-circle text-red-600 mt-1"></i>
                            <span>Menjaga kebersihan, keamanan, dan ketertiban lingkungan Lapas.</span>
                        </li>
                        <li class="flex gap-3">
                            <i class="fas fa-exclamation-circle text-red-600 mt-1"></i>
                            <span>Menghormati hak asasi petugas dan sesama Warga Binaan.</span>
                        </li>
                        <li class="flex gap-3">
                            <i class="fas fa-exclamation-circle text-red-600 mt-1"></i>
                            <span>Memelihara fasilitas, sarana, dan prasarana yang ada di dalam Lapas.</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

    </div>
</section>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

<script>
    AOS.init({ once: true, duration: 800, offset: 50 });

    // LOGIKA SWING ALERT (Sama seperti sebelumnya)
    document.querySelectorAll('.swing-trigger-icon').forEach(trigger => {
        trigger.addEventListener('click', function() {
            const nama = this.dataset.nama;
            const jabatan = this.dataset.jabatan;
            const level = this.dataset.level;

            let iconColor = level === 'utama' ? 'text-blue-600' : 'text-slate-500';
            let iconBg = level === 'utama' ? 'bg-blue-50' : 'bg-slate-100';

            Swal.fire({
                title: `<span class="text-xl font-bold text-slate-800">${nama}</span>`,
                html: `
                    <div class="flex justify-center my-4">
                        <div class="w-20 h-20 rounded-full ${iconBg} flex items-center justify-center animate__animated animate__pulse animate__infinite">
                            <i class="fas fa-user-tie text-4xl ${iconColor}"></i>
                        </div>
                    </div>
                    <p class="text-base font-bold text-slate-700 uppercase">${jabatan}</p>
                `,
                showConfirmButton: false, showCloseButton: true,
                showClass: { popup: 'animate__animated animate__swing animate__faster' },
                customClass: { popup: 'rounded-2xl p-6 shadow-xl border border-slate-100' }
            });
        });
    });

    document.querySelector('.swing-trigger-foto').addEventListener('click', function() {
        Swal.fire({
            title: `<span class="text-2xl font-bold text-slate-800">${this.dataset.nama}</span>`,
            html: `<p class="text-blue-600 font-bold mb-4">${this.dataset.jabatan}</p>`,
            imageUrl: this.dataset.img, imageWidth: 200, imageHeight: 200,
            showConfirmButton: false, showCloseButton: true,
            showClass: { popup: 'animate__animated animate__swing' },
            customClass: { popup: 'rounded-3xl', image: 'rounded-full border-4 border-yellow-400 shadow-lg mx-auto object-cover' }
        });
    });
</script>
@endpush