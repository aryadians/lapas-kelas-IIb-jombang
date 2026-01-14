@extends('layouts.main')

@section('content')

@php
    // DATA DUMMY (Sama seperti sebelumnya)
    $level2 = [
        ['nama' => '[Nama Pejabat]', 'jabatan' => 'Ka. KPLP', 'seksi' => 'Kesatuan Pengamanan Lapas'],
        ['nama' => '[Nama Pejabat]', 'jabatan' => 'Kasubag Tata Usaha', 'seksi' => 'Sub Bagian Tata Usaha'],
        ['nama' => 'Rd Epa Fatimah', 'jabatan' => 'Kasi Binadik & Giatja', 'seksi' => 'Bimbingan & Kegiatan Kerja'],
        ['nama' => '[Nama Pejabat]', 'jabatan' => 'Kasi Adm. Kamtib', 'seksi' => 'Administrasi Keamanan & Tata Tertib'],
    ];

    $level3 = [
        ['nama' => '[Nama Pejabat]', 'jabatan' => 'Kaur Kepeg & Keu'],
        ['nama' => '[Nama Pejabat]', 'jabatan' => 'Kaur Umum'],
        ['nama' => '[Nama Pejabat]', 'jabatan' => 'Kasubsi Registrasi'],
        ['nama' => '[Nama Pejabat]', 'jabatan' => 'Kasubsi Bimkemaswat'],
        ['nama' => '[Nama Pejabat]', 'jabatan' => 'Kasubsi Binker'],
        ['nama' => '[Nama Pejabat]', 'jabatan' => 'Kasubsi PHK'],
        ['nama' => '[Nama Pejabat]', 'jabatan' => 'Kasubsi Portatib'],
        ['nama' => '[Nama Pejabat]', 'jabatan' => 'Kasubsi Keamanan'],
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
    </style>
@endpush
{{-- ================================================================= --}}
{{-- 1. HEADER DENGAN ANIMASI --}}
{{-- ================================================================= --}}
{{-- PERBAIKAN: Menambahkan 'pb-44' dan 'pt-32' agar header lebih tinggi dan teks tidak ketutupan --}}
<section class="relative bg-gradient-to-br from-slate-900 via-blue-900 to-slate-900 text-white min-h-[60vh] flex items-center justify-center overflow-hidden pb-44 pt-32">
    
    {{-- Background Pattern (Titik-titik SVG) --}}
    <div class="absolute inset-0 z-0">
        <div class="absolute inset-0 bg-[url('data:image/svg+xml,%3Csvg width=\'60\' height=\'60\' viewBox=\'0 0 60 60\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cg fill=\'none\' fill-rule=\'evenodd\'%3E%3Cg fill=\'%23ffffff\' fill-opacity=\'0.05\'%3E%3Ccircle cx=\'30\' cy=\'30\' r=\'2\'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E')] opacity-30"></div>
        <div class="absolute inset-0 bg-gradient-to-b from-slate-900/50 via-blue-900/50 to-slate-900/90"></div>
    </div>

    {{-- Floating Elements (Bola-bola Cahaya) --}}
    <div class="absolute top-20 left-10 w-32 h-32 bg-blue-500/20 rounded-full blur-3xl animate-pulse"></div>
    <div class="absolute bottom-20 right-10 w-40 h-40 bg-yellow-500/10 rounded-full blur-3xl animate-pulse" style="animation-delay: 1.5s;"></div>

    {{-- Content --}}
    <div class="container mx-auto px-6 text-center relative z-10" data-aos="fade-down">
        
        {{-- Badge Kecil --}}
        <div class="inline-flex items-center px-4 py-2 rounded-full bg-white/5 backdrop-blur-md border border-white/10 text-sm font-semibold mb-6 text-blue-200">
            <i class="fas fa-sitemap mr-2"></i>
            Struktur Organisasi
        </div>

        {{-- Judul dengan Animasi Shimmer --}}
        <h1 class="text-4xl md:text-6xl font-black mb-6 tracking-tight leading-tight">
            Susunan <span class="text-transparent bg-clip-text bg-gradient-to-r from-yellow-300 via-white to-yellow-300 animate-text-shimmer">Pimpinan</span>
        </h1>
        
        <p class="text-xl text-slate-300 max-w-2xl mx-auto leading-relaxed">
            Mengenal jajaran pejabat struktural yang berdedikasi dalam pelayanan dan pembinaan di Lapas Kelas IIB Jombang.
        </p>
    </div>
</section>

{{-- ================================================================= --}}
{{-- 2. KEPALA LAPAS (FOTO ASLI) --}}
{{-- ================================================================= --}}
<section class="relative z-20 -mt-20 pb-12">
    <div class="container mx-auto px-6">
        <div class="max-w-4xl mx-auto">
            <div class="bg-white rounded-[2.5rem] shadow-2xl p-8 border border-slate-100 flex flex-col md:flex-row items-center gap-8 relative overflow-hidden" data-aos="zoom-in">
                
                {{-- Background Deco --}}
                <div class="absolute top-0 right-0 w-64 h-64 bg-blue-50/50 rounded-full -mr-20 -mt-20 blur-3xl"></div>

                {{-- Foto Wrapper --}}
                <div class="relative group cursor-pointer swing-trigger-foto flex-shrink-0" 
                     data-nama="Rino Soleh Sumitro" 
                     data-jabatan="Kepala Lapas Kelas IIB Jombang"
                     data-img="{{ asset('img/kalapas.png') }}">
                    <div class="w-48 h-48 md:w-56 md:h-56 rounded-full p-1.5 bg-gradient-to-br from-yellow-400 via-yellow-200 to-blue-600 shadow-2xl animate-spin-slow-stop">
                        <img src="{{ asset('img/kalapas.png') }}" alt="Kalapas" class="w-full h-full object-cover rounded-full border-4 border-white">
                    </div>
                    {{-- Crown Icon --}}
                    <div class="absolute bottom-2 right-2 bg-white text-yellow-500 w-12 h-12 flex items-center justify-center rounded-full shadow-lg text-xl border-2 border-slate-50">
                        <i class="fas fa-crown"></i>
                    </div>
                </div>

                {{-- Info --}}
                <div class="text-center md:text-left flex-1 relative z-10">
                    <div class="inline-block px-3 py-1 bg-blue-50 text-blue-600 rounded-lg text-xs font-bold tracking-widest uppercase mb-3 border border-blue-100">
                        Pimpinan Tertinggi
                    </div>
                    <h2 class="text-3xl md:text-4xl font-black text-slate-900 mb-1">Rino Soleh Sumitro</h2>
                    <p class="text-lg text-slate-500 font-medium mb-5">Kepala Lapas Kelas IIB Jombang</p>
                    <div class="relative">
                        <i class="fas fa-quote-left text-3xl text-slate-100 absolute -top-4 -left-2"></i>
                        <p class="text-slate-600 italic leading-relaxed pl-6 relative z-10">
                            "Melayani dengan Hati, Berintegritas, dan Profesional demi mewujudkan pemasyarakatan yang maju."
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ================================================================= --}}
{{-- 3. PEJABAT STRUKTURAL (ICON ORANG SERAGAM) --}}
{{-- ================================================================= --}}
<section class="py-16 bg-slate-50 min-h-screen">
    <div class="container mx-auto px-6">
        
        {{-- LEVEL 2: PEJABAT MENENGAH --}}
        <div class="mb-20">
            <div class="text-center mb-10" data-aos="fade-up">
                <span class="bg-blue-100 text-blue-700 text-xs font-bold px-3 py-1 rounded-full uppercase tracking-wider">Eselon IV</span>
                <h3 class="text-2xl font-bold text-slate-800 mt-2">Pejabat Struktural Utama</h3>
                <div class="w-20 h-1 bg-blue-500 mx-auto rounded-full mt-3"></div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach ($level2 as $i => $p)
                <div class="card-pro card-level-2 rounded-2xl p-6 text-center cursor-pointer swing-trigger-icon"
                     data-nama="{{ $p['nama'] }}" 
                     data-jabatan="{{ $p['jabatan'] }}"
                     data-level="utama"
                     data-aos="fade-up" 
                     data-aos-delay="{{ $i * 100 }}">
                    
                    <div class="icon-circle w-20 h-20 mx-auto mb-5 rounded-full bg-slate-100 flex items-center justify-center text-slate-400 shadow-inner">
                        <i class="fas fa-user-tie text-3xl"></i>
                    </div>

                    <h4 class="text-lg font-bold text-slate-800 mb-1">{{ $p['nama'] }}</h4>
                    <div class="h-px w-10 bg-blue-500 mx-auto my-3 opacity-30"></div>
                    <p class="text-blue-700 font-bold text-sm uppercase">{{ $p['jabatan'] }}</p>
                    <p class="text-slate-400 text-xs mt-1">{{ $p['seksi'] }}</p>
                </div>
                @endforeach
            </div>
        </div>

        {{-- LEVEL 3: PEJABAT PENGAWAS --}}
        <div>
            <div class="text-center mb-10" data-aos="fade-up">
                <span class="bg-slate-200 text-slate-600 text-xs font-bold px-3 py-1 rounded-full uppercase tracking-wider">Eselon V</span>
                <h3 class="text-2xl font-bold text-slate-800 mt-2">Pejabat Pengawas & Pelaksana</h3>
                 <div class="w-20 h-1 bg-slate-400 mx-auto rounded-full mt-3"></div>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-5">
                @foreach ($level3 as $i => $p)
                <div class="card-pro card-level-3 rounded-xl p-5 text-center cursor-pointer swing-trigger-icon"
                     data-nama="{{ $p['nama'] }}" 
                     data-jabatan="{{ $p['jabatan'] }}"
                     data-level="madya"
                     data-aos="zoom-in" 
                     data-aos-delay="{{ $i * 50 }}">
                    
                    <div class="icon-circle w-14 h-14 mx-auto mb-3 rounded-full bg-slate-50 border border-slate-100 flex items-center justify-center text-slate-400">
                        <i class="fas fa-user text-xl"></i>
                    </div>

                    <h5 class="font-bold text-slate-800 text-sm mb-1 line-clamp-1">{{ $p['nama'] }}</h5>
                    <p class="text-slate-500 font-semibold text-xs uppercase tracking-wide">{{ $p['jabatan'] }}</p>
                </div>
                @endforeach
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