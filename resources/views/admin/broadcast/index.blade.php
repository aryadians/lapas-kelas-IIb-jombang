@extends('layouts.admin')

@section('content')
<div class="space-y-6">
    <h1 class="text-2xl font-black">Broadcast Pengumuman Darurat</h1>
    
    @if(session('success'))
    <div class="bg-green-100 p-4 rounded-xl text-green-800 font-bold">{{ session('success') }}</div>
    @endif

    <form action="{{ route('admin.broadcast.update', $template->id) }}" method="POST" class="bg-white p-6 rounded-3xl shadow-sm border space-y-4">
        @csrf
        @method('PUT')
        <div>
            <label class="font-bold">WhatsApp Template</label>
            <textarea name="whatsapp_body" class="w-full p-3 border rounded-xl" rows="4">{{ $template->whatsapp_body }}</textarea>
        </div>
        <div>
            <label class="font-bold">Email Subject</label>
            <input type="text" name="email_subject" value="{{ $template->email_subject }}" class="w-full p-3 border rounded-xl">
        </div>
        <div>
            <label class="font-bold">Email Body (HTML)</label>
            <textarea name="email_body" class="w-full p-3 border rounded-xl" rows="6">{{ $template->email_body }}</textarea>
        </div>
        <button type="submit" class="bg-blue-600 text-white px-6 py-3 rounded-xl font-bold">Simpan Template</button>
    </form>

    <form action="{{ route('admin.broadcast.send') }}" method="POST" class="bg-white p-6 rounded-3xl shadow-sm border space-y-4">
        @csrf
        <h2 class="text-lg font-black">Kirim Broadcast ke Pengunjung</h2>
        <div>
            <label class="font-bold">Tanggal Kunjungan (Target)</label>
            <input type="date" name="tanggal" class="w-full p-3 border rounded-xl" required>
        </div>
        <div>
            <label class="font-bold">Alasan</label>
            <input type="text" name="alasan" class="w-full p-3 border rounded-xl" required>
        </div>
        <button type="submit" class="bg-rose-600 text-white px-6 py-3 rounded-xl font-bold">Kirim Broadcast Sekarang</button>
    </form>
</div>
@endsection
