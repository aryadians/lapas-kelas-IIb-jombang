<div align="center">
  <img src="./public/img/logo.png" alt="Lapas Jombang Logo" width="150">
  <h1>Lapas Jombang - Sistem Kunjungan Online</h1>
  <p>
    Aplikasi web untuk pendaftaran kunjungan online di Lembaga Pemasyarakatan Kelas IIB Jombang. Memudahkan masyarakat untuk menjadwalkan kunjungan dengan Warga Binaan Pemasyarakatan (WBP) secara efisien dan transparan.
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

## 🚀 Fitur Utama

Aplikasi ini dirancang dengan berbagai fitur untuk meningkatkan pelayanan di Lapas Jombang:

| Fitur                 | Deskripsi                                                                    | Ikon |
| :-------------------- | :--------------------------------------------------------------------------- | :--: |
| **Pendaftaran Kunjungan** | Pengunjung dapat mendaftar kunjungan secara online, memilih WBP, dan tanggal. | 📅   |
| **Manajemen Kunjungan** | Admin dapat menyetujui, menolak, atau menjadwalkan ulang kunjungan.          | ⚙️   |
| **Notifikasi Real-time**  | Pengunjung mendapatkan notifikasi status kunjungan secara instan.           | 🔔   |
| **QR Code Tiket**         | Setiap pendaftaran yang disetujui akan mendapatkan QR Code untuk check-in.   | 🎟️   |
| **Manajemen WBP**         | Admin dapat mengelola data Warga Binaan Pemasyarakatan (WBP).                | 👥   |
| **Berita & Pengumuman**   | Publikasi berita dan pengumuman penting langsung dari website.               | 📰   |
| **Survei Layanan**        | Mengumpulkan feedback dari pengunjung untuk evaluasi layanan.                | 📊   |
| **Voice Announcer**       | Sistem pengumuman suara cerdas untuk antrian dan informasi penting secara real-time. | 🎤   |
| **Control Room**          | Dashboard terpusat untuk monitoring dan manajemen real-time antrian, notifikasi, dan operasional. | 🖥️   |
| **WA Gateway**            | Integrasi WhatsApp Gateway untuk pengiriman notifikasi otomatis kepada pengunjung. | 💬   |
| **Desain Responsif**      | Tampilan yang optimal di berbagai perangkat, baik desktop maupun mobile.     | 📱   |

---

## 🔗 Teknologi Integrasi Canggih

Proyek ini memanfaatkan kombinasi teknologi modern untuk menghadirkan pengalaman real-time dan performa tinggi:

-   **Laravel & Redis (Backend Real-time):** Memungkinkan pemrosesan tugas latar belakang yang efisien dan broadcasting event untuk update real-time pada Control Room.
-   **Optimasi Performa Tinggi (Speed & UX):** 
    -   **Instant Navigation:** Menggunakan `instant.page` untuk prefetching halaman, membuat perpindahan menu terasa instan.
    -   **Visual Feedback:** Integrasi `NProgress` untuk indikator loading bar yang modern.
    -   **Data Caching:** Implementasi caching pada level aplikasi untuk mempercepat pemuatan data statis.
    -   **Database Indexing:** Optimasi query pada ribuan data kunjungan untuk akses cepat.
-   **Instant Image Processing:** Foto KTP pengunjung dan pengikut langsung diproses menjadi format **Base64** secara instan dengan kompresi otomatis untuk efisiensi penyimpanan database.
-   **Advanced Analytics:** Dashboard Executive yang akurat dengan deteksi otomatis usia berdasarkan NIK dan ekstraksi cerdas wilayah kecamatan asal pengunjung.
-   **WhatsApp API (WA Gateway):** Notifikasi otomatis dengan link tiket QR langsung ke perangkat pengunjung.
-   **JavaScript Kustom (Voice Announcer & 3D Animation):** Fungsionalitas Voice Announcer (text-to-speech) dan efek 3D pada halaman FAQ.

