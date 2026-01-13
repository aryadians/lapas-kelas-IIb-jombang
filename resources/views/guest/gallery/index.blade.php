@extends('layouts.main')

@section('content')

{{-- 1. DATA DUMMY PRODUK --}}
@php
    $products = [
        ['name' => 'Asbak Kayu Jati', 'image' => asset('img/galeri/asbak kayu jati.png'), 'cat' => 'Kerajinan', 'price' => 'Rp 45.000'],
        ['name' => 'Hiasan Meja', 'image' => asset('img/galeri/hiasan meja.png'), 'cat' => 'Dekorasi', 'price' => 'Rp 75.000'],
        ['name' => 'Jam Dinding Ukir', 'image' => asset('img/galeri/jam dinding ukir.png'), 'cat' => 'Furniture', 'price' => 'Rp 150.000'],
        ['name' => 'Phone Holder Jati', 'image' => asset('img/galeri/phone holder kayu jati.png'), 'cat' => 'Aksesoris', 'price' => 'Rp 35.000'],
        ['name' => 'Tempat Pisau Dapur', 'image' => asset('img/galeri/tempat pisau dapur.png'), 'cat' => 'Peralatan', 'price' => 'Rp 85.000'],
        ['name' => 'Tempat Tissue', 'image' => asset('img/galeri/tempat tissue.png'), 'cat' => 'Perlengkapan', 'price' => 'Rp 50.000'],
    ];

    $shopeeLink = $links['shopee'] ?? 'https://shopee.co.id';
    $tokpedLink = $links['tokopedia'] ?? 'https://tokopedia.com';
@endphp

