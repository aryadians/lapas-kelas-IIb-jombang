# Panduan Kontribusi

Terima kasih atas minat Anda untuk berkontribusi pada **Sistem Informasi Lapas Jombang**! 🎉

Dokumen ini berisi panduan untuk memastikan kontribusi Anda efektif dan sesuai dengan standar pengembangan proyek ini.

## 🔰 Cara Memulai

1.  **Fork** repository ini ke akun GitHub Anda.
2.  **Clone** hasil fork tersebut ke komputer lokal:
    ```bash
    git clone [https://github.com/USERNAME-ANDA/lapas-kelas-IIb-jombang.git](https://github.com/USERNAME-ANDA/lapas-kelas-IIb-jombang.git)
    ```
3.  **Setup Environment**:
    * Copy file `.env.example` menjadi `.env`.
    * Jalankan `composer install` dan `npm install`.
    * Generate key: `php artisan key:generate`.
    * Jalankan migrasi database: `php artisan migrate --seed`.
4.  **Buat Branch Baru**:
    Jangan pernah bekerja langsung di branch `main`. Buat branch sesuai fitur yang dikerjakan:
    ```bash
    git checkout -b fitur-antrian-baru
    # atau
    git checkout -b fix-bug-printer
    ```

## 🐛 Melaporkan Bug

Jika Anda menemukan error, mohon jangan langsung membuat Pull Request.
1.  Cek tab **Issues**, pastikan bug tersebut belum pernah dilaporkan.
2.  Jika belum ada, buat **New Issue**.
3.  Gunakan template **"Laporan Bug"** yang sudah kami sediakan.
4.  Jelaskan langkah-langkah untuk mereproduksi error tersebut secara detail.

> **PENTING:** Jika menemukan celah keamanan (Security Vulnerability), **JANGAN** lapor di Issue. Baca [Security Policy](SECURITY.md) kami.

## 💻 Standar Kode (Coding Standards)

Agar kode tetap rapi dan mudah dibaca (Maintainable), ikuti aturan ini:

### PHP / Laravel
* Ikuti standar **PSR-12**.
* Gunakan fitur **Type Hinting** pada fungsi (contoh: `public function index(): View`).
* Hindari logika kompleks di dalam *Controller*. Gunakan *Service* atau *Action* classes jika memungkinkan.
* Pastikan tidak ada error saat menjalankan tes: `php artisan test`.

### Frontend (Tailwind & Alpine.js)
* Gunakan **Utility Classes** Tailwind sebisa mungkin, hindari custom CSS kecuali mendesak.
* Untuk interaktivitas sederhana, gunakan **Alpine.js** daripada menulis Vanilla JS atau jQuery yang berat.

### Commit Message
Gunakan format **Conventional Commits** agar riwayat perubahan mudah dibaca:
* `feat: ...` (Untuk penambahan fitur baru)
* `fix: ...` (Untuk perbaikan bug)
* `docs: ...` (Untuk perubahan dokumentasi/README)
* `style: ...` (Perubahan formatting, titik koma, dll)
* `refactor: ...` (Perubahan kode tanpa mengubah fungsi)

Contoh:
```text
feat: menambahkan fitur notifikasi whatsapp antrian
fix: memperbaiki printer thermal tidak mencetak struk
