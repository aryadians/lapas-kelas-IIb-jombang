<div align="center">
  <img src="./public/img/logo.png" alt="Lapas Jombang Logo" width="160">
  <br>
  <h1>🏛️ LAPAS JOMBANG</h1>
  <h3><b>Sistem Layanan Kunjungan Terintegrasi (Si-LAKU)</b></h3>
  <p><i>Digitalisasi Modern Pelayanan Publik Lembaga Pemasyarakatan Kelas IIB Jombang</i></p>

  <p>
    <img src="https://img.shields.io/badge/Version-1.6.0-blue?style=for-the-badge&logo=git" alt="Version">
    <img src="https://img.shields.io/badge/Laravel-12.x-FF2D20?style=for-the-badge&logo=laravel&logoColor=white" alt="Laravel">
    <img src="https://img.shields.io/badge/PHP-8.2-777BB4?style=for-the-badge&logo=php&logoColor=white" alt="PHP">
    <img src="https://img.shields.io/badge/MySQL-8.0-4479A1?style=for-the-badge&logo=mysql&logoColor=white" alt="MySQL">
    <img src="https://img.shields.io/badge/Redis-Realtime-DC382D?style=for-the-badge&logo=redis&logoColor=white" alt="Redis">
    <img src="https://img.shields.io/badge/Tailwind-CSS-38B2AC?style=for-the-badge&logo=tailwind-css&logoColor=white" alt="Tailwind">
  </p>
</div>

---

## 📖 Deskripsi Proyek
**Si-LAKU Lapas Jombang** adalah platform ekosistem digital yang dirancang untuk mentransformasi prosedur kunjungan konvensional menjadi layanan berbasis teknologi. Sistem ini menjembatani interaksi antara masyarakat (pengunjung) dengan Warga Binaan Pemasyarakatan (WBP) melalui manajemen pendaftaran, verifikasi keamanan, dan antrian cerdas yang terautomasi secara *real-time*.

---

## 🆕 Pembaruan Terbaru (v1.6.0)

### Konfigurasi Terpusat (Admin Settings Overhaul)
Halaman pengaturan admin dirombak total menjadi **antarmuka 5 tab** yang lebih terorganisir, memungkinkan semua konfigurasi dikelola tanpa perlu menyentuh file `.env` atau kode program:

| Tab | Isi Konfigurasi |
| :--- | :--- |
| 📅 **Jadwal & Kuota** | Manajemen hari operasional, toggle buka/tutup, kuota online & offline per sesi |
| ⚙️ **Aturan & Batas** | Frekuensi kunjungan per NIK/WBP, lead time pendaftaran, edit guest, toleransi antrian |
| 📄 **Konten & Info Publik** | **Trix Rich Text Editor** untuk Syarat & Ketentuan + nomor WhatsApp helpdesk publik |
| 🕐 **Jam Operasional** | Input jam buka & tutup untuk Sesi Pagi dan Sesi Siang secara independen |
| 🔌 **Integrasi API** | Token API Fonnte (WhatsApp Gateway) + konfigurasi lengkap **Email Gmail SMTP** |

### Fitur Baru yang Ditambahkan
- **Syarat & Ketentuan Dinamis** — Teks S&K yang dapat diedit admin tampil otomatis di halaman pendaftaran publik tanpa deploy ulang.
- **Jam Operasional Dinamis** — Cron job auto-update antrian kini membaca jam buka/tutup sesi dari database, bukan nilai hardcode.
- **Token WA dari Database** — `WhatsAppService` membaca token API Fonnte dari panel admin (prioritas DB → fallback `.env`).
- **Konfigurasi Email dari Panel** — SMTP host, port, username, App Password Gmail, enkripsi, dan email admin semua bisa diubah dari UI tanpa edit `.env`. Diterapkan otomatis via `DynamicMailServiceProvider`.
- **Helpdesk WhatsApp Publik** — Nomor WA customer service tampil sebagai tombol chat di halaman pendaftaran pengunjung.

---

## 🚀 Fitur Unggulan (End-to-End)

### 👥 Modul Pengunjung & Publik
| Fitur | Deskripsi | Status |
| :--- | :--- | :---: |
| **Pendaftaran Mandiri** | Reservasi kunjungan online via web dengan validasi NIK dan kuota harian otomatis. | ✅ |
| **E-Ticket QR Code** | Tiket digital unik yang dikirim langsung setelah verifikasi disetujui. | ✅ |
| **Real-time Queue TV** | Tampilan display antrian publik untuk ruang tunggu (Smart TV ready). | ✅ |
| **Voice Announcer** | Panggilan suara otomatis (TTS) Bahasa Indonesia untuk setiap nomor antrian. | ✅ |
| **Survei IKM Digital** | Pengisian indeks kepuasan masyarakat pasca kunjungan untuk evaluasi instansi. | ✅ |
| **Syarat & Ketentuan** | Teks S&K kunjungan yang dapat diedit admin, tampil dinamis di halaman publik. | ✅ |
| **Helpdesk WhatsApp** | Tombol chat WA langsung ke petugas, nomor dikelola dari panel admin. | ✅ |

