@extends('layouts.main')

@section('content')
<div class="bg-slate-50 min-h-screen py-12" x-data="liveAntrian()">
    <div class="container mx-auto px-6 text-center">
        <div class="mb-12">
            <div class="inline-flex items-center px-4 py-2 rounded-full bg-blue-100 text-blue-800 text-sm font-semibold mb-4">
                <i class="fas fa-street-view mr-2"></i>
                Live Monitoring
            </div>
            <h1 class="text-4xl sm:text-5xl font-black text-slate-800 mb-2">Nomor Antrian Saat Ini</h1>
            <p class="text-lg text-slate-500">Nomor antrian yang sedang dilayani oleh petugas kami.</p>
            <p class="text-sm text-slate-400 mt-2 flex items-center justify-center gap-2">
                <span class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></span>
                Diperbarui secara otomatis
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 max-w-4xl mx-auto">
            {{-- SESI PAGI --}}
            <div class="bg-gradient-to-br from-blue-500 to-indigo-600 rounded-3xl shadow-2xl shadow-blue-500/30 p-8 text-white transform hover:scale-105 transition-transform duration-300">
                <h2 class="text-2xl font-bold uppercase tracking-widest text-blue-200 mb-4 flex items-center justify-center gap-2"><i class="fas fa-sun"></i> Sesi Pagi</h2>
                <div class="text-8xl font-black tracking-tighter" x-text="nomorPagi">0</div>
            </div>

            {{-- SESI SIANG --}}
            <div class="bg-gradient-to-br from-amber-500 to-orange-600 rounded-3xl shadow-2xl shadow-amber-500/30 p-8 text-white transform hover:scale-105 transition-transform duration-300">
                <h2 class="text-2xl font-bold uppercase tracking-widest text-amber-200 mb-4 flex items-center justify-center gap-2"><i class="fas fa-cloud-sun"></i> Sesi Siang</h2>
                <div class="text-8xl font-black tracking-tighter" x-text="nomorSiang">0</div>
            </div>
        </div>
        
        <div class="mt-16 text-center">
            <a href="{{ url('/') }}" class="text-slate-500 hover:text-blue-600 font-semibold transition-colors group inline-flex items-center gap-2">
                <i class="fas fa-arrow-left group-hover:-translate-x-1 transition-transform"></i>
                <span>Kembali ke Halaman Utama</span>
            </a>
        </div>
    </div>
</div>

<script>
    function liveAntrian() {
        return {
            nomorPagi: '...',
            nomorSiang: '...',
            init() {
                // Listen for AntrianUpdated event via Laravel Echo
                if (window.Echo) {
                    window.Echo.channel('antrian.public')
                        .listen('.antrian.updated', (e) => {
                            console.log('AntrianUpdated event received:', e);
                            const antrian = e.antrian || {};
                            if ((antrian.sesi || '') === 'pagi') {
                                this.nomorPagi = antrian.nomor ?? antrian.no_antrian ?? antrian.nomor_terpanggil ?? 0;
                            } else if ((antrian.sesi || '') === 'siang') {
                                this.nomorSiang = antrian.nomor ?? antrian.no_antrian ?? antrian.nomor_terpanggil ?? 0;
                            }
                        });
                } else {
                    console.warn('Laravel Echo is not initialized. Falling back to polling.');
                    this.fetchStatus();
                    setInterval(() => {
                        this.fetchStatus();
                    }, 7000); // Fallback to polling every 7 seconds
                }

                // Initial fetch to get the current status if Echo is not available or for initial display
                this.fetchStatus();
            },
            async fetchStatus() {
                try {
                    const response = await fetch('{{ route("api.antrian.status") }}');
                    const data = await response.json();
                    this.nomorPagi = data.pagi || 0;
                    this.nomorSiang = data.siang || 0;
                } catch (error) {
                    console.error('Gagal mengambil status antrian:', error);
                    this.nomorPagi = 'X';
                    this.nomorSiang = 'X';
                }
            }
        }
    }
</script>
@endsection
