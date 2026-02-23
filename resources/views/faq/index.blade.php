@extends('layouts.main')

@section('content')

@push('styles')
    {{-- ANIMASI & STYLE LIBRARIES --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    {{-- SweetAlert2 CSS --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    {{-- Font Awesome for Icons --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    
    <style>
        /* --- 1. ANIMASI TEXT SHIMMER (Kilauan Teks) --- */
        @keyframes text-shimmer {
            0% { background-position: -200% center; }
            100% { background-position: 200% center; }
        }
        .animate-text-shimmer {
            background-size: 200% auto;
            animation: text-shimmer 3s linear infinite;
        }

        @keyframes pulse-subtle {
            0% { transform: scale(1) translateZ(25px); }
            50% { transform: scale(1.02) translateZ(25px); }
            100% { transform: scale(1) translateZ(25px); }
        }

        /* --- 2. FAQ CARD STYLING & 3D EFFECT --- */
        .faq-list-container {
            perspective: 1000px; /* Jarak pandang 3D */
        }

        .faq-card {
            background: #ffffff;
            border: 1px solid #f1f5f9;
            transition: all 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275); /* Bouncy transition */
            position: relative;
            overflow: hidden;
            transform-style: preserve-3d; /* Enable 3D space */
            transform: translateZ(0);
            border-radius: 1rem;
        }
        
        /* Efek Hover Umum: Naik, Miring, dan Bayangan Tebal */
        .faq-card:hover {
            transform: translateY(-10px) rotateX(2deg) scale(1.02);
            z-index: 10;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
        }

        /* Warna-warni Hover per Card (diatur via CSS class di HTML nanti atau inline style) */
        .faq-card.hover-blue:hover { border-color: #3b82f6; box-shadow: 0 20px 40px -10px rgba(59, 130, 246, 0.3); }
        .faq-card.hover-cyan:hover { border-color: #06b6d4; box-shadow: 0 20px 40px -10px rgba(6, 182, 212, 0.3); }
        .faq-card.hover-orange:hover { border-color: #f97316; box-shadow: 0 20px 40px -10px rgba(249, 115, 22, 0.3); }
        .faq-card.hover-purple:hover { border-color: #a855f7; box-shadow: 0 20px 40px -10px rgba(168, 85, 247, 0.3); }
        .faq-card.hover-red:hover { border-color: #ef4444; box-shadow: 0 20px 40px -10px rgba(239, 68, 68, 0.3); }
        .faq-card.hover-indigo:hover { border-color: #6366f1; box-shadow: 0 20px 40px -10px rgba(99, 102, 241, 0.3); }
        .faq-card.hover-rose:hover { border-color: #f43f5e; box-shadow: 0 20px 40px -10px rgba(244, 63, 94, 0.3); }
        .faq-card.hover-teal:hover { border-color: #14b8a6; box-shadow: 0 20px 40px -10px rgba(20, 184, 166, 0.3); }

        .faq-icon-box {
            transition: all 0.4s ease;
            transform-style: preserve-3d;
        }
        .faq-card:hover .faq-icon-box {
            transform: scale(1.1) rotate(10deg);
        }

        /* --- 3. CUSTOM SCROLLBAR --- */
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }

        /* --- 4. BLOB ANIMATION (for Hero Section) --- */
        @keyframes blob {
            0%, 100% { transform: scale(1) translate(0, 0); }
            33% { transform: scale(1.1) translate(30px, -20px); }
            66% { transform: scale(0.9) translate(-20px, 30px); }
        }
        .animate-blob {
            animation: blob 7s infinite cubic-bezier(0.6, 0.01, 0.3, 0.95);
        }

        .animation-delay-2000 { animation-delay: 2s; }
        .animation-delay-4000 { animation-delay: 4s; }
        .animation-delay-6000 { animation-delay: 6s; }

        /* --- 5. Custom Pulse Animation for Buttons --- */
        @keyframes pulse-light {
            0%, 100% { transform: scale(1); box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1); }
            50% { transform: scale(1.05); box-shadow: 0 10px 15px -3px rgba(0,0,0,0.2); }
        }
        .animate-pulse-light {
            animation: pulse-light 2s infinite ease-in-out;
        }
        
        /* 3D Text Effect */
        .hero-text-3d {
            text-shadow: 0 10px 30px rgba(0,0,0,0.5);
            transform: translateZ(50px);
        }
    </style>
@endpush

{{-- ================================================================= --}}
{{-- 1. HERO SECTION (HEADER) --}}
{{-- ================================================================= --}}
<section class="relative bg-gradient-to-br from-slate-900 via-blue-950 to-slate-900 text-white min-h-[50vh] flex items-center justify-center overflow-hidden pt-36 pb-24 perspective-1000">
    
    {{-- 3D Canvas Background --}}
    <canvas id="hero-3d-canvas" class="absolute inset-0 w-full h-full z-0 opacity-40"></canvas>

    {{-- Background Pattern --}}
    <div class="absolute inset-0 z-10 pointer-events-none">
        <div class="absolute inset-0 bg-[url('data:image/svg+xml,%3Csvg width=\'60\' height=\'60\' viewBox=\'0 0 60 60\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cg fill=\'none\' fill-rule=\'evenodd\'%3E%3Cg fill=\'%23ffffff\' fill-opacity=\'0.05\'%3E%3Ccircle cx=\'30\' cy=\'30\' r=\'2\'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E')] opacity-30"></div>
        <div class="absolute inset-0 bg-gradient-to-b from-transparent via-blue-900/40 to-slate-900/95"></div>
    </div>

    {{-- Floating Blobs --}}
    <div class="absolute inset-0 flex items-center justify-center z-10 pointer-events-none">
        <div class="w-72 h-72 bg-purple-600/30 rounded-full blur-[100px] animate-blob animation-delay-4000 mix-blend-screen"></div>
        <div class="w-80 h-80 bg-cyan-500/30 rounded-full blur-[100px] animate-blob animation-delay-2000 mix-blend-screen"></div>
        <div class="w-96 h-96 bg-blue-600/30 rounded-full blur-[100px] animate-blob animation-delay-6000 mix-blend-screen"></div>
    </div>

    <div class="container mx-auto px-6 text-center relative z-30" data-aos="zoom-in" data-aos-duration="1000">
        
        {{-- Badge --}}
        <div class="inline-flex items-center px-5 py-2.5 rounded-full bg-white/5 backdrop-blur-lg border border-white/20 text-cyan-300 text-sm font-bold mb-10 shadow-[0_0_20px_rgba(6,182,212,0.3)] hover:scale-105 transition-transform duration-300">
            <i class="fas fa-life-ring mr-2 animate-bounce"></i>
            Pusat Bantuan & Informasi
        </div>

        {{-- Title dengan Animasi Shimmer --}}
        <h1 class="hero-text-3d text-5xl md:text-7xl font-black mb-6 tracking-tight leading-tight drop-shadow-[0_10px_20px_rgba(0,0,0,0.8)]">
            Pertanyaan <span class="text-transparent bg-clip-text bg-gradient-to-r from-cyan-400 via-white to-blue-500 animate-text-shimmer">Umum</span>
        </h1>
        
        <p class="hero-text-3d text-xl md:text-2xl text-slate-300 max-w-3xl mx-auto leading-relaxed font-light drop-shadow-md">
            Temukan jawaban instan seputar alur pendaftaran, jadwal layanan, dan tata tertib kunjungan di Lapas Kelas IIB Jombang.
        </p>
    </div>
</section>

{{-- ================================================================= --}}
{{-- 2. FAQ LIST SECTION --}}
{{-- ================================================================= --}}
<section class="py-24 bg-slate-50 min-h-screen relative">
    
    <div class="absolute top-0 left-0 w-full h-40 bg-gradient-to-b from-slate-900 to-slate-50 z-0 opacity-10"></div>

    <div class="container mx-auto px-6 max-w-4xl relative z-10">
        
        {{-- Section Intro --}}
        <div class="text-center mb-16" data-aos="fade-up">
            <h2 class="text-3xl md:text-4xl font-bold text-slate-800 mb-4 flex items-center justify-center gap-3">
                <span class="text-blue-600 bg-blue-100 p-2 rounded-lg shadow-sm"><i class="fas fa-comments"></i></span> Yang Sering Ditanyakan
            </h2>
            <div class="h-1.5 w-24 bg-gradient-to-r from-blue-500 via-cyan-400 to-blue-500 mx-auto rounded-full shadow-sm animate-pulse"></div>
        </div>

        {{-- FAQ List Container --}}
        <div class="space-y-6 faq-list-container">

            {{-- Item 1: Sistem Online (BLUE) --}}
            <div x-data="{ open: false }" 
                 :class="open ? 'border-l-4 border-l-blue-500 shadow-2xl scale-[1.02]' : 'hover:scale-[1.01]'"
                 class="faq-card hover-blue bg-white rounded-2xl overflow-hidden group" 
                 data-aos="fade-up" data-aos-delay="100">
                
                <button @click="open = !open; if(open) showSwingAlert('Info', 'Tentang pendaftaran online')" 
                        class="w-full flex justify-between items-center p-6 text-left focus:outline-none hover:bg-slate-50 transition-colors duration-300">
                    <div class="flex items-center gap-5">
                        <div class="faq-icon-box w-14 h-14 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center shrink-0 shadow-md group-hover:bg-blue-600 group-hover:text-white border border-blue-100">
                            <i class="fas fa-globe text-2xl"></i>
                        </div>
                        <span class="text-lg font-bold text-slate-700 group-hover:text-blue-600 transition-colors">Apa itu sistem pendaftaran kunjungan online?</span>
                    </div>
                    <div class="w-10 h-10 rounded-full bg-slate-100 flex items-center justify-center text-slate-400 transition-all duration-300 group-hover:bg-white group-hover:shadow-md" 
                         :class="{'rotate-180 bg-blue-100 text-blue-600 shadow-md': open}">
                        <i class="fas fa-chevron-down"></i>
                    </div>
                </button>

                <div x-show="open" x-collapse
                     class="border-t border-slate-100 bg-gradient-to-b from-slate-50/50 to-white">
                    <div class="p-6 pl-[5.5rem] text-slate-600 leading-relaxed text-base">
                        Sistem pendaftaran kunjungan online adalah platform digital inovatif yang memungkinkan Anda mendaftar kunjungan ke Lapas Kelas IIB Jombang secara praktis dari mana saja. Tujuannya untuk mengurangi antrian fisik dan mempercepat proses verifikasi data pengunjung.
                    </div>
                </div>
            </div>

            {{-- Item 2: Cara Daftar (CYAN) --}}
            <div x-data="{ open: false }" 
                 :class="open ? 'border-l-4 border-l-cyan-500 shadow-2xl scale-[1.02]' : 'hover:scale-[1.01]'"
                 class="faq-card hover-cyan bg-white rounded-2xl overflow-hidden group" 
                 data-aos="fade-up" data-aos-delay="200">
                
                <button @click="open = !open; if(open) showSwingAlert('Panduan', 'Cara daftar kunjungan')" 
                        class="w-full flex justify-between items-center p-6 text-left focus:outline-none hover:bg-slate-50 transition-colors duration-300">
                    <div class="flex items-center gap-5">
                        <div class="faq-icon-box w-14 h-14 rounded-2xl bg-cyan-50 text-cyan-600 flex items-center justify-center shrink-0 shadow-md group-hover:bg-cyan-500 group-hover:text-white border border-cyan-100">
                            <i class="fas fa-desktop text-2xl"></i>
                        </div>
                        <span class="text-lg font-bold text-slate-700 group-hover:text-cyan-600 transition-colors">Bagaimana cara mendaftar kunjungan?</span>
                    </div>
                    <div class="w-10 h-10 rounded-full bg-slate-100 flex items-center justify-center text-slate-400 transition-all duration-300 group-hover:bg-white group-hover:shadow-md" 
                         :class="{'rotate-180 bg-cyan-100 text-cyan-600 shadow-md': open}">
                        <i class="fas fa-chevron-down"></i>
                    </div>
                </button>

                <div x-show="open" x-collapse
                     class="border-t border-slate-100 bg-gradient-to-b from-slate-50/50 to-white">
                    <div class="p-6 pl-[5.5rem] text-slate-600 leading-relaxed text-base">
                        <ol class="list-decimal pl-5 space-y-2 marker:text-cyan-600 marker:font-bold">
                            <li>Buka menu <strong>"Daftar Kunjungan"</strong> di website ini.</li>
                            <li>Isi formulir data diri pengunjung dan data warga binaan yang dituju.</li>
                            <li>Pilih tanggal dan sesi kunjungan yang tersedia.</li>
                            <li>Kirim pendaftaran dan tunggu konfirmasi melalui email atau cek status secara berkala.</li>
                        </ol>
                    </div>
                </div>
            </div>

            {{-- Item 3: Syarat Dokumen (ORANGE) --}}
            <div x-data="{ open: false }" 
                 :class="open ? 'border-l-4 border-l-orange-500 shadow-2xl scale-[1.02]' : 'hover:scale-[1.01]'"
                 class="faq-card hover-orange bg-white rounded-2xl overflow-hidden group" 
                 data-aos="fade-up" data-aos-delay="300">
                
                <button @click="open = !open; if(open) showSwingAlert('Syarat', 'Dokumen yang diperlukan')" 
                        class="w-full flex justify-between items-center p-6 text-left focus:outline-none hover:bg-slate-50 transition-colors duration-300">
                    <div class="flex items-center gap-5">
                        <div class="faq-icon-box w-14 h-14 rounded-2xl bg-orange-50 text-orange-600 flex items-center justify-center shrink-0 shadow-md group-hover:bg-orange-500 group-hover:text-white border border-orange-100">
                            <i class="fas fa-id-card text-2xl"></i>
                        </div>
                        <span class="text-lg font-bold text-slate-700 group-hover:text-orange-600 transition-colors">Dokumen apa saja yang wajib dibawa?</span>
                    </div>
                    <div class="w-10 h-10 rounded-full bg-slate-100 flex items-center justify-center text-slate-400 transition-all duration-300 group-hover:bg-white group-hover:shadow-md" 
                         :class="{'rotate-180 bg-orange-100 text-orange-600 shadow-md': open}">
                        <i class="fas fa-chevron-down"></i>
                    </div>
                </button>

                <div x-show="open" x-collapse
                     class="border-t border-slate-100 bg-gradient-to-b from-slate-50/50 to-white">
                    <div class="p-6 pl-[5.5rem] text-slate-600 leading-relaxed text-base">
                        Pengunjung wajib membawa dokumen asli berikut saat datang ke Lapas:
                        <ul class="list-none mt-3 space-y-2">
                            <li class="flex items-center gap-2"><i class="fas fa-check-circle text-orange-500"></i> Kartu Identitas Asli (KTP/SIM/Paspor) yang masih berlaku.</li>
                            <li class="flex items-center gap-2"><i class="fas fa-check-circle text-orange-500"></i> Bukti Pendaftaran Online (QR Code/Tiket).</li>
                            <li class="flex items-center gap-2"><i class="fas fa-check-circle text-orange-500"></i> Kartu Keluarga (jika mengunjungi keluarga inti).</li>
                            <li class="flex items-center gap-2"><i class="fas fa-tshirt text-orange-500"></i> Berpakaian sopan dan rapi (No celana pendek/kaos oblong).</li>
                        </ul>
                    </div>
                </div>
            </div>

            {{-- Item 4: Maksimal Pengunjung (PURPLE) --}}
            <div x-data="{ open: false }" 
                 :class="open ? 'border-l-4 border-l-purple-500 shadow-2xl scale-[1.02]' : 'hover:scale-[1.01]'"
                 class="faq-card hover-purple bg-white rounded-2xl overflow-hidden group" 
                 data-aos="fade-up" data-aos-delay="400">
                
                <button @click="open = !open; if(open) showSwingAlert('Aturan', 'Maksimal 4 orang')" 
                        class="w-full flex justify-between items-center p-6 text-left focus:outline-none hover:bg-slate-50 transition-colors duration-300">
                    <div class="flex items-center gap-5">
                        <div class="faq-icon-box w-14 h-14 rounded-2xl bg-purple-50 text-purple-600 flex items-center justify-center shrink-0 shadow-md group-hover:bg-purple-600 group-hover:text-white border border-purple-100">
                            <i class="fas fa-users text-2xl"></i>
                        </div>
                        <span class="text-lg font-bold text-slate-700 group-hover:text-purple-600 transition-colors">Berapa maksimal jumlah pengikut?</span>
                    </div>
                    <div class="w-10 h-10 rounded-full bg-slate-100 flex items-center justify-center text-slate-400 transition-all duration-300 group-hover:bg-white group-hover:shadow-md" 
                         :class="{'rotate-180 bg-purple-100 text-purple-600 shadow-md': open}">
                        <i class="fas fa-chevron-down"></i>
                    </div>
                </button>

                <div x-show="open" x-collapse
                     class="border-t border-slate-100 bg-gradient-to-b from-slate-50/50 to-white">
                    <div class="p-6 pl-[5.5rem] text-slate-600 leading-relaxed text-base">
                        Demi ketertiban dan kenyamanan, jumlah pengunjung dibatasi maksimal <strong class="text-purple-600 bg-purple-50 px-1 rounded">4 orang (dewasa)</strong> untuk satu kali kunjungan per Warga Binaan. Anak-anak di bawah umur tetap dihitung namun mendapat prioritas kenyamanan.
                    </div>
                </div>
            </div>

             {{-- Item 5: Barang Terlarang (RED) --}}
             <div x-data="{ open: false }" 
                  :class="open ? 'border-l-4 border-l-red-500 shadow-2xl scale-[1.02]' : 'hover:scale-[1.01]'"
                  class="faq-card hover-red bg-white rounded-2xl overflow-hidden group" 
                  data-aos="fade-up" data-aos-delay="500">
                
                <button @click="open = !open; if(open) showSwingAlert('Peringatan', 'Barang terlarang!')" 
                        class="w-full flex justify-between items-center p-6 text-left focus:outline-none hover:bg-slate-50 transition-colors duration-300">
                    <div class="flex items-center gap-5">
                        <div class="faq-icon-box w-14 h-14 rounded-2xl bg-red-50 text-red-600 flex items-center justify-center shrink-0 shadow-md group-hover:bg-red-600 group-hover:text-white border border-red-100">
                            <i class="fas fa-ban text-2xl"></i>
                        </div>
                        <span class="text-lg font-bold text-slate-700 group-hover:text-red-600 transition-colors">Apa saja barang yang dilarang dibawa?</span>
                    </div>
                    <div class="w-10 h-10 rounded-full bg-slate-100 flex items-center justify-center text-slate-400 transition-all duration-300 group-hover:bg-white group-hover:shadow-md" 
                         :class="{'rotate-180 bg-red-100 text-red-600 shadow-md': open}">
                        <i class="fas fa-chevron-down"></i>
                    </div>
                </button>

                <div x-show="open" x-collapse
                     class="border-t border-slate-100 bg-gradient-to-b from-slate-50/50 to-white">
                    <div class="p-6 pl-[5.5rem] text-slate-600 leading-relaxed text-base">
                        <p class="mb-3 text-red-600 font-bold uppercase tracking-wider text-xs">DILARANG KERAS MEMBAWA:</p>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-3 text-sm">
                            <div class="flex items-center gap-2 bg-red-50 p-2 rounded border border-red-100 text-red-700 font-medium">
                                <i class="fas fa-times-circle"></i> Narkoba & Obat Terlarang
                            </div>
                            <div class="flex items-center gap-2 bg-red-50 p-2 rounded border border-red-100 text-red-700 font-medium">
                                <i class="fas fa-times-circle"></i> Senjata Tajam / Api
                            </div>
                            <div class="flex items-center gap-2 bg-red-50 p-2 rounded border border-red-100 text-red-700 font-medium">
                                <i class="fas fa-times-circle"></i> Handphone / Kamera
                            </div>
                            <div class="flex items-center gap-2 bg-red-50 p-2 rounded border border-red-100 text-red-700 font-medium">
                                <i class="fas fa-times-circle"></i> Minuman Beralkohol
                            </div>
                        </div>
                        <p class="mt-4 text-xs text-slate-400 italic flex items-center gap-1">
                            <i class="fas fa-info-circle"></i> *Semua barang bawaan akan diperiksa secara ketat oleh petugas.
                        </p>
                    </div>
                </div>
            </div>

            {{-- Item 6: Verifikasi (INDIGO) --}}
            <div x-data="{ open: false }" 
                 :class="open ? 'border-l-4 border-l-indigo-500 shadow-2xl scale-[1.02]' : 'hover:scale-[1.01]'"
                 class="faq-card hover-indigo bg-white rounded-2xl overflow-hidden group" 
                 data-aos="fade-up" data-aos-delay="600">
                
                <button @click="open = !open; if(open) showSwingAlert('Verifikasi', 'Proses verifikasi kunjungan')" 
                        class="w-full flex justify-between items-center p-6 text-left focus:outline-none hover:bg-slate-50 transition-colors duration-300">
                    <div class="flex items-center gap-5">
                        <div class="faq-icon-box w-14 h-14 rounded-2xl bg-indigo-50 text-indigo-600 flex items-center justify-center shrink-0 shadow-md group-hover:bg-indigo-600 group-hover:text-white border border-indigo-100">
                            <i class="fas fa-check-double text-2xl"></i>
                        </div>
                        <span class="text-lg font-bold text-slate-700 group-hover:text-indigo-600 transition-colors">Berapa lama proses verifikasi kunjungan?</span>
                    </div>
                    <div class="w-10 h-10 rounded-full bg-slate-100 flex items-center justify-center text-slate-400 transition-all duration-300 group-hover:bg-white group-hover:shadow-md" 
                         :class="{'rotate-180 bg-indigo-100 text-indigo-600 shadow-md': open}">
                        <i class="fas fa-chevron-down"></i>
                    </div>
                </button>

                <div x-show="open" x-collapse
                     class="border-t border-slate-100 bg-gradient-to-b from-slate-50/50 to-white">
                    <div class="p-6 pl-[5.5rem] text-slate-600 leading-relaxed text-base">
                        Proses verifikasi dokumen di loket pendaftaran memakan waktu sekitar <strong class="text-indigo-600">5-10 menit</strong>. Namun, kami sarankan datang 15 menit sebelum sesi kunjungan dimulai untuk menghindari antrian panjang.
                    </div>
                </div>
            </div>

            {{-- Item 7: Pembatalan (ROSE) --}}
            <div x-data="{ open: false }" 
                 :class="open ? 'border-l-4 border-l-rose-500 shadow-2xl scale-[1.02]' : 'hover:scale-[1.01]'"
                 class="faq-card hover-rose bg-white rounded-2xl overflow-hidden group" 
                 data-aos="fade-up" data-aos-delay="700">
                
                <button @click="open = !open; if(open) showSwingAlert('Pembatalan', 'Hubungi Admin')" 
                        class="w-full flex justify-between items-center p-6 text-left focus:outline-none hover:bg-slate-50 transition-colors duration-300">
                    <div class="flex items-center gap-5">
                        <div class="faq-icon-box w-14 h-14 rounded-2xl bg-rose-50 text-rose-600 flex items-center justify-center shrink-0 shadow-md group-hover:bg-rose-600 group-hover:text-white border border-rose-100">
                            <i class="fas fa-calendar-times text-2xl"></i>
                        </div>
                        <span class="text-lg font-bold text-slate-700 group-hover:text-rose-600 transition-colors">Bisakah membatalkan atau mengubah jadwal kunjungan?</span>
                    </div>
                    <div class="w-10 h-10 rounded-full bg-slate-100 flex items-center justify-center text-slate-400 transition-all duration-300 group-hover:bg-white group-hover:shadow-md" 
                         :class="{'rotate-180 bg-rose-100 text-rose-600 shadow-md': open}">
                        <i class="fas fa-chevron-down"></i>
                    </div>
                </button>

                <div x-show="open" x-collapse
                     class="border-t border-slate-100 bg-gradient-to-b from-slate-50/50 to-white">
                    <div class="p-6 pl-[5.5rem] text-slate-600 leading-relaxed text-base">
                        Bisa, namun harus dikonfirmasi minimal <strong>H-1</strong> sebelum jadwal kunjungan. Silakan hubungi nomor layanan kami untuk proses pembatalan atau penjadwalan ulang agar kuota bisa dialihkan ke pengunjung lain.
                    </div>
                </div>
            </div>

            {{-- Item 8: Jam Layanan (TEAL) --}}
            <div x-data="{ open: false }" 
                 :class="open ? 'border-l-4 border-l-teal-500 shadow-2xl scale-[1.02]' : 'hover:scale-[1.01]'"
                 class="faq-card hover-teal bg-white rounded-2xl overflow-hidden group" 
                 data-aos="fade-up" data-aos-delay="800">
                
                <button @click="open = !open; if(open) showSwingAlert('Waktu', 'Senin - Sabtu')" 
                        class="w-full flex justify-between items-center p-6 text-left focus:outline-none hover:bg-slate-50 transition-colors duration-300">
                    <div class="flex items-center gap-5">
                        <div class="faq-icon-box w-14 h-14 rounded-2xl bg-teal-50 text-teal-600 flex items-center justify-center shrink-0 shadow-md group-hover:bg-teal-600 group-hover:text-white border border-teal-100">
                            <i class="fas fa-clock text-2xl"></i>
                        </div>
                        <span class="text-lg font-bold text-slate-700 group-hover:text-teal-600 transition-colors">Kapan jam layanan kunjungan?</span>
                    </div>
                    <div class="w-10 h-10 rounded-full bg-slate-100 flex items-center justify-center text-slate-400 transition-all duration-300 group-hover:bg-white group-hover:shadow-md" 
                         :class="{'rotate-180 bg-teal-100 text-teal-600 shadow-md': open}">
                        <i class="fas fa-chevron-down"></i>
                    </div>
                </button>

                <div x-show="open" x-collapse
                     class="border-t border-slate-100 bg-gradient-to-b from-slate-50/50 to-white">
                    <div class="p-6 pl-[5.5rem] text-slate-600 leading-relaxed text-base">
                        Layanan kunjungan tatap muka tersedia setiap hari <strong>Senin - Sabtu</strong>.
                        <div class="mt-2 grid grid-cols-2 gap-2 max-w-xs">
                            <div class="bg-teal-50 text-teal-700 px-3 py-1 rounded text-sm text-center border border-teal-100">
                                <strong>Sesi Pagi</strong><br>08.30 - 11.30
                            </div>
                            <div class="bg-teal-50 text-teal-700 px-3 py-1 rounded text-sm text-center border border-teal-100">
                                <strong>Sesi Siang</strong><br>13.00 - 14.30
                            </div>
                        </div>
                        <div class="mt-2 text-xs text-red-500 italic">*(Minggu & Hari Libur Nasional Tutup)</div>
                    </div>
                </div>
            </div>

        </div>

        {{-- CALL TO ACTION --}}
        <div class="mt-32 mb-10" data-aos="zoom-in-up">
            <div class="bg-gradient-to-br from-slate-900 via-blue-900 to-slate-900 rounded-[3rem] p-12 md:p-20 text-center text-white relative overflow-hidden shadow-[0_20px_50px_rgba(0,0,0,0.3)] border border-blue-500/30 transform hover:shadow-[0_20px_60px_rgba(37,99,235,0.4)] transition-all duration-500 group">
                
                {{-- Decorative Blob --}}
                <div class="absolute top-0 right-0 w-[500px] h-[500px] bg-blue-500/30 rounded-full blur-[100px] -mr-40 -mt-40 pointer-events-none group-hover:scale-110 transition-transform duration-1000"></div>
                <div class="absolute bottom-0 left-0 w-[400px] h-[400px] bg-cyan-500/20 rounded-full blur-[100px] -ml-40 -mb-20 pointer-events-none group-hover:scale-110 transition-transform duration-1000" style="animation-delay: 1s"></div>

                <div class="relative z-10">
                    <div class="inline-flex items-center justify-center w-24 h-24 bg-white/10 rounded-full mb-8 backdrop-blur-md border border-white/20 shadow-[0_0_30px_rgba(6,182,212,0.3)]">
                        <i class="fas fa-headset text-5xl text-cyan-300 animate-bounce"></i>
                    </div>
                    <h2 class="text-4xl md:text-6xl font-black mb-6 tracking-tight drop-shadow-lg leading-tight">Masih Butuh Bantuan?</h2>
                    <p class="text-blue-100 text-xl font-light mb-12 max-w-2xl mx-auto leading-relaxed drop-shadow-sm">
                        Jangan ragu untuk menghubungi kami. Tim Layanan Lapas Jombang siap membantu menjawab keluhan maupun pertanyaan Anda secara langsung.
                    </p>
                    
                    <div class="flex flex-col sm:flex-row justify-center items-center gap-6">
                        <a href="https://wa.me/6281234567890" target="_blank" class="w-full sm:w-auto group inline-flex items-center justify-center gap-4 bg-green-500 hover:bg-green-400 text-white px-10 py-5 rounded-full font-bold transition-all shadow-[0_10px_20px_rgba(34,197,94,0.4)] hover:shadow-[0_15px_30px_rgba(34,197,94,0.6)] transform hover:-translate-y-2">
                            <i class="fab fa-whatsapp text-4xl group-hover:scale-110 transition-transform"></i> 
                            <div class="text-left leading-tight">
                                <span class="text-lg">Chat WhatsApp</span><br>
                                <span class="text-sm font-normal text-green-100">Respon Super Cepat</span>
                            </div>
                        </a>
                        <button onclick="showContactModal()" class="w-full sm:w-auto group inline-flex items-center justify-center gap-4 bg-white/10 hover:bg-white backdrop-blur border border-white/30 hover:border-white text-white hover:text-blue-900 px-10 py-5 rounded-full font-bold transition-all shadow-lg hover:shadow-[0_15px_30px_rgba(255,255,255,0.2)] transform hover:-translate-y-2">
                            <i class="fas fa-envelope text-3xl group-hover:text-blue-600 transition-colors"></i> 
                            <div class="text-left leading-tight">
                                <span class="text-lg">Kirim Email & Telp</span><br>
                                <span class="text-sm font-light text-slate-300 group-hover:text-blue-700">Untuk Pertanyaan Formal</span>
                            </div>
                        </button>
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>

@endsection

@push('scripts')
{{-- Script Libraries --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
{{-- Alpine.js (Pastikan hanya di-load sekali di layout utama jika sudah ada) --}}
{{-- <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script> --}}

<script>
    // 1. Initialize AOS (Animate On Scroll)
    AOS.init({
        once: true,
        duration: 800,
        offset: 50,
    });

    // 2. Swing Alert untuk Tombol Kontak (POPUP BESAR)
    function showContactModal() {
        Swal.fire({
            title: '<span class="text-2xl font-bold text-slate-800">Hubungi Kami</span>',
            html: `
                <div class="text-left mt-4 space-y-4">
                    <div class="flex items-center gap-4 p-4 bg-blue-50 rounded-2xl border border-blue-100 hover:shadow-md transition-shadow">
                        <div class="w-14 h-14 bg-blue-600 rounded-full flex items-center justify-center text-white shadow-md">
                            <i class="fas fa-phone-alt text-xl"></i>
                        </div>
                        <div>
                            <p class="text-xs text-blue-500 font-bold uppercase tracking-wider">Layanan Telepon</p>
                            <p class="text-xl text-slate-800 font-black">(0321) 123456</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-4 p-4 bg-red-50 rounded-2xl border border-red-100 hover:shadow-md transition-shadow">
                        <div class="w-14 h-14 bg-red-600 rounded-full flex items-center justify-center text-white shadow-md">
                            <i class="fas fa-envelope text-xl"></i>
                        </div>
                        <div>
                            <p class="text-xs text-red-500 font-bold uppercase tracking-wider">Email Resmi</p>
                            <p class="text-xl text-slate-800 font-black">info@lapasjombang.go.id</p>
                        </div>
                    </div>
                </div>
            `,
            showConfirmButton: false,
            showCloseButton: true,
            showClass: {
                popup: 'animate__animated animate__zoomIn animate__fast'
            },
            hideClass: {
                popup: 'animate__animated animate__zoomOut animate__faster'
            },
            customClass: {
                popup: 'rounded-[2rem] p-6 border-4 border-white shadow-2xl'
            }
        });
    }

    // 3. Mini Swing Alert untuk FAQ Items (TOAST NOTIFICATION)
    function showSwingAlert(title, text) {
        Swal.fire({
            title: title,
            text: text,
            timer: 2000,
            showConfirmButton: false,
            backdrop: false, // Background tetap transparan
            position: 'top-end', // Muncul di pojok kanan atas
            toast: true,
            icon: 'info',
            iconColor: '#3b82f6',
            showClass: { popup: 'animate__animated animate__fadeInRight' },
            hideClass: { popup: 'animate__animated animate__fadeOutRight' },
            customClass: {
                popup: 'rounded-xl shadow-xl border border-blue-200 bg-white'
            }
        });
    }

    // 4. ANIMASI 3D CANVAS (PARTICLES)
    document.addEventListener('DOMContentLoaded', function() {
        const canvas = document.getElementById('hero-3d-canvas');
        if (canvas) {
            const ctx = canvas.getContext('2d');
            let width, height;
            let particles = [];

            function resize() {
                width = canvas.width = canvas.offsetWidth;
                height = canvas.height = canvas.offsetHeight;
            }

            class Particle {
                constructor() {
                    this.x = Math.random() * width;
                    this.y = Math.random() * height;
                    this.vx = (Math.random() - 0.5) * 0.5;
                    this.vy = (Math.random() - 0.5) * 0.5;
                    this.size = Math.random() * 2;
                    this.color = Math.random() > 0.5 ? 'rgba(6, 182, 212, ' : 'rgba(59, 130, 246, '; // Cyan / Blue
                    this.alpha = Math.random() * 0.5;
                }
                update() {
                    this.x += this.vx;
                    this.y += this.vy;
                    if (this.x < 0 || this.x > width) this.vx *= -1;
                    if (this.y < 0 || this.y > height) this.vy *= -1;
                }
                draw() {
                    ctx.beginPath();
                    ctx.arc(this.x, this.y, this.size, 0, Math.PI * 2);
                    ctx.fillStyle = this.color + this.alpha + ')';
                    ctx.fill();
                }
            }

            function initParticles() {
                particles = [];
                for (let i = 0; i < 100; i++) {
                    particles.push(new Particle());
                }
            }

            function animate() {
                ctx.clearRect(0, 0, width, height);
                particles.forEach(p => {
                    p.update();
                    p.draw();
                });
                // Draw lines between close particles
                particles.forEach((p1, i) => {
                    for (let j = i + 1; j < particles.length; j++) {
                        const p2 = particles[j];
                        const dx = p1.x - p2.x;
                        const dy = p1.y - p2.y;
                        const dist = Math.sqrt(dx * dx + dy * dy);
                        if (dist < 100) {
                            ctx.beginPath();
                            ctx.strokeStyle = `rgba(255, 255, 255, ${0.1 - dist/1000})`;
                            ctx.lineWidth = 0.5;
                            ctx.moveTo(p1.x, p1.y);
                            ctx.lineTo(p2.x, p2.y);
                            ctx.stroke();
                        }
                    }
                });
                requestAnimationFrame(animate);
            }

            window.addEventListener('resize', resize);
            resize();
            initParticles();
            animate();
        }
    });
</script>
@endpush