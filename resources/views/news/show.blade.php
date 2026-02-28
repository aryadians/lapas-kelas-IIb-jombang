@extends('layouts.main')

@section('content')

{{-- Read Progress Bar --}}
<div class="fixed top-0 left-0 z-50 w-full h-1 bg-gradient-to-r from-blue-500 to-purple-600"
    x-data="{ progressBar: 0 }"
    x-init="window.addEventListener('scroll', () => {
        let winScroll = document.body.scrollTop || document.documentElement.scrollTop;
        let height = document.documentElement.scrollHeight - document.documentElement.clientHeight;
        progressBar = (winScroll / height) * 100;
    })">
    <div class="h-full bg-gradient-to-r from-blue-600 to-purple-700 transition-all duration-100 ease-out" :style="`width: ${progressBar}%`"></div>
</div>

{{-- Breadcrumb --}}
<section class="bg-gray-50 py-4">
    <div class="container mx-auto px-6">
        <nav class="flex" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-3">
                <li class="inline-flex items-center">
                    <a href="/" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600">
                        <svg class="w-3 h-3 mr-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                            <path d="m19.707 9.293-2-2-7-7a1 1 0 0 0-1.414 0l-7 7-2 2A1 1 0 0 0 1 10h2v8a1 1 0 0 0 1 1h4a1 1 0 0 0 1-1v-4a1 1 0 0 0 1-1v-1h2v1a1 1 0 0 0 1 1v4a1 1 0 0 0 1 1h4a1 1 0 0 0 1-1v-8h2a1 1 0 0 0 .707-1.707Z"/>
                        </svg>
                        Beranda
                    </a>
                </li>
                <li>
                    <div class="flex items-center">
                        <svg class="w-3 h-3 text-gray-400 mx-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                        </svg>
                        <a href="{{ route('news.public.index') }}" class="ml-1 text-sm font-medium text-gray-700 hover:text-blue-600 md:ml-2">Berita</a>
                    </div>
                </li>
                <li aria-current="page">
                    <div class="flex items-center">
                        <svg class="w-3 h-3 text-gray-400 mx-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                        </svg>
                        <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2">{{ Str::limit($news->title, 30) }}</span>
                    </div>
                </li>
            </ol>
        </nav>
    </div>
</section>

<section class="relative bg-gradient-to-br from-slate-900 via-blue-900 to-slate-900 text-white min-h-[400px] flex items-center justify-center overflow-hidden">
    <div class="absolute inset-0 z-0">
        <img src="{{ (is_array($news->image) && count($news->image) > 0) ? $news->image[0] : asset('img/default-news-background.jpg') }}"
            alt="Background News"
            class="w-full h-full object-cover opacity-40">
        <div class="absolute inset-0 bg-gradient-to-b from-slate-900/70 via-slate-900/80 to-slate-900/95"></div>
        <div class="absolute inset-0 bg-gradient-to-r from-blue-900/20 to-purple-900/20"></div>
    </div>
    <div class="container mx-auto px-6 text-center relative z-10">
        <div class="inline-flex items-center px-4 py-2 rounded-full bg-white/10 backdrop-blur-sm border border-white/20 text-sm font-medium text-white mb-6">
            <i class="fas fa-newspaper mr-2"></i>
            Berita Terbaru
        </div>
        <h1 class="text-4xl md:text-6xl font-black mb-6 tracking-tight leading-tight">
            {{ $news->title }}
        </h1>
        <div class="flex items-center justify-center space-x-6 text-gray-300 mb-8">
            <div class="flex items-center bg-white/10 backdrop-blur-sm px-4 py-2 rounded-full">
                <i class="fas fa-calendar-alt mr-2"></i>
                <span>{{ $news->created_at->translatedFormat('l, d F Y') }}</span>
            </div>
            <div class="flex items-center bg-white/10 backdrop-blur-sm px-4 py-2 rounded-full">
                <i class="fas fa-clock mr-2"></i>
                <span>{{ $news->created_at->translatedFormat('H:i') }} WIB</span>
            </div>
            <div class="flex items-center bg-white/10 backdrop-blur-sm px-4 py-2 rounded-full">
                <i class="fas fa-book-open mr-2"></i>
                <span>{{ ceil(str_word_count(strip_tags($news->content)) / 200) }} menit baca</span>
            </div>
        </div>
    </div>
</section>

