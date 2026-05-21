<div align="center">
  <img src="./public/img/logo.png" alt="Lapas Jombang Logo" width="160">
  <br>
  <h1>🏛️ LAPAS JOMBANG</h1>
  <h3><b>Sistem Layanan Kunjungan Terintegrasi (Si-LAKU)</b></h3>
  <p><i>Digitalisasi Modern Pelayanan Publik Lembaga Pemasyarakatan Kelas IIB Jombang</i></p>

<p>
    <img src="https://img.shields.io/badge/Version-1.8.0-blue?style=for-the-badge&logo=git" alt="Version">
    <img src="https://img.shields.io/badge/Laravel-12.x-FF2D20?style=for-the-badge&logo=laravel&logoColor=white" alt="Laravel">
    <img src="https://img.shields.io/badge/PHP-8.2-777BB4?style=for-the-badge&logo=php&logoColor=white" alt="PHP">
    <img src="https://img.shields.io/badge/MySQL-8.0-4479A1?style=for-the-badge&logo=mysql&logoColor=white" alt="MySQL">
    <img src="https://img.shields.io/badge/Redis-Realtime-DC382D?style=for-the-badge&logo=redis&logoColor=white" alt="Redis">
    <img src="https://img.shields.io/badge/Tailwind-CSS-38B2AC?style=for-the-badge&logo=tailwind-css&logoColor=white" alt="Tailwind">
  <p>
    <a href="https://lapasjombang.id/" target="_blank">
      <img src="https://img.shields.io/badge/Website_Resmi-lapasjombang.id-000000?style=for-the-badge&logo=google-chrome&logoColor=white" alt="Website Resmi">
    </a>
  </p>
</div>

---

## 📖 Deskripsi Proyek

**Si-LAKU Lapas Jombang** adalah platform ekosistem digital yang dirancang untuk mentransformasi prosedur kunjungan konvensional menjadi layanan berbasis teknologi. sistem ini menjembatani interaksi antara masyarakat (pengunjung) dengan Warga Binaan Pemasyarakatan (WBP) melalui manajemen pendaftaran, verifikasi keamanan, dan antrian cerdas yang terautomasi secara *real-time*.

---

## 🆕 Pembaruan Terbaru

### 🚀 Versi 1.8.3 (Penyempurnaan Import & Status WBP)

- **🔄 Resolusi Duplikasi Registrasi Otomatis** — Fitur cerdas untuk menangani duplikasi nomor registrasi (`no_registrasi`) pada file Excel yang di-import dengan menambahkan suffix unik secara dinamis (misalnya `-2`, `-3`), memastikan semua baris berhasil tersimpan dan ditampilkan.
- **🛡️ Penyesuaian Sinkronisasi Status WBP** — Menghapus sinkronisasi otomatis status "Bebas" saat import data baru guna mencegah data WBP aktif terubah statusnya akibat potongan file Excel yang tidak lengkap.
- **⚙️ Pencocokan Header Fleksibel** — Peningkatan algoritma import untuk secara otomatis mencocokkan struktur kolom header yang bergeser atau memiliki judul/title block dekoratif di baris teratas.

### 🚀 Versi 1.8.2 (Pembatasan & Disiplin)

- **🛡️ Sistem Pembatasan Kunjungan Otomatis** — Fitur baru untuk memblokir kunjungan WBP yang sedang dalam masa *Mapenaling*, *Strap Cell*, atau *Sidang TPP*.
- **📢 Broadcast Sistem (WA/Email)** — Pengiriman notifikasi pembatalan kunjungan secara massal dan otomatis kepada keluarga pengunjung jika WBP bersangkutan mendadak terkena pembatasan.

- **🗂️ Sidebar Menu Grouping** — Navigasi admin kini dikelompokkan berdasarkan fungsionalitas (Dashboard, Layanan Kunjungan, Data Master, Humas, Pengaturan) dengan kontrol akses (RBAC) yang lebih ketat.
- **⚖️ Bulk Action & Sorting** — Filter urutan abjad dan fitur *bulk selection* untuk pembaruan status WBP secara efisien.

