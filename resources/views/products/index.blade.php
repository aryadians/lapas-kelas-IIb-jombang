@extends('layouts.main')

@section('content')

<section class="py-24 bg-slate-50">
    <div class="container mx-auto px-6">
        <div class="max-w-6xl mx-auto">
            {{-- Header --}}
            <div class="text-center mb-16 animate-fade-in-down">
                <div class="inline-flex items-center px-4 py-2 rounded-full bg-yellow-100 text-yellow-800 text-sm font-semibold mb-4">
                    <i class="fas fa-store mr-2"></i>
                    Galeri Karya
                </div>
                <h1 class="text-4xl sm:text-5xl font-black text-slate-800 mb-4">
                    Produk Hasil Karya Warga Binaan
                </h1>
                <p class="text-lg text-gray-600 leading-relaxed max-w-3xl mx-auto">
                    Lihat dan dukung kreativitas warga binaan Lapas Jombang melalui produk-produk berkualitas yang mereka hasilkan.
                </p>
            </div>

            {{-- Product Grid --}}
            @if($products->count() > 0)
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
                    @foreach($products as $product)
                        <div class="transition-all duration-700 bg-white rounded-2xl shadow-lg hover:shadow-2xl overflow-hidden group border border-gray-100 card-hover-scale card-3d animate-fade-in-up">
                            <a href="{{ route('products.show', $product) }}" class="block">
                                {{-- Image --}}
                                <div class="relative h-64 overflow-hidden">
                                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover group-hover:scale-110 transition duration-500" loading="lazy" onerror="this.src='https://via.placeholder.com/400x400.png?text=Produk'"/>
                                    <div class="absolute inset-0 bg-gradient-to-t from-black/40 via-transparent to-transparent"></div>
                                    <div class="absolute bottom-4 left-4">
                                        <span class="bg-gradient-to-r from-yellow-400 to-yellow-500 text-slate-900 text-lg font-bold px-4 py-2 rounded-lg shadow-lg">
                                            Rp {{ number_format($product->price, 0, ',', '.') }}
                                        </span>
                                    </div>
                                </div>

                                {{-- Content --}}
                                <div class="p-6">
                                    <h3 class="text-lg font-bold text-slate-800 group-hover:text-blue-700 transition-colors duration-300 line-clamp-2 leading-tight">
                                        {{ $product->name }}
                                    </h3>
                                    <p class="text-gray-500 text-sm mt-2 line-clamp-3 leading-relaxed">
                                        {{ Str::limit($product->description, 100) }}
                                    </p>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>

                {{-- Pagination --}}
                <div class="mt-16">
                    {{ $products->links() }}
                </div>
            @else
                <div class="col-span-1 md:col-span-4">
                    <div class="text-center py-24 bg-gradient-to-br from-gray-50 to-gray-100 rounded-2xl border-2 border-dashed border-gray-300">
                        <div class="w-24 h-24 bg-gray-200 rounded-full flex items-center justify-center mx-auto mb-6">
                            <span class="text-5xl">🛍️</span>
                        </div>
                        <h3 class="text-2xl font-semibold text-gray-700 mb-2">Belum Ada Produk</h3>
                        <p class="text-gray-500 max-w-md mx-auto">
                            Saat ini belum ada produk yang tersedia untuk ditampilkan. Silakan kembali lagi nanti.
                        </p>
                    </div>
                </div>
            @endif
        </div>
    </div>
</section>

@endsection
