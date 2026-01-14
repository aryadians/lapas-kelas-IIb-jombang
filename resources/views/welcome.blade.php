@extends('layouts.main')

@section('content')

<section class="relative bg-gradient-to-br from-slate-900 via-blue-900 to-slate-900 text-white min-h-screen flex items-center justify-center overflow-hidden">
    {{-- Background Pattern --}}
    <div class="absolute inset-0 z-0">
        <div class="absolute inset-0 bg-[url('data:image/svg+xml,%3Csvg width="60" height="60" viewBox="0 0 60 60" xmlns="http://www.w3.org/2000/svg"%3E%3Cg fill="none" fill-rule="evenodd"%3E%3Cg fill="%23ffffff" fill-opacity="0.05"%3E%3Ccircle cx="30" cy="30" r="2"/%3E%3C/g%3E%3C/g%3E%3C/svg%3E')] opacity-20"></div>
        <div class="absolute inset-0 bg-gradient-to-b from-slate-900/70 via-slate-900/80 to-slate-900/95"></div>
        <div class="absolute inset-0 bg-gradient-to-r from-blue-900/20 to-purple-900/20"></div>
    </div>

    {{-- Floating Elements --}}
    <div class="absolute top-20 left-10 w-20 h-20 bg-blue-500/10 rounded-full blur-xl opacity-50 animate-pulse"></div>
    <div class="absolute bottom-20 right-10 w-32 h-32 bg-yellow-500/10 rounded-full blur-xl opacity-50 animate-pulse" style="animation-delay: 1s;"></div>
    <div class="absolute top-1/2 left-1/4 w-16 h-16 bg-emerald-500/10 rounded-full blur-xl opacity-50 animate-pulse" style="animation-delay: 2s;"></div>

    <div class="container mx-auto px-6 text-center relative z-10">
        {{-- Logo --}}
        <div class="mt-12 mb-16 flex justify-center">
            <div class="relative group">
                <img src="{{ asset('img/logo.png') }}"
                    alt="Logo Lapas Kelas IIB Jombang"
                    class="h-28 md:h-36 w-auto drop-shadow-2xl animate-fade-in-down relative z-10 transform group-hover:scale-110 transition-transform duration-300"
                    onerror="this.style.display='none'" loading="lazy">
                <div class="absolute -inset-4 bg-gradient-to-r from-blue-500/20 to-yellow-500/20 rounded-full blur-lg opacity-40 animate-pulse group-hover:opacity-70 group-hover:blur-xl group-hover:-inset-6 transition-all duration-300"></div>
            </div>
        </div>

        {{-- Main Heading --}}
        <h1 class="text-4xl sm:text-5xl md:text-6xl lg:text-7xl font-black mb-6 tracking-tight leading-tight animate-fade-in-up group hover:drop-shadow-2xl transition-all">
            Lapas Kelas IIB <span class="bg-gradient-to-r from-yellow-400 to-yellow-600 bg-clip-text text-transparent animate-text-shimmer">Jombang</span>
        </h1>

        {{-- Subtitle --}}
        <p class="text-lg sm:text-xl md:text-2xl text-gray-300 mb-12 max-w-4xl mx-auto font-light leading-relaxed animate-fade-in-up group card-3d" style="animation-delay: 0.2s;">
            Mewujudkan pelayanan pemasyarakatan yang <span class="font-semibold text-yellow-400 group-hover:animate-glow-pulse inline-block">PASTI</span> (Profesional, Akuntabel, Sinergi, Transparan, dan Inovatif).
        </p>

        {{-- CTA Buttons --}}
        <div class="flex flex-col sm:flex-row justify-center gap-4 animate-fade-in-up" style="animation-delay: 0.4s;">
            <a href="{{ route('kunjungan.create') }}" class="group bg-gradient-to-r from-emerald-500 to-emerald-600 hover:from-emerald-600 hover:to-emerald-700 text-white text-lg font-bold py-4 px-10 rounded-full shadow-2xl transition-all transform hover:-translate-y-2 hover:shadow-emerald-500/25 inline-flex items-center justify-center gap-3 relative overflow-hidden btn-glow card-3d shine-effect btn-hover-lift">
                <div class="absolute inset-0 bg-gradient-to-r from-white/0 via-white/20 to-white/0 transform -skew-x-12 -translate-x-full group-hover:translate-x-full transition-transform duration-1000"></div>
                <i class="fa-solid fa-user-plus text-xl relative z-10 group-hover:animate-float-up"></i>
                <span class="relative z-10">Daftar Kunjungan</span>
                <i class="fa-solid fa-arrow-right-long text-sm group-hover:translate-x-2 transition-transform relative z-10"></i>
            </a>
            <a href="#berita" class="group bg-gradient-to-r from-yellow-500 to-yellow-600 hover:from-yellow-400 hover:to-yellow-500 text-slate-900 text-lg font-bold py-4 px-10 rounded-full shadow-2xl transition-all transform hover:-translate-y-2 hover:shadow-yellow-500/25 inline-flex items-center justify-center gap-3 relative overflow-hidden btn-glow card-3d shine-effect btn-hover-lift">
                <div class="absolute inset-0 bg-gradient-to-r from-slate-900/0 via-slate-900/10 to-slate-900/0 transform -skew-x-12 -translate-x-full group-hover:translate-x-full transition-transform duration-1000"></div>
                <i class="fa-solid fa-newspaper text-xl relative z-10 group-hover:animate-float-up"></i>
                <span class="relative z-10">Berita Terbaru</span>
                <i class="fa-solid fa-arrow-right-long text-sm group-hover:translate-x-2 transition-transform relative z-10"></i>
            </a>
        </div>

        {{-- Quick Stats --}}
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mt-16 max-w-4xl mx-auto animate-fade-in-up" style="animation-delay: 0.8s;">
            <div class="bg-white/10 backdrop-blur-sm border border-white/20 rounded-2xl p-4 text-center hover:bg-white/20 transition-all card-hover-scale group card-3d hover:shadow-xl hover:shadow-blue-500/20">
                <div class="text-2xl md:text-3xl font-black text-yellow-400 mb-1 group-hover:animate-float-up">24/7</div>
                <div class="text-xs md:text-sm text-gray-300 font-medium">Layanan Online</div>
            </div>
            <div class="bg-white/10 backdrop-blur-sm border border-white/20 rounded-2xl p-4 text-center hover:bg-white/20 transition-all card-hover-scale group card-3d hover:shadow-xl hover:shadow-emerald-500/20">
                <div class="text-2xl md:text-3xl font-black text-emerald-400 mb-1 group-hover:animate-float-up">450+</div>
                <div class="text-xs md:text-sm text-gray-300 font-medium">Warga Binaan</div>
            </div>
            <div class="bg-white/10 backdrop-blur-sm border border-white/20 rounded-2xl p-4 text-center hover:bg-white/20 transition-all card-hover-scale group card-3d hover:shadow-xl hover:shadow-blue-500/20">
                <div class="text-2xl md:text-3xl font-black text-blue-400 mb-1 group-hover:animate-float-up">100+</div>
                <div class="text-xs md:text-sm text-gray-300 font-medium">Pegawai</div>
            </div>
            <div class="bg-white/10 backdrop-blur-sm border border-white/20 rounded-2xl p-4 text-center hover:bg-white/20 transition-all card-hover-scale group card-3d hover:shadow-xl hover:shadow-purple-500/20">
                <div class="text-2xl md:text-3xl font-black text-purple-400 mb-1 group-hover:animate-float-up">12+</div>
                <div class="text-xs md:text-sm text-gray-300 font-medium">Program</div>
            </div>
        </div>

        {{-- Secondary Links --}}
        <div class="flex flex-wrap justify-center gap-4 mt-8 mb-12 animate-fade-in-up" style="animation-delay: 0.6s;">
            <a href="{{ route('profile.index') }}" class="group border-2 border-white/30 hover:border-white hover:bg-white hover:text-slate-900 text-white text-sm font-semibold py-3 px-6 rounded-full shadow-lg transition-all card-hover-scale inline-flex items-center justify-center gap-2 btn-glow card-3d">
                <i class="fa-solid fa-building-columns group-hover:animate-float-up inline-block"></i>
                <span>Profil Kami</span>
            </a>
            <a href="{{ route('faq.index') }}" class="group border-2 border-white/30 hover:border-white hover:bg-white hover:text-slate-900 text-white text-sm font-semibold py-3 px-6 rounded-full shadow-lg transition-all card-hover-scale inline-flex items-center justify-center gap-2 btn-glow card-3d">
                <i class="fa-solid fa-circle-info group-hover:animate-float-up inline-block"></i>
                <span>FAQ</span>
            </a>
            <a href="#kontak" class="group border-2 border-white/30 hover:border-white hover:bg-white hover:text-slate-900 text-white text-sm font-semibold py-3 px-6 rounded-full shadow-lg transition-all card-hover-scale inline-flex items-center justify-center gap-2 btn-glow card-3d">
                <i class="fa-solid fa-phone group-hover:animate-float-up inline-block"></i>
                <span>Kontak</span>
            </a>
        </div>

    </div>
