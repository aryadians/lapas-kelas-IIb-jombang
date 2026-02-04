@echo off
TITLE Cloudflare Tunnel (DOCKER) - Lapas Jombang

echo [CHECK] Memeriksa instalasi cloudflared...
where cloudflared >nul 2>nul
if %errorlevel% neq 0 (
    echo.
    echo [ERROR] Program 'cloudflared' tidak ditemukan!
    echo -------------------------------------------------------
    echo Harap install terlebih dahulu dengan perintah:
    echo winget install --id Cloudflare.cloudflared
    echo -------------------------------------------------------
    echo atau download manual dari website Cloudflare.
    pause
    exit /b
)

echo [OK] cloudflared terdeteksi.
echo.
echo ===========================================================
echo   MEMULAI CLOUDFLARE TUNNEL (DOCKER MODE)
echo   Target: http://127.0.0.1:8080
echo ===========================================================
echo.
echo [TIPS]
echo 1. Pastikan Docker sudah running (./docker-start.sh)
echo 2. Salin URL 'https://....trycloudflare.com' yang muncul di bawah.
echo 3. Update APP_URL di file .env Anda jika perlu.
echo.
echo Menunggu koneksi...
echo.

cloudflared tunnel --url http://127.0.0.1:8080
pause