---

## 🛠️ Instalasi & Konfigurasi

### **Metode 1: Docker (Direkomendasikan) 🐳**
Metode paling mudah dan konsisten. Tidak perlu install PHP/MySQL/Redis manual di laptop.

1.  **Start Aplikasi**:
    ```bash
    ./docker-start.sh
    ```
2.  **Stop Aplikasi**:
    ```bash
    ./docker-stop.sh
    ```
3.  **Akses**:
    - Web: [http://localhost:8080](http://localhost:8080)
    - Mailpit: [http://localhost:8025](http://localhost:8025)
    - Database: localhost:3306 (User: `root`, Pass: `secret`)

> 📖 **Dokumentasi Lengkap Docker**: Lihat [DOCKER.md](./DOCKER.md) dan [DOCKER-QUICKSTART.md](./DOCKER-QUICKSTART.md)

---

### **Metode 2: Manual (Legacy) 🛠️**
Gunakan metode ini jika Anda menggunakan XAMPP/Laragon.

1.  **Setup Awal**:
    ```bash
    composer run setup
    ```
2.  **Jalankan Mode Development**:
    ```bash
    composer run dev
    ```
3.  **Akses**:
    - Web: [http://localhost:8000](http://localhost:8000)

---

### **🌍 Deployment ke VPS**
Panduan lengkap cara deploy ke production (Niagahoster/DigitalOcean) tersedia di:
👉 **[DEPLOYMENT.md](./DEPLOYMENT.md)**

---

### **📡 Share ke Internet (Cloudflare Tunnel)**
Ingin demo aplikasi ke orang lain tanpa deploy?
- **Docker**: Jalankan `.\docker-share.bat`
- **Manual**: Jalankan `.\share.bat`

---

## ⚙️ Deployment & Production Notes ✅

- **Optimasi Server**: Pastikan **Gzip Compression** dan **Browser Caching** aktif pada web server (Nginx/Apache) untuk mendukung pengiriman aset yang sangat cepat. Aturan dasar sudah tersedia di file `.htaccess`.
- **Base64 Handling**: Foto KTP disimpan langsung di database dalam format string. Pastikan `post_max_size` pada PHP disesuaikan jika menangani pendaftaran massal.
- **Queue**: Jalankan worker untuk menangani notifikasi WA dan Email agar tidak menghambat request utama.
--- 

## ☕ Dukungan & Donasi

Jika aplikasi ini bermanfaat untuk instansi atau pembelajaran Anda, Anda bisa mentraktir saya kopi melalui:

| Metode | Detail Pembayaran |
| :--- | :--- |
| **🏦 Bank BRI** | **3128-01-008734-50-9**<br>a.n. Arya Dian Saputra |
| **📱 DANA** | **0838-4552-9777**<br>a.n. Arya Dian Saputra |

*Dukungan Anda sangat berarti untuk pengembangan fitur selanjutnya!* 🚀

---

## 📄 Citation / Sitasi

Jika Anda menggunakan source code ini sebagai referensi untuk Skripsi, Penelitian, atau Pengembangan Proyek, mohon cantumkan sitasi berikut:

**APA Style:**
> Dian, A. (2026). *Sistem Informasi Manajemen Lapas Kelas IIB Jombang* (Version 1.0.0) [Computer software]. https://github.com/aryadians/lapas-kelas-IIb-jombang

**BibTeX (Untuk LaTeX/Jurnal):**
```bibtex
@software{lapas_jombang_2026,
  author       = {Dian, Arya},
  title        = {{Sistem Informasi Manajemen Lapas Kelas IIB Jombang}},
  month        = jan,
  year         = 2026,
  version      = {1.0.0},
  url          = {[https://github.com/aryadians/lapas-kelas-IIb-jombang](https://github.com/aryadians/lapas-kelas-IIb-jombang)}}



