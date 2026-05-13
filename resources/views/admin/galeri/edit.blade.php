@extends('layouts.admin')

@section('title', 'Edit Galeri')

@section('content')
<div class="max-w-2xl mx-auto">
    <form action="{{ route('admin.galeri.update', $galeri->id) }}" method="POST" enctype="multipart/form-data" class="bg-white p-8 rounded-3xl shadow-sm border border-slate-100">
        @csrf
        @method('PUT')
        <h2 class="text-xl font-bold mb-6">Edit Foto Galeri</h2>
        
        <div class="space-y-4">
            <div id="imagePreview" class="w-full h-64 bg-slate-100 rounded-2xl flex items-center justify-center border-2 border-dashed border-slate-200 mb-4 overflow-hidden">
                <img src="{{ $galeri->image_path }}" class="w-full h-full object-cover">
            </div>
            
            <input type="file" name="image" accept="image/*" onchange="previewImage(event)" class="w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
            
            <input type="text" name="title" value="{{ $galeri->title }}" placeholder="Judul Foto" class="w-full px-4 py-3 rounded-xl border border-slate-200 outline-none focus:ring-2 focus:ring-blue-500">
            
            <textarea name="description" placeholder="Deskripsi/Keterangan" rows="3" class="w-full px-4 py-3 rounded-xl border border-slate-200 outline-none focus:ring-2 focus:ring-blue-500">{{ $galeri->description }}</textarea>
            
            <div class="flex items-center gap-4">
                <input type="number" name="order_index" value="{{ $galeri->order_index }}" placeholder="Urutan" class="w-24 px-4 py-3 rounded-xl border border-slate-200 outline-none">
                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="checkbox" name="is_active" {{ $galeri->is_active ? 'checked' : '' }} class="w-5 h-5 accent-blue-600">
                    <span class="text-sm font-bold text-slate-600">Aktifkan Tampil</span>
                </label>
            </div>
        </div>

        <div class="mt-8 flex justify-end gap-3">
            <a href="{{ route('admin.galeri.index') }}" class="px-6 py-3 bg-slate-100 rounded-xl font-bold">Batal</a>
            <button class="px-6 py-3 bg-blue-600 text-white rounded-xl font-bold">Perbarui</button>
        </div>
    </form>
</div>

<script>
    function previewImage(event) {
        const reader = new FileReader();
        reader.onload = function() {
            const preview = document.getElementById('imagePreview');
            preview.innerHTML = `<img src="${reader.result}" class="w-full h-full object-cover">`;
        };
        reader.readAsDataURL(event.target.files[0]);
    }
</script>
@endsection
