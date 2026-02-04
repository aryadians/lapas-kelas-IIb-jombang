# 🐳 Docker Setup - Lapas Jombang

Comprehensive Docker setup untuk **Lapas Kelas IIB Jombang - Sistem Layanan Kunjungan**. Setup ini menyediakan environment yang konsisten untuk development dan production deployment.

---

## 📋 Table of Contents

- [Prerequisites](#prerequisites)
- [Quick Start](#quick-start)
- [Development Workflow](#development-workflow)
- [Production Deployment](#production-deployment)
- [Service Management](#service-management)
- [Database Management](#database-management)
- [Troubleshooting](#troubleshooting)
- [Architecture](#architecture)

---

## 🔧 Prerequisites

Pastikan Anda sudah menginstall:

- **Docker Desktop** versi 20.10+ ([Download](https://www.docker.com/products/docker-desktop))
- **WSL 2** (untuk Windows) versi 2.6.3+
- **Git** untuk version control

Verifikasi instalasi:

```bash
docker --version
docker compose version
wsl --version  # Untuk Windows
```

---

## 🚀 Quick Start

### Development (Recommended untuk Lokal)

```bash
# 1. Clone repository (jika belum)
git clone <repository-url>
cd lapas-jombang

# 2. Copy environment file
cp .env.docker .env

# 3. Generate application key
docker run --rm -v "$(pwd):/app" -w /app composer:2.7 php artisan key:generate

# 4. Start Docker containers
bash docker-start.sh

# Atau manual:
# docker compose -f docker-compose.dev.yml up -d --build
```

**Akses aplikasi:**
- 🌐 Web Application: http://localhost:8080
- 📧 Mailpit (Email Testing): http://localhost:8025
- 🔥 Vite HMR: http://localhost:5173

### Production

```bash
# 1. Update .env untuk production
cp .env.docker .env
# Edit .env dan set APP_ENV=production, APP_DEBUG=false

# 2. Start production containers
bash docker-start.sh prod

# Atau manual:
# docker compose up -d --build
```

**Akses aplikasi:**
- 🌐 Web Application: http://localhost

---

## 💻 Development Workflow

### Starting Development Environment

```bash
# Start semua services
bash docker-start.sh

# Atau dengan docker compose langsung
docker compose -f docker-compose.dev.yml up -d
```

### Running Artisan Commands

```bash
# Template: docker compose exec app php artisan <command>

# Examples:
docker compose -f docker-compose.dev.yml exec app php artisan migrate
docker compose -f docker-compose.dev.yml exec app php artisan db:seed
docker compose -f docker-compose.dev.yml exec app php artisan make:controller UserController
docker compose -f docker-compose.dev.yml exec app php artisan queue:work
docker compose -f docker-compose.dev.yml exec app php artisan cache:clear
```

### Running Composer Commands

```bash
# Install package
docker compose -f docker-compose.dev.yml exec app composer require spatie/laravel-permission

# Update dependencies
docker compose -f docker-compose.dev.yml exec app composer update

# Dump autoload
docker compose -f docker-compose.dev.yml exec app composer dump-autoload
```

### Running NPM Commands

```bash
# Install package
docker compose -f docker-compose.dev.yml exec vite npm install three

# Run build
docker compose -f docker-compose.dev.yml exec vite npm run build
```

### Accessing Database

```bash
# Melalui MySQL CLI di container
docker compose -f docker-compose.dev.yml exec mysql mysql -u laravel -psecret lapasjombang

# Atau menggunakan MySQL client dari host
# Host: localhost
# Port: 3306
# User: laravel
# Password: secret
# Database: lapasjombang
```

### Viewing Logs

```bash
# All services
docker compose -f docker-compose.dev.yml logs -f

# Specific service
docker compose -f docker-compose.dev.yml logs -f app
docker compose -f docker-compose.dev.yml logs -f queue
docker compose -f docker-compose.dev.yml logs -f nginx

# Last 100 lines
docker compose -f docker-compose.dev.yml logs --tail=100 app
```

### Stopping Development Environment

```bash
# Stop containers (data tetap tersimpan)
bash docker-stop.sh

# Atau manual
docker compose -f docker-compose.dev.yml down
```

### Reset Development Environment

> ⚠️ **Warning:** Ini akan menghapus semua data di database!

```bash
bash docker-reset.sh
```

---

## 🏭 Production Deployment

### VPS Deployment (Recommended)

#### 1. Persiapan VPS

```bash
# SSH ke VPS
ssh user@your-server-ip

# Install Docker & Docker Compose
curl -fsSL https://get.docker.com -o get-docker.sh
sudo sh get-docker.sh
sudo usermod -aG docker $USER

# Install Docker Compose
sudo apt-get update
sudo apt-get install docker-compose-plugin

# Logout dan login lagi
exit
ssh user@your-server-ip
```

#### 2. Deploy Aplikasi

```bash
# Clone repository
git clone <repository-url> /var/www/lapas-jombang
cd /var/www/lapas-jombang

# Setup environment
cp .env.docker .env
nano .env  # Edit sesuai kebutuhan production

# Update these values in .env:
# APP_ENV=production
# APP_DEBUG=false
# APP_URL=https://your-domain.com
# DB_PASSWORD=<strong-password>
# REDIS_PASSWORD=<strong-password>
# WHATSAPP_API_TOKEN=<your-fonnte-token>

# Generate key
docker run --rm -v "$(pwd):/app" -w /app composer:2.7 php artisan key:generate

# Start containers
docker compose up -d --build

# Check status
docker compose ps
```

#### 3. Setup Nginx Reverse Proxy (Optional, untuk SSL)

Jika Anda ingin menggunakan domain dengan SSL:

```bash
# Install Nginx di VPS (bukan di container)
sudo apt-get install nginx certbot python3-certbot-nginx

# Create Nginx config
sudo nano /etc/nginx/sites-available/lapas-jombang

# Paste konfigurasi:
server {
    listen 80;
    server_name your-domain.com;
    
    location / {
        proxy_pass http://localhost:80;
        proxy_set_header Host $host;
        proxy_set_header X-Real-IP $remote_addr;
        proxy_set_header X-Forwarded-For $proxy_add_x_forwarded_for;
        proxy_set_header X-Forwarded-Proto $scheme;
    }
}

# Enable site
sudo ln -s /etc/nginx/sites-available/lapas-jombang /etc/nginx/sites-enabled/
sudo nginx -t
sudo systemctl reload nginx

# Setup SSL dengan Let's Encrypt
sudo certbot --nginx -d your-domain.com
```

#### 4. Setup Auto-Start (Systemd)

```bash
# Docker sudah auto-start by default
# Verify dengan:
sudo systemctl status docker
```

#### 5. Monitoring & Maintenance

```bash
# View logs
docker compose logs -f

# Check container health
docker compose ps

# Restart services
docker compose restart

# Update aplikasi
cd /var/www/lapas-jombang
git pull
docker compose up -d --build
```

---

## 🔄 Service Management

### Service Overview

Docker setup ini terdiri dari beberapa services:

| Service | Description | Port |
|---------|-------------|------|
| `app` | PHP-FPM Laravel Application | 9000 (internal) |
| `nginx` | Web Server | 80, 443 |
| `mysql` | Database Server | 3306 |
| `redis` | Cache & Queue Backend | 6379 |
| `queue` | Laravel Queue Worker | - |
| `scheduler` | Laravel Task Scheduler | - |
| `vite` | Frontend Dev Server (dev only) | 5173 |
| `mailpit` | Email Testing (dev only) | 1025, 8025 |

### Restart Services

```bash
# Restart single service
docker compose restart app

# Restart multiple services
docker compose restart app queue

# Restart all services
docker compose restart
```

### Scale Queue Workers

```bash
# Scale queue workers ke 3 instances
docker compose up -d --scale queue=3

# Verify
docker compose ps queue
```

### View Container Resource Usage

```bash
# Real-time resource usage
docker stats

# Specific container
docker stats lapas-app lapas-queue
```

---

## 🗄️ Database Management

### Backup Database

```bash
# Backup ke file SQL
docker compose exec mysql mysqldump -u laravel -psecret lapasjombang > backup-$(date +%Y%m%d).sql

# Atau dengan compression
docker compose exec mysql mysqldump -u laravel -psecret lapasjombang | gzip > backup-$(date +%Y%m%d).sql.gz
```

### Restore Database

```bash
# Restore dari file SQL
docker compose exec -T mysql mysql -u laravel -psecret lapasjombang < backup-20260204.sql

# Dari compressed file
gunzip < backup-20260204.sql.gz | docker compose exec -T mysql mysql -u laravel -psecret lapasjombang
```

### Import Existing Database

```bash
# Jika Anda punya file SQL existing (misalnya dari XAMPP)
docker compose exec -T mysql mysql -u laravel -psecret lapasjombang < lapasjombang.sql
```

### Access MySQL Console

```bash
docker compose exec mysql mysql -u laravel -psecret lapasjombang
```

---

## 🐛 Troubleshooting

### Port Already in Use

**Problem:** Port 3306, 6379, atau 80 sudah digunakan

**Solution:**

```bash
# Stop local MySQL/Redis/Apache
sudo systemctl stop mysql
sudo systemctl stop redis
sudo systemctl stop apache2

# Atau ubah port di docker-compose.yml atau .env
```

### Permission Denied Errors

**Problem:** Laravel tidak bisa write ke storage/cache

**Solution:**

```bash
# Fix permissions
docker compose exec app chmod -R 775 storage bootstrap/cache
docker compose exec app chown -R www-data:www-data storage bootstrap/cache
```

### Queue Not Processing

**Problem:** Jobs tidak diproses oleh queue worker

**Solution:**

```bash
# Check queue worker logs
docker compose logs -f queue

# Restart queue worker
docker compose restart queue

# Manual run untuk testing
docker compose exec app php artisan queue:work --once
```

### Database Connection Refused

**Problem:** SQLSTATE[HY000] [2002] Connection refused

**Solution:**

```bash
# Wait for MySQL to be fully ready
docker compose exec app php artisan db:show

# Check MySQL is healthy
docker compose ps mysql

# Restart MySQL
docker compose restart mysql
```

### Vite Not Hot Reloading

**Problem:** Changes tidak auto-reload di development

**Solution:**

```bash
# Restart Vite container
docker compose -f docker-compose.dev.yml restart vite

# Check Vite logs
docker compose -f docker-compose.dev.yml logs -f vite

# Verify Vite accessible di http://localhost:5173
```

### Cannot Access from Mobile Device

**Problem:** HP tidak bisa akses QR Code

**Solution:**

```bash
# Update APP_URL di .env dengan IP laptop
# Misal laptop IP: 192.168.1.100
APP_URL=http://192.168.1.100:8080

# Restart containers
docker compose restart
```

### Out of Memory

**Problem:** Container stopped karena memory

**Solution:**

```bash
# Check resource usage
docker stats

# Increase Docker memory limit di Docker Desktop Settings
# Settings > Resources > Memory > Increase to 4GB+

# Or reduce PHP memory limit di docker/php/php.ini
memory_limit = 128M
```

---

## 🏗️ Architecture

### Container Architecture

```
┌─────────────────────────────────────────┐
│           Client (Browser/Mobile)        │
└──────────────────┬──────────────────────┘
                   │ HTTP
                   ▼
┌──────────────────────────────────────────┐
│              Nginx (Port 80)             │
│         - Static file serving            │
│         - FastCGI proxy to PHP-FPM       │
└──────────────────┬──────────────────────┘
                   │ FastCGI
                   ▼
┌──────────────────────────────────────────┐
│         PHP-FPM (Laravel App)            │
│         - Business logic                 │
│         - API endpoints                  │
│         - Blade rendering                │
└─────┬──────────────────┬────────────────┘
      │                  │
      │                  │
      ▼                  ▼
┌──────────┐      ┌─────────────┐
│  MySQL   │      │    Redis    │
│  (Port   │      │  (Port      │
│   3306)  │      │   6379)     │
└──────────┘      └─────────────┘
      ▲                  ▲
      │                  │
      │                  │
┌─────┴──────────┐┌──────┴──────┐
│  Queue Worker  ││  Scheduler  │
│  (Background)  ││   (Cron)    │
└────────────────┘└─────────────┘
```

### Network Flow

1. **Client Request** → Nginx (Port 80/443)
2. **Nginx** → PHP-FPM (Port 9000, internal)
3. **PHP-FPM** → MySQL (Port 3306, internal) atau Redis (Port 6379, internal)
4. **Queue Worker** → Polls Redis untuk jobs
5. **Scheduler** → Runs cron setiap menit

### Volume Mounts

- **mysql-data:** Persistent MySQL database storage
- **redis-data:** Persistent Redis data (queue & cache)
- **./storage:** Laravel storage (logs, uploads, cache)
- **./public/storage:** Symlinked storage untuk public access

---

## 📚 Additional Resources

### Useful Commands Cheat Sheet

```bash
# === Container Management ===
docker compose ps                    # List containers
docker compose up -d                 # Start in background
docker compose down                  # Stop & remove containers
docker compose restart               # Restart all
docker compose logs -f               # Follow logs

# === Laravel Artisan ===
docker compose exec app php artisan migrate
docker compose exec app php artisan db:seed
docker compose exec app php artisan cache:clear
docker compose exec app php artisan queue:work

# === Composer ===
docker compose exec app composer install
docker compose exec app composer update
docker compose exec app composer dump-autoload

# === Database ===
docker compose exec mysql mysql -u laravel -psecret lapasjombang
docker compose exec mysql mysqldump -u laravel -psecret lapasjombang

# === Shell Access ===
docker compose exec app bash
docker compose exec mysql bash
docker compose exec nginx sh
```

### Environment Variables Reference

Key environment variables untuk `.env`:

```bash
# Application
APP_ENV=local|production
APP_DEBUG=true|false
APP_URL=http://localhost:8080

# Database (Docker service names)
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=lapasjombang
DB_USERNAME=laravel
DB_PASSWORD=secret

# Redis (Docker service name)
REDIS_HOST=redis
REDIS_PORT=6379
QUEUE_CONNECTION=redis
CACHE_DRIVER=redis

# Mail (Mailpit for dev)
MAIL_HOST=mailpit
MAIL_PORT=1025
```

---

## 🤝 Support

Jika mengalami masalah:

1. Check logs: `docker compose logs -f`
2. Verify all containers healthy: `docker compose ps`
3. Review troubleshooting section di atas
4. Check GitHub Issues atau buat issue baru

---

## 📄 License

This project is licensed under the MIT License.

---

**Happy Dockerizing! 🐳🚀**
