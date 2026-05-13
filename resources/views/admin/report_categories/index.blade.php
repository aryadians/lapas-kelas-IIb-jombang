@extends('layouts.admin')

@section('title', 'Manajemen Kategori Laporan')

@section('content')
<div class="space-y-6 pb-12" x-data="categoryApp()">

    {{-- HEADER --}}
    <div class="flex items-center justify-between">
        <div class="flex items-center gap-4">
            <a href="{{ route('admin.financial-reports.index') }}"
                class="w-10 h-10 rounded-xl bg-white border border-slate-200 flex items-center justify-center text-slate-400 hover:text-blue-600 hover:border-blue-300 transition-all shadow-sm">
                <i class="fas fa-arrow-left text-sm"></i>
            </a>
            <div>
                <h1 class="text-2xl font-black text-slate-900 tracking-tight">Manajemen Kategori Laporan</h1>
                <p class="text-slate-400 text-sm">Kelola kategori dan ikon informasi publik.</p>
            </div>
        </div>
        <button type="button" @click="openCreateModal()"
            class="inline-flex items-center gap-2 bg-slate-900 hover:bg-blue-600 text-white font-black px-5 py-2.5 rounded-2xl shadow-xl transition-all hover:-translate-y-0.5 active:scale-95 text-sm">
            <i class="fas fa-plus"></i> Tambah Kategori
        </button>
    </div>

    {{-- LIST KATEGORI --}}
    <div class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden overflow-x-auto">
        <table class="w-full text-sm text-left">
            <thead class="bg-slate-50 border-b border-slate-100">
                <tr>
                    <th class="px-6 py-4 font-black uppercase tracking-widest text-[10px] text-slate-400 w-16 text-center">No</th>
                    <th class="px-6 py-4 font-black uppercase tracking-widest text-[10px] text-slate-400 w-20 text-center">Ikon</th>
                    <th class="px-6 py-4 font-black uppercase tracking-widest text-[10px] text-slate-400">Nama Kategori</th>
                    <th class="px-6 py-4 font-black uppercase tracking-widest text-[10px] text-slate-400 text-center">Urutan</th>
                    <th class="px-6 py-4 font-black uppercase tracking-widest text-[10px] text-slate-400 text-center">Jumlah Laporan</th>
                    <th class="px-6 py-4 font-black uppercase tracking-widest text-[10px] text-slate-400 text-center w-32">Opsi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @foreach($categories as $index => $cat)
                <tr class="hover:bg-blue-50/30 transition-colors group">
                    <td class="px-6 py-4 text-center font-bold text-slate-400">{{ $index + 1 }}</td>
                    <td class="px-6 py-4 text-center">
                        <div class="w-12 h-12 rounded-2xl bg-slate-100 flex items-center justify-center text-2xl shadow-inner mx-auto">
                            @if($cat->emoji)
                                {{ $cat->emoji }}
                            @else
                                <i class="fas {{ $cat->icon }} text-blue-600 text-xl"></i>
                            @endif
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="font-black text-slate-800 text-base leading-tight">{{ $cat->name }}</div>
                        <p class="text-[10px] text-slate-400 mt-1 uppercase tracking-widest font-bold">
                            {{ $cat->emoji ? 'Mode: Emoji' : 'Mode: Font Awesome (' . $cat->icon . ')' }}
                        </p>
                    </td>
                    <td class="px-6 py-4 text-center">
                        <span class="px-3 py-1 bg-slate-100 rounded-lg font-black text-slate-600 border border-slate-200">{{ $cat->sort_order }}</span>
                    </td>
                    <td class="px-6 py-4 text-center">
                        <span class="font-black text-blue-600 text-lg">{{ $cat->financialReports->count() }}</span>
                    </td>
                    <td class="px-6 py-4 text-center">
                        <div class="flex justify-center items-center gap-2">
                            <button @click="openEditModal({{ json_encode($cat) }})"
                                class="w-9 h-9 rounded-xl bg-amber-50 hover:bg-amber-500 border-2 border-amber-100 hover:border-amber-500 text-amber-600 hover:text-white transition-all flex items-center justify-center hover:shadow-md hover:shadow-amber-500/30 active:scale-95">
                                <i class="fas fa-pencil-alt text-xs"></i>
                            </button>
                            <button @click="confirmDelete({{ $cat->id }}, '{{ addslashes($cat->name) }}')"
                                class="w-9 h-9 rounded-xl bg-red-50 hover:bg-red-500 border-2 border-red-100 hover:border-red-500 text-red-500 hover:text-white transition-all flex items-center justify-center hover:shadow-md hover:shadow-red-500/30 active:scale-95">
                                <i class="fas fa-trash-alt text-xs"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- MODAL CREATE/EDIT --}}
    <div x-show="isModalOpen" style="display: none;" class="fixed inset-0 z-[100] flex items-center justify-center p-4" x-transition.opacity>
        <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm" @click="closeModal()"></div>
        <div class="bg-white rounded-[2rem] w-full max-w-xl shadow-2xl relative z-10 flex flex-col max-h-[90vh]" x-transition.scale.95>
            
            <div class="p-6 border-b border-slate-100 flex justify-between items-center bg-slate-50/50 rounded-t-[2rem]">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-2xl bg-indigo-100 text-indigo-600 flex items-center justify-center">
                        <i class="fas fa-tags"></i>
                    </div>
                    <div>
                        <h2 class="text-lg font-black text-slate-800" x-text="editMode ? 'Edit Kategori' : 'Tambah Kategori Baru'"></h2>
                        <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest">Kategori Laporan Publik</p>
                    </div>
                </div>
                <button @click="closeModal()" class="w-8 h-8 rounded-full bg-slate-200 text-slate-500 hover:bg-rose-500 hover:text-white transition-colors">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            
            <form @submit.prevent="submitForm()" class="flex flex-col flex-1 overflow-hidden">
                <div class="p-8 space-y-6 overflow-y-auto">
                    
                    {{-- Nama Kategori --}}
                    <div class="space-y-1.5">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Nama Kategori <span class="text-red-500">*</span></label>
                        <input type="text" x-model="formData.name" required placeholder="Contoh: LKjIP, Laporan Keuangan..." 
                            class="w-full px-4 py-3 bg-slate-50 border-2 border-slate-100 rounded-xl font-bold text-slate-700 text-sm focus:bg-white focus:border-blue-400 focus:outline-none transition-all">
                    </div>

                    {{-- Urutan --}}
                    <div class="space-y-1.5">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Urutan Tampilan</label>
                        <input type="number" x-model="formData.sort_order" class="w-full px-4 py-3 bg-slate-50 border-2 border-slate-100 rounded-xl font-black text-slate-700 text-sm focus:border-blue-400 focus:outline-none">
                    </div>

                    {{-- TYPE PICKER --}}
                    <div class="grid grid-cols-2 gap-3 p-1 bg-slate-100 rounded-2xl">
                        <button type="button" @click="formData.useEmoji = false" 
                            :class="!formData.useEmoji ? 'bg-white shadow-sm text-blue-600' : 'text-slate-500'"
                            class="flex items-center justify-center gap-2 py-2 rounded-xl text-xs font-black transition-all">
                            <i class="fas fa-font-awesome"></i> Font Awesome
                        </button>
                        <button type="button" @click="formData.useEmoji = true" 
                            :class="formData.useEmoji ? 'bg-white shadow-sm text-blue-600' : 'text-slate-500'"
                            class="flex items-center justify-center gap-2 py-2 rounded-xl text-xs font-black transition-all">
                            <i class="far fa-smile"></i> Emoji
                        </button>
                    </div>

                    {{-- FONT AWESOME PICKER --}}
                    <div x-show="!formData.useEmoji" class="space-y-3">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Pilih Ikon</label>
                        <div class="grid grid-cols-6 gap-2">
                            <template x-for="icon in faIcons">
                                <button type="button" @click="formData.icon = icon"
                                    :class="formData.icon === icon ? 'bg-blue-600 text-white border-blue-600' : 'bg-slate-50 text-slate-400 border-slate-200 hover:border-blue-300'"
                                    class="w-full aspect-square border-2 rounded-xl flex items-center justify-center text-xl transition-all">
                                    <i class="fas" :class="icon"></i>
                                </button>
                            </template>
                        </div>
                        <div class="flex items-center gap-3">
                            <input type="text" x-model="formData.icon" placeholder="fa-custom-icon" 
                                class="flex-1 px-4 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs font-mono">
                            <div class="w-10 h-10 rounded-xl bg-slate-900 text-white flex items-center justify-center text-lg">
                                <i class="fas" :class="formData.icon || 'fa-question'"></i>
                            </div>
                        </div>
                    </div>

                    {{-- EMOJI PICKER --}}
                    <div x-show="formData.useEmoji" class="space-y-3">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Pilih Emoji</label>
                        <div class="grid grid-cols-8 gap-2">
                            <template x-for="emoji in emojis">
                                <button type="button" @click="formData.emoji = emoji"
                                    :class="formData.emoji === emoji ? 'bg-blue-100 border-blue-400' : 'bg-slate-50 border-slate-100'"
                                    class="w-full aspect-square border-2 rounded-xl flex items-center justify-center text-2xl transition-all" x-text="emoji">
                                </button>
                            </template>
                        </div>
                        <div class="flex items-center gap-3">
                            <input type="text" x-model="formData.emoji" maxlength="4" placeholder="✏️" 
                                class="w-20 px-4 py-2 bg-slate-50 border border-slate-200 rounded-xl text-center text-lg">
                            <span class="text-xs text-slate-400 font-medium italic">Preview di samping:</span>
                            <div class="w-10 h-10 rounded-xl bg-slate-100 border border-slate-200 flex items-center justify-center text-2xl" x-text="formData.emoji || '?'"></div>
                        </div>
                    </div>

                </div>
                
                <div class="p-6 border-t border-slate-100 bg-slate-50/50 flex justify-end gap-3 rounded-b-[2rem]">
                    <button type="button" @click="closeModal()" class="px-6 py-2.5 bg-white border border-slate-200 text-slate-600 font-bold rounded-xl hover:bg-slate-100 transition-all text-sm">Batal</button>
                    <button type="submit" :disabled="isLoading" 
                        class="px-8 py-2.5 bg-slate-900 hover:bg-blue-600 disabled:opacity-50 text-white font-black rounded-xl shadow-lg shadow-slate-300/50 transition-all active:scale-95 text-sm flex items-center gap-2">
                        <i class="fas" :class="isLoading ? 'fa-spinner fa-spin' : 'fa-save'"></i>
                        <span x-text="editMode ? 'Simpan Perubahan' : 'Tambah Kategori'"></span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function categoryApp() {
        return {
            isModalOpen: false,
            editMode: false,
            isLoading: false,
            formData: {
                id: null,
                name: '',
                icon: 'fa-file-alt',
                emoji: '',
                sort_order: 0,
                useEmoji: false
            },
            faIcons: [
                'fa-file-alt', 'fa-chart-line', 'fa-money-bill-transfer', 'fa-vault', 
                'fa-map', 'fa-tasks', 'fa-building', 'fa-landmark', 'fa-gavel', 
                'fa-shield-halved', 'fa-book', 'fa-folder-open', 'fa-clipboard-list',
                'fa-user-tie', 'fa-bullhorn', 'fa-hand-holding-dollar', 'fa-file-signature',
                'fa-briefcase'
            ],
            emojis: ['📄','📊','📈','📉','💰','🏦','📋','✅','🗺️','🏢','📁','🔐','🗂️','📝','💼','🔍','📌','⚖️','🏛️','🛡️','📚','💹','📣','🔔'],

            openCreateModal() {
                this.editMode = false;
                this.formData = {
                    id: null,
                    name: '',
                    icon: 'fa-file-alt',
                    emoji: '',
                    sort_order: {{ $categories->max('sort_order') + 1 }},
                    useEmoji: false
                };
                this.isModalOpen = true;
            },

            openEditModal(cat) {
                this.editMode = true;
                this.formData = {
                    id: cat.id,
                    name: cat.name,
                    icon: cat.icon || 'fa-file-alt',
                    emoji: cat.emoji || '',
                    sort_order: cat.sort_order,
                    useEmoji: !!cat.emoji
                };
                this.isModalOpen = true;
            },

            closeModal() {
                this.isModalOpen = false;
            },

            async submitForm() {
                this.isLoading = true;
                const url = this.editMode 
                    ? `{{ url('report-categories') }}/${this.formData.id}` 
                    : `{{ route('admin.report-categories.store') }}`;
                
                const method = this.editMode ? 'PUT' : 'POST';
                
                // Prepare data
                const payload = {
                    name: this.formData.name,
                    sort_order: this.formData.sort_order,
                    icon: this.formData.useEmoji ? null : (this.formData.icon || 'fa-file-alt'),
                    emoji: this.formData.useEmoji ? (this.formData.emoji || null) : null,
                };

                try {
                    const res = await fetch(url, {
                        method: method,
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify(payload)
                    });

                    const data = await res.json();

                    if (res.ok && data.success) {
                        Swal.fire({ icon: 'success', title: 'Berhasil!', text: data.message, timer: 1500, showConfirmButton: false });
                        setTimeout(() => location.reload(), 1000);
                    } else {
                        Swal.fire({ icon: 'error', title: 'Gagal', text: data.message || 'Terjadi kesalahan validasi.' });
                    }
                } catch (e) {
                    Swal.fire({ icon: 'error', title: 'Error', text: 'Terjadi kesalahan koneksi.' });
                } finally {
                    this.isLoading = false;
                }
            },

            async confirmDelete(id, name) {
                const res = await Swal.fire({
                    title: `Hapus Kategori?`,
                    html: `Hapus kategori "<b>${name}</b>"?<br><small class="text-slate-400">Pastikan tidak ada laporan yang menggunakannya.</small>`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, Hapus',
                    cancelButtonText: 'Batal',
                    customClass: {
                        popup: 'rounded-3xl',
                        confirmButton: 'px-5 py-2.5 bg-red-600 text-white font-bold rounded-xl mx-1.5',
                        cancelButton: 'px-5 py-2.5 bg-slate-100 text-slate-700 font-bold rounded-xl mx-1.5'
                    },
                    buttonsStyling: false
                });

                if (res.isConfirmed) {
                    try {
                        const delUrl = `{{ url('report-categories') }}/${id}`;
                        const response = await fetch(delUrl, {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Accept': 'application/json'
                            }
                        });
                        const data = await response.json();

                        if (response.ok && data.success) {
                            Swal.fire({ icon: 'success', title: 'Dihapus!', text: data.message, timer: 1500, showConfirmButton: false });
                            setTimeout(() => location.reload(), 1000);
                        } else {
                            Swal.fire({ icon: 'error', title: 'Gagal', text: data.message });
                        }
                    } catch (e) {
                        Swal.fire({ icon: 'error', title: 'Error', text: 'Gagal menghubungi server.' });
                    }
                }
            }
        }
    }
</script>
@endpush
@endsection
