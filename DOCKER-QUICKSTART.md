# 🐳 Quick Start Guide - Docker untuk Lapas Jombang

## ⚠️ Langkah Pertama: Start Docker Desktop

Sebelum menjalankan perintah Docker, pastikan **Docker Desktop sudah berjalan**:

### Windows:
1. **Buka Docker Desktop** dari Start Menu atau Desktop shortcut
2. **Tunggu** hingga Docker Desktop fully loaded (icon di system tray akan berwarna hijau)
3. **Verify** dengan klik icon Docker Desktop di system tray, pastikan statusnya "Running"

### Cara Manual Verify:
```bash
# Jalankan di terminal:
docker ps

# Jika berhasil, akan muncul:
# CONTAINER ID   IMAGE     COMMAND   CREATED   STATUS    PORTS     NAMES
# (atau list kosong jika belum ada container)

# Jika gagal, akan muncul error:
# error: cannot connect to the Docker daemon
```

---

## 🚀 Setelah Docker Desktop Running

### Option 1: Menggunakan Helper Script (Recommended)

```bash
# Masuk ke folder project
cd "c:\Tugas Kuliah\Belajar\lapas-jombang"

# Start development environment
bash docker-start.sh
```

### Option 2: Manual dengan Docker Compose

```bash
# Masuk ke folder project
cd "c:\Tugas Kuliah\Belajar\lapas-jombang"

# Build and start containers
docker compose -f docker-compose.dev.yml up -d --build

# View logs
docker compose -f docker-compose.dev.yml logs -f
```

---

## 📱 Setelah Container Jalan

Akses aplikasi di browser:

- **Web Application:** http://localhost:8080
- **Mailpit (Email Testing):** http://localhost:8025
- **Vite HMR:** http://localhost:5173

---

## 🛑 Stop Docker

```bash
# Stop semua containers (data tetap tersimpan)
bash docker-stop.sh

# Atau manual:
docker compose -f docker-compose.dev.yml down
```

---

## 🔄 Troubleshooting

### Error: "cannot connect to Docker daemon"

**Solusi:**
1. Buka Docker Desktop
2. Tunggu sampai fully loaded
3. Coba perintah lagi

### Error: "port already in use"

**Solusi:**
```bash
# Stop aplikasi lain yang menggunakan port 8080, 3306, 6379
# Atau ubah port di .env dan docker-compose.dev.yml
```

### Need Help?

Baca dokumentasi lengkap di **DOCKER.md**
