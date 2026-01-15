@extends('layouts.main')

@section('content')

<section class="py-24 bg-white">
    <div class="container mx-auto px-6">
        <div class="max-w-5xl mx-auto">

            {{-- Back Button --}}
            <div class="mb-8">
                <a href="{{ route('products.index') }}" class="inline-flex items-center text-slate-600 hover:text-blue-700 font-semibold transition-colors group">
                    <i class="fas fa-arrow-left mr-2 group-hover:-translate-x-1 transition-transform"></i>
                    Kembali ke Katalog
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-start">
                {{-- Product Image --}}
                <div class="animate-fade-in-right">
                    <div class="relative rounded-2xl shadow-2xl overflow-hidden border-4 border-white">
                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-auto object-cover" onerror="this.src='https://via.placeholder.com/800x800.png?text=Produk'"/>
                        <div class="absolute top-4 right-4">
                            @if($product->stock > 0)
                                <span class="inline-flex items-center bg-green-100 text-green-800 text-sm font-bold px-4 py-2 rounded-full shadow-md">
                                    <i class="fas fa-check-circle mr-2"></i>Tersedia
                                </span>
                            @else
                                <span class="inline-flex items-center bg-red-100 text-red-800 text-sm font-bold px-4 py-2 rounded-full shadow-md">
                                    <i class="fas fa-times-circle mr-2"></i>Terjual
                                </span>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- Product Details --}}
                <div class="animate-fade-in-left">
                    {{-- Product Name --}}
                    <h1 class="text-4xl lg:text-5xl font-black text-slate-800 mb-4">
                        {{ $product->name }}
                    </h1>

                    {{-- Creator Info --}}
                    @if($product->creator)
                    <div class="flex items-center gap-3 mb-6 text-slate-500">
                        <i class="fas fa-user-edit"></i>
                        <span class="text-sm">Hasil karya dari: <strong class="text-slate-700">{{ $product->creator->nama }}</strong></span>
                    </div>
                    @endif
                    
                    {{-- Price --}}
                    <div class="mb-8">
                        <span class="text-5xl font-extrabold text-blue-700 bg-blue-50 px-4 py-2 rounded-lg">
                            Rp {{ number_format($product->price, 0, ',', '.') }}
                        </span>
                    </div>

                    {{-- Description --}}
                    <div class="prose max-w-none text-slate-600 leading-relaxed mb-8">
                        {!! $product->description !!}
                    </div>

                    {{-- Stock Info --}}
                    <div class="bg-slate-100 border-l-4 border-slate-300 text-slate-700 p-4 rounded-r-lg mb-8">
                        <strong>Stok Tersisa:</strong> {{ $product->stock }} buah
                    </div>

                    {{-- Action Button --}}
                    <div>
                        <button type="button" class="w-full text-center px-8 py-4 rounded-xl text-lg font-extrabold text-white bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 transition-all duration-300 shadow-lg hover:shadow-blue-500/30 transform hover:-translate-y-1 disabled:opacity-50 disabled:cursor-not-allowed" @if($product->stock <= 0) disabled @endif>
                            <i class="fas fa-shopping-cart mr-3"></i>
                            @if($product->stock > 0)
                                Hubungi untuk Membeli
                            @else
                                Stok Habis
                            @endif
                        </button>
                        <p class="text-xs text-center text-slate-500 mt-3">
                            *Untuk saat ini pembelian dilakukan secara langsung. Klik tombol untuk info lebih lanjut.
                        </p>
                    </div>

                </div>
            </div>
        </div>
    </div>
</section>

@endsection
