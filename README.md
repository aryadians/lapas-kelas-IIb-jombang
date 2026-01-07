<div align="center">
  <img src="./public/img/logo.pngalt="Lapas Jombang Logo" width="150">
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
  </p>
</div>

---

## 🚀 Fitur Utama

Aplikasi ini dirancang dengan berbagai fitur untuk meningkatkan pelayanan di Lapas Jombang:

| Fitur                 | Deskripsi                                                                    | Ikon |
| --------------------- | ---------------------------------------------------------------------------- | :--: |
| **Pendaftaran Kunjungan** | Pengunjung dapat mendaftar kunjungan secara online, memilih WBP, dan tanggal. | 📅   |
| **Manajemen Kunjungan** | Admin dapat menyetujui, menolak, atau menjadwalkan ulang kunjungan.          | ⚙️   |
| **Notifikasi Real-time**  | Pengunjung mendapatkan notifikasi status kunjungan melalui email.            | 📧   |
| **QR Code Tiket**         | Setiap pendaftaran yang disetujui akan mendapatkan QR Code untuk check-in.   | 🎟️   |
| **Manajemen WBP**         | Admin dapat mengelola data Warga Binaan Pemasyarakatan (WBP).                | 👥   |
| **Berita & Pengumuman**   | Publikasi berita dan pengumuman penting langsung dari website.               | 📰   |
| **Survei Layanan**        | Mengumpulkan feedback dari pengunjung untuk evaluasi layanan.                | 📊   |
| **Desain Responsif**      | Tampilan yang optimal di berbagai perangkat, baik desktop maupun mobile.     | 📱   |

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
| <img src="https/raw.githubusercontent.com/mlbbef/resource/main/home.png" alt="Halaman Utama" width="300"> | <img src="https://raw.githubusercontent.com/mlbbef/resource/main/form.png" alt="Form Pendaftaran" width="300"> | <img src="https://raw.githubusercontent.com/mlbbef/resource/main/admin.png" alt="Dashboard Admin" width="300"> |

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