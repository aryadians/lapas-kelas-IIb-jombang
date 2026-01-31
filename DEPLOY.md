# Deployment Checklist

Ringkasan singkat langkah-langkah penting sebelum dan saat deploy aplikasi ke production.

## 1) Persyaratan Sistem
- PHP >= 8.2
- PHP extensions: `gd`, `pdo_mysql` (atau driver DB anda), `fileinfo`, `mbstring`, `openssl`.
- Composer & Node/NPM untuk build aset
- Redis (direkomendasikan) atau database untuk queue

## 2) Konfigurasi PHP (php.ini)
- upload_max_filesize = 8M
- post_max_size = 10M
- memory_limit = 128M (atau lebih sesuai kebutuhan)
- max_execution_time = 300
- Pastikan `gd` aktif: `php -m | grep gd` atau `php -r "var_export(extension_loaded('gd'));"`

> Catatan: Aplikasi mengharuskan kompresi gambar (ImageService) menggunakan GD. Tanpa GD, proses akan tetap fallback tetapi kompresi tidak berjalan.

## 3) Environment (.env)
Atur variabel penting:
- `APP_ENV=production`
- `APP_DEBUG=false`
- `QUEUE_CONNECTION=redis` (direkomendasikan) atau `database`
- `WHATSAPP_API_TOKEN=...` (WA provider)
- `ADMIN_EMAIL=ops@example.com` (alert WA provider failures)
- DB_* konfigurasi dan mail provider

## 4) Migrate & Seed
```bash
php artisan migrate --force
php artisan db:seed --force   # jika perlu
```

## 5) Storage & Permissions
```bash
php artisan storage:link
chown -R www-data:www-data storage bootstrap/cache
chmod -R 775 storage bootstrap/cache
```

## 6) Queue Workers (Production)
Aplikasi memproses kompresi gambar di background dan job lain (WA, email). Pastikan worker berjalan, contoh untuk beberapa platform:

- systemd (Linux):
```ini
[Unit]
Description=Laravel Queue Worker
After=network.target

[Service]
User=www-data
Group=www-data
Restart=always
ExecStart=/usr/bin/php /var/www/project/artisan queue:work redis --sleep=3 --tries=3 --timeout=90
WorkingDirectory=/var/www/project

[Install]
WantedBy=multi-user.target
```

- Supervisor (Linux):
```ini
[program:laravel-queue]
command=php /var/www/project/artisan queue:work redis --sleep=3 --tries=3 --timeout=90
process_name=%(program_name)s_%(process_num)02d
numprocs=2
autostart=true
autorestart=true
user=www-data
redirect_stderr=true
stdout_logfile=/var/log/laravel-queue.log
```

- NSSM (Windows): contoh singkat
```powershell
nssm install laravel-queue C:\php\php.exe "C:\path\to\project\artisan queue:work redis --sleep=3 --tries=3 --timeout=90"
nssm set laravel-queue AppDirectory C:\path\to\project
nssm set laravel-queue AppStdout C:\path\to\project\storage\logs\worker.log
nssm start laravel-queue
```

> Tips: saat deploy, jalankan `php artisan queue:restart` untuk menjalankan ulang proses worker dengan kode baru.

## 7) Jobs/Background Work
- Aplikasi menyimpan file upload sementara di `storage/app/kunjungan/originals` dan dispatch job `CompressKtpImageJob` dan `CompressPengikutImageJob` untuk memproses hasil ke `foto_ktp` base64.
- Pastikan worker memproses antrean agar file sementara tidak menumpuk.

## 8) Monitoring & Logging
- Pantau `storage/logs/laravel.log` untuk error runtime.
- Pantau worker log (mis. `/var/log/laravel-queue.log` atau `storage/logs/worker.log`).
- Pertimbangkan menambahkan alert (email/Slack) untuk error berulang (WA provider failures dikirimi `ADMIN_EMAIL`).

## 9) Cron (Scheduler)
Jalankan scheduler via cron/systemd timer:
```cron
* * * * * /usr/bin/php /var/www/project/artisan schedule:run >> /dev/null 2>&1
```

## 10) Backup & Rollback
- Backup DB sebelum migrasi besar.
- Siapkan dokumentasi rollback (DB schema/migration plan).

## 11) Post-deploy checklist
- `php artisan migrate --force`
- `php artisan queue:restart`
- `php artisan config:cache` & `php artisan route:cache` (kalau perlu)
- Verifikasi Worker berjalan dan tidak ada antrean backlog: `php artisan queue:failed` dan inspect monitoring dashboard

---

Jika mau, saya bisa menambahkan contoh systemd unit file & Supervisor config ke `examples/` atau membuat script deploy sederhana (bash/PowerShell) untuk mempermudah deploy. Pilih: `examples` / `script` / `tidak`.