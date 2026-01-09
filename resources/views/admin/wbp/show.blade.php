@extends('layouts.admin')

@section('content')
<div class="space-y-6">

    <div class="flex flex-col md:flex-row justify-between items-start gap-4">
        <div>
            <a href="{{ route('admin.wbp.index') }}" class="inline-flex items-center gap-2 text-sm text-slate-500 hover:text-indigo-600 mb-2 transition-colors">
                <i class="fa-solid fa-chevron-left"></i>
                <span>Kembali ke Daftar WBP</span>
            </a>
            <h1 class="text-3xl font-bold text-slate-800 leading-tight">{{ $wbp->nama }}</h1>
            <p class="text-slate-500 mt-1">Detail informasi untuk warga binaan.</p>
        </div>
        <div class="flex items-center gap-2 flex-shrink-0">
            <a href="{{ route('admin.wbp.edit', $wbp->id) }}" class="action-btn-lg bg-blue-500 hover:bg-blue-600 text-white">
                <i class="fa-solid fa-pencil mr-2"></i>
                Edit
            </a>
            <form id="delete-form" action="{{ route('admin.wbp.destroy', $wbp->id) }}" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" class="action-btn-lg bg-red-500 hover:bg-red-600 text-white">
                    <i class="fa-solid fa-trash-alt mr-2"></i>
                    Hapus
                </button>
            </form>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        {{-- Kolom Kiri: Info Utama & Lokasi --}}
        <div class="lg:col-span-2 space-y-8">
            <div class="bg-white rounded-2xl shadow-lg border border-slate-200 transform hover:scale-[1.02] transition-transform duration-300">
                <div class="p-6 border-b border-slate-200">
                    <h3 class="text-lg font-bold text-slate-800 flex items-center"><i class="fa-solid fa-id-card-clip mr-3 text-indigo-500"></i>Informasi Tahanan</h3>
                </div>
                <div class="p-6 grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <div class="info-item">
                        <label><i class="fa-solid fa-user-tag"></i>No. Registrasi</label>
                        <p class="font-mono">{{ $wbp->no_registrasi }}</p>
                    </div>
                    <div class="info-item">
                        <label><i class="fa-solid fa-signature"></i>Nama Panggilan (Alias)</label>
                        <p>{{ $wbp->nama_panggilan ?: '-' }}</p>
                    </div>
                    <div class="info-item">
                        <label><i class="fa-solid fa-building-columns"></i>Blok</label>
                        <p class="font-bold text-indigo-600">{{ $wbp->blok ?: '-' }}</p>
                    </div>
                    <div class="info-item">
                        <label><i class="fa-solid fa-door-closed"></i>Kamar</label>
                        <p class="font-bold text-emerald-600">{{ $wbp->kamar ?: '-' }}</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Kolom Kanan: Masa Tahanan & Riwayat --}}
        <div class="space-y-8">
            <div class="bg-white rounded-2xl shadow-lg border border-slate-200 transform hover:scale-[1.02] transition-transform duration-300">
                <div class="p-6 border-b border-slate-200">
                    <h3 class="text-lg font-bold text-slate-800 flex items-center"><i class="fa-solid fa-calendar-alt mr-3 text-red-500"></i>Masa Tahanan</h3>
                </div>
                <div class="p-6 space-y-4">
                    <div class="info-item">
                        <label><i class="fa-solid fa-calendar-day"></i>Tanggal Masuk</label>
                        <p>{{ $wbp->tanggal_masuk ? \Carbon\Carbon::parse($wbp->tanggal_masuk)->isoFormat('D MMMM Y') : '-' }}</p>
                    </div>
                    <div class="info-item">
                        <label class="text-red-700"><i class="fa-solid fa-calendar-times"></i>Tanggal Ekspirasi</label>
                        <p class="font-bold text-red-600">{{ $wbp->tanggal_ekspirasi ? \Carbon\Carbon::parse($wbp->tanggal_ekspirasi)->isoFormat('D MMMM Y') : '-' }}</p>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-2xl shadow-lg border border-slate-200 text-center p-6 transform hover:scale-[1.02] transition-transform duration-300">
                 <a href="{{ route('admin.wbp.history', $wbp->id) }}" class="inline-flex flex-col items-center gap-2 text-indigo-600 hover:text-indigo-800 font-semibold group">
                    <i class="fa-solid fa-clock-rotate-left text-4xl text-slate-300 group-hover:text-indigo-500 transition-colors"></i>
                    <span>Lihat Riwayat Kunjungan</span>
                </a>
            </div>
        </div>
    </div>
</div>

<style>
.action-btn-lg {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-weight: 600;
    padding: 0.6rem 1.2rem;
    border-radius: 0.75rem;
    box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);
    transition: all 0.3s ease;
    transform-style: preserve-3d;
}
.action-btn-lg:hover {
    transform: translateY(-3px) scale(1.05);
    box-shadow: 0 10px 15px -3px rgb(0 0 0 / 0.1), 0 4px 6px -2px rgb(0 0 0 / 0.05);
}
.info-item label {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 0.8rem;
    font-weight: 600;
    color: #64748b; /* slate-500 */
    text-transform: uppercase;
    letter-spacing: 0.05em;
}
.info-item p {
    margin-top: 0.25rem;
    font-size: 1.1rem;
    font-weight: 600;
    color: #1e293b; /* slate-800 */
}
</style>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const deleteForm = document.getElementById('delete-form');
    if(deleteForm) {
        deleteForm.addEventListener('submit', function (e) {
            e.preventDefault();
            Swal.fire({
                ...swalTheme,
                icon: 'warning',
                title: 'Anda Yakin?',
                text: "Data WBP '{{ $wbp->nama }}' akan dihapus secara permanen.",
                showCancelButton: true,
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal',
                customClass: {
                    ...swalTheme.customClass,
                    confirmButton: 'px-5 py-2.5 bg-red-600 hover:bg-red-700 text-white font-semibold rounded-lg transition-all duration-200 mx-1.5 shadow-lg shadow-red-500/30 focus:outline-none focus:ring-4 focus:ring-red-300',
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    deleteForm.submit();
                }
            });
        });
    }
});
</script>
@endpush
