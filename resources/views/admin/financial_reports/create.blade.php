@extends('layouts.admin')

@section('title', 'Tambah Laporan Publik')

@section('content')

{{-- ═══════════════════════════════════════════════════════════ --}}
{{-- MODAL: Kelola Kategori (Tambah + Hapus) --}}
{{-- ═══════════════════════════════════════════════════════════ --}}
<div id="manageModal" class="fixed inset-0 z-50 hidden bg-black/60 backdrop-blur-sm flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-lg overflow-hidden">
        {{-- Header --}}
        <div class="flex items-center justify-between px-6 py-4 border-b border-slate-100 bg-slate-50">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 bg-blue-100 rounded-xl flex items-center justify-center text-blue-600">
                    <i class="fas fa-tags text-sm"></i>
                </div>
                <div>
                    <p class="font-black text-slate-800 text-sm">Kelola Kategori</p>
                    <p class="text-[10px] text-slate-400">Tambah atau hapus kategori laporan</p>
                </div>
            </div>
            <button onclick="document.getElementById('manageModal').classList.add('hidden')"
                class="w-8 h-8 rounded-lg hover:bg-slate-200 flex items-center justify-center text-slate-400 transition-all">
                <i class="fas fa-times text-sm"></i>
            </button>
        </div>

        <div class="p-6 space-y-5 max-h-[70vh] overflow-y-auto">
            {{-- Tambah Kategori Baru --}}
            <div class="bg-blue-50 border border-blue-100 rounded-2xl p-4 space-y-3">
                <p class="text-xs font-black text-blue-700 uppercase tracking-widest">Tambah Kategori Baru</p>

                {{-- Nama --}}
                <div>
                    <label class="text-[10px] font-bold text-slate-500 mb-1 block">Nama Kategori</label>
                    <input type="text" id="newCatName" placeholder="mis: Laporan Tahunan, LKjIP, SPIP..."
                        class="w-full px-3 py-2.5 bg-white border-2 border-blue-100 rounded-xl text-sm font-bold text-slate-700 focus:border-blue-400 focus:outline-none">
                </div>

                {{-- EMOJI PICKER --}}
                <div>
                    <label class="text-[10px] font-bold text-slate-500 mb-2 block">Pilih Ikon / Emoji</label>
                    <div id="emojiGrid" class="grid grid-cols-8 gap-1.5">
                        @foreach(['📄','📊','📈','📉','💰','🏦','📋','✅','🗺️','🏢','📁','🔐','🗂️','📝','💼','🔍','📌','⚖️','🎯','🔖','🏛️','👥','📅','🧾','💹','📣','🔔','🛡️','📚','✍️','🗃️','📎'] as $emoji)
                        <button type="button" onclick="selectEmoji('{{ $emoji }}')"
                            data-emoji="{{ $emoji }}"
                            class="emoji-btn aspect-square rounded-xl border-2 border-transparent hover:bg-blue-100 hover:border-blue-300 text-xl flex items-center justify-center transition-all">
                            {{ $emoji }}
                        </button>
                        @endforeach
                    </div>
                    <div class="mt-2 flex items-center gap-2">
                        <span class="text-[10px] text-slate-400 font-medium">Atau emoji custom:</span>
                        <input type="text" id="customEmojiInput" maxlength="4" placeholder="✏️"
                            class="w-16 text-center px-2 py-1.5 bg-white border-2 border-slate-200 rounded-lg text-base font-medium focus:border-blue-400 focus:outline-none"
                            oninput="selectEmoji(this.value)">
                        <div id="selectedEmojiPreview"
                            class="w-9 h-9 rounded-xl bg-slate-100 border-2 border-slate-200 flex items-center justify-center text-xl font-bold text-slate-500">
                            ?
                        </div>
                    </div>
                </div>

                <button onclick="submitNewCategory()"
                    class="w-full py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-black rounded-xl transition-all text-sm flex items-center justify-center gap-2">
                    <i class="fas fa-plus"></i> Simpan Kategori Baru
                </button>
                <div id="newCatMsg" class="hidden text-sm font-bold text-center py-1 rounded-lg"></div>
            </div>

            {{-- Daftar Kategori Existing --}}
            <div>
                <p class="text-xs font-black text-slate-500 uppercase tracking-widest mb-3">Kategori Saat Ini</p>
                <div class="space-y-2" id="categoryList">
                    @foreach($categories as $cat)
                    <div class="flex items-center justify-between bg-slate-50 border border-slate-100 rounded-xl px-4 py-3 category-row" id="cat-row-{{ $cat->id }}">
                        <div class="flex items-center gap-3">
                            <span class="text-xl w-8 text-center">
                                @if($cat->emoji){{ $cat->emoji }}@else<i class="fas {{ $cat->icon }} text-blue-500 text-base"></i>@endif
                            </span>
                            <span class="font-bold text-slate-700 text-sm">{{ $cat->name }}</span>
                        </div>
                        <button onclick="deleteCategory({{ $cat->id }}, '{{ addslashes($cat->name) }}')"
                            class="w-8 h-8 rounded-lg bg-red-50 border border-red-100 text-red-400 hover:bg-red-500 hover:text-white hover:border-red-500 transition-all flex items-center justify-center"
                            title="Hapus kategori">
                            <i class="fas fa-trash-alt text-xs"></i>
                        </button>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

