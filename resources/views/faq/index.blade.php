@extends('layouts.main')

@section('content')

@push('styles')
    {{-- ANIMASI & STYLE LIBRARIES --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    
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

        /* --- 2. FAQ CARD STYLING --- */
        .faq-card {
            background: #ffffff;
            border: 1px solid #f1f5f9;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
        }
        
        /* Efek Hover: Naik sedikit + Bayangan + Border berwarna sesuai tema icon */
        .faq-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
            border-color: #e2e8f0;
        }

        /* Indikator Garis Kiri saat Aktif */
        .faq-card.active {
            border-left: 4px solid #3b82f6; /* Warna biru */
        }

        /* --- 3. CUSTOM SCROLLBAR --- */
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
    </style>
@endpush

{{-- ================================================================= --}}
{{-- 1. HERO SECTION (HEADER) --}}
{{-- ================================================================= --}}
<section class="relative bg-gradient-to-br from-slate-900 via-blue-900 to-slate-900 text-white min-h-[50vh] flex items-center justify-center overflow-hidden pt-32 pb-20">
    
    {{-- Background Pattern --}}
    <div class="absolute inset-0 z-0">
        <div class="absolute inset-0 bg-[url('data:image/svg+xml,%3Csvg width=\'60\' height=\'60\' viewBox=\'0 0 60 60\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cg fill=\'none\' fill-rule=\'evenodd\'%3E%3Cg fill=\'%23ffffff\' fill-opacity=\'0.05\'%3E%3Ccircle cx=\'30\' cy=\'30\' r=\'2\'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E')] opacity-20"></div>
        <div class="absolute inset-0 bg-gradient-to-b from-slate-900/60 via-blue-900/60 to-slate-900/95"></div>
    </div>

    {{-- Floating Elements --}}
    <div class="absolute top-20 left-10 w-32 h-32 bg-blue-500/20 rounded-full blur-3xl animate-pulse"></div>
    <div class="absolute bottom-20 right-10 w-40 h-40 bg-cyan-500/10 rounded-full blur-3xl animate-pulse" style="animation-delay: 1.5s;"></div>

    <div class="container mx-auto px-6 text-center relative z-10" data-aos="fade-down">
        
        {{-- Badge --}}
        <div class="inline-flex items-center px-4 py-2 rounded-full bg-white/10 backdrop-blur-md border border-white/20 text-blue-200 text-sm font-semibold mb-6 shadow-lg">
            <i class="fas fa-life-ring mr-2 animate-bounce"></i>
            Pusat Bantuan & Informasi
        </div>

        {{-- Title dengan Animasi Shimmer --}}
        <h1 class="text-4xl md:text-6xl font-black mb-6 tracking-tight leading-tight">
            Pertanyaan <span class="text-transparent bg-clip-text bg-gradient-to-r from-cyan-400 via-white to-cyan-400 animate-text-shimmer">Umum</span>
        </h1>
        
        <p class="text-xl text-slate-300 max-w-2xl mx-auto leading-relaxed">
            Temukan jawaban cepat seputar layanan, jadwal, dan tata tertib kunjungan di Lapas Kelas IIB Jombang.
        </p>
    </div>
</section>

{{-- ================================================================= --}}
{{-- 2. FAQ LIST SECTION --}}
{{-- ================================================================= --}}
<section class="py-20 bg-slate-50 min-h-screen relative">
    
    {{-- Background Decoration --}}
    <div class="absolute top-0 left-0 w-full h-64 bg-gradient-to-b from-slate-900 to-slate-50 z-0 opacity-10"></div>

    <div class="container mx-auto px-6 max-w-4xl relative z-10">
        
        {{-- Section Intro --}}
        <div class="text-center mb-16" data-aos="fade-up">
            <h2 class="text-3xl font-bold text-slate-800 mb-4 flex items-center justify-center gap-3">
                <span class="text-blue-600"><i class="fas fa-comments"></i></span> Yang Sering Ditanyakan
            </h2>
            <div class="h-1.5 w-24 bg-gradient-to-r from-blue-500 to-cyan-500 mx-auto rounded-full shadow-sm"></div>
        </div>

        {{-- FAQ List Container --}}
        <div class="space-y-5">

            {{-- Item 1: Sistem Online --}}
            <div x-data="{ open: false }" 
                 :class="open ? 'border-l-4 border-l-blue-500 shadow-lg' : ''"
                 class="faq-card bg-white rounded-2xl overflow-hidden" 
                 data-aos="fade-up" data-aos-delay="100">
                
                <button @click="open = !open; if(open) showSwingAlert('Info', 'Tentang pendaftaran online')" 
                        class="w-full flex justify-between items-center p-6 text-left focus:outline-none hover:bg-slate-50 transition-colors duration-300">
                    <div class="flex items-center gap-5">
                        {{-- Icon Box --}}
                        <div class="w-12 h-12 rounded-xl bg-blue-100 text-blue-600 flex items-center justify-center shrink-0 shadow-sm">
                            <i class="fas fa-globe text-xl"></i>
                        </div>
                        <span class="text-lg font-bold text-slate-800 group-hover:text-blue-600 transition-colors">Apa itu sistem pendaftaran kunjungan online?</span>
                    </div>
                    {{-- Chevron Icon --}}
                    <div class="w-8 h-8 rounded-full bg-slate-100 flex items-center justify-center text-slate-400 transition-transform duration-300" 
                         :class="{'rotate-180 bg-blue-100 text-blue-600': open}">
                        <i class="fas fa-chevron-down"></i>
                    </div>
                </button>

                <div x-show="open" 
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0 -translate-y-2 max-h-0"
                     x-transition:enter-end="opacity-100 translate-y-0 max-h-[500px]"
                     x-transition:leave="transition ease-in duration-200"
                     x-transition:leave-start="opacity-100 translate-y-0 max-h-[500px]"
                     x-transition:leave-end="opacity-0 -translate-y-2 max-h-0"
                     class="border-t border-slate-100 bg-slate-50/50">
                    <div class="p-6 pl-[5.5rem] text-slate-600 leading-relaxed">
                        Sistem pendaftaran kunjungan online adalah platform digital inovatif yang memungkinkan Anda mendaftar kunjungan ke Lapas Kelas IIB Jombang secara praktis dari mana saja. Tujuannya untuk mengurangi antrian fisik dan mempercepat proses verifikasi data pengunjung.
                    </div>
                </div>
            </div>

            {{-- Item 2: Cara Daftar --}}
            <div x-data="{ open: false }" 
                 :class="open ? 'border-l-4 border-l-cyan-500 shadow-lg' : ''"
                 class="faq-card bg-white rounded-2xl overflow-hidden" 
                 data-aos="fade-up" data-aos-delay="200">
                
                <button @click="open = !open; if(open) showSwingAlert('Panduan', 'Cara daftar kunjungan')" 
                        class="w-full flex justify-between items-center p-6 text-left focus:outline-none hover:bg-slate-50 transition-colors duration-300">
                    <div class="flex items-center gap-5">
                        <div class="w-12 h-12 rounded-xl bg-cyan-100 text-cyan-600 flex items-center justify-center shrink-0 shadow-sm">
                            <i class="fas fa-desktop text-xl"></i>
                        </div>
                        <span class="text-lg font-bold text-slate-800">Bagaimana cara mendaftar kunjungan?</span>
                    </div>
                    <div class="w-8 h-8 rounded-full bg-slate-100 flex items-center justify-center text-slate-400 transition-transform duration-300" :class="{'rotate-180 bg-cyan-100 text-cyan-600': open}">
                        <i class="fas fa-chevron-down"></i>
                    </div>
                </button>

                <div x-show="open" 
                     x-collapse
                     class="border-t border-slate-100 bg-slate-50/50">
                    <div class="p-6 pl-[5.5rem] text-slate-600 leading-relaxed">
                        <ol class="list-decimal pl-5 space-y-2 marker:text-cyan-600 marker:font-bold">
                            <li>Buka menu <strong>"Daftar Kunjungan"</strong> di website ini.</li>
                            <li>Isi formulir data diri pengunjung dan data warga binaan yang dituju.</li>
                            <li>Pilih tanggal dan sesi kunjungan yang tersedia.</li>
                            <li>Kirim pendaftaran dan tunggu konfirmasi melalui email atau cek status secara berkala.</li>
                        </ol>
                    </div>
                </div>
            </div>

            {{-- Item 3: Syarat --}}
            <div x-data="{ open: false }" 
                 :class="open ? 'border-l-4 border-l-orange-500 shadow-lg' : ''"
                 class="faq-card bg-white rounded-2xl overflow-hidden" 
                 data-aos="fade-up" data-aos-delay="300">
                
                <button @click="open = !open; if(open) showSwingAlert('Syarat', 'Dokumen yang diperlukan')" 
                        class="w-full flex justify-between items-center p-6 text-left focus:outline-none hover:bg-slate-50 transition-colors duration-300">
                    <div class="flex items-center gap-5">
                        <div class="w-12 h-12 rounded-xl bg-orange-100 text-orange-600 flex items-center justify-center shrink-0 shadow-sm">
                            <i class="fas fa-id-card text-xl"></i>
                        </div>
                        <span class="text-lg font-bold text-slate-800">Apa saja syarat berkunjung?</span>
                    </div>
                    <div class="w-8 h-8 rounded-full bg-slate-100 flex items-center justify-center text-slate-400 transition-transform duration-300" :class="{'rotate-180 bg-orange-100 text-orange-600': open}">
                        <i class="fas fa-chevron-down"></i>
                    </div>
                </button>

                <div x-show="open" x-collapse class="border-t border-slate-100 bg-slate-50/50">
                    <div class="p-6 pl-[5.5rem] text-slate-600 leading-relaxed">
                        Pengunjung wajib membawa dokumen asli berikut:
                        <ul class="list-none mt-3 space-y-2">
                            <li class="flex items-center gap-2"><i class="fas fa-check-circle text-orange-500"></i> Kartu Identitas Asli (KTP/SIM/Paspor) yang masih berlaku.</li>
                            <li class="flex items-center gap-2"><i class="fas fa-check-circle text-orange-500"></i> Bukti Pendaftaran Online (screenshot/cetak).</li>
                            <li class="flex items-center gap-2"><i class="fas fa-check-circle text-orange-500"></i> Kartu Keluarga (jika mengunjungi keluarga inti).</li>
                            <li class="flex items-center gap-2"><i class="fas fa-tshirt text-orange-500"></i> Berpakaian sopan dan rapi (No celana pendek/kaos oblong).</li>
                        </ul>
                    </div>
                </div>
            </div>

            {{-- Item 4: Maksimal Pengunjung --}}
            <div x-data="{ open: false }" 
                 :class="open ? 'border-l-4 border-l-purple-500 shadow-lg' : ''"
                 class="faq-card bg-white rounded-2xl overflow-hidden" 
                 data-aos="fade-up" data-aos-delay="400">
                
                <button @click="open = !open; if(open) showSwingAlert('Aturan', 'Maksimal 4 orang')" 
                        class="w-full flex justify-between items-center p-6 text-left focus:outline-none hover:bg-slate-50 transition-colors duration-300">
                    <div class="flex items-center gap-5">
                        <div class="w-12 h-12 rounded-xl bg-purple-100 text-purple-600 flex items-center justify-center shrink-0 shadow-sm">
                            <i class="fas fa-users text-xl"></i>
                        </div>
                        <span class="text-lg font-bold text-slate-800">Berapa maksimal jumlah pengunjung?</span>
                    </div>
                    <div class="w-8 h-8 rounded-full bg-slate-100 flex items-center justify-center text-slate-400 transition-transform duration-300" :class="{'rotate-180 bg-purple-100 text-purple-600': open}">
                        <i class="fas fa-chevron-down"></i>
                    </div>
                </button>

                <div x-show="open" x-collapse class="border-t border-slate-100 bg-slate-50/50">
                    <div class="p-6 pl-[5.5rem] text-slate-600 leading-relaxed">
                        Demi ketertiban dan kenyamanan, jumlah pengunjung dibatasi maksimal <strong class="text-purple-600">4 orang (dewasa)</strong> untuk satu kali kunjungan per Warga Binaan. Anak-anak di bawah umur tetap dihitung namun mendapat prioritas kenyamanan.
                    </div>
                </div>
            </div>

             {{-- Item 5: Barang Terlarang --}}
             <div x-data="{ open: false }" 
                  :class="open ? 'border-l-4 border-l-red-500 shadow-lg' : ''"
                  class="faq-card bg-white rounded-2xl overflow-hidden" 
                  data-aos="fade-up" data-aos-delay="500">
                
                <button @click="open = !open; if(open) showSwingAlert('Peringatan', 'Barang terlarang!')" 
                        class="w-full flex justify-between items-center p-6 text-left focus:outline-none hover:bg-slate-50 transition-colors duration-300">
                    <div class="flex items-center gap-5">
                        <div class="w-12 h-12 rounded-xl bg-red-100 text-red-600 flex items-center justify-center shrink-0 shadow-sm">
                            <i class="fas fa-ban text-xl"></i>
                        </div>
                        <span class="text-lg font-bold text-slate-800">Barang apa saja yang dilarang?</span>
                    </div>
                    <div class="w-8 h-8 rounded-full bg-slate-100 flex items-center justify-center text-slate-400 transition-transform duration-300" :class="{'rotate-180 bg-red-100 text-red-600': open}">
                        <i class="fas fa-chevron-down"></i>
                    </div>
                </button>

                <div x-show="open" x-collapse class="border-t border-slate-100 bg-slate-50/50">
                    <div class="p-6 pl-[5.5rem] text-slate-600 leading-relaxed">
                        <p class="mb-3 text-red-600 font-bold uppercase tracking-wider text-xs">DILARANG KERAS MEMBAWA:</p>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-3 text-sm">
                            <div class="flex items-center gap-2 bg-white p-2 rounded border border-red-100 text-red-700">
                                <i class="fas fa-times-circle"></i> Narkoba & Obat Terlarang
                            </div>
                            <div class="flex items-center gap-2 bg-white p-2 rounded border border-red-100 text-red-700">
                                <i class="fas fa-times-circle"></i> Senjata Tajam / Api
                            </div>
                            <div class="flex items-center gap-2 bg-white p-2 rounded border border-red-100 text-red-700">
                                <i class="fas fa-times-circle"></i> Handphone / Kamera
                            </div>
                            <div class="flex items-center gap-2 bg-white p-2 rounded border border-red-100 text-red-700">
                                <i class="fas fa-times-circle"></i> Minuman Beralkohol
                            </div>
                        </div>
                        <p class="mt-4 text-xs text-slate-400 italic">*Semua barang bawaan akan diperiksa secara ketat oleh petugas di pintu utama.</p>
                    </div>
                </div>
            </div>

            {{-- Item 6: Verifikasi --}}
            <div x-data="{ open: false }" 
                 :class="open ? 'border-l-4 border-l-indigo-500 shadow-lg' : ''"
                 class="faq-card bg-white rounded-2xl overflow-hidden" 
                 data-aos="fade-up" data-aos-delay="600">
                
                <button @click="open = !open; if(open) showSwingAlert('Verifikasi', 'Maksimal 1x24 Jam')" 
                        class="w-full flex justify-between items-center p-6 text-left focus:outline-none hover:bg-slate-50 transition-colors duration-300">
                    <div class="flex items-center gap-5">
                        <div class="w-12 h-12 rounded-xl bg-indigo-100 text-indigo-600 flex items-center justify-center shrink-0 shadow-sm">
                            <i class="fas fa-check-double text-xl"></i>
                        </div>
                        <span class="text-lg font-bold text-slate-800">Berapa lama proses verifikasi?</span>
                    </div>
                    <div class="w-8 h-8 rounded-full bg-slate-100 flex items-center justify-center text-slate-400 transition-transform duration-300" :class="{'rotate-180 bg-indigo-100 text-indigo-600': open}">
                        <i class="fas fa-chevron-down"></i>
                    </div>
                </button>

                <div x-show="open" x-collapse class="border-t border-slate-100 bg-slate-50/50">
                    <div class="p-6 pl-[5.5rem] text-slate-600 leading-relaxed">
                        Proses verifikasi maksimal <strong>1x24 jam</strong> pada hari kerja. Notifikasi akan dikirim ke email atau dapat dicek melalui menu "Cek Status" di halaman utama.
                    </div>
                </div>
            </div>

            {{-- Item 7: Pembatalan --}}
            <div x-data="{ open: false }" 
                 :class="open ? 'border-l-4 border-l-rose-500 shadow-lg' : ''"
                 class="faq-card bg-white rounded-2xl overflow-hidden" 
                 data-aos="fade-up" data-aos-delay="700">
                
                <button @click="open = !open; if(open) showSwingAlert('Pembatalan', 'Hubungi Admin')" 
                        class="w-full flex justify-between items-center p-6 text-left focus:outline-none hover:bg-slate-50 transition-colors duration-300">
                    <div class="flex items-center gap-5">
                        <div class="w-12 h-12 rounded-xl bg-rose-100 text-rose-600 flex items-center justify-center shrink-0 shadow-sm">
                            <i class="fas fa-times-circle text-xl"></i>
                        </div>
                        <span class="text-lg font-bold text-slate-800">Bisakah membatalkan jadwal?</span>
                    </div>
                    <div class="w-8 h-8 rounded-full bg-slate-100 flex items-center justify-center text-slate-400 transition-transform duration-300" :class="{'rotate-180 bg-rose-100 text-rose-600': open}">
                        <i class="fas fa-chevron-down"></i>
                    </div>
                </button>

                <div x-show="open" x-collapse class="border-t border-slate-100 bg-slate-50/50">
                    <div class="p-6 pl-[5.5rem] text-slate-600 leading-relaxed">
                        Bisa, namun harus dikonfirmasi minimal <strong>H-1</strong> sebelum jadwal kunjungan. Silakan hubungi nomor layanan kami untuk proses pembatalan atau penjadwalan ulang.
                    </div>
                </div>
            </div>

            {{-- Item 8: Jam Layanan --}}
            <div x-data="{ open: false }" 
                 :class="open ? 'border-l-4 border-l-teal-500 shadow-lg' : ''"
                 class="faq-card bg-white rounded-2xl overflow-hidden" 
                 data-aos="fade-up" data-aos-delay="800">
                
                <button @click="open = !open; if(open) showSwingAlert('Waktu', 'Senin - Sabtu')" 
                        class="w-full flex justify-between items-center p-6 text-left focus:outline-none hover:bg-slate-50 transition-colors duration-300">
                    <div class="flex items-center gap-5">
                        <div class="w-12 h-12 rounded-xl bg-teal-100 text-teal-600 flex items-center justify-center shrink-0 shadow-sm">
                            <i class="fas fa-clock text-xl"></i>
                        </div>
                        <span class="text-lg font-bold text-slate-800">Kapan jam layanan kunjungan?</span>
                    </div>
                    <div class="w-8 h-8 rounded-full bg-slate-100 flex items-center justify-center text-slate-400 transition-transform duration-300" :class="{'rotate-180 bg-teal-100 text-teal-600': open}">
                        <i class="fas fa-chevron-down"></i>
                    </div>
                </button>

                <div x-show="open" x-collapse class="border-t border-slate-100 bg-slate-50/50">
                    <div class="p-6 pl-[5.5rem] text-slate-600 leading-relaxed">
                        Layanan kunjungan tatap muka tersedia setiap hari <strong>Senin - Sabtu</strong>.
                        <br>Sesi Pagi: 08.30 - 11.30 WIB
                        <br>Sesi Siang: 13.00 - 14.30 WIB
                        <br><em>(Minggu & Hari Libur Nasional Tutup)</em>
                    </div>
                </div>
            </div>

        </div>

        {{-- CALL TO ACTION --}}
        <div class="mt-24" data-aos="zoom-in-up">
            <div class="bg-gradient-to-br from-slate-900 to-blue-900 rounded-[2.5rem] p-10 md:p-16 text-center text-white relative overflow-hidden shadow-2xl border border-slate-700">
                
                {{-- Decorative Blob --}}
                <div class="absolute top-0 right-0 w-80 h-80 bg-blue-500/20 rounded-full blur-[80px] -mr-20 -mt-20 animate-pulse"></div>
                <div class="absolute bottom-0 left-0 w-80 h-80 bg-cyan-500/20 rounded-full blur-[80px] -ml-20 -mb-20 animate-pulse" style="animation-delay: 1s"></div>

                <div class="relative z-10">
                    <div class="inline-flex items-center justify-center w-16 h-16 bg-white/10 rounded-full mb-6 backdrop-blur-sm border border-white/20">
                        <i class="fas fa-headset text-3xl text-cyan-300"></i>
                    </div>
                    <h2 class="text-3xl md:text-4xl font-black mb-4 tracking-tight">Masih Butuh Bantuan?</h2>
                    <p class="text-blue-100 text-lg mb-10 max-w-xl mx-auto leading-relaxed">
                        Jika pertanyaan Anda belum terjawab di atas, tim layanan kami siap membantu Anda melalui saluran resmi berikut.
                    </p>
                    
                    <div class="flex flex-col sm:flex-row justify-center gap-4">
                        <a href="https://wa.me/6281234567890" target="_blank" class="inline-flex items-center justify-center gap-3 bg-green-500 hover:bg-green-600 text-white px-8 py-4 rounded-full font-bold transition-all shadow-lg hover:shadow-green-500/40 transform hover:-translate-y-1">
                            <i class="fab fa-whatsapp text-2xl"></i> Chat WhatsApp
                        </a>
                        <button onclick="showContactModal()" class="inline-flex items-center justify-center gap-3 bg-white hover:bg-slate-100 text-slate-900 border border-transparent px-8 py-4 rounded-full font-bold transition-all shadow-lg hover:shadow-white/20 transform hover:-translate-y-1">
                            <i class="fas fa-envelope text-2xl text-blue-600"></i> Hubungi Kami
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
                <div class="text-left mt-4 space-y-3">
                    <div class="flex items-center gap-4 p-4 bg-blue-50 rounded-2xl border border-blue-100">
                        <div class="w-12 h-12 bg-blue-600 rounded-full flex items-center justify-center text-white shadow-md">
                            <i class="fas fa-phone-alt"></i>
                        </div>
                        <div>
                            <p class="text-xs text-blue-500 font-bold uppercase tracking-wider">Layanan Telepon</p>
                            <p class="text-lg text-slate-800 font-black">(0321) 123456</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-4 p-4 bg-red-50 rounded-2xl border border-red-100">
                        <div class="w-12 h-12 bg-red-600 rounded-full flex items-center justify-center text-white shadow-md">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <div>
                            <p class="text-xs text-red-500 font-bold uppercase tracking-wider">Email Resmi</p>
                            <p class="text-lg text-slate-800 font-black">info@lapasjombang.go.id</p>
                        </div>
                    </div>
                </div>
            `,
            showConfirmButton: false,
            showCloseButton: true,
            // LOGIKA ANIMASI SWING
            showClass: {
                popup: 'animate__animated animate__swing animate__fast'
            },
            hideClass: {
                popup: 'animate__animated animate__fadeOutUp animate__faster'
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
            // LOGIKA ANIMASI SWING PADA TOAST
            showClass: { popup: 'animate__animated animate__swing' },
            hideClass: { popup: 'animate__animated animate__fadeOutRight' },
            customClass: {
                popup: 'rounded-xl shadow-lg border border-slate-100'
            }
        });
    }
</script>
@endpush