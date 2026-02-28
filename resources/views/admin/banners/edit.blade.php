@extends('layouts.admin')

@section('title', 'Edit Banner')

@section('content')
{{-- Load Animate.css --}}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>

<div class="space-y-6 max-w-4xl mx-auto">
    {{-- Header Section --}}
    <div class="flex items-center gap-4 bg-white p-6 rounded-2xl shadow-sm border border-slate-100">
        <div class="flex-shrink-0">
            <a href="{{ route('admin.banners.index') }}" class="w-10 h-10 flex items-center justify-center rounded-xl bg-slate-100 text-slate-500 hover:bg-slate-200 hover:text-slate-800 transition-colors">
                <i class="fas fa-arrow-left"></i>
            </a>
        </div>
        <div>
            <h1 class="text-2xl font-bold text-slate-800">Edit Banner</h1>
            <p class="text-slate-500 mt-1 text-sm">Update gambar/video atau pengaturan banner.</p>
        </div>
    </div>

    {{-- Form --}}
    <form id="bannerForm" action="{{ route('admin.banners.update', $banner->id) }}" method="POST" enctype="multipart/form-data" class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
        @csrf
        @method('PUT')

        <div class="p-8 space-y-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                
                {{-- Input File Section --}}
                <div class="md:col-span-1">
                    <label class="block text-sm font-bold text-slate-700 mb-2">Ganti Media Banner</label>
                    <p class="text-xs text-slate-500 mb-3">Abaikan jika tidak ingin mengganti file saat ini.</p>
                    
                    <div class="flex justify-center px-4 pt-6 pb-8 border-2 border-slate-300 border-dashed rounded-2xl hover:bg-slate-50 transition-colors relative group h-48" id="drop-zone">
                        <div class="space-y-1 text-center self-center w-full">
                            <i class="fas fa-edit text-3xl text-slate-400 group-hover:text-amber-500 transition-colors mb-2"></i>
                            <div class="flex text-sm text-slate-600 justify-center">
                                <label for="file-upload" class="relative cursor-pointer bg-white rounded-md font-bold text-amber-600 hover:text-amber-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-amber-500 px-2">
                                    <span>Pilih file baru</span>
                                    <input id="file-upload" name="file" type="file" class="sr-only" accept="image/*,video/mp4,video/webm" onchange="previewMedia(this)">
                                </label>
                            </div>
                        </div>
                        
                        {{-- New Preview Container (Hidden initially) --}}
                        <div id="media-preview" class="hidden absolute inset-0 bg-slate-100 rounded-2xl overflow-hidden flex items-center justify-center border-2 border-amber-400 border-dashed z-10">
                            <img id="img-preview" src="#" alt="Preview" class="hidden max-h-full object-contain">
                            <video id="vid-preview" src="#" class="hidden max-h-full w-full object-cover" controls muted loop></video>
                            <button type="button" onclick="clearMedia()" class="absolute top-2 right-2 bg-red-500 text-white p-1.5 rounded-lg shadow-md hover:bg-red-600 transition-all text-xs">
                                Batal
                            </button>
                        </div>
                    </div>
                </div>

                {{-- Current Media Preview --}}
                <div class="md:col-span-1">
                    <label class="block text-sm font-bold text-slate-700 mb-2 border-b border-slate-100 pb-2">Media Saat Ini</label>
                    <div class="h-48 rounded-2xl border-2 border-slate-200 bg-slate-50 overflow-hidden relative shadow-inner">
                        @if($banner->type === 'image')
                            @if(str_starts_with($banner->file_path, 'data:image'))
                                <img src="{{ $banner->file_path }}" class="w-full h-full object-cover">
                            @else
                                <img src="{{ Storage::url($banner->file_path) }}" class="w-full h-full object-cover">
                            @endif
                        @elseif($banner->type === 'video')
                            <video src="{{ Storage::url($banner->file_path) }}" class="w-full h-full object-cover" controls muted></video>
                        @endif
                        <div class="absolute top-2 right-2 bg-black/60 text-white text-xs px-2 py-1 rounded font-bold backdrop-blur-sm">
                            <i class="fas {{ $banner->type === 'image' ? 'fa-image' : 'fa-video' }} mr-1"></i> {{ strtoupper($banner->type) }}
                        </div>
                    </div>
                </div>

                <div class="md:col-span-2 border-t border-slate-100 pt-6 mt-2 grid grid-cols-1 md:grid-cols-2 gap-8">
                    {{-- Input Judul --}}
                    <div class="md:col-span-2">
                        <label for="title" class="block text-sm font-bold text-slate-700 mb-2">Judul Internal</label>
                        <input type="text" name="title" id="title" class="block w-full rounded-xl border-slate-300 shadow-sm focus:border-amber-500 focus:ring focus:ring-amber-200 focus:ring-opacity-50 px-4 py-3" value="{{ old('title', $banner->title) }}">
                        @error('title') <p class="mt-1 text-sm text-rose-500">{{ $message }}</p> @enderror
                    </div>

                    {{-- Input Order --}}
                    <div>
                        <label for="order_index" class="block text-sm font-bold text-slate-700 mb-2">Urutan Tampil (Order)</label>
                        <input type="number" name="order_index" id="order_index" class="block w-full rounded-xl border-slate-300 shadow-sm focus:border-amber-500 focus:ring focus:ring-amber-200 focus:ring-opacity-50 px-4 py-3" value="{{ old('order_index', $banner->order_index) }}">
                        @error('order_index') <p class="mt-1 text-sm text-rose-500">{{ $message }}</p> @enderror
                    </div>

                    {{-- Input Status --}}
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Status Penayangan</label>
                        <label class="relative inline-flex items-center cursor-pointer mt-2">
                            <input type="checkbox" name="is_active" value="1" class="sr-only peer" {{ old('is_active', $banner->is_active) ? 'checked' : '' }}>
                            <div class="w-14 h-7 bg-slate-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-amber-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-6 after:w-6 after:transition-all peer-checked:bg-amber-500"></div>
                            <span class="ml-3 text-sm font-medium text-slate-700 select-none peer-checked:text-amber-600 peer-checked:font-bold">Aktif / Tampilkan di Beranda</span>
                        </label>
                    </div>
                </div>
            </div>
        </div>

        {{-- Footer/Submit --}}
        <div class="bg-slate-50 px-8 py-5 border-t border-slate-100 flex items-center justify-end gap-3">
            <a href="{{ route('admin.banners.index') }}" class="px-6 py-2.5 rounded-xl border border-slate-300 text-slate-700 font-bold hover:bg-slate-100 transition-colors">Batal</a>
            <button type="submit" id="submitBtn" class="px-6 py-2.5 rounded-xl bg-amber-500 text-white font-bold hover:bg-amber-600 shadow-md hover:shadow-lg transition-all active:scale-95 flex items-center gap-2">
                <i class="fas fa-save"></i> <span>Update Banner</span>
            </button>
        </div>
    </form>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    const swal3DConfig = {
        showClass: { popup: 'animate__animated animate__zoomInDown animate__faster' },
        hideClass: { popup: 'animate__animated animate__zoomOutUp animate__faster' },
        customClass: {
            popup: 'rounded-3xl shadow-2xl border-4 border-white/50 backdrop-blur-xl',
            title: 'text-2xl font-black text-slate-800',
            confirmButton: 'rounded-xl px-6 py-3 font-bold shadow-lg transition-all hover:-translate-y-1',
            cancelButton: 'rounded-xl px-6 py-3 font-bold shadow-lg bg-slate-200 text-slate-600 hover:bg-slate-300 transition-all hover:-translate-y-1'
        },
        buttonsStyling: false
    };

    {{-- Error Alert from Session --}}
    @if($errors->any())
        Swal.fire({
            ...swal3DConfig,
            icon: 'error',
            title: 'Oops...',
            text: 'Mohon periksa kembali formulir Anda.',
            confirmButtonText: 'Perbaiki',
            customClass: {
                ...swal3DConfig.customClass,
                confirmButton: swal3DConfig.customClass.confirmButton + ' bg-rose-500 text-white hover:bg-rose-600 shadow-rose-200'
            }
        });
    @endif

    {{-- Loading on Submit --}}
    document.getElementById('bannerForm').addEventListener('submit', function() {
        const btn = document.getElementById('submitBtn');
        btn.disabled = true;
        btn.innerHTML = '<i class="fas fa-circle-notch animate-spin"></i> Memproses...';
        btn.classList.add('opacity-75', 'cursor-not-allowed');
    });

    function previewMedia(input) {
        const previewContainer = document.getElementById('media-preview');
        const imgPreview = document.getElementById('img-preview');
        const vidPreview = document.getElementById('vid-preview');
        
        if (input.files && input.files[0]) {
            const file = input.files[0];
            const reader = new FileReader();
            
            reader.onload = function(e) {
                previewContainer.classList.remove('hidden');
                
                // Cek type
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
    }
</script>
@endpush
@endsection
