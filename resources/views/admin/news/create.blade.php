@extends('layouts.admin')

@section('title', 'Tulis Berita Baru')

@section('content')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/trix@2.0.0/dist/trix.css">
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/trix@2.0.0/dist/trix.umd.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<style>
    trix-editor { border: 2px solid #e2e8f0 !important; border-radius: 0.75rem; padding: 1rem; min-height: 300px; background: white; }
    trix-editor:focus { border-color: #3b82f6 !important; box-shadow: 0 0 0 4px rgba(59,130,246,0.1); }
    .input-field { border: 2px solid #e2e8f0; transition: all 0.2s; }
    .input-field:focus { border-color: #3b82f6; box-shadow: 0 0 0 4px rgba(59,130,246,0.1); outline: none; }
    .drop-zone { border: 2px dashed #cbd5e1; background: #f8fafc; transition: all 0.2s; }
    .drop-zone.active { border-color: #3b82f6; background: #eff6ff; }
</style>

<div class="max-w-5xl mx-auto pb-12 space-y-8"
    x-data="{
        activeMedia: 'images',
        images: [],
        videos: [],
        addImages(files) {
            Array.from(files).forEach(f => this.images.push({ file: f, url: URL.createObjectURL(f), name: f.name, size: (f.size/1024/1024).toFixed(2) }));
        },
        addVideos(files) {
            Array.from(files).forEach(f => this.videos.push({ file: f, url: URL.createObjectURL(f), name: f.name, size: (f.size/1024/1024).toFixed(2) }));
        },
        removeImage(idx) { this.images.splice(idx, 1); this.syncToInput('images', this.images); },
        removeVideo(idx) { this.videos.splice(idx, 1); this.syncToInput('videos', this.videos); },
        syncToInput(type, arr) {
            const dt = new DataTransfer();
            arr.forEach(m => dt.items.add(m.file));
            document.getElementById(type + '-input').files = dt.files;
        },
        handleImageDrop(e) {
            e.preventDefault(); e.currentTarget.classList.remove('active');
            const files = Array.from(e.dataTransfer.files).filter(f => f.type.startsWith('image/'));
            this.addImages(files); this.syncToInput('images', this.images);
        },
        handleVideoDrop(e) {
            e.preventDefault(); e.currentTarget.classList.remove('active');
            const files = Array.from(e.dataTransfer.files).filter(f => f.type.startsWith('video/'));
            this.addVideos(files); this.syncToInput('videos', this.videos);
        }
    }">

    {{-- HEADER --}}
    <header class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 animate__animated animate__fadeInDown">
        <div>
            <h1 class="text-3xl font-extrabold text-slate-800">Tulis Berita Baru</h1>
            <p class="text-slate-500 mt-1">Bagikan informasi terbaru kepada publik.</p>
        </div>
        <a href="{{ route('news.index') }}" class="inline-flex items-center gap-2 bg-white text-slate-600 font-bold py-2.5 px-5 rounded-xl shadow-sm border border-slate-200 hover:bg-slate-50 transition-all active:scale-95">
            <i class="fas fa-arrow-left text-slate-400"></i> Kembali
        </a>
    </header>

    <form action="{{ route('news.store') }}" method="POST" enctype="multipart/form-data" id="createNewsForm" class="space-y-6">
        @csrf

        {{-- Hidden file inputs --}}
        <input type="file" id="images-input" name="images[]" multiple accept="image/*" class="hidden"
            @change="addImages($event.target.files)">
        <input type="file" id="videos-input" name="videos[]" multiple accept="video/mp4,video/mov,video/avi,video/webm" class="hidden"
            @change="addVideos($event.target.files)">

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            {{-- KOLOM KIRI --}}
            <div class="lg:col-span-2 space-y-6">

                {{-- Judul --}}
                <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
                    <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2">Judul Artikel</label>
                    <input type="text" name="title" value="{{ old('title') }}"
                        class="input-field w-full px-4 py-3.5 rounded-xl bg-slate-50 text-slate-800 font-bold text-lg placeholder-slate-300"
                        placeholder="Ketik judul berita..." required>
                    @error('title') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Konten --}}
                <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
                    <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2">Isi Berita</label>
                    <input id="content" type="hidden" name="content" value="{{ old('content') }}">
                    <trix-editor input="content"></trix-editor>
                    @error('content') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- MEDIA UPLOAD --}}
                <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
                    {{-- Tabs --}}
                    <div class="flex border-b border-slate-100">
                        <button type="button"
                            @click="activeMedia = 'images'"
                            :class="activeMedia === 'images' ? 'border-b-2 border-blue-600 text-blue-600 bg-blue-50/50' : 'text-slate-400 hover:text-slate-600'"
                            class="flex-1 flex items-center justify-center gap-2 px-6 py-4 font-bold text-sm transition-all">
                            <i class="fas fa-images"></i>
                            Gambar
                            <span x-show="images.length > 0" class="bg-blue-600 text-white text-[10px] font-black px-1.5 py-0.5 rounded-full" x-text="images.length"></span>
                        </button>
                        <button type="button"
                            @click="activeMedia = 'videos'"
                            :class="activeMedia === 'videos' ? 'border-b-2 border-violet-600 text-violet-600 bg-violet-50/50' : 'text-slate-400 hover:text-slate-600'"
                            class="flex-1 flex items-center justify-center gap-2 px-6 py-4 font-bold text-sm transition-all">
                            <i class="fas fa-film"></i>
                            Video
                            <span x-show="videos.length > 0" class="bg-violet-600 text-white text-[10px] font-black px-1.5 py-0.5 rounded-full" x-text="videos.length"></span>
                        </button>
                    </div>

                    <div class="p-6">
                        {{-- Tab Gambar --}}
                        <div x-show="activeMedia === 'images'">
                            {{-- Drop Zone --}}
                            <div class="drop-zone rounded-2xl p-8 text-center cursor-pointer"
                                @click="document.getElementById('images-input').click()"
                                @dragover.prevent="$el.classList.add('active')"
                                @dragleave="$el.classList.remove('active')"
                                @drop="handleImageDrop($event)">
                                <div class="w-14 h-14 bg-blue-100 rounded-2xl flex items-center justify-center text-blue-500 text-2xl mx-auto mb-3">
                                    <i class="fas fa-images"></i>
                                </div>
                                <p class="font-bold text-slate-700">Klik atau Drag & Drop Gambar</p>
                                <p class="text-xs text-slate-400 mt-1">PNG, JPG, WEBP — Maks. 5MB per file</p>
                            </div>
                            @error('images.*') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror

                            {{-- Preview Grid --}}
                            <div x-show="images.length > 0" class="grid grid-cols-3 gap-3 mt-4">
                                <template x-for="(img, idx) in images" :key="idx">
                                    <div class="relative group rounded-xl overflow-hidden border border-slate-200 bg-slate-50 aspect-video animate__animated animate__fadeIn">
                                        <img :src="img.url" class="w-full h-full object-cover">
                                        <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-all flex flex-col items-center justify-center gap-2">
                                            <p class="text-white text-[10px] text-center font-bold px-2 leading-tight" x-text="img.name"></p>
                                            <p class="text-white/70 text-[10px]" x-text="img.size + ' MB'"></p>
                                            <button type="button" @click="removeImage(idx)"
                                                class="bg-red-600 text-white text-xs font-bold px-3 py-1 rounded-lg transition-all active:scale-95">
                                                <i class="fas fa-trash-alt mr-1"></i> Hapus
                                            </button>
                                        </div>
                                    </div>
                                </template>
                            </div>
                        </div>

                        {{-- Tab Video --}}
                        <div x-show="activeMedia === 'videos'">
                            <div class="drop-zone rounded-2xl p-8 text-center cursor-pointer"
                                @click="document.getElementById('videos-input').click()"
                                @dragover.prevent="$el.classList.add('active')"
                                @dragleave="$el.classList.remove('active')"
                                @drop="handleVideoDrop($event)">
                                <div class="w-14 h-14 bg-violet-100 rounded-2xl flex items-center justify-center text-violet-500 text-2xl mx-auto mb-3">
                                    <i class="fas fa-film"></i>
                                </div>
                                <p class="font-bold text-slate-700">Klik atau Drag & Drop Video</p>
                                <p class="text-xs text-slate-400 mt-1">MP4, MOV, AVI, WEBM — Maks. 100MB per file</p>
                            </div>
                            @error('videos.*') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror

                            {{-- Video Preview List --}}
                            <div x-show="videos.length > 0" class="space-y-3 mt-4">
                                <template x-for="(vid, idx) in videos" :key="idx">
                                    <div class="bg-slate-50 rounded-xl border border-slate-200 overflow-hidden animate__animated animate__fadeIn">
                                        <video :src="vid.url" controls class="w-full max-h-48 bg-black"></video>
                                        <div class="flex items-center justify-between px-4 py-2">
                                            <div>
                                                <p class="text-xs font-bold text-slate-700 truncate max-w-xs" x-text="vid.name"></p>
                                                <p class="text-[10px] text-slate-400" x-text="vid.size + ' MB'"></p>
                                            </div>
                                            <button type="button" @click="removeVideo(idx)"
                                                class="text-red-500 hover:text-red-700 text-xs font-bold flex items-center gap-1 transition-colors">
                                                <i class="fas fa-trash-alt"></i> Hapus
                                            </button>
                                        </div>
                                    </div>
                                </template>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- KOLOM KANAN --}}
            <div class="space-y-6">

                {{-- Status --}}
                <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
                    <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2">Status Publikasi</label>
                    <div class="relative">
                        <select name="status" class="input-field w-full px-4 py-3.5 rounded-xl bg-slate-50 text-slate-700 font-bold appearance-none cursor-pointer">
                            <option value="published" {{ old('status') == 'published' ? 'selected' : '' }}>✅ Terbitkan Sekarang</option>
                            <option value="draft" {{ old('status') == 'draft' ? 'selected' : '' }}>📝 Simpan Draft</option>
                        </select>
                        <i class="fas fa-chevron-down absolute right-4 top-4 text-slate-400 pointer-events-none"></i>
                    </div>
                </div>

                {{-- Ringkasan Media --}}
                <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 space-y-3">
                    <p class="text-xs font-black text-slate-400 uppercase tracking-widest">Ringkasan Media</p>
                    <div class="flex items-center justify-between py-2 border-b border-slate-50">
                        <div class="flex items-center gap-2 text-sm text-slate-600">
                            <i class="fas fa-images text-blue-500"></i> Gambar
                        </div>
                        <span class="font-black text-slate-800 text-sm" x-text="images.length + ' file'"></span>
                    </div>
                    <div class="flex items-center justify-between py-2">
                        <div class="flex items-center gap-2 text-sm text-slate-600">
                            <i class="fas fa-film text-violet-500"></i> Video
                        </div>
                        <span class="font-black text-slate-800 text-sm" x-text="videos.length + ' file'"></span>
                    </div>
                </div>

                {{-- Tombol --}}
                <div class="space-y-3">
                    <button type="button" onclick="confirmCreate()"
                        class="w-full py-3.5 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-bold rounded-2xl shadow-lg shadow-blue-500/30 transition-all hover:-translate-y-0.5 active:scale-95 flex items-center justify-center gap-2">
                        <i class="fas fa-paper-plane"></i> Publikasikan Berita
                    </button>
                    <a href="{{ route('news.index') }}"
                        class="block w-full py-3.5 bg-slate-100 hover:bg-slate-200 text-slate-600 font-bold rounded-2xl text-center transition-all active:scale-95">
                        Batal
                    </a>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
    const swalConfig = {
        customClass: {
            popup: 'rounded-3xl shadow-2xl',
            confirmButton: 'rounded-xl px-6 py-3 font-bold bg-blue-600 text-white mr-2',
            cancelButton: 'rounded-xl px-6 py-3 font-bold bg-slate-200 text-slate-600'
        },
        buttonsStyling: false
    };

    function confirmCreate() {
        Swal.fire({
            ...swalConfig,
            title: 'Publikasikan Berita?',
            text: 'Pastikan konten, gambar, dan video sudah sesuai.',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Ya, Publikasikan',
            cancelButtonText: 'Cek Lagi'
        }).then(result => {
            if (result.isConfirmed) {
                Swal.fire({ title: 'Mengunggah...', text: 'Mohon tunggu, sedang memproses media.', allowOutsideClick: false, showConfirmButton: false, didOpen: () => Swal.showLoading() });
                document.getElementById('createNewsForm').submit();
            }
        });
    }
</script>
@endsection