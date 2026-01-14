@extends('layouts.guest')

@section('title', 'Terima Kasih!')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-2xl mx-auto bg-white p-8 rounded-lg shadow-md text-center">
        <svg class="w-16 h-16 mx-auto text-green-500 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        <h1 class="text-3xl font-bold text-gray-800">Terima Kasih!</h1>
        <p class="text-gray-600 mt-2">Anda telah mengisi survei ini sebelumnya. Kami sangat menghargai partisipasi Anda.</p>
        <div class="mt-8">
            <a href="/" class="inline-block bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Kembali ke Beranda
            </a>
        </div>
    </div>
</div>
@endsection
