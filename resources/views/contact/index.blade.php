@extends('layouts.main')

@section('content')
<section class="relative bg-gradient-to-br from-blue-900 via-slate-900 to-blue-900 text-white min-h-[350px] flex items-center justify-center overflow-hidden">
    {{-- Background Pattern --}}
    <div class="absolute inset-0 z-0">
        <div class="absolute inset-0 bg-[url('data:image/svg+xml,%3Csvg width="60" height="60" viewBox="0 0 60 60" xmlns="http://www.w3.org/2000/svg"%3E%3Cg fill="none" fill-rule="evenodd"%3E%3Cg fill="%23ffffff" fill-opacity="0.05"%3E%3Ccircle cx="30" cy="30" r="2"/%3E%3C/g%3E%3C/g%3E%3C/svg%3E')] opacity-20"></div>
        <div class="absolute inset-0 bg-gradient-to-b from-blue-900/70 via-blue-900/80 to-blue-900/95"></div>
        <div class="absolute inset-0 bg-gradient-to-r from-slate-900/20 to-cyan-900/20"></div>
    </div>

    {{-- Floating Elements --}}
    <div class="absolute top-20 left-10 w-20 h-20 bg-blue-500/10 rounded-full blur-xl animate-pulse"></div>
    <div class="absolute bottom-20 right-10 w-32 h-32 bg-cyan-500/10 rounded-full blur-xl animate-pulse" style="animation-delay: 1s;"></div>

    <div class="container mx-auto px-6 text-center relative z-10">
        <div class="inline-flex items-center px-4 py-2 rounded-full bg-white/10 backdrop-blur-sm border border-white/20 text-sm font-semibold mb-6">
            <i class="fas fa-headset mr-2"></i>
            Kontak Kami
        </div>
        <h1 class="text-4xl md:text-6xl font-black mb-6 tracking-tight">
            Kami Siap <span class="bg-gradient-to-r from-cyan-400 to-cyan-600 bg-clip-text text-transparent animate-text-shimmer">Membantu Anda</span>
        </h1>
        <p class="text-xl text-blue-100 max-w-3xl mx-auto leading-relaxed">
            Jangan ragu untuk menghubungi kami melalui berbagai saluran komunikasi yang tersedia.
        </p>
    </div>
</section>

