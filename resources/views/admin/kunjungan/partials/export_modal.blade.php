{{-- EXPORT MODAL --}}
<div id="exportModal" class="fixed inset-0 z-[100] hidden overflow-y-auto no-print" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-center justify-center min-h-screen p-4 text-center sm:p-0">
        <div class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm transition-opacity" aria-hidden="true"></div>
        
        <div class="inline-block relative bg-white rounded-[2rem] text-left overflow-hidden shadow-[0_20px_50px_rgba(0,0,0,0.3)] transform transition-all sm:my-8 sm:max-w-lg w-full border border-slate-100">
            <div class="bg-gradient-to-br from-blue-900 via-slate-900 to-blue-950 px-6 py-5 border-b border-white/10 flex justify-between items-center relative overflow-hidden group">
                <div class="absolute -top-12 -right-12 w-32 h-32 bg-blue-500 blur-[40px] opacity-30 rounded-full group-hover:opacity-50 transition-opacity duration-700"></div>
                <div class="flex items-center gap-4 relative z-10 text-white">
                    <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-emerald-400 to-emerald-600 text-white flex items-center justify-center shadow-[0_10px_20px_-10px_rgba(16,185,129,0.5)]">
                        <i class="fas fa-file-excel text-xl"></i>
                    </div>
                    <div>
                        <h3 class="text-xl font-black tracking-tight drop-shadow-sm">Export Laporan</h3>
                        <p class="text-[11px] font-bold text-blue-200 uppercase tracking-widest mt-0.5">Pilih format & jadwal</p>
                    </div>
                </div>
                <button type="button" id="closeExportModal" class="relative z-10 text-slate-400 hover:text-white hover:bg-white/10 w-10 h-10 rounded-xl flex items-center justify-center transition-colors">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>
            
            <div class="px-6 py-8">
                <form id="exportForm" action="{{ route('admin.kunjungan.export') }}" method="GET" class="space-y-6">
                    <div>
                        <label class="block text-[11px] font-black uppercase tracking-widest text-slate-400 mb-3">Format Data</label>
                        <div class="grid grid-cols-3 gap-3">
                            <label class="cursor-pointer group">
                                <input type="radio" name="type" value="excel" class="peer sr-only" checked>
                                <div class="px-3 py-4 border-2 border-slate-100 rounded-2xl text-center peer-checked:border-emerald-500 peer-checked:bg-emerald-50/50 peer-checked:text-emerald-700 hover:-translate-y-1 transition-all shadow-sm group-hover:shadow-md bg-white">
                                    <div class="font-black text-xs flex flex-col items-center justify-center gap-2">
                                        <i class="fas fa-file-excel text-3xl text-emerald-500 drop-shadow-md"></i>
                                        <span>Excel (.xlsx)</span>
                                    </div>
                                </div>
                            </label>
                            <label class="cursor-pointer group">
                                <input type="radio" name="type" value="csv" class="peer sr-only">
                                <div class="px-3 py-4 border-2 border-slate-100 rounded-2xl text-center peer-checked:border-blue-500 peer-checked:bg-blue-50/50 peer-checked:text-blue-700 hover:-translate-y-1 transition-all shadow-sm group-hover:shadow-md bg-white">
                                    <div class="font-black text-xs flex flex-col items-center justify-center gap-2">
                                        <i class="fas fa-file-csv text-3xl text-blue-500 drop-shadow-md"></i>
                                        <span>CSV (.csv)</span>
                                    </div>
                                </div>
                            </label>
                            <label class="cursor-pointer group">
                                <input type="radio" name="type" value="pdf" class="peer sr-only" id="type_pdf">
                                <div class="px-3 py-4 border-2 border-slate-100 rounded-2xl text-center peer-checked:border-red-500 peer-checked:bg-red-50/50 peer-checked:text-red-700 hover:-translate-y-1 transition-all shadow-sm group-hover:shadow-md bg-white">
                                    <div class="font-black text-xs flex flex-col items-center justify-center gap-2">
                                        <i class="fas fa-file-pdf text-3xl text-red-500 drop-shadow-md"></i>
                                        <span>PDF (Cetak)</span>
                                    </div>
                                </div>
                            </label>
                        </div>
                    </div>

                    
                    <div>
                        <label class="block text-[11px] font-black uppercase tracking-widest text-slate-400 mb-3">Rentang Waktu</label>
                        <select id="modal_export_period" name="period" class="w-full px-4 py-3.5 bg-white border-2 border-slate-100 rounded-2xl focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/20 transition-all font-bold text-slate-700 shadow-sm">
                            <option value="all">Seluruh Data Riwayat</option>
                            <option value="day">Harian (Satu Hari Saja)</option>
                            <option value="week">Mingguan Berjalan</option>
                            <option value="month">Bulanan Berjalan</option>
                        </select>
                    </div>

                    <div id="modal_export_date_container" class="hidden">
                        <label class="block text-[11px] font-black uppercase tracking-widest text-slate-400 mb-3">Tanggal Acuan</label>
                        <input type="date" name="date" class="w-full px-4 py-3.5 bg-white border-2 border-slate-100 rounded-2xl focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/20 transition-all font-bold text-slate-700 shadow-sm" value="{{ date('Y-m-d') }}">
                    </div>
                </form>
            </div>
            
            <div class="bg-slate-50 border-t border-slate-100 px-6 py-5 flex justify-end gap-3 rounded-b-[2rem]">
                <button type="button" class="px-6 py-3 rounded-2xl text-slate-500 font-bold hover:bg-slate-200 hover:text-slate-700 transition-all border-2 border-transparent hover:border-slate-300" onclick="document.getElementById('closeExportModal').click()">Batal</button>
                <button type="button" id="btnExportSubmit" onclick="submitExportForm()"
                    class="px-8 py-3 bg-gradient-to-r from-emerald-500 to-teal-600 hover:from-emerald-400 hover:to-teal-500 text-white font-black rounded-2xl shadow-[0_10px_20px_-10px_rgba(16,185,129,0.6)] hover:shadow-[0_15px_30px_-10px_rgba(16,185,129,0.8)] transition-all hover:-translate-y-1 flex items-center gap-2">
                    <i class="fas fa-download drop-shadow-md"></i> <span id="btnExportLabel">Mulai Download</span>
                </button>
            </div>
        </div>
    </div>