</section>

<section class="py-32 bg-gradient-to-b from-slate-50 to-white">
    <div class="container mx-auto px-6">
        <div class="max-w-6xl mx-auto">
            <div class="text-center mb-20">
                <div class="inline-flex items-center px-4 py-2 rounded-full bg-emerald-100 text-emerald-800 text-sm font-semibold mb-8">
                    <i class="fas fa-handshake mr-2"></i>
                    Komitmen Kami
                </div>
                <h2 class="text-3xl sm:text-4xl md:text-5xl font-black text-slate-800 mb-8">
                    Pelayanan yang <span class="text-emerald-600">Berkualitas</span>
                </h2>
                <div class="h-1 w-24 bg-gradient-to-r from-emerald-500 to-blue-500 mx-auto mb-8"></div>
                <p class="text-lg text-gray-600 leading-relaxed max-w-4xl mx-auto">
                    Kami berkomitmen penuh untuk menyediakan layanan pemasyarakatan yang transparan, profesional, dan berorientasi pada kemanusiaan. Keamanan, pembinaan, dan reintegrasi sosial adalah prioritas utama kami.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <div class="transition-all duration-1000 bg-white p-8 rounded-2xl shadow-xl border border-gray-100 card-hover-scale group card-3d">
                    <div class="w-16 h-16 flex items-center justify-center bg-gradient-to-br from-blue-500 to-blue-600 text-white rounded-2xl mx-auto mb-6 group-hover:scale-110 transition-transform shadow-lg group-hover:animate-float-up">
                        <i class="fa-solid fa-shield-halved text-2xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-slate-800 mb-4">Keamanan Terjamin</h3>
                    <p class="text-gray-600 leading-relaxed">Sistem keamanan berlapis untuk menjaga ketertiban dan kenyamanan bagi semua pihak dengan teknologi modern dan pengawasan 24/7.</p>
                </div>
                <div class="transition-all duration-1000 bg-white p-8 rounded-2xl shadow-xl border border-gray-100 card-hover-scale group card-3d">
                    <div class="w-16 h-16 flex items-center justify-center bg-gradient-to-br from-emerald-500 to-emerald-600 text-white rounded-2xl mx-auto mb-6 group-hover:scale-110 transition-transform shadow-lg group-hover:animate-float-up">
                        <i class="fa-solid fa-book-open-reader text-2xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-slate-800 mb-4">Pembinaan Holistik</h3>
                    <p class="text-gray-600 leading-relaxed">Program pembinaan kepribadian dan kemandirian yang komprehensif mencakup pendidikan, keterampilan, dan pembinaan mental spiritual.</p>
                </div>
                <div class="transition-all duration-1000 bg-white p-8 rounded-2xl shadow-xl border border-gray-100 card-hover-scale group card-3d">
                    <div class="w-16 h-16 flex items-center justify-center bg-gradient-to-br from-yellow-500 to-yellow-600 text-white rounded-2xl mx-auto mb-6 group-hover:scale-110 transition-transform shadow-lg group-hover:animate-float-up">
                        <i class="fa-solid fa-users-gear text-2xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-slate-800 mb-4">Pelayanan Profesional</h3>
                    <p class="text-gray-600 leading-relaxed">Petugas yang terlatih dan berintegritas siap memberikan pelayanan terbaik dengan standar operasional yang ketat dan berorientasi pada kepuasan.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<section id="berita" class="py-20 bg-gradient-to-b from-slate-50 to-white border-t border-gray-200 mb-16">
    <div class="container mx-auto px-6">

        <div class="flex flex-col lg:flex-row gap-12">

           {{-- Berita Terkini --}}