@push('styles')
    {{-- ANIMASI & STYLE LIBRARIES --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    
    <style>
        /* --- A. PREMIUM BUTTON STYLES (UTAMA) --- */
        .btn-market-pro {
            position: relative;
            overflow: hidden;
            transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
            z-index: 1;
            border: 0;
        }

        /* Efek Kilatan Cahaya (Shine) saat Hover */
        .btn-market-pro::after {
            content: '';
            position: absolute;
            top: 0; left: -120%; width: 100%; height: 100%;
            background: linear-gradient(120deg, transparent, rgba(255, 255, 255, 0.4), transparent);
            transition: all 0.6s ease;
            z-index: 2;
        }
        .btn-market-pro:hover::after { left: 120%; }
        .btn-market-pro:hover { transform: translateY(-5px) scale(1.03); }

        /* WARNA SHOPEE (Orange) */
        .btn-shopee-pro {
            background: linear-gradient(135deg, #EE4D2D 0%, #FF7337 100%);
            box-shadow: 0 8px 20px -6px rgba(238, 77, 45, 0.6);
        }
        .btn-shopee-pro:hover { box-shadow: 0 15px 30px -8px rgba(238, 77, 45, 0.8); }

        /* WARNA TOKOPEDIA (Hijau) */
        .btn-tokped-pro {
            background: linear-gradient(135deg, #00AA5B 0%, #42B549 100%);
            box-shadow: 0 8px 20px -6px rgba(0, 170, 91, 0.6);
        }
        .btn-tokped-pro:hover { box-shadow: 0 15px 30px -8px rgba(0, 170, 91, 0.8); }

        /* --- B. CARD STYLES --- */
        .product-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(226, 232, 240, 0.8);
            transition: all 0.5s ease;
        }
        .product-card:hover {
            transform: translateY(-10px);
            border-color: #3b82f6;
            box-shadow: 0 25px 50px -12px rgba(59, 130, 246, 0.25);
        }

        /* Icon Action Buttons (Mini) */
        .action-btn { transition: all 0.3s ease; }
        .action-btn:hover { transform: rotate(15deg) scale(1.1); }
    </style>
@endpush

{{-- 2. HERO SECTION --}}
<section class="relative pt-36 pb-24 bg-slate-900 overflow-hidden">
    {{-- Background Animated --}}
    <div class="absolute inset-0 z-0">
        <div class="absolute top-0 right-0 w-[600px] h-[600px] bg-blue-600/10 rounded-full blur-[120px] animate-pulse"></div>
        <div class="absolute bottom-0 left-0 w-[500px] h-[500px] bg-yellow-500/10 rounded-full blur-[100px]" style="animation-delay: 1.5s"></div>
    </div>

    <div class="container mx-auto px-6 relative z-10 text-center">
        <div data-aos="fade-down" class="mb-8">
            <span class="inline-flex items-center gap-2 py-1 px-4 rounded-full bg-slate-800 border border-slate-700 text-yellow-400 text-sm font-bold tracking-wider shadow-[0_0_15px_rgba(250,204,21,0.3)]">
                <i class="fas fa-star animate-spin-slow"></i> KARYA WARGA BINAAN
            </span>
        </div>

        <h1 class="text-4xl md:text-7xl font-black text-white mb-8 leading-tight drop-shadow-2xl" data-aos="zoom-in">
            Galeri <span class="text-transparent bg-clip-text bg-gradient-to-r from-yellow-300 via-orange-400 to-yellow-300 animate-gradient">Bimker</span> Lapas
        </h1>

        <p class="text-lg text-slate-300 max-w-2xl mx-auto mb-12" data-aos="fade-up">
            Temukan produk kerajinan tangan berkualitas premium.
            <br>Belanja mudah melalui marketplace favorit Anda.
        </p>

     {{-- BUTTONS MARKETPLACE (DENGAN GAMBAR PNG) --}}
        <div class="flex flex-col md:flex-row justify-center gap-6 w-full max-w-4xl mx-auto" data-aos="fade-up" data-aos-delay="200">
            
            {{-- Shopee Button (Orange) --}}
            <a href="{{ $shopeeLink }}" target="_blank" 
               class="btn-market-pro group w-full md:w-auto px-8 py-5 rounded-2xl flex items-center justify-center md:justify-start gap-5 text-white transition-all duration-300 shadow-lg hover:shadow-2xl hover:-translate-y-1 bg-gradient-to-br from-[#EE4D2D] to-[#FF7337] shadow-orange-500/40 hover:shadow-orange-600/60">
                
                {{-- Icon Container (Glass Effect) --}}
                <div class="bg-white/20 backdrop-blur-sm p-2 rounded-xl border border-white/30 group-hover:rotate-6 transition-transform duration-300">
                    {{-- GANTI SVG DENGAN GAMBAR PNG --}}
                    <img src="{{ asset('img/shopee.png') }}" alt="Shopee Logo" class="w-10 h-10 object-contain drop-shadow-sm">
                </div>

                {{-- Text --}}
                <div class="text-left">
                    <div class="flex items-center gap-2">
                        <p class="text-[10px] md:text-xs opacity-90 uppercase tracking-[0.2em] font-bold">Official Store</p>
                        <i class="fas fa-external-link-alt text-[10px] opacity-60"></i>
                    </div>
                    <p class="text-2xl md:text-3xl font-black font-sans tracking-tight">Shopee</p>
                </div>
            </a>

            {{-- Tokopedia Button (Green) --}}
            <a href="{{ $tokpedLink }}" target="_blank" 
               class="btn-market-pro group w-full md:w-auto px-8 py-5 rounded-2xl flex items-center justify-center md:justify-start gap-5 text-white transition-all duration-300 shadow-lg hover:shadow-2xl hover:-translate-y-1 bg-gradient-to-br from-[#00AA5B] to-[#42B549] shadow-green-500/40 hover:shadow-green-600/60">
                
                {{-- Icon Container (Glass Effect) --}}
                <div class="bg-white/20 backdrop-blur-sm p-2 rounded-xl border border-white/30 group-hover:-rotate-6 transition-transform duration-300">
                    {{-- GANTI SVG DENGAN GAMBAR PNG --}}
                    <img src="{{ asset('img/tokopedia.png') }}" alt="Tokopedia Logo" class="w-10 h-10 object-contain drop-shadow-sm">
                </div>

                {{-- Text --}}
                <div class="text-left">
                    <div class="flex items-center gap-2">
                        <p class="text-[10px] md:text-xs opacity-90 uppercase tracking-[0.2em] font-bold">Official Store</p>
                        <i class="fas fa-check-circle text-[10px] opacity-80"></i>
                    </div>
                    <p class="text-2xl md:text-3xl font-black font-sans tracking-tight">Tokopedia</p>
                </div>
            </a>

        </div>

          

    </div>
</section>

{{-- 3. PRODUCT GRID --}}
<section class="py-24 bg-slate-50 min-h-screen">
    <div class="container mx-auto px-6">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            
            @foreach($products as $i => $item)
            <div class="product-card rounded-3xl overflow-hidden relative group" data-aos="fade-up" data-aos-delay="{{ $i * 100 }}">
                
                {{-- Gambar Produk (Trigger Swing Alert saat diklik) --}}
                <div class="relative h-72 overflow-hidden cursor-pointer swing-trigger" 
                     data-img="{{ $item['image'] }}" 
                     data-title="{{ $item['name'] }}">
                    
                    <img src="{{ $item['image'] }}" alt="{{ $item['name'] }}" class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-700">
                    
                    {{-- Overlay Badge --}}
                    <div class="absolute top-4 left-4 z-10">
                        <span class="bg-white/95 backdrop-blur text-slate-900 text-xs font-bold px-4 py-1.5 rounded-full shadow-lg">
                            {{ $item['cat'] }}
                        </span>
                    </div>

                    {{-- Hover Hint --}}
                    <div class="absolute inset-0 bg-black/20 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                        <i class="fas fa-expand text-white text-4xl drop-shadow-lg transform scale-0 group-hover:scale-100 transition-transform duration-300"></i>
                    </div>
                </div>

                {{-- Info Produk --}}
                <div class="p-6">
                    <div class="flex justify-between items-start mb-3">
                        <h3 class="text-xl font-bold text-slate-800 leading-tight">{{ $item['name'] }}</h3>
                    </div>
                    
                    <div class="flex items-center justify-between pt-4 border-t border-slate-100">
                        <p class="text-xl font-black text-slate-700">{{ $item['price'] }}</p>
                        
                        {{-- Mini Buttons Marketplace --}}
                        <div class="flex gap-2">
                            <a href="{{ $shopeeLink }}" target="_blank" class="action-btn w-10 h-10 rounded-full bg-orange-100 text-orange-600 flex items-center justify-center shadow-sm hover:bg-orange-600 hover:text-white hover:shadow-orange-500/50" title="Beli di Shopee">
                                <i class="fas fa-shopping-bag"></i>
                            </a>
                            <a href="{{ $tokpedLink }}" target="_blank" class="action-btn w-10 h-10 rounded-full bg-green-100 text-green-600 flex items-center justify-center shadow-sm hover:bg-green-600 hover:text-white hover:shadow-green-500/50" title="Beli di Tokopedia">
                                <i class="fas fa-store"></i>
                            </a>
                            <a href="https://wa.me/6281234567890" target="_blank" class="action-btn w-10 h-10 rounded-full bg-slate-100 text-slate-700 flex items-center justify-center shadow-sm hover:bg-slate-800 hover:text-white" title="Tanya WA">
                                <i class="fab fa-whatsapp"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach

        </div>
    </div>
</section>

{{-- 4. CUSTOM ORDER CTA (SESUAI REQUEST) --}}
<section class="py-20 bg-white border-t border-slate-200">
    <div class="container mx-auto px-6">
        <div class="bg-gradient-to-br from-blue-800 to-slate-900 rounded-[2.5rem] p-10 md:p-16 text-center relative overflow-hidden shadow-2xl" data-aos="zoom-in-up">
            
            {{-- Background Elements --}}
            <div class="absolute top-0 right-0 w-64 h-64 bg-white/10 rounded-full blur-3xl -translate-y-1/2 translate-x-1/2 animate-pulse"></div>
            <div class="absolute bottom-0 left-0 w-64 h-64 bg-yellow-400/10 rounded-full blur-3xl translate-y-1/2 -translate-x-1/2"></div>

            <div class="relative z-10">
                <h2 class="text-3xl md:text-5xl font-black text-white mb-6">Punya Desain Sendiri?</h2>
                <p class="text-blue-100 text-lg mb-8 max-w-2xl mx-auto">
                    Kami menerima pesanan custom (kustomisasi) untuk souvenir kantor, plakat, furniture, hingga kerajinan tangan sesuai keinginan Anda.
                </p>
                <a href="https://wa.me/6281234567890" target="_blank" class="inline-flex items-center gap-3 bg-yellow-500 text-slate-900 font-bold py-4 px-10 rounded-full shadow-[0_0_20px_rgba(234,179,8,0.4)] hover:shadow-[0_0_30px_rgba(234,179,8,0.6)] hover:bg-yellow-400 hover:scale-105 transition-all duration-300">
                    <i class="fab fa-whatsapp text-2xl"></i>
                    <span>Konsultasi Gratis via WA</span>
                </a>
            </div>

        </div>
    </div>
</section>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

<script>
    AOS.init({ once: true, duration: 800 });

    // --- SWING ALERT LOGIC (KLIK GAMBAR) ---
    document.querySelectorAll('.swing-trigger').forEach(item => {
        item.addEventListener('click', function() {
            let img = this.dataset.img;
            let title = this.dataset.title;

            Swal.fire({
                title: `<span class="text-2xl font-bold">${title}</span>`,
                imageUrl: img,
                imageWidth: 400,
                imageAlt: title,
                showConfirmButton: false,
                showCloseButton: true,
                // ANIMASI SWING
                showClass: { popup: 'animate__animated animate__swing animate__fast' },
                hideClass: { popup: 'animate__animated animate__fadeOutUp animate__faster' },
                customClass: {
                    popup: 'rounded-2xl overflow-hidden',
                    image: 'rounded-lg mt-4 shadow-lg border border-slate-200'
                },
                // FOOTER TOMBOL
                footer: `
                    <div class="flex justify-center gap-3 w-full pb-2">
                        <a href="{{ $shopeeLink }}" target="_blank" class="px-5 py-2 bg-[#ff5722] text-white rounded-full font-bold shadow hover:bg-orange-700 transition">
                            <i class="fas fa-shopping-bag mr-1"></i> Shopee
                        </a>
                        <a href="{{ $tokpedLink }}" target="_blank" class="px-5 py-2 bg-[#00bfa5] text-white rounded-full font-bold shadow hover:bg-teal-700 transition">
                            <i class="fas fa-store mr-1"></i> Tokopedia
                        </a>
                    </div>
                `
            });
        });
    });
</script>
@endpush