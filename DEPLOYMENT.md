# 🚀 Panduan Deploy ke VPS (Niagahoster/DigitalOcean/dll)

Panduan ini menjelaskan cara men-deploy aplikasi Lapas Jombang ke VPS Linux (Ubuntu 22.04/24.04 Recommended) menggunakan Docker.

## 📋 Prasyarat

1.  **VPS** dengan OS Ubuntu (Recomended).
2.  **Domain** yang sudah diarahkan ke IP VPS (A Record).
3.  **Akses SSH** ke VPS (User `root` atau user dengan `sudo`).

---

## Langkah 1: Persiapan VPS (Install Docker)

Login ke VPS via SSH, lalu jalankan perintah berikut satu per satu untuk menginstall Docker dan Docker Compose.

```bash
# Update repository
sudo apt update && sudo apt upgrade -y

# Install tools dasar
sudo apt install -y apt-transport-https ca-certificates curl software-properties-common git

# Tambahkan GPG Key Docker
curl -fsSL https://download.docker.com/linux/ubuntu/gpg | sudo gpg --dearmor -o /usr/share/keyrings/docker-archive-keyring.gpg

# Tambahkan Repository Docker
echo "deb [arch=$(dpkg --print-architecture) signed-by=/usr/share/keyrings/docker-archive-keyring.gpg] https://download.docker.com/linux/ubuntu $(lsb_release -cs) stable" | sudo tee /etc/apt/sources.list.d/docker.list > /dev/null

# Install Docker Engine
sudo apt update
sudo apt install -y docker-ce docker-ce-cli containerd.io docker-compose-plugin

# Cek instalasi
docker --version
docker compose version
```

---

## Langkah 2: Setup Project

1.  **Clone Repository** (Pastikan code Anda sudah di GitHub/GitLab):
    ```bash
    cd /var/www
    git clone https://github.com/username/lapas-jombang.git
    cd lapas-jombang
    ```
    *(Ganti URL git dengan repository Anda)*

2.  **Setup Permissions Folder**:
    ```bash
    # Buat folder storage jika belum ada
    mkdir -p storage/framework/{sessions,views,cache}
    mkdir -p storage/logs
    
    # Set permission (user 1000:1000 adalah user www-data di dalam container)
    sudo chown -R 1000:1000 storage bootstrap/cache
    sudo chmod -R 775 storage bootstrap/cache
    ```

3.  **Buat File .env Production**:
    Copy file default dan edit sesuai kebutuhan production.
    ```bash
    cp .env.example .env
    nano .env
    ```

    **PENTING: Ubah Bagian Ini di `.env`:**
    ```ini
    APP_ENV=production
    APP_DEBUG=false
    APP_URL=https://nama-domain-anda.com
    
    # Database (Gunakan service name 'mysql', bukan IP)
    DB_CONNECTION=mysql
    DB_HOST=mysql
    DB_PORT=3306
    DB_DATABASE=lapasjombang
    DB_USERNAME=lapas_user
    DB_PASSWORD=GANTI_PASSWORD_YANG_KUAT_DISINI
    
    # Redis
    REDIS_HOST=redis
    
    # Email (Gunakan SMTP Asli Niagahoster/Gmail, bukan Mailpit)
    MAIL_MAILER=smtp
    MAIL_HOST=smtp.niagahoster.co.id
    MAIL_PORT=465
    MAIL_USERNAME=admin@domain.com
    MAIL_PASSWORD=password_email
    MAIL_ENCRYPTION=ssl
    ```

    Simpan (Ctrl+O, Enter) dan Keluar (Ctrl+X).

---

## Langkah 3: Jalankan Aplikasi (Start Docker)

Jalankan Docker Compose menggunakan file production (`docker-compose.yml`), BUKAN `dev`.

1.  **Start Containers**:
    ```bash
    docker compose up -d --build
    ```

2.  **Install Dependencies & Optimize**:
    Setelah container up, jalankan perintah setup ini:
    ```bash
    # Install Composer (No Dev Dependencies) & Generate Key
    docker compose exec app composer install --no-dev --optimize-autoloader
    docker compose exec app php artisan key:generate
    
    # Cache Config & Route untuk performa
    docker compose exec app php artisan config:cache
    docker compose exec app php artisan route:cache
    docker compose exec app php artisan view:cache
    
    # Link Storage
    docker compose exec app php artisan storage:link
    
    # Run Migrations (Hati-hati, ini production!)
    docker compose exec app php artisan migrate --force
    ```

---

## Langkah 4: Setup Domain & SSL (HTTPS)

Aplikasi Anda sekarang berjalan di port `80` (HTTP). Untuk Production, **WAJIB pakai HTTPS**.
Cara termudah adalah menggunakan **Nginx Proxy Manager** atau install **Nginx Host** + **Certbot**.

### Opsi Mudah: Install Nginx + Certbot di VPS (Host)

1.  **Install Nginx di VPS**:
    ```bash
    sudo apt install nginx -y
    ```

2.  **Buat Config Nginx**:
    ```bash
    sudo nano /etc/nginx/sites-available/lapas-jombang
    ```
    Isi dengan (mengarah ke port Docker 80):
    ```nginx
    server {
        server_name domain-anda.com;
    
        location / {
            proxy_pass http://127.0.0.1:80; # Mengarah ke Docker Port 80
            proxy_set_header Host $host;
            proxy_set_header X-Real-IP $remote_addr;
            proxy_set_header X-Forwarded-For $proxy_add_x_forwarded_for;
            proxy_set_header X-Forwarded-Proto $scheme;
        }
    }
    ```

3.  **Aktifkan Config**:
    ```bash
    sudo ln -s /etc/nginx/sites-available/lapas-jombang /etc/nginx/sites-enabled/
    sudo nginx -t # Cek error
    sudo systemctl restart nginx
    ```

4.  **Install SSL Gratis (Let's Encrypt)**:
    ```bash
    sudo apt install certbot python3-certbot-nginx
    sudo certbot --nginx -d domain-anda.com
    ```

Selesai! Aplikasi Anda sekarang bisa diakses di `https://domain-anda.com`.

---

## 🔄 Cara Update Aplikasi (Redeploy)

Jika Anda ada update codingan baru:

1.  **Pull code terbaru**:
    ```bash
    cd /var/www/lapas-jombang
    git pull origin main
    ```

2.  **Rebuild Container** (hanya jika ada perubahan config docker):
    ```bash
    docker compose up -d --build
    ```
    *Jika hanya ubah kode PHP/Blade, tidak perlu restart container!*

3.  **Clear Cache** (Wajib di production):
    ```bash
    docker compose exec app php artisan optimize
    ```