<div class="lg:w-2/3">
    <div class="flex justify-between items-center mb-12">
        <div>
            <div class="inline-flex items-center px-4 py-2 rounded-full bg-blue-100 text-blue-800 text-sm font-semibold mb-4">
                <i class="fas fa-newspaper mr-2"></i>
                Berita Terkini
            </div>
            <h2 class="text-3xl sm:text-4xl font-black text-slate-800">Informasi Terbaru</h2>
        </div>
        <a href="{{ route('news.public.index') }}" class="group inline-flex items-center text-blue-700 font-bold hover:text-blue-800 transition-colors">
            <span>Lihat Semua</span>
            <i class="fas fa-arrow-right ml-2 group-hover:translate-x-1 transition-transform"></i>
        </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        @forelse($news as $item)
        <div class="transition-all duration-700 bg-white rounded-2xl shadow-lg hover:shadow-2xl overflow-hidden group border border-gray-100 card-hover-scale card-3d">
            
            {{-- Image / Placeholder --}}
            <div class="relative h-48 overflow-hidden">
                @if(is_array($item->image) && count($item->image) > 0)
                    <img src="{{ $item->image[0] }}" alt="{{ $item->title }}" class="w-full h-full object-cover group-hover:scale-110 transition duration-500" loading="lazy">
                @else
                    <div class="w-full h-full bg-gradient-to-br from-slate-200 to-slate-300 flex items-center justify-center text-slate-400">
                        <div class="text-center">
                            <svg class="w-16 h-16 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            <span class="text-sm font-medium">Tidak ada gambar</span>
                        </div>
                    </div>
                @endif
                
                {{-- Date Badge --}}
                <div class="absolute top-4 right-4 bg-gradient-to-r from-yellow-400 to-yellow-500 text-slate-900 text-xs font-bold px-3 py-1 rounded-full shadow-lg group-hover:animate-float-up">
                    {{ $item->created_at->format('d M Y') }}
                </div>
                <div class="absolute inset-0 bg-gradient-to-t from-black/20 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
            </div>

            {{-- Content --}}
            <div class="p-6">
                <h3 class="text-lg font-bold text-slate-800 mb-3 group-hover:text-blue-700 transition-colors duration-300 line-clamp-2 leading-tight">
                    {{ $item->title }}
                </h3>
                
                {{-- PERBAIKAN: Menambahkan strip_tags() --}}
                <p class="text-gray-500 text-sm mb-4 line-clamp-3 leading-relaxed">
                    {{ Str::limit(strip_tags($item->content), 120) }}
                </p>
                
                <a href="{{ route('news.public.show', $item->slug) }}" class="inline-flex items-center text-sm font-bold text-blue-600 hover:text-blue-700 group-hover:translate-x-1 transition-all duration-300">
                    <span>Baca Selengkapnya</span>
                    <i class="fas fa-arrow-right ml-2"></i>
                </a>
            </div>
        </div>
        @empty
        <div class="col-span-1 md:col-span-2">
            <div class="text-center py-16 bg-gradient-to-br from-gray-50 to-gray-100 rounded-2xl border-2 border-dashed border-gray-300">
                <div class="w-20 h-20 bg-gray-200 rounded-full flex items-center justify-center mx-auto mb-6">
                    <span class="text-4xl">📰</span>
                </div>
                <h3 class="text-xl font-semibold text-gray-700 mb-2">Belum Ada Berita</h3>
                <p class="text-gray-500 max-w-md mx-auto">
                    Saat ini belum ada berita yang diterbitkan. Silakan kembali lagi nanti untuk informasi terbaru.
                </p>
            </div>
        </div>
        @endforelse
    </div>
