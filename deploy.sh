#!/bin/bash

# --- AUTOMATED DEPLOYMENT SCRIPT ---
# Script ini digunakan untuk mempermudah proses update aplikasi di server produksi.
# Menjalankan git pull, migrasi database, optimasi cache, dan restart queue worker.

echo "🚀 Starting Deployment Process..."

# 1. Pull Code terbaru dari Git
echo "📦 Pulling latest code..."
git pull origin main

# 2. Install/Update Dependency PHP
echo "🔧 Installing Composer Dependencies..."
composer install --no-interaction --prefer-dist --optimize-autoloader

# 3. Install/Update Dependency Frontend (jika ada perubahan asset)
echo "🎨 Building Frontend Assets..."
npm install && npm run build

# 4. Jalankan Migrasi Database (Force agar tidak tanya konfirmasi di prod)
echo "🗄️  Migrating Database..."
php artisan migrate --force

# 5. Optimasi Cache Laravel
echo "⚡ Optimizing Application..."
php artisan optimize:clear
php artisan optimize
php artisan config:cache
php artisan route:cache
php artisan view:cache

# 6. Restart Queue Worker (Penting agar Job baru terbaca)
echo "🔄 Restarting Queue Workers..."
php artisan queue:restart

# 7. Update Dokumentasi API
echo "📚 Generating API Documentation..."
php artisan scramble:export

echo "✅ Deployment Finished Successfully!"