### 🚀 Versi 1.8.1 (Terbaru)

- **🌐 Production Ready** — Sistem kini telah *live* dan dapat diakses publik melalui domain resmi [lapasjombang.id](https://lapasjombang.id/).
- **⚡ Real-time Cache Sinkronisasi** — Berita dan Pengumuman di beranda kini otomatis tersinkronisasi (*cache invalidation*) secara *real-time* setiap kali admin melakukan penambahan, perubahan, atau penghapusan data.
- **📷 Smart QR Scanner** — Fitur *Scan* QR Code kini ditingkatkan untuk secara cerdas memprioritaskan penggunaan kamera belakang (*Environment-facing camera*) pada perangkat *mobile* demi kenyamanan petugas.
- **🎫 Comprehensive Ticket Details** — Optimalisasi *Eager Loading* pada relasi database memastikan detail Nomor Blok dan Lokasi Sel Warga Binaan dapat selalu tampil akurat di tiket pengunjung.
- **✅ Quick Action Update** — Perbaikan pada fungsionalitas tombol jalan pintas (Selesai/Tolak) di tabel Kunjungan Admin dengan *routing* status khusus yang mem-*bypass* validasi form lengkap.

### ✨ Versi 1.8.0

- **💾 Arsitektur Zero-File Storage (Base64)** — Sistem kini beralih ke penyimpanan **Base64 (LongText)** untuk Foto KTP dan QR Code. Dokumen kini tersimpan aman di dalam database, meningkatkan portabilitas data dan menghilangkan ketergantungan pada file fisik server.
- **🖼️ CMS Banner Hybrid** — Manajemen banner kini mendukung mode cerdas: **Gambar** disimpan via Base64 (Database), sedangkan **Video** tetap melalui File Storage untuk menjaga performa.
- **🏷️ Legenda Kode Kunjungan (A/B)** — UI Pendaftaran kini dilengkapi keterangan pemetaan status WBP: **Kode A untuk Tahanan** dan **Kode B untuk Narapidana**.
- **🔔 Polished UI Alerts** — Integrasi **SweetAlert2** pada seluruh modul manajemen banner untuk pengalaman pengguna yang lebih premium dan interaktif.

### ⚡ Versi 1.7.0

- **⚡ Performa Native (SPA)** — Diperkuat dengan **Hotwire Turbo Drive**, memberikan navigasi instan tanpa *reload* halaman penuh (No Janks!).
- **📅 Penjadwalan Dinamis Cerdas** — Admin dapat memetakan hari buka khusus berdasarkan Kode Tahanan atau Blok secara fleksibel.
- **📅 Smart Date Picker** — Formulir pendaftaran otomatis memfilter opsi tanggal yang diizinkan sesuai status WBP yang dipilih.
- **🖼️ CMS Manajemen Homepage** — Carousel latar belakang hero menggunakan sistem CRUD penuh untuk pengelolaan Gambar HD dan Video.

---

## 🚀 Fitur Unggulan (End-to-End)

### 👥 Modul Pengunjung & Publik

| Fitur                          | Deskripsi                                                                                      | Status |
| :----------------------------- | :--------------------------------------------------------------------------------------------- | :----: |
| **Pendaftaran Mandiri**  | Reservasi kunjungan online via web dengan validasi NIK dan kuota harian otomatis.              |   ✅   |
| **Smart Date Picker**    | Pemilihan tanggal cerdas yang otomatis menyesuaikan kuota, jadwal blok, dan limit pendaftaran. |   ✅   |
| **E-Ticket QR Code**     | Tiket digital Base64 yang tersimpan permanen di database, siap cetak kapan saja.               |   ✅   |
| **Real-time Queue TV**   | Tampilan display antrian publik untuk ruang tunggu (Smart TV ready).                           |   ✅   |
| **Voice Announcer**      | Panggilan suara otomatis (TTS) Bahasa Indonesia untuk setiap nomor antrian.                    |   ✅   |
| **Survei IKM Digital**   | Pengisian indeks kepuasan masyarakat pasca kunjungan untuk evaluasi instansi.                  |   ✅   |
| **Aksesibilitas Widget** | Fitur khusus disabilitas: TTS, Kontras Tinggi, Font Disleksia, dan Kursor Besar.               |   ✅   |
| **Helpdesk WhatsApp**    | Tombol chat WA langsung ke petugas, nomor dikelola dari panel admin.                           |   ✅   |

### 🛠️ Modul Admin & Operasional

| Fitur                             | Deskripsi                                                                            | Status |
| :-------------------------------- | :----------------------------------------------------------------------------------- | :----: |
| **Mini Dashboard**          | Pantauan beban kerja harian (Pending, Serving, Sisa Kuota) dalam satu pandangan.     |   ✅   |
| **Smart Quota Manager**     | Manajemen kuota dinamis (Sesi Pagi/Siang) dengan visual progres bar yang responsif.  |   ✅   |
| **Pendaftaran Offline**     | Input data pendaftaran di tempat (walk-in) dengan fitur*Quota Warning* otomatis.   |   ✅   |
| **Database Pengunjung**     | Repositori data master pengunjung dengan filter loyalitas dan integrasi foto Base64. |   ✅   |
| **WBP Management**          | Sinkronisasi data Warga Binaan, lokasi blok, sel, masa tahanan, dan kode tahanan.    |   ✅   |
| **Manajemen Banner**        | Unggah dan kelola slideshow gambar/video interaktif dengan efek Lightbox.            |   ✅   |
| **Panel Konfigurasi 5-Tab** | Semua pengaturan sistem dikelola dari satu halaman terorganisir.                     |   ✅   |

---

## 🧠 Logika Bisnis & Alur Kerja Utama (Core Business Logic)

### 🔄 1. Siklus Hidup Kunjungan (Visit Lifecycle Status Flow)
Alur transaksi kunjungan dirancang terstruktur dari awal registrasi hingga survei selesai:
1. **`PENDING`** 📥: Pengunjung melakukan pendaftaran secara mandiri (online) atau dibantu petugas (offline). Sistem memeriksa kuota harian dan masa pembatasan WBP.
2. **`APPROVED`** / **`REJECTED`** ⚖️: Petugas memverifikasi kelengkapan KTP dan relasi keluarga. Tiket QR Code dikirim otomatis via WhatsApp/Email jika disetujui, atau alasan penolakan jika ditolak.
3. **`ON_QUEUE`** 🚪: Pengunjung tiba di gerbang Lapas dan petugas memindai QR Code untuk menandai kehadiran.
4. **`CALLED`** 📢: Petugas memanggil nomor antrian menggunakan suara announcer otomatis (TTS).
5. **`SERVING`** 🤝: Pengunjung berada di ruang tatap muka menemui WBP.
6. **`COMPLETED`** ✅: Kunjungan selesai, sistem otomatis mengirimkan tautan survei kepuasan pelanggan (IKM) melalui pesan WhatsApp.

### 📢 2. Pengantrean Tugas Berat (Background Jobs & Queues)
Demi kenyamanan navigasi pengguna, tugas-tugas dengan latency tinggi diproses di latar belakang menggunakan **Laravel Queue & Redis**:
- **`ImageService`**: Mengompres gambar KTP dan foto pengikut menggunakan intervensi GD untuk mengoptimalkan ruang penyimpanan sebelum dikonversi menjadi format Base64.
- **`WhatsAppService`**: Pengiriman pesan teks/notifikasi melalui Fonnte atau Wablas API dijalankan secara asinkron.
- **`KunjunganObserver`**: Memantau perubahan status kunjungan dan secara otomatis memicu antrean pengiriman email serta notifikasi WhatsApp.

### 🛡️ 3. Sistem Disiplin & Pembatasan WBP
Untuk menjaga ketertiban, sistem melarang pendaftaran kunjungan ke WBP yang memiliki catatan disiplin aktif:
- **Tipe Pembatasan**: *Mapenaling* (Masa Pengenalan Lingkungan), *Strap Cell* (Sel Sunyi), dan *Sidang TPP*.
- **Blokir Registrasi**: Form pendaftaran online otomatis memblokir pencarian dan reservasi terhadap WBP yang sedang dibatasi.
- **Broadcast Pembatalan Otomatis**: Jika WBP mendadak dibatasi setelah kunjungan disetujui, sistem akan membatalkan kunjungan secara massal dan mengirimkan notifikasi penolakan via WhatsApp secara otomatis kepada pengunjung terdaftar.

---

## 📂 Struktur Data & Arsitektur Model Utama (Core Database Models)

Desain database Si-LAKU dioptimalkan untuk performa tinggi dan integritas data:
- **`User`** (`users`): Pengguna sistem dengan otorisasi berbasis peran (Role-Based Access Control - RBAC) yaitu `admin`, `superadmin` (Kalapas), dan `petugas`.
- **`Wbp`** (`wbps`): Data master Warga Binaan Pemasyarakatan, mencakup nomor registrasi unik, nama, blok, sel kamar, tanggal masuk, tanggal ekspirasi, serta status hukum (Narapidana/Tahanan).
- **`ProfilPengunjung`** (`profil_pengunjungs`): Menyimpan data master pengunjung (NIK, nama, alamat, nomor hp) untuk mempercepat pengisian otomatis pada pendaftaran berulang.
- **`Kunjungan`** (`kunjungans`): Tabel transaksi sentral yang menyimpan jadwal kunjungan, sesi (pagi/siang), nomor antrian harian, token QR, tipe pendaftaran (online/offline), dan status alur hidup kunjungan.
- **`Pengikut`** (`pengikuts`): Relasi one-to-many ke kunjungan untuk menyimpan data pengikut keluarga yang ikut serta menemani pengunjung utama.
- **`AntrianStatus`** (`antrian_status`): Memantau real-time display status antrean yang terintegrasi dengan layar TV antrean.

---

## 🛠️ Arsitektur Teknologi

Sistem ini dibangun dengan *stack* modern untuk menjamin skalabilitas:

- **Core Engine:** Laravel 12 (Framework PHP Tercanggih).
- **SPA Navigation Engine:** Hotwire Turbo Drive (Navigasi instan via AJAX).
- **Frontend Real-time:** Alpine.js, Tailwind CSS & Swiper.js untuk UI interaktif.
- **Image Intelligence:** Pemrosesan media berbasis **Base64** dengan kompresi otomatis.
- **Background Jobs:** Pemanfaatan Laravel Queue & Redis untuk pengiriman notifikasi massal.

---

## 📦 Panduan Instalasi Cepat

### **Opsi A: Docker 🐳**

```bash
# Nyalakan semua kontainer (Web, DB, Redis, Mailpit)
git pull && ./docker-start.sh

# Akses aplikasi
URL: http://localhost:8080
```

### **Opsi B: Manual 🛠️**

```bash
# Instalasi dependensi & setup database
composer run setup

# Jalankan server development & Vite
composer run dev

# Akses aplikasi
URL: http://localhost:8000
```

### **Catatan Penting Setelah Instalasi**

```bash
# Wajib dijalankan agar queue (WA & Email) berfungsi
php artisan queue:listen --tries=3

# Wajib untuk symlink storage (khusus untuk Video Banner & Logo)
php artisan storage:link
```

---

## 🤝 Kontribusi & Dukungan

Kami sangat menghargai dukungan Anda untuk keberlanjutan pengembangan sistem ini.

- **Developer:** Arya Dian Saputra
- **Donasi Kopi:**
  - BRI: `3128-01-008734-50-9`
  - DANA: `0838-4552-9777`

---

<div align="center">
  <p><b>Lapas Kelas IIB Jombang - Semakin PASTI & Berakhlak</b></p>
  <p>Copyright © 2026. All Rights Reserved.</p>
</div>