### 🛠️ Modul Admin & Operasional
| Fitur | Deskripsi | Status |
| :--- | :--- | :---: |
| **Mini Dashboard** | Pantauan beban kerja harian (Pending, Serving, Sisa Kuota) dalam satu pandangan. | ✅ |
| **Smart Quota Manager** | Manajemen kuota dinamis (Sesi Pagi/Siang) dengan visual progres bar yang responsif. | ✅ |
| **Pendaftaran Offline** | Input data pendaftaran di tempat (walk-in) dengan fitur *Quota Warning* otomatis. | ✅ |
| **Jam Operasional Dinamis** | Jam buka/tutup sesi pagi & siang dikelola dari panel, langsung diterapkan ke mesin antrian. | ✅ |
| **Database Pengunjung** | Repositori data master pengunjung dengan filter loyalitas, wilayah, dan kelengkapan KTP. | ✅ |
| **WBP Management** | Sinkronisasi data Warga Binaan, lokasi blok, sel, dan masa tahanan. | ✅ |
| **Panel Konfigurasi 5-Tab** | Semua pengaturan sistem dikelola dari satu halaman terorganisir tanpa perlu akses server. | ✅ |

### 🔌 Integrasi & Notifikasi
| Fitur | Deskripsi | Status |
| :--- | :--- | :---: |
| **WhatsApp Gateway (Fonnte)** | Notifikasi otomatis (Pending, Approved, Rejected, QR Code, Reminder H-1). Token dikelola dari panel. | ✅ |
| **Email Notifikasi (Gmail SMTP)** | Konfigurasi SMTP Gmail (host, port, username, App Password) langsung dari UI admin. | ✅ |
| **Auto-cancel Antrian** | Kunjungan yang melewati toleransi waktu dibatalkan otomatis oleh cron scheduler. | ✅ |
| **Background Jobs (Queue)** | Pengiriman WA & Email diproses via Laravel Queue + Redis tanpa blokir request utama. | ✅ |

### 🔐 Keamanan & Audit (Security & Trust)
| Fitur | Deskripsi | Status |
| :--- | :--- | :---: |
| **Timeline Audit Trail** | Log aktivitas lengkap: mencatat siapa petugas yang melakukan aksi, apa yang diubah, dan kapan waktunya. | ✅ |
| **Notification Logs** | Pelacakan status pengiriman WhatsApp/Email (Sent/Failed) beserta alasan teknis kegagalannya. | ✅ |
| **NIK Masking** | Proteksi privasi dengan menyensor 6 digit tengah NIK pada antarmuka admin. | ✅ |
| **RBAC System** | Pembatasan hak akses ketat (Super Admin, Admin Registrasi, Admin Humas, Petugas). | ✅ |
| **Konfigurasi Tanpa .env** | Kredensial API (WA & Email) disimpan di database terenkripsi, bukan file konfigurasi server. | ✅ |

---

## 🛠️ Arsitektur Teknologi

Sistem ini dibangun dengan *stack* modern untuk menjamin skalabilitas dan pengalaman pengguna yang luar biasa:

- **Core Engine:** Laravel 12 (Framework PHP Tercanggih).
- **Frontend Real-time:** Alpine.js & Tailwind CSS untuk UI yang ringan dan interaktif.
- **Rich Text Editor:** Trix Editor untuk pengelolaan konten HTML (Syarat & Ketentuan) langsung dari panel admin.
- **Image Intelligence:** Pemrosesan gambar KTP berbasis Base64 dengan kompresi otomatis untuk menghemat ruang penyimpanan.
- **Reporting Engine:** Integrasi `Maatwebsite Excel` untuk laporan profesional dan `fslightbox` untuk penampil dokumen resolusi tinggi.
- **Background Jobs:** Pemanfaatan Laravel Queue & Redis untuk pengiriman notifikasi massal tanpa menghambat performa server.
- **Dynamic Config:** `DynamicMailServiceProvider` — override konfigurasi mail Laravel dari database tanpa restart server.

---

## 📦 Panduan Instalasi Cepat

### **Opsi A: Docker (Enterprise Way) 🐳**
Sangat disarankan untuk lingkungan produksi dan development yang stabil.
```bash
# Nyalakan semua kontainer (Web, DB, Redis, Mailpit)
./docker-start.sh

# Akses aplikasi
URL: http://localhost:8080
```

### **Opsi B: Manual (Development) 🛠️**
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

# Wajib untuk symlink storage (foto KTP, QR Code)
php artisan storage:link
```

---

## ⚙️ Konfigurasi via Panel Admin

Mulai versi 1.6.0, hampir semua konfigurasi operasional dapat dikelola langsung dari **Panel Admin → Konfigurasi Sistem** tanpa perlu mengubah file `.env`:

| Pengaturan | Deskripsi |
| :--- | :--- |
| `WHATSAPP_API_TOKEN` | Token Fonnte untuk pengiriman WA |
| `MAIL_*` | Host, port, username, App Password Gmail |
| `ADMIN_EMAIL` | Email penerima notifikasi harian |
| Jam Operasional | Jam buka & tutup sesi pagi dan siang |
| Syarat & Ketentuan | Teks HTML yang tampil di halaman pendaftaran publik |

---

## 📊 Pelaporan & Ekspor Data
Sistem menyediakan modul pelaporan yang siap saji untuk keperluan manajerial:
- **Laporan Kunjungan:** Filter harian, mingguan, bulanan ke format **Excel (.xlsx)**.
- **Database Profil:** Rekapitulasi seluruh pengunjung unik ke format **CSV**.
- **Cetak Tiket:** Optimasi layout PDF untuk pencetakan tiket antrian fisik.

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