{{-- ═══════════════════════════════════════════════════════════ --}}
{{-- FORM UTAMA --}}
{{-- ═══════════════════════════════════════════════════════════ --}}
<div class="max-w-3xl mx-auto space-y-6 pb-12"
    x-data="{
        categoryMode: 'existing',
        selectedCategory: '{{ old('category', $categories->first()?->name) }}',
        fileName: ''
    }">

    {{-- HEADER --}}
    <div class="flex items-center justify-between">
        <div class="flex items-center gap-4">
            <a href="{{ route('admin.financial-reports.index') }}"
                class="w-10 h-10 rounded-xl bg-white border border-slate-200 flex items-center justify-center text-slate-400 hover:text-blue-600 hover:border-blue-300 transition-all shadow-sm">
                <i class="fas fa-arrow-left text-sm"></i>
            </a>
            <div>
                <h1 class="text-2xl font-black text-slate-900 tracking-tight">Tambah Laporan Publik</h1>
                <p class="text-slate-400 text-sm">Unggah dokumen informasi publik baru.</p>
            </div>
        </div>
        <button type="button" onclick="document.getElementById('manageModal').classList.remove('hidden')"
            class="flex items-center gap-2 px-4 py-2.5 bg-white border border-slate-200 text-slate-600 font-bold rounded-xl hover:bg-blue-50 hover:border-blue-300 hover:text-blue-700 transition-all text-sm shadow-sm">
            <i class="fas fa-tags"></i> Kelola Kategori
        </button>
    </div>

    {{-- ERRORS --}}
    @if($errors->any())
    <div class="bg-red-50 border border-red-200 rounded-2xl p-4 flex gap-3">
        <i class="fas fa-exclamation-circle text-red-500 mt-0.5 flex-shrink-0"></i>
        <ul class="text-sm text-red-700 font-medium space-y-1">
            @foreach($errors->all() as $e) <li>{{ $e }}</li> @endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('admin.financial-reports.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
            <div class="p-6 space-y-6">

                {{-- Judul --}}
                <div class="space-y-1.5">
                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Judul Laporan <span class="text-red-500">*</span></label>
                    <input type="text" name="title" value="{{ old('title') }}" required
                        class="w-full px-4 py-3 bg-slate-50 border-2 border-slate-100 rounded-xl font-bold text-slate-700 text-sm focus:bg-white focus:border-blue-400 focus:outline-none transition-all @error('title') border-red-400 @enderror"
                        placeholder="Contoh: LHKPN Kepala Lapas Tahun 2025">
                </div>

                {{-- KATEGORI --}}
                <div class="space-y-3">
                    <div class="flex items-center justify-between">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest">
                            Kategori Laporan <span class="text-red-500">*</span>
                        </label>
                    </div>

                    {{-- Grid Badge Kategori --}}
                    <div class="grid grid-cols-2 sm:grid-cols-3 gap-2" id="categoryBadgeGrid">
                        @foreach($categories as $cat)
                        <label class="cursor-pointer group">
                            <input type="radio" name="category" value="{{ $cat->name }}" class="sr-only peer"
                                {{ old('category', $categories->first()?->name) == $cat->name ? 'checked' : '' }}>
                            <div class="flex items-center gap-2.5 px-3 py-2.5 bg-slate-50 border-2 border-slate-100 rounded-xl peer-checked:bg-blue-50 peer-checked:border-blue-400 peer-checked:text-blue-800 group-hover:border-slate-300 transition-all">
                                <span class="text-lg flex-shrink-0">
                                    @if($cat->emoji){{ $cat->emoji }}@else<i class="fas {{ $cat->icon }} text-sm text-slate-500 peer-checked:text-blue-600"></i>@endif
                                </span>
                                <span class="font-bold text-slate-600 text-xs truncate peer-checked:text-blue-700">{{ $cat->name }}</span>
                            </div>
                        </label>
                        @endforeach
                    </div>
                </div>

                {{-- Tahun & File --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div class="space-y-1.5">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Tahun Anggaran <span class="text-red-500">*</span></label>
                        <div class="relative">
                            <i class="fas fa-calendar absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-sm"></i>
                            <input type="number" name="year" value="{{ old('year', date('Y')) }}" required min="2000" max="{{ date('Y')+1 }}"
                                class="w-full pl-11 pr-4 py-3 bg-slate-50 border-2 border-slate-100 rounded-xl font-black text-slate-700 text-sm focus:bg-white focus:border-blue-400 focus:outline-none transition-all">
                        </div>
                    </div>

                    <div class="space-y-1.5">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Dokumen (PDF/Excel) <span class="text-red-500">*</span></label>
                        <label class="block cursor-pointer group">
                            <input type="file" name="file" required class="hidden"
                                x-on:change="fileName = $event.target.files[0]?.name || ''">
                            <div class="w-full px-4 py-3 bg-slate-50 border-2 border-dashed border-slate-200 rounded-xl flex items-center gap-3 group-hover:border-blue-400 group-hover:bg-blue-50 transition-all"
                                :class="fileName ? 'border-emerald-400 bg-emerald-50' : ''">
                                <div class="w-8 h-8 rounded-lg flex items-center justify-center flex-shrink-0"
                                    :class="fileName ? 'bg-emerald-100 text-emerald-600' : 'bg-white text-slate-400'">
                                    <i class="fas" :class="fileName ? 'fa-check-circle' : 'fa-cloud-upload-alt'" class="text-sm"></i>
                                </div>
                                <span class="text-xs font-bold truncate"
                                    :class="fileName ? 'text-emerald-700' : 'text-slate-400 group-hover:text-blue-500'"
                                    x-text="fileName || 'Pilih file dari komputer...'"></span>
                            </div>
                        </label>
                        <p class="text-[10px] text-slate-400 pl-1">Maks. 10 MB · PDF, DOC, XLS</p>
                    </div>
                </div>

                {{-- Deskripsi --}}
                <div class="space-y-1.5">
                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Ringkasan / Keterangan</label>
                    <textarea name="description" rows="3"
                        class="w-full px-4 py-3 bg-slate-50 border-2 border-slate-100 rounded-xl font-medium text-slate-700 text-sm focus:bg-white focus:border-blue-400 focus:outline-none resize-none transition-all"
                        placeholder="Gambaran singkat isi laporan ini...">{{ old('description') }}</textarea>
                </div>

                {{-- Status Publikasi --}}
                <div class="flex items-center justify-between bg-slate-50 border border-slate-200 rounded-xl px-5 py-4">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 bg-blue-100 rounded-xl flex items-center justify-center text-blue-600 flex-shrink-0">
                            <i class="fas fa-globe-asia text-sm"></i>
                        </div>
                        <div>
                            <p class="text-sm font-black text-slate-800">Publikasikan Sekarang</p>
                            <p class="text-xs text-slate-400">Langsung tampil di halaman laporan publik pengunjung.</p>
                        </div>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" name="is_published" value="1" class="sr-only peer" checked>
                        <div class="w-12 h-6 bg-slate-200 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:left-[3px] after:bg-white after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                    </label>
                </div>
            </div>

            {{-- Footer --}}
            <div class="bg-slate-50 px-6 py-4 flex justify-end gap-3 border-t border-slate-100">
                <a href="{{ route('admin.financial-reports.index') }}"
                    class="px-5 py-2.5 bg-white border border-slate-200 text-slate-600 font-bold rounded-xl hover:bg-slate-100 transition-all text-sm">
                    Batal
                </a>
                <button type="submit"
                    class="px-6 py-2.5 bg-slate-900 hover:bg-blue-600 text-white font-black rounded-xl transition-all active:scale-95 shadow-lg shadow-slate-300/50 text-sm flex items-center gap-2">
                    <i class="fas fa-save"></i> Simpan Laporan
                </button>
            </div>
        </div>
    </form>
</div>

@push('scripts')
<script>
    // ── CSRF Token ──────────────────
    const CSRF = document.querySelector('meta[name="csrf-token"]').content;

    // ── Emoji Picker ───────────────
    let selectedEmoji = '';

    function selectEmoji(emoji) {
        selectedEmoji = emoji;
        // Update preview
        document.getElementById('selectedEmojiPreview').textContent = emoji || '?';
        // Highlight grid button
        document.querySelectorAll('.emoji-btn').forEach(btn => {
            btn.classList.toggle('bg-blue-200', btn.dataset.emoji === emoji);
            btn.classList.toggle('border-blue-400', btn.dataset.emoji === emoji);
        });
        // Sync custom input
        document.getElementById('customEmojiInput').value = emoji;
    }

    // ── Tambah Kategori ────────────
    async function submitNewCategory() {
        const name  = document.getElementById('newCatName').value.trim();
        const emoji = selectedEmoji || document.getElementById('customEmojiInput').value.trim();
        const msgEl = document.getElementById('newCatMsg');

        if (!name) {
            showMsg(msgEl, 'Nama kategori tidak boleh kosong.', 'error');
            return;
        }

        try {
            const res  = await fetch('{{ route('admin.report-categories.store') }}', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': CSRF, 'Accept': 'application/json' },
                body: JSON.stringify({ name, emoji: emoji || null, icon: emoji ? null : 'fa-file-alt' }),
            });
            const data = await res.json();

            if (res.ok && data.success) {
                showMsg(msgEl, data.message, 'success');
                document.getElementById('newCatName').value = '';
                selectedEmoji = '';
                document.getElementById('selectedEmojiPreview').textContent = '?';
                document.getElementById('customEmojiInput').value = '';
                // Refresh the page to show new category
                setTimeout(() => location.reload(), 800);
            } else {
                showMsg(msgEl, data.message || 'Terjadi kesalahan.', 'error');
            }
        } catch (e) {
            showMsg(msgEl, 'Gagal menghubungi server.', 'error');
        }
    }

    // ── Hapus Kategori ─────────────
    async function deleteCategory(id, name) {
        const confirmed = await Swal.fire({
            title: `Hapus "${name}"?`,
            text: 'Kategori yang masih dipakai laporan tidak bisa dihapus.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc2626',
            cancelButtonText: 'Batal',
            confirmButtonText: 'Ya, Hapus',
        });
        if (!confirmed.isConfirmed) return;

        try {
            const res  = await fetch(`{{ url('report-categories') }}/${id}`, {
                method: 'DELETE',
                headers: { 'X-CSRF-TOKEN': CSRF, 'Accept': 'application/json' },
            });
            const data = await res.json();

            if (res.ok && data.success) {
                Swal.fire({ icon: 'success', title: 'Dihapus!', text: data.message, timer: 2000, showConfirmButton: false });
                document.getElementById(`cat-row-${id}`)?.remove();
                // Also remove from badge grid
                document.querySelectorAll(`input[value="${name}"]`).forEach(el => el.closest('label')?.remove());
            } else {
                Swal.fire({ icon: 'warning', title: 'Tidak bisa dihapus', text: data.message });
            }
        } catch (e) {
            Swal.fire({ icon: 'error', title: 'Error', text: 'Gagal menghubungi server.' });
        }
    }

    // ── Helper ─────────────────────
    function showMsg(el, msg, type) {
        el.textContent = msg;
        el.className = `text-sm font-bold text-center py-1 rounded-lg ${type === 'success' ? 'text-emerald-700 bg-emerald-50' : 'text-red-700 bg-red-50'}`;
        el.classList.remove('hidden');
        setTimeout(() => el.classList.add('hidden'), 3500);
    }
</script>
@endpush
@endsection