</div>

<script>
// Update button label when PDF is selected
document.querySelectorAll('input[name="type"]').forEach(function(radio) {
    radio.addEventListener('change', function() {
        var btn = document.getElementById('btnExportLabel');
        if (this.value === 'pdf') {
            btn.textContent = 'Buka PDF';
            document.getElementById('btnExportSubmit').className = document.getElementById('btnExportSubmit').className.replace('from-emerald-500 to-teal-600 hover:from-emerald-400 hover:to-teal-500', 'from-red-500 to-rose-600 hover:from-red-400 hover:to-rose-500');
            document.getElementById('btnExportSubmit').querySelector('i').className = 'fas fa-file-pdf drop-shadow-md';
        } else {
            btn.textContent = 'Mulai Download';
            document.getElementById('btnExportSubmit').className = document.getElementById('btnExportSubmit').className.replace('from-red-500 to-rose-600 hover:from-red-400 hover:to-rose-500', 'from-emerald-500 to-teal-600 hover:from-emerald-400 hover:to-teal-500');
            document.getElementById('btnExportSubmit').querySelector('i').className = 'fas fa-download drop-shadow-md';
        }
    });
});

function submitExportForm() {
    var form  = document.getElementById('exportForm');
    var type  = document.querySelector('input[name="type"]:checked')?.value;
    if (type === 'pdf') {
        form.target = '_blank'; // Buka PDF di tab baru
    } else {
        form.target = '_self';  // Download normal
    }
    form.submit();
}
</script>

