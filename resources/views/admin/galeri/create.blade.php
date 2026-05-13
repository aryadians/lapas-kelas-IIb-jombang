@extends('layouts.admin')

@section('title', 'Tambah Galeri')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <form action="{{ route('admin.galeri.store') }}" method="POST" enctype="multipart/form-data" class="bg-white p-8 rounded-3xl shadow-sm border border-slate-100">
        @csrf
        <h2 class="text-xl font-bold mb-6">Tambah Karya/Galeri</h2>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="space-y-4">
                <div id="imagePreview" class="w-full h-64 bg-slate-100 rounded-2xl flex items-center justify-center border-2 border-dashed border-slate-200 overflow-hidden">
                    <i class="fas fa-image text-4xl text-slate-300"></i>
                </div>
                <input type="file" name="image" required accept="image/*" onchange="previewImage(event)" class="w-full text-sm">
            </div>

            <div class="space-y-4">
                <input type="text" name="title" required placeholder="Judul / Nama Barang" class="w-full px-4 py-3 rounded-xl border border-slate-200 outline-none focus:ring-2 focus:ring-blue-500">
                <input type="text" name="price" placeholder="Harga (Contoh: 350000)" class="w-full px-4 py-3 rounded-xl border border-slate-200 outline-none focus:ring-2 focus:ring-blue-500">
                <input type="text" name="material" placeholder="Bahan (Contoh: Kayu Jati)" class="w-full px-4 py-3 rounded-xl border border-slate-200 outline-none focus:ring-2 focus:ring-blue-500">
                <input type="text" name="dimension" placeholder="Dimensi (Contoh: 30cm x 10cm)" class="w-full px-4 py-3 rounded-xl border border-slate-200 outline-none focus:ring-2 focus:ring-blue-500">
                <select name="status" class="w-full px-4 py-3 rounded-xl border border-slate-200 outline-none">
                    <option value="Tersedia">Tersedia</option>
                    <option value="Pre-order">Pre-order</option>
                    <option value="Sold Out">Sold Out</option>
                </select>
            </div>
        </div>
        
        <textarea name="description" placeholder="Deskripsi/Keterangan Detail" rows="4" class="w-full mt-4 px-4 py-3 rounded-xl border border-slate-200 outline-none focus:ring-2 focus:ring-blue-500"></textarea>
            
        <div class="flex items-center gap-4 mt-4">
            <input type="number" name="order_index" value="0" placeholder="Urutan" class="w-24 px-4 py-3 rounded-xl border border-slate-200 outline-none">
            <label class="flex items-center gap-2 cursor-pointer">
                <input type="checkbox" name="is_active" checked class="w-5 h-5 accent-blue-600">
                <span class="text-sm font-bold text-slate-600">Aktifkan Tampil</span>
            </label>
        </div>

        <div class="mt-8 flex justify-end gap-3">
            <a href="{{ route('admin.galeri.index') }}" class="px-6 py-3 bg-slate-100 rounded-xl font-bold">Batal</a>
            <button class="px-6 py-3 bg-blue-600 text-white rounded-xl font-bold">Simpan</button>
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
