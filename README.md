<div align="center">
  <img src="./public/img/logo.png" alt="Lapas Jombang Logo" width="160">
  <br>
  <h1>🏛️ LAPAS JOMBANG</h1>
  <h3><b>Sistem Layanan Kunjungan Terintegrasi (Si-LAKU)</b></h3>
  <p><i>Digitalisasi Modern Pelayanan Publik Lembaga Pemasyarakatan Kelas IIB Jombang</i></p>

  <p>
    <img src="https://img.shields.io/badge/Version-1.5.0-blue?style=for-the-badge&logo=git" alt="Version">
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

## 🚀 Fitur Unggulan (End-to-End)

### 👥 Modul Pengunjung & Publik
| Fitur | Deskripsi | Status |
| :--- | :--- | :---: |
| **Pendaftaran Mandiri** | Reservasi kunjungan online via web dengan validasi NIK dan kuota harian otomatis. | ✅ |
| **E-Ticket QR Code** | Tiket digital unik yang dikirim langsung setelah verifikasi disetujui. | ✅ |
| **Real-time Queue TV** | Tampilan display antrian publik untuk ruang tunggu (Smart TV ready). | ✅ |
| **Voice Announcer** | Panggilan suara otomatis (TTS) Bahasa Indonesia untuk setiap nomor antrian. | ✅ |
| **Survei IKM Digital** | Pengisian indeks kepuasan masyarakat pasca kunjungan untuk evaluasi instansi. | ✅ |

### 🛠️ Modul Admin & Operasional
| Fitur | Deskripsi | Status |
| :--- | :--- | :---: |
| **Mini Dashboard** | Pantauan beban kerja harian (Pending, Serving, Sisa Kuota) dalam satu pandangan. | ✅ |
| **Smart Quota Manager** | Manajemen kuota dinamis (Sesi Pagi/Siang) dengan visual progres bar yang responsif. | ✅ |
| **Pendaftaran Offline** | Input data pendaftaran di tempat (walk-in) dengan fitur *Quota Warning* otomatis. | ✅ |
| **Database Pengunjung** | Repositori data master pengunjung dengan filter loyalitas, wilayah, dan kelengkapan KTP. | ✅ |
| **WBP Management** | Sinkronisasi data Warga Binaan, lokasi blok, sel, dan masa tahanan. | ✅ |

### 🔐 Keamanan & Audit (Security & Trust)
| Fitur | Deskripsi | Status |
| :--- | :--- | :---: |
| **Timeline Audit Trail** | Log aktivitas lengkap: mencatat siapa petugas yang melakukan aksi, apa yang diubah, dan kapan waktunya. | ✅ |
| **Notification Logs** | Pelacakan status pengiriman WhatsApp/Email (Sent/Failed) beserta alasan teknis kegagalannya. | ✅ |
| **NIK Masking** | Proteksi privasi dengan menyensor 6 digit tengah NIK pada antarmuka admin. | ✅ |
| **RBAC System** | Pembatasan hak akses ketat (Super Admin, Admin Registrasi, Admin Humas, Petugas). | ✅ |

---

## 🛠️ Arsitektur Teknologi

Sistem ini dibangun dengan *stack* modern untuk menjamin skalabilitas dan pengalaman pengguna yang luar biasa:

- **Core Engine:** Laravel 12 (Framework PHP Tercanggih).
- **Frontend Real-time:** Alpine.js & Tailwind CSS untuk UI yang ringan dan interaktif.
- **Image Intelligence:** Pemrosesan gambar KTP berbasis Base64 dengan kompresi otomatis untuk menghemat ruang penyimpanan.
- **Reporting Engine:** Integrasi `Maatwebsite Excel` untuk laporan profesional dan `fslightbox` untuk penampil dokumen resolusi tinggi.
- **Background Jobs:** Pemanfaatan Laravel Queue & Redis untuk pengiriman notifikasi massal tanpa menghambat performa server.

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