</div>

           {{-- Papan Pengumuman - Sticky & Enhanced --}}
<div class="lg:w-1/3">
    <div class="lg:sticky lg:top-8">
        <div class="transition duration-700 bg-gradient-to-br from-slate-900 via-blue-900 to-slate-900 rounded-2xl shadow-2xl p-8 text-white border border-slate-700/50">
            
            {{-- Header --}}
            <div class="flex items-center justify-between mb-8 pb-6 border-b border-slate-700/50">
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-gradient-to-br from-yellow-400 to-yellow-500 rounded-xl flex items-center justify-center mr-4 shadow-lg">
                        <span class="text-2xl">📢</span>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-yellow-400">Papan Pengumuman</h3>
                        <p class="text-xs text-slate-400">Informasi Penting</p>
                    </div>
                </div>
                <div class="w-8 h-8 bg-slate-800 rounded-lg flex items-center justify-center">
                    <i class="fas fa-thumbtack text-yellow-400 text-sm"></i>
                </div>
            </div>

            {{-- Announcements List --}}
            <div class="space-y-6 max-h-96 overflow-y-auto scrollbar-thin scrollbar-thumb-slate-600 scrollbar-track-slate-800">
                @forelse($announcements as $info)
                <div class="group bg-slate-800/50 rounded-xl p-4 border border-slate-700/30 hover:bg-slate-800/70 hover:border-yellow-500/30 transition-all duration-300 card-hover-scale card-3d">
                    <div class="flex items-start space-x-3">
                        
                        {{-- Date Badge --}}
                        <div class="flex-shrink-0">
                            <div class="w-12 h-12 bg-gradient-to-br from-emerald-500 to-emerald-600 rounded-lg flex flex-col items-center justify-center shadow-lg border-2 border-emerald-400/30 group-hover:animate-float-up">
                                <span class="text-sm font-bold text-white leading-none">{{ $info->date->format('d') }}</span>
                                <span class="text-xs text-emerald-200 uppercase font-semibold">{{ $info->date->format('M') }}</span>
                            </div>
                        </div>
                        
                        {{-- Content --}}
                        <div class="flex-1 min-w-0">
                            <h4 class="text-sm font-bold text-gray-200 group-hover:text-yellow-400 transition-colors duration-300 leading-snug mb-2 line-clamp-2">
                                {{ $info->title }}
                            </h4>
                            
                            {{-- PERBAIKAN: strip_tags() ditambahkan di sini --}}
                            <p class="text-xs text-gray-400 leading-relaxed line-clamp-3">
                                {{ Str::limit(strip_tags($info->content), 80) }}
                            </p>
                            
                            <div class="mt-2 text-xs text-slate-500">
                                {{ $info->created_at->translatedFormat('d M Y') }}
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                <div class="text-center py-8 bg-slate-800/30 rounded-xl border border-dashed border-slate-600">
                    <div class="w-12 h-12 bg-slate-700 rounded-full flex items-center justify-center mx-auto mb-3">
                        <span class="text-xl">📭</span>
                    </div>
                    <p class="text-gray-400 text-sm">Tidak ada pengumuman aktif saat ini.</p>
                </div>
                @endforelse
            </div>

            {{-- Footer --}}
            <div class="mt-8 pt-6 border-t border-slate-700/50 text-center">
                <a href="{{ route('announcements.public.index') }}" class="inline-flex items-center text-sm text-slate-400 hover:text-yellow-400 transition-colors duration-300 group">
                    <span>Lihat Arsip Lengkap</span>
                    <i class="fas fa-arrow-right ml-2 group-hover:translate-x-1 transition-transform duration-300"></i>
                </a>
            </div>
        </div>
    </div>