<section class="py-20 bg-white">
    <div class="container mx-auto px-6 max-w-5xl">
        {{-- Social Sharing Buttons --}}
        <div class="flex justify-center gap-4 mb-12">
            <div class="bg-white rounded-2xl shadow-xl p-6">
                <div class="text-center mb-4">
                    <h4 class="text-lg font-bold text-gray-800 mb-2">Bagikan Berita Ini</h4>
                    <p class="text-sm text-gray-600">Bantu sebarkan informasi penting ini</p>
                </div>
                <div class="flex justify-center gap-3">
                    <a href="https://wa.me/?text={{ urlencode($news->title . ' ' . route('news.public.show', $news->slug)) }}" target="_blank" class="bg-green-500 hover:bg-green-600 text-white p-3 rounded-xl transition-all transform hover:-translate-y-1 hover:shadow-lg group" aria-label="Share on WhatsApp">
                        <i class="fab fa-whatsapp text-xl group-hover:scale-110 transition-transform"></i>
                    </a>
                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(route('news.public.show', $news->slug)) }}" target="_blank" class="bg-blue-600 hover:bg-blue-700 text-white p-3 rounded-xl transition-all transform hover:-translate-y-1 hover:shadow-lg group" aria-label="Share on Facebook">
                        <i class="fab fa-facebook-f text-xl group-hover:scale-110 transition-transform"></i>
                    </a>
                    <a href="https://twitter.com/intent/tweet?url={{ urlencode(route('news.public.show', $news->slug)) }}&text={{ urlencode($news->title) }}" target="_blank" class="bg-sky-500 hover:bg-sky-600 text-white p-3 rounded-xl transition-all transform hover:-translate-y-1 hover:shadow-lg group" aria-label="Share on Twitter">
                        <i class="fab fa-twitter text-xl group-hover:scale-110 transition-transform"></i>
                    </a>
                    <button onclick="navigator.share({title: '{{ $news->title }}', url: '{{ route('news.public.show', $news->slug) }}'})" class="bg-gray-600 hover:bg-gray-700 text-white p-3 rounded-xl transition-all transform hover:-translate-y-1 hover:shadow-lg group" aria-label="Share">
                        <i class="fas fa-share-alt text-xl group-hover:scale-110 transition-transform"></i>
                    </button>
                </div>
            </div>
        </div>

        {{-- Main Content --}}
        <article class="bg-white rounded-2xl shadow-xl overflow-hidden mt-6">
            @if(is_array($news->image) && count($news->image) > 0)
                {{-- Instagram-Style Image Slider using Alpine.js --}}
                <div x-data="{ 
                        activeSlide: 0, 
                        totalSlides: {{ count($news->image) }},
                        next() { this.activeSlide = this.activeSlide === this.totalSlides - 1 ? 0 : this.activeSlide + 1; },
                        prev() { this.activeSlide = this.activeSlide === 0 ? this.totalSlides - 1 : this.activeSlide - 1; }
                    }" 
                    class="relative w-full aspect-square md:aspect-[4/3] bg-gray-100 overflow-hidden group">
                    
                    {{-- Slides Container --}}
                    <div class="flex h-full transition-transform duration-500 ease-in-out" 
                         :style="`transform: translateX(-${activeSlide * 100}%)`">
                        @foreach($news->image as $index => $img)
                            <div class="w-full h-full flex-shrink-0 relative bg-black/5 flex items-center justify-center">
                                <img src="{{ $img }}" alt="{{ $news->title }} - Slide {{ $index + 1 }}" 
                                     class="w-full h-full object-contain backdrop-blur-2xl" loading="lazy">
                            </div>
                        @endforeach
                    </div>

                    {{-- Left & Right Navigation Arrows --}}
                    @if(count($news->image) > 1)
                        <button @click="prev()" 
                                class="absolute top-1/2 left-4 -translate-y-1/2 w-8 h-8 md:w-10 md:h-10 rounded-full bg-white/80 hover:bg-white text-gray-800 shadow-lg flex justify-center items-center opacity-0 group-hover:opacity-100 transition-opacity z-10 focus:outline-none">
                            <i class="fas fa-chevron-left text-sm md:text-base"></i>
                        </button>
                        <button @click="next()" 
                                class="absolute top-1/2 right-4 -translate-y-1/2 w-8 h-8 md:w-10 md:h-10 rounded-full bg-white/80 hover:bg-white text-gray-800 shadow-lg flex justify-center items-center opacity-0 group-hover:opacity-100 transition-opacity z-10 focus:outline-none">
                            <i class="fas fa-chevron-right text-sm md:text-base"></i>
                        </button>
                        
                        {{-- Instagram-like Dots/Pagination Indicator --}}
                        <div class="absolute bottom-4 left-0 right-0 flex justify-center gap-1.5 z-10 shrink-0">
                            <template x-for="i in totalSlides" :key="i">
                                <button @click="activeSlide = i - 1"
                                        class="transition-all duration-300 rounded-full bg-white shadow-sm"
                                        :class="activeSlide === (i - 1) ? 'w-2 h-2 opacity-100' : 'w-1.5 h-1.5 opacity-50 hover:opacity-100'"></button>
                            </template>
                        </div>
                        
                        {{-- Image Counter Badge (Top Right) --}}
                        <div class="absolute top-4 right-4 bg-black/60 text-white text-[10px] md:text-xs font-bold px-2.5 py-1 rounded-full backdrop-blur-sm z-10 tracking-widest">
                            <span x-text="activeSlide + 1"></span> / {{ count($news->image) }}
                        </div>
                    @endif
                </div>
            @endif

            <div class="p-8 md:p-12">
                <div class="prose prose-xl prose-slate max-w-none prose-headings:text-slate-800 prose-p:text-gray-700 prose-p:leading-relaxed prose-a:text-blue-600 prose-a:no-underline hover:prose-a:underline prose-strong:text-slate-900 prose-blockquote:border-l-blue-500 prose-blockquote:text-slate-700 prose-li:text-gray-700">
                    {!! $news->content !!}
                </div>
            </div>
        </article>

        {{-- Article Navigation --}}
        <div class="mt-16 bg-gradient-to-r from-blue-50 to-indigo-50 rounded-2xl p-8 border border-blue-100">
            <h3 class="text-2xl font-bold text-slate-800 mb-6 text-center">Artikel Lainnya</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- Previous Article --}}
                @if($previousNews)
                <a href="{{ route('news.public.show', $previousNews->slug) }}" class="group bg-white rounded-xl p-6 shadow-lg hover:shadow-xl transition-all transform hover:-translate-y-1 border border-gray-100">
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-blue-500 rounded-full flex items-center justify-center mr-4 group-hover:bg-blue-600 transition-colors">
                            <i class="fas fa-arrow-left text-white"></i>
                        </div>
                        <div class="flex-1">
                            <p class="text-sm text-blue-600 font-semibold mb-1">Artikel Sebelumnya</p>
                            <h4 class="font-bold text-slate-800 group-hover:text-blue-700 transition-colors line-clamp-2">{{ $previousNews->title }}</h4>
                        </div>
                    </div>
                </a>
                @else
                <div class="bg-gray-100 rounded-xl p-6 border border-gray-200 opacity-50">
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-gray-400 rounded-full flex items-center justify-center mr-4">
                            <i class="fas fa-arrow-left text-white"></i>
                        </div>
                        <div class="flex-1">
                            <p class="text-sm text-gray-500 font-semibold mb-1">Artikel Sebelumnya</p>
                            <p class="text-gray-400">Tidak ada artikel sebelumnya</p>
                        </div>
                    </div>
                </div>
                @endif

                {{-- Next Article --}}
                @if($nextNews)
                <a href="{{ route('news.public.show', $nextNews->slug) }}" class="group bg-white rounded-xl p-6 shadow-lg hover:shadow-xl transition-all transform hover:-translate-y-1 border border-gray-100">
                    <div class="flex items-center">
                        <div class="flex-1 text-right mr-4">
                            <p class="text-sm text-blue-600 font-semibold mb-1">Artikel Selanjutnya</p>
                            <h4 class="font-bold text-slate-800 group-hover:text-blue-700 transition-colors line-clamp-2">{{ $nextNews->title }}</h4>
                        </div>
                        <div class="w-12 h-12 bg-blue-500 rounded-full flex items-center justify-center group-hover:bg-blue-600 transition-colors">
                            <i class="fas fa-arrow-right text-white"></i>
                        </div>
                    </div>
                </a>
                @else
                <div class="bg-gray-100 rounded-xl p-6 border border-gray-200 opacity-50">
                    <div class="flex items-center">
                        <div class="flex-1 text-right mr-4">
                            <p class="text-sm text-gray-500 font-semibold mb-1">Artikel Selanjutnya</p>
                            <p class="text-gray-400">Tidak ada artikel selanjutnya</p>
                        </div>
                        <div class="w-12 h-12 bg-gray-400 rounded-full flex items-center justify-center">
                            <i class="fas fa-arrow-right text-white"></i>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</section>

{{-- Back to Top Button --}}
<button x-data="{ showButton: false }" @scroll.window="showButton = (window.pageYOffset > 300) ? true : false"
    x-show="showButton" x-transition:enter="transition ease-out duration-300" x-transition:leave="transition ease-in duration-200"
    @click="window.scrollTo({top: 0, behavior: 'smooth'})"
    class="fixed bottom-8 right-8 bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white p-4 rounded-full shadow-2xl transition-all duration-300 z-40 focus:outline-none focus:ring-4 focus:ring-blue-300 hover:scale-110"
    aria-label="Back to top">
    <i class="fa-solid fa-arrow-up text-lg"></i>
</button>

@endsection