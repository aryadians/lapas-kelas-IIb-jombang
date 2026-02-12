<div align="center">
  <img src="./public/img/logo.png" alt="Lapas Jombang Logo" width="150">
  <h1>Lapas Jombang - Sistem Layanan Kunjungan Online</h1>
  <p>
    <b>Digitalisasi Pelayanan Kunjungan WBP Terintegrasi</b><br>
    Lembaga Pemasyarakatan Kelas IIB Jombang
  </p>
  
  <p>
    <img src="https://img.shields.io/badge/PHP-8.2-blue?style=for-the-badge&logo=php" alt="PHP 8.2">
    <img src="https://img.shields.io/badge/Laravel-12-orange?style=for-the-badge&logo=laravel" alt="Laravel 12">
    <img src="https://img.shields.io/badge/MySQL-8.0-blue?style=for-the-badge&logo=mysql" alt="MySQL 8.0">
    <img src="https://img.shields.io/badge/Vite-5.0-purple?style=for-the-badge&logo=vite" alt="Vite">
    <img src="https://img.shields.io/badge/Tailwind_CSS-3.4-cyan?style=for-the-badge&logo=tailwind-css" alt="Tailwind CSS">
    <img src="https://img.shields.io/badge/Alpine.js-3.x-blueviolet?style=for-the-badge&logo=alpine-dot-js&logoColor=white" alt="Alpine.js 3.x">
    <img src="https://img.shields.io/badge/Redis-6.x-red?style=for-the-badge&logo=redis&logoColor=white" alt="Redis 6.x">
  </p>
</div>

---

## 🚀 Fitur Utama & Keunggulan

Sistem ini dikembangkan untuk memberikan transparansi, keamanan, dan efisiensi dalam manajemen kunjungan Warga Binaan Pemasyarakatan (WBP).

### 📅 Sistem Pendaftaran & Antrian
- **Pendaftaran Online/Offline:** Mendukung pendaftaran mandiri oleh keluarga via web atau pendaftaran langsung (Walk-in) oleh petugas.
- **QR Code Verification:** Tiket otomatis dengan QR Code unik untuk verifikasi kedatangan yang cepat di pintu gerbang.
- **Smart Queue Management:** Manajemen nomor antrian harian otomatis yang terbagi berdasarkan sesi (Pagi/Siang).
- **Audio Voice Announcer:** Panggilan antrian otomatis berbasis Text-to-Speech (TTS) untuk memandu pengunjung di ruang tunggu.

### 🖥️ Admin Panel & Operasional
- **Mini Dashboard Real-time:** Pantau statistik harian (Total Kunjungan, Perlu Verifikasi, Sedang Dilayani) langsung di halaman utama manajemen.
- **Smart Quota Warning:** Indikator visual sisa kuota (Hijau/Kuning/Merah) saat petugas menginput pendaftaran offline untuk mencegah beban berlebih.
- **Advanced Visitor Database:** Pencarian canggih berdasarkan loyalitas (sering berkunjung), wilayah domisili, dan kelengkapan dokumen KTP.
- **Timeline Audit Trail:** Histori lengkap setiap perubahan data (siapa petugas yang menyetujui/menolak dan kapan waktunya).

### 🔔 Notifikasi & Transparansi
- **WhatsApp & Email Gateway:** Pengiriman otomatis tiket QR dan update status kunjungan via WA (Fonnte/Wablas) dan Email.
- **Notification Logs:** Pantau status pengiriman pesan (Sent/Failed) secara mendetail untuk setiap kunjungan guna memastikan informasi sampai ke pengunjung.
- **Survei IKM Otomatis:** Link survei kepuasan pelanggan dikirim otomatis saat kunjungan dinyatakan selesai.

### 📊 Pelaporan & Ekspor
- **Professional Reporting:** Ekspor data kunjungan dan database pengunjung ke format **Excel (.xlsx)** atau **CSV** dengan layout yang rapi dan siap cetak.
- **Cetak PDF:** Fitur cetak laporan yang dioptimalkan untuk dokumen fisik resmi.

---

## 🔗 Teknologi Integrasi

Kombinasi teknologi modern untuk performa tinggi:

- **Laravel 12 & Redis:** Backend bertenaga dengan sistem antrian (Queue) untuk tugas berat seperti pengiriman notifikasi dan pemrosesan gambar.
- **SweetAlert2 & fslightbox:** Pengalaman UI yang modern dengan popup interaktif dan penampil foto KTP resolusi tinggi tanpa membebani memori browser.
- **Base64 Image Processing:** Foto KTP diproses secara instan di sisi klien sebelum dikirim ke server untuk efisiensi penyimpanan.
- **Spatie Activity Log:** Melacak setiap jejak digital petugas untuk keperluan audit keamanan Lapas.

---

## 🛠️ Panduan Instalasi

### **Metode 1: Docker 🐳 (Sangat Direkomendasikan)**
Menjamin lingkungan yang sama persis antara development dan produksi.

1.  **Jalankan Sistem**:
    ```bash
    ./docker-start.sh
    ```
2.  **Hentikan Sistem**:
    ```bash
    ./docker-stop.sh
    ```
3.  **Akses**:
    - **Aplikasi:** [http://localhost:8080](http://localhost:8080)
    - **Mailpit (Cek Email):** [http://localhost:8025](http://localhost:8025)

> 📖 **Dokumentasi Lanjutan Docker**: Lihat [DOCKER.md](./DOCKER.md)

### **Metode 2: Manual (XAMPP/Laragon) 🛠️**
1.  **Setup Awal**: `composer run setup`
2.  **Mode Dev**: `composer run dev`
3.  **Akses**: [http://localhost:8000](http://localhost:8000)

---

## 🔐 Keamanan & Kepatuhan Data
- **NIK Masking:** Sensor otomatis pada 6 digit tengah NIK di tampilan publik/admin untuk melindungi privasi pengunjung.
- **Role-Based Access Control (RBAC):** Pembatasan akses fitur berdasarkan peran (Super Admin, Admin Registrasi, Petugas Ruang Kunjungan).
- **Input Validation:** Validasi ketat terhadap NIK, nomor HP, dan relasi WBP untuk mencegah manipulasi data.

---

## ☕ Dukungan & Donasi

Jika sistem ini membantu operasional instansi Anda, Anda dapat memberikan dukungan melalui:

| Metode | Detail Pembayaran |
| :--- | :--- |
| **🏦 Bank BRI** | **3128-01-008734-50-9** (Arya Dian Saputra) |
| **📱 DANA** | **0838-4552-9777** (Arya Dian Saputra) |

---

## 📄 Sitasi (Citation)

Gunakan format berikut jika Anda merujuk proyek ini dalam karya ilmiah:

**APA Style:**
> Dian, A. (2026). *Sistem Informasi Manajemen Layanan Kunjungan Online Lapas Jombang* (Version 1.2.0) [Computer software]. https://github.com/aryadians/lapas-kelas-IIb-jombang

---
<div align="center">
  <p>Dikembangkan dengan ❤️ untuk kemajuan pelayanan publik Indonesia.</p>
</div>
