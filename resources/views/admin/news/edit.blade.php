@extends('layouts.admin')

@section('title', 'Edit Berita')

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
        newImages: [],
        newVideos: [],
        removeAllVideos: false,
        addImages(files) {
            Array.from(files).forEach(f => this.newImages.push({ file: f, url: URL.createObjectURL(f), name: f.name, size: (f.size/1024/1024).toFixed(2) }));
        },
        addVideos(files) {
            Array.from(files).forEach(f => this.newVideos.push({ file: f, url: URL.createObjectURL(f), name: f.name, size: (f.size/1024/1024).toFixed(2) }));
        },
        removeNewImage(idx) { this.newImages.splice(idx, 1); this.syncToInput('images', this.newImages); },
        removeNewVideo(idx) { this.newVideos.splice(idx, 1); this.syncToInput('videos', this.newVideos); },
        syncToInput(type, arr) {
            const dt = new DataTransfer();
            arr.forEach(m => dt.items.add(m.file));
            document.getElementById(type + '-input').files = dt.files;
        },
        handleImageDrop(e) {
            e.preventDefault(); e.currentTarget.classList.remove('active');
            const files = Array.from(e.dataTransfer.files).filter(f => f.type.startsWith('image/'));
            this.addImages(files); this.syncToInput('images', this.newImages);
        },
        handleVideoDrop(e) {
            e.preventDefault(); e.currentTarget.classList.remove('active');
            const files = Array.from(e.dataTransfer.files).filter(f => f.type.startsWith('video/'));
            this.addVideos(files); this.syncToInput('videos', this.newVideos);
        }
    }">

    {{-- HEADER --}}
    <header class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 animate__animated animate__fadeInDown">
        <div>
            <h1 class="text-3xl font-extrabold text-slate-800">Edit Berita</h1>
            <p class="text-slate-500 mt-1">Memperbarui: <strong>{{ Str::limit($news->title, 50) }}</strong></p>
        </div>
        <a href="{{ route('news.index') }}" class="inline-flex items-center gap-2 bg-white text-slate-600 font-bold py-2.5 px-5 rounded-xl shadow-sm border border-slate-200 hover:bg-slate-50 transition-all active:scale-95">
            <i class="fas fa-arrow-left text-slate-400"></i> Kembali
        </a>
    </header>

    <form action="{{ route('news.update', $news->id) }}" method="POST" enctype="multipart/form-data" id="editNewsForm" class="space-y-6">
        @csrf
        @method('PUT')
        <input type="hidden" name="remove_all_videos" :value="removeAllVideos ? '1' : '0'">

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
                    <input type="text" name="title" value="{{ old('title', $news->title) }}"
                        class="input-field w-full px-4 py-3.5 rounded-xl bg-slate-50 text-slate-800 font-bold text-lg"
                        required>
                    @error('title') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Konten --}}
                <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
                    <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2">Isi Berita</label>
                    <input id="content" type="hidden" name="content" value="{{ old('content', $news->content) }}">
                    <trix-editor input="content"></trix-editor>
                    @error('content') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- MEDIA --}}
                <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
                    {{-- Tabs --}}
                    <div class="flex border-b border-slate-100">
                        <button type="button"
                            @click="activeMedia = 'images'"
                            :class="activeMedia === 'images' ? 'border-b-2 border-blue-600 text-blue-600 bg-blue-50/50' : 'text-slate-400 hover:text-slate-600'"
                            class="flex-1 flex items-center justify-center gap-2 px-6 py-4 font-bold text-sm transition-all">
                            <i class="fas fa-images"></i> Gambar
                            @if(!empty($news->image) && is_array($news->image))
                            <span class="bg-slate-200 text-slate-600 text-[10px] font-black px-1.5 py-0.5 rounded-full">{{ count($news->image) }}</span>
                            @endif
                        </button>
                        <button type="button"
                            @click="activeMedia = 'videos'"
                            :class="activeMedia === 'videos' ? 'border-b-2 border-violet-600 text-violet-600 bg-violet-50/50' : 'text-slate-400 hover:text-slate-600'"
                            class="flex-1 flex items-center justify-center gap-2 px-6 py-4 font-bold text-sm transition-all">
                            <i class="fas fa-film"></i> Video
                            @if(!empty($news->videos) && is_array($news->videos))
                            <span class="bg-slate-200 text-slate-600 text-[10px] font-black px-1.5 py-0.5 rounded-full">{{ count($news->videos) }}</span>
                            @endif
                        </button>
                    </div>

                    <div class="p-6 space-y-4">
                        {{-- Tab Gambar --}}
                        <div x-show="activeMedia === 'images'" class="space-y-4">

                            {{-- Gambar Lama --}}
                            @if(!empty($news->image) && is_array($news->image))
                            <div>
                                <p class="text-xs font-black text-slate-400 uppercase tracking-widest mb-3">Gambar Saat Ini</p>
                                <div class="grid grid-cols-3 gap-3">
                                    @foreach($news->image as $img)
                                    <div class="relative rounded-xl overflow-hidden border border-slate-200 aspect-video group">
                                        <img src="{{ $img }}" class="w-full h-full object-cover">
                                        <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-all flex items-center justify-center">
                                            <span class="text-white text-[10px] font-bold bg-black/60 px-2 py-1 rounded">Gambar Lama</span>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                                <p class="text-[11px] text-amber-600 mt-2 font-medium"><i class="fas fa-info-circle mr-1"></i>Upload gambar baru di bawah untuk mengganti gambar saat ini.</p>
                            </div>
                            <div class="border-t border-dashed border-slate-200"></div>
                            @endif

                            {{-- Drop Zone Gambar Baru --}}
                            <div class="drop-zone rounded-2xl p-6 text-center cursor-pointer"
                                @click="document.getElementById('images-input').click()"
                                @dragover.prevent="$el.classList.add('active')"
                                @dragleave="$el.classList.remove('active')"
                                @drop="handleImageDrop($event)">
                                <div class="w-12 h-12 bg-blue-100 rounded-2xl flex items-center justify-center text-blue-500 text-xl mx-auto mb-2">
                                    <i class="fas fa-images"></i>
                                </div>
                                <p class="font-bold text-slate-600 text-sm">Tambah / Ganti Gambar</p>
                                <p class="text-xs text-slate-400 mt-1">PNG, JPG, WEBP — Maks. 5MB per file</p>
                            </div>

                            {{-- Preview Gambar Baru --}}
                            <div x-show="newImages.length > 0" class="grid grid-cols-3 gap-3">
                                <template x-for="(img, idx) in newImages" :key="idx">
                                    <div class="relative group rounded-xl overflow-hidden border-2 border-blue-300 aspect-video animate__animated animate__fadeIn">
                                        <img :src="img.url" class="w-full h-full object-cover">
                                        <div class="absolute top-1 left-1 bg-blue-600 text-white text-[9px] font-black px-1.5 rounded">BARU</div>
                                        <div class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 transition-all flex items-center justify-center gap-1">
                                            <button type="button" @click="removeNewImage(idx)" class="bg-red-600 text-white text-xs font-bold px-2 py-1 rounded-lg">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </div>
                                    </div>
                                </template>
                            </div>
                        </div>

                        {{-- Tab Video --}}
                        <div x-show="activeMedia === 'videos'" class="space-y-4">

                            {{-- Video Lama --}}
                            @if(!empty($news->videos) && is_array($news->videos))
                            <div>
                                <div class="flex items-center justify-between mb-3">
                                    <p class="text-xs font-black text-slate-400 uppercase tracking-widest">Video Saat Ini</p>
                                    <button type="button" @click="removeAllVideos = true"
                                        x-show="!removeAllVideos"
                                        class="text-xs text-red-500 hover:text-red-700 font-bold flex items-center gap-1">
                                        <i class="fas fa-trash-alt"></i> Hapus Semua Video Lama
                                    </button>
                                    <span x-show="removeAllVideos" class="text-xs text-red-600 font-bold">
                                        ✓ Video lama akan dihapus saat disimpan
                                    </span>
                                </div>
                                <div class="space-y-3" :class="removeAllVideos ? 'opacity-40 pointer-events-none' : ''">
                                    @foreach($news->videos as $videoPath)
                                    <div class="bg-slate-50 rounded-xl border border-slate-200 overflow-hidden">
                                        <video controls class="w-full max-h-44 bg-black" src="{{ Storage::url($videoPath) }}"></video>
                                        <div class="px-3 py-2">
                                            <p class="text-xs font-bold text-slate-600 truncate">{{ basename($videoPath) }}</p>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                                <div class="border-t border-dashed border-slate-200 mt-4"></div>
                            </div>
                            @endif

                            {{-- Drop Zone Video Baru --}}
                            <div class="drop-zone rounded-2xl p-6 text-center cursor-pointer"
                                @click="document.getElementById('videos-input').click()"
                                @dragover.prevent="$el.classList.add('active')"
                                @dragleave="$el.classList.remove('active')"
                                @drop="handleVideoDrop($event)">
                                <div class="w-12 h-12 bg-violet-100 rounded-2xl flex items-center justify-center text-violet-500 text-xl mx-auto mb-2">
                                    <i class="fas fa-film"></i>
                                </div>
                                <p class="font-bold text-slate-600 text-sm">Tambah / Ganti Video</p>
                                <p class="text-xs text-slate-400 mt-1">MP4, MOV, AVI, WEBM — Maks. 100MB</p>
                            </div>

                            {{-- Preview Video Baru --}}
                            <div x-show="newVideos.length > 0" class="space-y-3">
                                <template x-for="(vid, idx) in newVideos" :key="idx">
                                    <div class="bg-violet-50 rounded-xl border-2 border-violet-300 overflow-hidden animate__animated animate__fadeIn">
                                        <div class="flex items-center gap-2 px-3 py-1.5 bg-violet-600">
                                            <span class="text-white text-[10px] font-black uppercase">Video Baru</span>
                                        </div>
                                        <video :src="vid.url" controls class="w-full max-h-44 bg-black"></video>
                                        <div class="flex items-center justify-between px-3 py-2">
                                            <div>
                                                <p class="text-xs font-bold text-slate-700 truncate max-w-xs" x-text="vid.name"></p>
                                                <p class="text-[10px] text-slate-400" x-text="vid.size + ' MB'"></p>
                                            </div>
                                            <button type="button" @click="removeNewVideo(idx)" class="text-red-500 hover:text-red-700 text-xs font-bold">
                                                <i class="fas fa-trash-alt"></i>
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
                            <option value="published" {{ old('status', $news->status) == 'published' ? 'selected' : '' }}>✅ Terbitkan</option>
                            <option value="draft" {{ old('status', $news->status) == 'draft' ? 'selected' : '' }}>📝 Draft</option>
                        </select>
                        <i class="fas fa-chevron-down absolute right-4 top-4 text-slate-400 pointer-events-none"></i>
                    </div>
                </div>

                {{-- Ringkasan Media --}}
                <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 space-y-3">
                    <p class="text-xs font-black text-slate-400 uppercase tracking-widest">Ringkasan Media</p>
                    <div class="flex items-center justify-between py-2 border-b border-slate-50">
                        <span class="text-sm text-slate-600"><i class="fas fa-images text-blue-500 mr-2"></i>Gambar tersimpan</span>
                        <span class="font-black text-slate-800 text-sm">{{ !empty($news->image) && is_array($news->image) ? count($news->image) : 0 }}</span>
                    </div>
                    <div class="flex items-center justify-between py-2 border-b border-slate-50">
                        <span class="text-sm text-slate-600"><i class="fas fa-film text-violet-500 mr-2"></i>Video tersimpan</span>
                        <span class="font-black text-slate-800 text-sm">{{ !empty($news->videos) && is_array($news->videos) ? count($news->videos) : 0 }}</span>
                    </div>
                    <div class="flex items-center justify-between py-2 border-b border-slate-50">
                        <span class="text-sm text-slate-600"><i class="fas fa-plus text-blue-400 mr-2"></i>Gambar baru</span>
                        <span class="font-black text-blue-600 text-sm" x-text="newImages.length + ' file'"></span>
                    </div>
                    <div class="flex items-center justify-between py-2">
                        <span class="text-sm text-slate-600"><i class="fas fa-plus text-violet-400 mr-2"></i>Video baru</span>
                        <span class="font-black text-violet-600 text-sm" x-text="newVideos.length + ' file'"></span>
                    </div>
                </div>

                {{-- Info --}}
                <div class="bg-amber-50 border border-amber-200 rounded-2xl p-4 text-xs text-amber-700">
                    <p class="font-bold mb-1"><i class="fas fa-info-circle mr-1"></i>Catatan Upload:</p>
                    <ul class="space-y-1 list-disc list-inside">
                        <li>Upload gambar baru akan <strong>mengganti</strong> semua gambar lama</li>
                        <li>Upload video baru akan <strong>mengganti</strong> semua video lama</li>
                        <li>Kosongkan input untuk mempertahankan media lama</li>
                    </ul>
                </div>

                {{-- Tombol --}}
                <div class="space-y-3">
                    <button type="button" onclick="confirmEdit()"
                        class="w-full py-3.5 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-bold rounded-2xl shadow-lg shadow-blue-500/30 transition-all hover:-translate-y-0.5 active:scale-95 flex items-center justify-center gap-2">
                        <i class="fas fa-save"></i> Simpan Perubahan
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
    function confirmEdit() {
        Swal.fire({
            customClass: {
                popup: 'rounded-3xl shadow-2xl',
                confirmButton: 'rounded-xl px-6 py-3 font-bold bg-blue-600 text-white mr-2',
                cancelButton: 'rounded-xl px-6 py-3 font-bold bg-slate-200 text-slate-600'
            },
            buttonsStyling: false,
            title: 'Simpan Perubahan?',
            text: 'Pastikan semua data sudah sesuai.',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Ya, Simpan',
            cancelButtonText: 'Batal'
        }).then(result => {
            if (result.isConfirmed) {
                Swal.fire({ title: 'Menyimpan...', text: 'Mohon tunggu, sedang memproses media.', allowOutsideClick: false, showConfirmButton: false, didOpen: () => Swal.showLoading() });
                document.getElementById('editNewsForm').submit();
            }
        });
    }
</script>
@endsection