<section class="py-20 bg-gradient-to-b from-gray-50 to-white">
    <div class="container mx-auto px-6 max-w-6xl">
        {{-- Contact Information Cards --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-16">
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-8 text-center card-3d card-hover-scale group">
                <div class="w-20 h-20 bg-gradient-to-br from-blue-500 to-blue-600 rounded-full flex items-center justify-center mx-auto mb-6 shadow-xl group-hover:scale-110 transition-transform">
                    <i class="fab fa-whatsapp text-3xl text-white"></i>
                </div>
                <h3 class="text-2xl font-bold text-slate-800 mb-3">WhatsApp</h3>
                <p class="text-gray-600 mb-4">Hubungi kami melalui chat WhatsApp.</p>
                <a href="https://wa.me/6285733333400" class="inline-flex items-center px-6 py-3 bg-blue-500 hover:bg-blue-600 text-white font-semibold rounded-full transition-all btn-hover-lift hover:shadow-lg">
                    <i class="fab fa-whatsapp mr-2"></i>
                    +6285733333400
                </a>
            </div>

            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-8 text-center card-3d card-hover-scale group">
                <div class="w-20 h-20 bg-gradient-to-br from-emerald-500 to-emerald-600 rounded-full flex items-center justify-center mx-auto mb-6 shadow-xl group-hover:scale-110 transition-transform">
                    <i class="fas fa-envelope text-3xl text-white"></i>
                </div>
                <h3 class="text-2xl font-bold text-slate-800 mb-3">Email</h3>
                <p class="text-gray-600 mb-4">Kirim email untuk pertanyaan detail.</p>
                <a href="mailto:info@lapas-jombang.go.id" class="inline-flex items-center px-6 py-3 bg-emerald-500 hover:bg-emerald-600 text-white font-semibold rounded-full transition-all btn-hover-lift hover:shadow-lg">
                    <i class="fas fa-envelope mr-2"></i>
                    info@lapas-jombang.go.id
                </a>
            </div>

            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-8 text-center card-3d card-hover-scale group">
                <div class="w-20 h-20 bg-gradient-to-br from-purple-500 to-purple-600 rounded-full flex items-center justify-center mx-auto mb-6 shadow-xl group-hover:scale-110 transition-transform">
                    <i class="fas fa-map-marker-alt text-3xl text-white"></i>
                </div>
                <h3 class="text-2xl font-bold text-slate-800 mb-3">Alamat</h3>
                <p class="text-gray-600 mb-4">Jl. Wahid Hasyim No.1, Jombang, Jawa Timur</p>
                <a href="https://maps.app.goo.gl/yJ6h1sX1aX2Y2Z3A7" target="_blank" class="inline-flex items-center px-6 py-3 bg-purple-500 hover:bg-purple-600 text-white font-semibold rounded-full transition-all btn-hover-lift hover:shadow-lg">
                    <i class="fas fa-directions mr-2"></i>
                    Lihat Peta
                </a>
            </div>
        </div>

        {{-- Contact Form Section --}}
        <div class="bg-white rounded-3xl p-8 md:p-12 shadow-2xl border border-gray-100 max-w-3xl mx-auto" x-data="{ formData: { name: '', email: '', subject: '', message: '' }, formSuccess: false, formError: false, loading: false }" @submit.prevent="submitForm">
            <h2 class="text-3xl font-bold text-center text-slate-800 mb-8">Kirim Pesan</h2>
            
            <template x-if="formSuccess">
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded-lg shadow-md mb-6 animate-message" role="alert">
                    <p class="font-bold">Pesan Terkirim!</p>
                    <p>Terima kasih telah menghubungi kami. Kami akan merespons secepatnya.</p>
                </div>
            </template>
            <template x-if="formError">
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-lg shadow-md mb-6 animate-message" role="alert">
                    <p class="font-bold">Gagal Mengirim Pesan!</p>
                    <p>Terjadi kesalahan. Mohon coba lagi nanti atau hubungi kami langsung.</p>
                </div>
            </template>

            <form class="space-y-6" @submit.prevent="submitForm">
                @csrf
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Nama Lengkap</label>
                    <input type="text" id="name" name="name" x-model="formData.name" required class="w-full px-5 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 form-focus-glow transition-all">
                </div>
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                    <input type="email" id="email" name="email" x-model="formData.email" required class="w-full px-5 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 form-focus-glow transition-all">
                </div>
                <div>
                    <label for="subject" class="block text-sm font-medium text-gray-700 mb-2">Subjek</label>
                    <input type="text" id="subject" name="subject" x-model="formData.subject" required class="w-full px-5 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 form-focus-glow transition-all">
                </div>
                <div>
                    <label for="message" class="block text-sm font-medium text-gray-700 mb-2">Pesan Anda</label>
                    <textarea id="message" name="message" x-model="formData.message" rows="6" required class="w-full px-5 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 form-focus-glow transition-all"></textarea>
                </div>
                <div class="text-center">
                    <button type="submit" :disabled="loading" class="inline-flex items-center justify-center px-8 py-4 bg-gradient-to-r from-blue-600 to-cyan-600 text-white font-bold rounded-xl shadow-lg hover:shadow-xl btn-hover-lift transition-all duration-300" :class="{ 'opacity-50 cursor-not-allowed': loading }">
                        <template x-if="loading">
                            <i class="fas fa-spinner fa-spin mr-3"></i>
                        </template>
                        <template x-if="!loading">
                            <i class="fas fa-paper-plane mr-3"></i>
                        </template>
                        Kirim Pesan
                    </button>
                </div>
            </form>
            <script>
                async function submitForm() {
                    this.loading = true;
                    this.formSuccess = false;
                    this.formError = false;

                    const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                    try {
                        const response = await fetch('{{ route('contact.store') }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'Accept': 'application/json',
                                'X-CSRF-TOKEN': token
                            },
                            body: JSON.stringify(this.formData)
                        });

                        if (!response.ok) {
                            const errorData = await response.json();
                            console.error('Form submission failed:', errorData);
                            this.formError = true;
                        } else {
                            const successData = await response.json();
                            console.log('Form submission successful:', successData);
                            this.formSuccess = true;
                            this.formData = { name: '', email: '', subject: '', message: '' }; // Clear form
                        }
                    } catch (error) {
                        console.error('Network or unexpected error:', error);
                        this.formError = true;
                    } finally {
                        this.loading = false;
                    }
                }
            </script>
        </div>

        {{-- Operating Hours --}}
        <div class="mt-20 bg-white rounded-2xl p-6 shadow-lg border border-gray-100 max-w-xl mx-auto">
            <h4 class="text-xl font-bold text-slate-800 mb-4 text-center">Jam Operasional Layanan</h4>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="text-center">
                    <h5 class="font-semibold text-gray-800 mb-2">Pendaftaran Online</h5>
                    <p class="text-gray-600">24 Jam / 7 Hari</p>
                </div>
                <div class="text-center">
                    <h5 class="font-semibold text-gray-800 mb-2">Layanan Telepon & Email</h5>
                    <p class="text-gray-600">Senin - Jumat: 08:00 - 16:00 WIB</p>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection