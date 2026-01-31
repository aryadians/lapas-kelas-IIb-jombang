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

Proyek ini memanfaatkan kombinasi teknologi modern untuk menghadirkan pengalaman real-time dan interaktif yang kaya:

-   **Laravel & Redis (Backend Real-time):** Laravel Queue System dipadukan dengan Redis sebagai driver antrian, memungkinkan pemrosesan tugas latar belakang yang efisien seperti pengiriman notifikasi, pengelolaan data real-time, dan pemicuan Voice Announcer. Redis juga dimanfaatkan untuk _broadcasting events_, memastikan notifikasi real-time ke _Control Room_ dan _Voice Announcer_.
-   **Alpine.js (Frontend Interaktif):** Digunakan untuk menambahkan interaktivitas langsung pada antarmuka pengguna tanpa _full page reload_. Alpine.js bekerja secara harmonis dengan event Laravel Echo yang didorong oleh Redis, memungkinkan _real-time updates_ pada _Control Room_ dan _display_ antrian.
-   **WhatsApp API (WA Gateway):** Mengintegrasikan WhatsApp Gateway untuk mengirim notifikasi otomatis kepada pengunjung mengenai status kunjungan, informasi penting, dan pengingat. Ini memastikan komunikasi yang efektif dan langsung dengan pengguna.
-   **JavaScript Kustom (Voice Announcer & 3D Animation):** Logika JavaScript khusus dikembangkan untuk fungsionalitas Voice Announcer (text-to-speech) di Control Room dan Display Antrian, serta untuk menghadirkan efek 3D yang menarik di halaman tertentu seperti FAQ, meningkatkan estetika dan pengalaman pengguna.

---

## 🛠️ Instalasi & Konfigurasi

Ikuti langkah-langkah berikut untuk menjalankan aplikasi ini di lingkungan lokal Anda.

### **1. Clone Repository**
Gunakan `git clone` untuk mengunduh repository ini ke mesin lokal Anda.
```bash
git clone https://github.com/username/lapas-jombang.git
cd lapas-jombang
```

### **2. Instalasi Dependensi**
Instal semua dependensi yang dibutuhkan oleh Composer dan NPM.
```bash
# Instal dependensi PHP
composer install

# Instal dependensi JavaScript
npm install
```
### **3. Konfigurasi Lingkungan**
Salin file `.env.example` dan buat file `.env` baru. Kemudian, generate application key.
```bash
# Salin file environment
cp .env.example .env

# Generate APP_KEY
php artisan key:generate
```

### **4. Konfigurasi Database**
Buka file `.env` dan sesuaikan konfigurasi database Anda.
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=lapas_jombang
DB_USERNAME=root
DB_PASSWORD=
```
Pastikan Anda sudah membuat database dengan nama `lapas_jombang` atau sesuaikan dengan nama yang Anda inginkan.

### **5. Migrasi & Seeding Database**
Jalankan migrasi untuk membuat tabel-tabel yang diperlukan dan seeding untuk mengisi data awal (jika ada).
```bash
php artisan migrate --seed
```

### **6. Build Aset Frontend**
Kompilasi aset frontend seperti CSS dan JavaScript menggunakan Vite.
```bash
# Jalankan build untuk production
npm run build

# Atau jalankan dalam mode development
npm run dev
```

### **7. Jalankan Server Lokal**
Terakhir, jalankan server development Laravel.
```bash
php artisan serve
```
🎉 Aplikasi sekarang akan berjalan di **http://127.0.0.1:8000**.

---

## 🎨 Tampilan Aplikasi

Berikut adalah beberapa tampilan dari aplikasi Lapas Jombang:

| Halaman Utama | Form Pendaftaran | Dashboard Admin |
| :---: | :---: | :---: |
| <img src="/public/img/HomePage.png" alt="Halaman Utama" width="300"> | <img src="/public/img/PageDaftar.png" alt="Form Pendaftaran" width="300"> | <img src="./public/img/DashboardAdmin.png" alt="Dashboard Admin" width="300"> |

---

## 🤝 Kontribusi

Kontribusi sangat kami harapkan! Jika Anda menemukan bug atau memiliki ide untuk fitur baru, silakan buat *issue* atau *pull request*.

1.  **Fork** repository ini.
2.  Buat *branch* fitur baru (`git checkout -b fitur/nama-fitur`).
3.  **Commit** perubahan Anda (`git commit -m 'Menambahkan fitur X'`).
4.  **Push** ke *branch* Anda (`git push origin fitur/nama-fitur`).
5.  Buka **Pull Request**.

---

## 📜 Lisensi

Proyek ini dilisensikan di bawah [MIT License](LICENSE).

<div align="center">
  <small>Dibuat dengan ❤️ untuk pelayanan publik yang lebih baik.</small>
</div>

--- 

## ⚙️ Deployment & Production Notes ✅

**Ringkas:** pastikan server production dikonfigurasi untuk menangani unggahan gambar, menjalankan queue worker, dan memiliki ekstensi yang diperlukan.

- **PHP & Extensions**: Pastikan PHP >= **8.2** dan ekstensi **GD** terpasang (dibutuhkan oleh ImageService). Cek dengan: `php -m | grep gd`.
- **PHP ini**: Set nilai yang cukup di `php.ini` untuk menghindari POST body terpotong:
  - `upload_max_filesize = 8M`
  - `post_max_size = 10M`
  - `memory_limit` sesuai kebutuhan (mis. `128M` atau lebih)

- **Queue** (recommended): Gunakan driver non-`sync` (Redis atau database) di `.env`:
  - `QUEUE_CONNECTION=redis`
  - Jalankan worker di production (mis. **NSSM** di Windows atau **systemd/supervisor** di Linux). Contoh singkat NSSM (Windows):
    ```powershell
    nssm install laravel-queue C:\php\php.exe "C:\path\to\project\artisan queue:work redis --sleep=3 --tries=3 --timeout=90"
    nssm set laravel-queue AppDirectory C:\path\to\project
    nssm start laravel-queue
    ```

  Contoh file konfigurasi dan skrip deploy tersedia di folder `examples/` pada repository (systemd, supervisor, NSSM instructions, dan skrip deploy untuk Linux/Windows).
- **Migrations & Setup**:
  - Jalankan migrasi: `php artisan migrate --force` sebelum membuka produksi.
  - Saat deploy, beri sinyal worker untuk restart: `php artisan queue:restart`.
  - Pastikan `ADMIN_EMAIL` (untuk alert WA provider failures) dan `WHATSAPP_API_TOKEN` ter-set di `.env`.

- **KTP / Pengikut Image Handling**: Aplikasi sekarang menyimpan file asli sementara dan memproses kompresi di background (job queue). Pastikan worker berjalan agar `foto_ktp` ter-processed dan tidak menumpuk file sementara.

- **Monitoring & Logs**: Pantau `storage/logs/laravel.log` dan worker logs (`storage/logs/worker.log`) untuk deteksi cepat kegagalan.

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



