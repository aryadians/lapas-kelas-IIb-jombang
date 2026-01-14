@extends('layouts.guest')

@section('title', 'Survei Kepuasan Masyarakat')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-2xl mx-auto bg-white p-8 rounded-lg shadow-md">
        <div class="text-center mb-8">
            <img src="{{ asset('img/logo.png') }}" alt="Logo Lapas Jombang" class="w-20 h-20 mx-auto mb-4">
            <h1 class="text-3xl font-bold text-gray-800">Survei Kepuasan Masyarakat</h1>
            <p class="text-gray-600 mt-2">Bantu kami menjadi lebih baik dengan mengisi survei singkat ini.</p>
        </div>

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                <strong class="font-bold">Terima Kasih!</strong>
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
            <div class="text-center">
                 <a href="/" class="inline-block bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Kembali ke Beranda
                </a>
            </div>
        @else
            <form action="{{ route('surveys.store') }}" method="POST">
                @csrf
                <input type="hidden" name="kunjungan_id" value="{{ $kunjungan->id }}">

                <div class="mb-6">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="rating">
                        Bagaimana kualitas pelayanan kami secara keseluruhan?
                    </label>
                    <div class="flex items-center justify-center space-x-2 star-rating">
                        <input type="radio" id="star5" name="rating" value="5" class="hidden" required/><label for="star5" title="Luar Biasa">5 stars</label>
                        <input type="radio" id="star4" name="rating" value="4" class="hidden"/><label for="star4" title="Baik">4 stars</label>
                        <input type="radio" id="star3" name="rating" value="3" class="hidden"/><label for="star3" title="Cukup">3 stars</label>
                        <input type="radio" id="star2" name="rating" value="2" class="hidden"/><label for="star2" title="Kurang">2 stars</label>
                        <input type="radio" id="star1" name="rating" value="1" class="hidden"/><label for="star1" title="Sangat Kurang">1 star</label>
                    </div>
                     @error('rating')
                        <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                    @enderror
                </div>


                <div class="mb-6">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="comment">
                        Saran atau masukan (opsional):
                    </label>
                    <textarea
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                        id="comment" name="comment" rows="4" placeholder="Berikan saran Anda untuk kami..."></textarea>
                </div>

                <div class="flex items-center justify-center">
                    <button
                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
                        type="submit">
                        Kirim Survei
                    </button>
                </div>
            </form>
        @endif
    </div>
</div>

<style>
.star-rating {
  direction: rtl;
  display: inline-block;
}

.star-rating input[type=radio] {
  display: none;
}

.star-rating label {
  color: #ddd;
  font-size: 2.5rem;
  padding: 0 5px;
  cursor: pointer;
  transition: all 0.2s ease-in-out;
}

.star-rating label:hover,
.star-rating label:hover ~ label,
.star-rating input[type=radio]:checked ~ label {
  color: #ffc107;
}

.star-rating label:before {
    content: '★';
}
</style>
@endsection