</div>
                       

        </div>
    </div>
</section>



{{-- Contact CTA Section --}}
<section id="kontak" class="py-32 bg-gradient-to-br from-slate-900 via-blue-900 to-slate-900 text-white relative overflow-hidden">
    {{-- Background Pattern --}}
    <div class="absolute inset-0 z-0">
        <div class="absolute inset-0 bg-[url('data:image/svg+xml,%3Csvg width="60" height="60" viewBox="0 0 60 60" xmlns="http://www.w3.org/2000/svg"%3E%3Cg fill="none" fill-rule="evenodd"%3E%3Cg fill="%23ffffff" fill-opacity="0.05"%3E%3Ccircle cx="30" cy="30" r="2"/%3E%3C/g%3E%3C/g%3E%3C/svg%3E')] opacity-20"></div>
        <div class="absolute inset-0 bg-gradient-to-b from-slate-900/70 via-slate-900/80 to-slate-900/95"></div>
        <div class="absolute inset-0 bg-gradient-to-r from-blue-900/20 to-purple-900/20"></div>
    </div>

    {{-- Floating Elements --}}
    <div class="absolute top-20 left-10 w-20 h-20 bg-white/10 rounded-full blur-xl animate-pulse"></div>
    <div class="absolute bottom-20 right-10 w-32 h-32 bg-yellow-500/10 rounded-full blur-xl animate-pulse" style="animation-delay: 1s;"></div>

    <div class="container mx-auto px-6 text-center relative z-10">
        <div class="max-w-4xl mx-auto">
            <div class="inline-flex items-center px-4 py-2 rounded-full bg-white/10 backdrop-blur-sm border border-white/20 text-sm font-semibold mb-8">
                <i class="fas fa-phone mr-2"></i>
                Hubungi Kami
            </div>
            <h2 class="text-3xl sm:text-4xl md:text-5xl font-black mb-8">
                Butuh Informasi <span class="bg-gradient-to-r from-yellow-400 to-yellow-600 bg-clip-text text-transparent">Lebih Lanjut?</span>
            </h2>
            <p class="text-lg text-slate-300 mb-16 leading-relaxed">
                Hubungi kami untuk mendapatkan informasi tentang layanan kunjungan, program pembinaan, atau hal lainnya terkait Lembaga Pemasyarakatan Kelas IIB Jombang.
            </p>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-12">
                <div class="bg-white/10 backdrop-blur-sm rounded-2xl p-6 border border-white/20 hover:bg-white/20 transition-all duration-300 card-hover-scale group">
                    <div class="w-16 h-16 bg-gradient-to-br from-yellow-400 to-yellow-500 rounded-full flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition-transform shadow-lg">
                        <i class="fas fa-phone text-2xl text-white"></i>
                    </div>
                    <h3 class="font-bold mb-2">Telepon & Fax</h3>
                    <p class="text-slate-300 text-sm">+62 321 861205</p>
                </div>
                <div class="bg-white/10 backdrop-blur-sm rounded-2xl p-6 border border-white/20 hover:bg-white/20 transition-all duration-300 card-hover-scale group">
                    <div class="w-16 h-16 bg-gradient-to-br from-yellow-400 to-yellow-500 rounded-full flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition-transform shadow-lg">
                        <i class="fas fa-envelope text-2xl text-white"></i>
                    </div>
                    <h3 class="font-bold mb-2">Email</h3>
                    <p class="text-slate-300 text-sm">info@lapasjombang.go.id</p>
                </div>
                <div class="bg-white/10 backdrop-blur-sm rounded-2xl p-6 border border-white/20 hover:bg-white/20 transition-all duration-300 card-hover-scale group">
                    <div class="w-16 h-16 bg-gradient-to-br from-yellow-400 to-yellow-500 rounded-full flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition-transform shadow-lg">
                        <i class="fas fa-map-marker-alt text-2xl text-white"></i>
                    </div>
                    <h3 class="font-bold mb-2">Alamat Kantor</h3>
                    <p class="text-slate-300 text-sm">Jl. KH. Wahid Hasyim No.155<br>Jombang, Jawa Timur 61419</p>
                </div>
            </div>

            <div class="flex flex-col sm:flex-row justify-center gap-4">
                <a href="{{ route('kunjungan.create') }}" class="bg-gradient-to-r from-yellow-400 to-yellow-500 hover:from-yellow-500 hover:to-yellow-600 text-slate-900 font-bold py-4 px-8 rounded-full shadow-lg hover:shadow-xl transition-all transform hover:-translate-y-1 inline-flex items-center justify-center gap-2">
                    <i class="fas fa-user-plus"></i>
                    <span>Daftar Kunjungan Sekarang</span>
                </a>
                <a href="{{ route('faq.index') }}" class="border-2 border-white text-white font-bold py-4 px-8 rounded-full hover:bg-white hover:text-slate-900 transition-all transform hover:-translate-y-1 inline-flex items-center justify-center gap-2">
                    <i class="fas fa-question-circle"></i>
                    <span>Lihat FAQ</span>
                </a>
            </div>
        </div>
    </div>
</section>

@endsection