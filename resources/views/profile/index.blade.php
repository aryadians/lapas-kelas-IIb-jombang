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

        /* --- 4. INSTITUTIONAL CONTENT STYLE --- */
        .institutional-list ul {
            list-style-type: none;
            padding-left: 0;
        }
        .institutional-list li {
            display: flex;
            gap: 12px;
            margin-bottom: 1rem;
        }
        .institutional-list li::before {
            content: "\f058";
            font-family: "Font Awesome 6 Free";
            font-weight: 900;
            color: currentColor;
            opacity: 0.8;
            margin-top: 4px;
        }

        .institutional-content h3 {
            font-size: 1.25rem;
            font-weight: 900;
            color: #1e293b;
            margin-top: 2rem;
            margin-bottom: 1rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }
        
        .premium-list ul {
            list-style: none;
            padding-left: 0;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 1.5rem;
        }
        .premium-list li {
            background: #f8fafc;
            border: 1px solid #f1f5f9;
            padding: 1.5rem;
            border-radius: 1.5rem;
            display: flex;
            gap: 12px;
            align-items: flex-start;
            transition: all 0.3s ease;
        }
        .premium-list li:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.05);
            border-color: #34d399;
            background: #ffffff;
        }
        .premium-list li::before {
            content: "\f00c";
            font-family: "Font Awesome 6 Free";
            font-weight: 900;
            color: #10b981;
            margin-top: 2px;
            font-size: 1.1rem;
        }

        .premium-list-dark h3 {
            color: #ffffff;
            border-bottom: 1px solid #334155;
            padding-bottom: 0.5rem;
            margin-top: 0;
        }
        .premium-list-dark ul {
            list-style: none;
            padding-left: 0;
            margin-bottom: 2rem;
        }
        .premium-list-dark li {
            padding: 0.75rem 1rem;
            background: rgba(255,255,255,0.05);
            border-radius: 1rem;
            margin-bottom: 0.5rem;
            display: flex;
            gap: 12px;
            align-items: flex-start;
            color: #cbd5e1;
            transition: all 0.3s ease;
        }
        .premium-list-dark li:hover {
            background: rgba(255,255,255,0.1);
            color: #ffffff;
            transform: translateX(5px);
        }
        .premium-list-dark li::before {
            content: "\f192";
            font-family: "Font Awesome 6 Free";
            font-weight: 900;
            color: #6366f1;
            margin-top: 3px;
        }
        .sasaran-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 2rem;
            align-items: start;
        }

        .premium-text p {
            font-size: 1.125rem;
            line-height: 1.8;
            color: #475569;
            margin-bottom: 1rem;
            font-weight: 500;
        }

        .premium-rights-list h3 {
            font-size: 1.5rem;
            color: #9f1239;
        }
        .premium-rights-list ul {
            list-style: none;
            padding-left: 0;
        }
        .premium-rights-list li {
            padding: 1rem;
            background: white;
            border-radius: 1rem;
            margin-bottom: 0.75rem;
            box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05);
            display: flex;
            gap: 12px;
            align-items: flex-start;
            transition: transform 0.3s ease;
            border-left: 4px solid #f43f5e;
        }
        .premium-rights-list li:hover {
            transform: scale(1.02);
        }
        .premium-rights-list li::before {
            content: "\f06a";
            font-family: "Font Awesome 6 Free";
            font-weight: 900;
            color: #f43f5e;
            margin-top: 2px;
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
                            @if($p->foto)
                                <img src="{{ $p->foto }}" alt="{{ $p->nama }}" class="w-full h-full object-cover">
                            @else
                                <i class="fas fa-user-tie text-4xl transform group-hover:scale-110 transition-transform duration-300"></i>
                            @endif
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
                        <div class="icon-circle relative w-full h-full rounded-full bg-white border border-slate-100 shadow-md flex items-center justify-center text-slate-400 z-10 overflow-hidden">
                            @if($p->foto)
                                <img src="{{ $p->foto }}" alt="{{ $p->nama }}" class="w-full h-full object-cover">
                            @else
                                <i class="fas fa-user-shield text-2xl group-hover:text-slate-700 transition-colors"></i>
                            @endif
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
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-24">
            {{-- Visi --}}
            <div class="group relative bg-gradient-to-br from-blue-900 via-slate-900 to-blue-950 rounded-[2.5rem] p-10 md:p-12 text-white shadow-2xl overflow-hidden hover:-translate-y-2 transition-all duration-500" data-aos="fade-right">
                <div class="absolute -top-24 -right-24 w-64 h-64 bg-blue-500/20 rounded-full blur-[80px] group-hover:bg-blue-400/30 transition-colors duration-700"></div>
                <div class="absolute bottom-0 left-0 w-full h-1 bg-gradient-to-r from-blue-400 to-indigo-500 transform scale-x-0 group-hover:scale-x-100 transition-transform duration-700 origin-left"></div>
                
                <div class="flex flex-col h-full relative z-10">
                    <div class="flex items-center gap-5 mb-8">
                        <div class="w-16 h-16 bg-white/10 rounded-2xl flex items-center justify-center backdrop-blur-md border border-white/20 shadow-inner group-hover:scale-110 group-hover:rotate-3 transition-transform duration-500">
                            <i class="fas fa-eye text-3xl text-blue-300 drop-shadow-md"></i>
                        </div>
                        <div>
                            <h3 class="text-4xl font-black text-transparent bg-clip-text bg-gradient-to-r from-yellow-200 to-yellow-500 tracking-tight drop-shadow-sm">VISI</h3>
                            <p class="text-[10px] uppercase tracking-[0.3em] text-blue-200 font-bold mt-1 opacity-80">Arah & Pandangan</p>
                        </div>
                    </div>
                    <div class="flex-grow flex items-center">
                        <p class="text-xl md:text-2xl text-blue-50 leading-relaxed font-semibold italic drop-shadow-md">
                            "{{ $institutional['visi'] ?? 'Terwujudnya Pemasyarakatan yang Profesional dalam Mendukung Penegakan Hukum Berbasis Hak Asasi Manusia yang Berkeadilan untuk Mewujudkan Indonesia Maju yang Berdaulat, Mandiri dan Berkepribadian, berlandaskan Gotong Royong' }}"
                        </p>
                    </div>
                </div>
            </div>

            {{-- Misi --}}
            <div class="group relative bg-white rounded-[2.5rem] p-10 md:p-12 text-slate-800 shadow-[0_20px_50px_-20px_rgba(0,0,0,0.1)] border border-slate-100 overflow-hidden hover:-translate-y-2 transition-all duration-500" data-aos="fade-left">
                <div class="absolute top-0 right-0 w-64 h-64 bg-amber-500/10 rounded-full blur-[80px] group-hover:bg-amber-400/20 transition-colors duration-700"></div>
                <div class="absolute bottom-0 left-0 w-full h-1 bg-gradient-to-r from-amber-400 to-orange-500 transform scale-x-0 group-hover:scale-x-100 transition-transform duration-700 origin-left"></div>

                <div class="flex flex-col h-full relative z-10">
                    <div class="flex items-center gap-5 mb-8">
                        <div class="w-16 h-16 bg-gradient-to-br from-amber-400 to-orange-500 rounded-2xl flex items-center justify-center shadow-lg shadow-orange-500/30 group-hover:scale-110 group-hover:-rotate-3 transition-transform duration-500">
                            <i class="fas fa-bullseye text-3xl text-white drop-shadow-md"></i>
                        </div>
                        <div>
                            <h3 class="text-4xl font-black text-slate-800 tracking-tight">MISI</h3>
                            <p class="text-[10px] uppercase tracking-[0.3em] text-slate-400 font-bold mt-1">Langkah Strategis</p>
                        </div>
                    </div>
                    <div class="flex-grow institutional-list">
                        {!! $institutional['misi'] ?? '<ul><li>Melindungi Hak Asasi Manusia.</li><li>Mewujudkan Pemasyarakatan yang bersih dan melayani.</li><li>Meningkatkan pembinaan kepribadian dan kemandirian.</li></ul>' !!}
                    </div>
                </div>
            </div>
        </div>

        {{-- Tujuan & Sasaran Program --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-10 mb-24">
            {{-- Tujuan --}}
            <div class="bg-white border border-slate-100 rounded-[2.5rem] p-10 shadow-[0_15px_40px_-15px_rgba(0,0,0,0.05)] relative overflow-hidden group" data-aos="fade-up">
                <div class="absolute -top-10 -right-10 w-40 h-40 bg-emerald-50 rounded-full blur-3xl"></div>
                <div class="flex items-center gap-4 mb-8 relative z-10 border-b border-slate-100 pb-6">
                    <div class="w-14 h-14 bg-emerald-100 text-emerald-600 rounded-2xl flex items-center justify-center shadow-inner group-hover:bg-emerald-600 group-hover:text-white transition-colors duration-300">
                        <i class="fas fa-flag-checkered text-2xl"></i>
                    </div>
                    <div>
                        <h3 class="text-3xl font-black text-slate-800 tracking-tight">Tujuan</h3>
                        <p class="text-xs text-slate-400 font-bold uppercase tracking-widest mt-1">Target Pencapaian</p>
                    </div>
                </div>
                <div class="relative z-10 text-slate-600 leading-relaxed font-medium institutional-content premium-list">
                    {!! $institutional['tujuan'] ?? 'Mendukung Penegakan Hukum di Bidang Pemasyarakatan yang Bebas dari Korupsi, Bermartabat dan Terpercaya.' !!}
                </div>
            </div>

            {{-- Sasaran Program --}}
            <div class="bg-slate-900 border border-slate-800 rounded-[2.5rem] p-10 shadow-2xl relative overflow-hidden group" data-aos="fade-up" data-aos-delay="100">
                <div class="absolute -top-10 -right-10 w-40 h-40 bg-indigo-500/20 rounded-full blur-3xl"></div>
                <div class="flex items-center gap-4 mb-8 relative z-10 border-b border-slate-700 pb-6">
                    <div class="w-14 h-14 bg-indigo-500/20 text-indigo-400 rounded-2xl flex items-center justify-center shadow-inner group-hover:bg-indigo-500 group-hover:text-white transition-colors duration-300">
                        <i class="fas fa-chart-line text-2xl"></i>
                    </div>
                    <div>
                        <h3 class="text-3xl font-black text-white tracking-tight">Sasaran Program</h3>
                        <p class="text-xs text-indigo-300/70 font-bold uppercase tracking-widest mt-1">Indikator Kinerja</p>
                    </div>
                </div>
                
                <div class="relative z-10 institutional-content premium-list-dark sasaran-grid">
                    {!! $institutional['sasaran_program'] ?? 'Terwujudnya Penyelenggaraan Pemasyarakatan yang Berkualitas.' !!}
                </div>
            </div>
        </div>

        {{-- Tugas & Fungsi --}}
        <div class="mb-24" data-aos="fade-up">
            <div class="text-center mb-12">
                <span class="inline-block px-4 py-1.5 rounded-full bg-blue-50 text-blue-600 text-xs font-black uppercase tracking-widest border border-blue-100 mb-4">Core Business</span>
                <h3 class="text-4xl md:text-5xl font-black text-slate-800 tracking-tight">Tugas & Fungsi</h3>
                <p class="text-slate-500 mt-4 max-w-2xl mx-auto font-medium text-lg">Sesuai dengan peraturan perundang-undangan yang berlaku dalam sistem Pemasyarakatan.</p>
                <div class="w-24 h-1.5 bg-gradient-to-r from-blue-400 to-blue-600 mx-auto rounded-full mt-6"></div>
            </div>

            <div class="bg-white border-2 border-slate-100 rounded-[3rem] p-10 md:p-16 shadow-[0_20px_50px_-20px_rgba(0,0,0,0.1)] relative overflow-hidden group">
                <div class="absolute inset-0 bg-[url('data:image/svg+xml,%3Csvg width=\'40\' height=\'40\' viewBox=\'0 0 40 40\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cpath d=\'M20 20.5V18H0v-2h20v-2H0v-2h20v-2H0V8h20V6H0V4h20V2H0V0h22v20h2V0h2v20h2V0h2v20h2V0h2v20h2V0h2v20h2v2H20v-1.5zM0 20h2v20H0V20zm4 0h2v20H4V20zm4 0h2v20H8V20zm4 0h2v20h-2V20zm4 0h2v20h-2V20zm4 4h20v2H20v-2zm0 4h20v2H20v-2zm0 4h20v2H20v-2zm0 4h20v2H20v-2z\' fill=\'%23f1f5f9\' fill-opacity=\'0.4\' fill-rule=\'evenodd\'/%3E%3C/svg%3E')]"></div>
                <div class="relative z-10 institutional-content premium-text">
                    {!! $institutional['tugas_fungsi'] ?? 'Melaksanakan pemasyarakatan narapidana / anak didik.' !!}
                </div>
            </div>
        </div>

        {{-- Hak & Kewajiban WBP --}}
        <div class="mt-24 mb-10" data-aos="fade-up">
            <div class="text-center mb-12">
                <span class="inline-block px-4 py-1.5 rounded-full bg-rose-50 text-rose-600 text-xs font-black uppercase tracking-widest border border-rose-100 mb-4">Informasi Publik</span>
                <h3 class="text-4xl md:text-5xl font-black text-slate-800 tracking-tight">Hak & Kewajiban WBP</h3>
                <p class="text-slate-500 mt-4 max-w-2xl mx-auto font-medium text-lg">Informasi resmi mengenai hak dan kewajiban Warga Binaan Pemasyarakatan (WBP) selama menjalani masa pidana.</p>
                <div class="w-24 h-1.5 bg-gradient-to-r from-rose-400 to-rose-600 mx-auto rounded-full mt-6"></div>
            </div>

            <div class="bg-gradient-to-b from-white to-slate-50 border border-slate-200 rounded-[3rem] p-10 md:p-16 shadow-[0_20px_50px_-20px_rgba(0,0,0,0.1)] institutional-content premium-rights-list relative overflow-hidden">
                <div class="absolute -bottom-40 -left-40 w-96 h-96 bg-rose-500/5 rounded-full blur-3xl pointer-events-none"></div>
                <div class="absolute -top-40 -right-40 w-96 h-96 bg-emerald-500/5 rounded-full blur-3xl pointer-events-none"></div>
                
                <div class="relative z-10">
                    {!! $institutional['hak_kewajiban'] ?? 'Informasi hak dan kewajiban WBP.' !!}
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