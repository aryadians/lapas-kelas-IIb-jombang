@extends('layouts.admin')

@section('title', 'Tambah Banner')

@section('content')
<div class="space-y-6 max-w-4xl mx-auto">
    {{-- Header Section --}}
    <div class="flex items-center gap-4 bg-white p-6 rounded-2xl shadow-sm border border-slate-100">
        <div class="flex-shrink-0">
            <a href="{{ route('admin.banners.index') }}" class="w-10 h-10 flex items-center justify-center rounded-xl bg-slate-100 text-slate-500 hover:bg-slate-200 hover:text-slate-800 transition-colors">
                <i class="fas fa-arrow-left"></i>
            </a>
        </div>
        <div>
            <h1 class="text-2xl font-bold text-slate-800">Tambah Banner Baru</h1>
            <p class="text-slate-500 mt-1 text-sm">Upload gambar atau video untuk slideshow beranda.</p>
        </div>
    </div>

    {{-- Form --}}
    <form action="{{ route('admin.banners.store') }}" method="POST" enctype="multipart/form-data" class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
        @csrf

        <div class="p-8 space-y-8">
            {{-- Input File --}}
            <div>
                <label class="block text-sm font-bold text-slate-700 mb-2">Media Banner (Gambar/Video) <span class="text-rose-500">*</span></label>
                
                <div class="mt-1 flex justify-center px-6 pt-8 pb-10 border-2 border-slate-300 border-dashed rounded-2xl hover:bg-slate-50 transition-colors relative group" id="drop-zone">
                    <div class="space-y-2 text-center">
                        <i class="fas fa-cloud-upload-alt text-4xl text-slate-400 group-hover:text-blue-500 transition-colors mb-3"></i>
                        <div class="flex text-sm text-slate-600 justify-center">
                            <label for="file-upload" class="relative cursor-pointer bg-white rounded-md font-bold text-blue-600 hover:text-blue-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-blue-500 px-2 py-1">
                                <span>Pilih file</span>
                                <input id="file-upload" name="file" type="file" class="sr-only" required accept="image/*,video/mp4,video/webm" onchange="previewMedia(this)">
                            </label>
                            <p class="pl-1 pt-1">atau seret dan lepas ke sini</p>
                        </div>
                        <p class="text-xs text-slate-500 uppercase tracking-wider font-semibold">
                            JPG, PNG, MP4, WEBM (Max 20MB)
                        </p>
                    </div>
                    
                    {{-- Preview Container (Hidden initially) --}}
                    <div id="media-preview" class="hidden absolute inset-0 bg-slate-100 rounded-2xl overflow-hidden flex items-center justify-center border-2 border-blue-400 border-dashed">
                        <img id="img-preview" src="#" alt="Preview" class="hidden max-h-full object-contain">
                        <video id="vid-preview" src="#" class="hidden max-h-full w-full object-cover" controls muted loop></video>
                        <button type="button" onclick="clearMedia()" class="absolute top-3 right-3 bg-red-500 text-white p-2 rounded-lg shadow-md hover:bg-red-600 hover:scale-105 transition-all">
                            <i class="fas fa-times"></i> Hapus Media
                        </button>
                    </div>
                </div>
                @error('file') <p class="mt-2 text-sm text-rose-500"><i class="fas fa-info-circle mr-1"></i> {{ $message }}</p> @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                {{-- Input Judul --}}
                <div class="md:col-span-2">
                    <label for="title" class="block text-sm font-bold text-slate-700 mb-2">Judul Internal <span class="text-slate-400 font-normal">(Opsional)</span></label>
                    <input type="text" name="title" id="title" class="block w-full rounded-xl border-slate-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50 px-4 py-3" placeholder="Contoh: Banner HUT Kemerdekaan 2026" value="{{ old('title') }}">
                    <p class="mt-2 text-xs text-slate-500">Judul ini hanya untuk memudahkan admin mengenali banner, tidak akan ditampilkan di website.</p>
                    @error('title') <p class="mt-1 text-sm text-rose-500">{{ $message }}</p> @enderror
                </div>

                {{-- Input Order --}}
                <div>
                    <label for="order_index" class="block text-sm font-bold text-slate-700 mb-2">Urutan Tampil (Order)</label>
                    <input type="number" name="order_index" id="order_index" class="block w-full rounded-xl border-slate-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50 px-4 py-3" value="{{ old('order_index', 0) }}" placeholder="0">
                    <p class="mt-2 text-xs text-slate-500">Urutan dari yang terkecil (misal 0 tampil pertama).</p>
                    @error('order_index') <p class="mt-1 text-sm text-rose-500">{{ $message }}</p> @enderror
                </div>

                {{-- Input Status --}}
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Status Penayangan</label>
                    <label class="relative inline-flex items-center cursor-pointer mt-2">
                        <input type="checkbox" name="is_active" value="1" class="sr-only peer" {{ old('is_active', true) ? 'checked' : '' }}>
                        <div class="w-14 h-7 bg-slate-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-6 after:w-6 after:transition-all peer-checked:bg-blue-600"></div>
                        <span class="ml-3 text-sm font-medium text-slate-700 select-none peer-checked:text-blue-600 peer-checked:font-bold">Aktif / Tampilkan di Beranda</span>
                    </label>
                </div>
            </div>
        </div>

        {{-- Footer/Submit --}}
        <div class="bg-slate-50 px-8 py-5 border-t border-slate-100 flex items-center justify-end gap-3">
            <a href="{{ route('admin.banners.index') }}" class="px-6 py-2.5 rounded-xl border border-slate-300 text-slate-700 font-bold hover:bg-slate-100 transition-colors">Batal</a>
            <button type="submit" class="px-6 py-2.5 rounded-xl bg-blue-600 text-white font-bold hover:bg-blue-700 shadow-md hover:shadow-lg transition-all active:scale-95">
                <i class="fas fa-save mr-2"></i> Simpan Banner
            </button>
        </div>
    </form>
</div>

{{-- SCRIPT MEDIA PREVIEW --}}
<script>
    function previewMedia(input) {
        const previewContainer = document.getElementById('media-preview');
        const imgPreview = document.getElementById('img-preview');
        const vidPreview = document.getElementById('vid-preview');
        
        if (input.files && input.files[0]) {
            const file = input.files[0];
            const reader = new FileReader();
            
            reader.onload = function(e) {
                previewContainer.classList.remove('hidden');
                
                // Cek type (gambar atau video)
                if(file.type.startsWith('image/')) {
                    imgPreview.src = e.target.result;
                    imgPreview.classList.remove('hidden');
                    vidPreview.classList.add('hidden');
                    vidPreview.src = '';
                } else if(file.type.startsWith('video/')) {
                    vidPreview.src = e.target.result;
                    vidPreview.classList.remove('hidden');
                    imgPreview.classList.add('hidden');
                    imgPreview.src = '';
                }
            }
            
            reader.readAsDataURL(file);
        } else {
            clearMedia();
        }
    }

    function clearMedia() {
        document.getElementById('file-upload').value = '';
        document.getElementById('media-preview').classList.add('hidden');
        document.getElementById('img-preview').src = '#';
        document.getElementById('vid-preview').src = '#';
        document.getElementById('img-preview').classList.add('hidden');
        document.getElementById('vid-preview').classList.add('hidden');
    }
</script>
@endsection
