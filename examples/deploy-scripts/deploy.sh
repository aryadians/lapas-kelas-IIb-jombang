#!/usr/bin/env bash
# Simple deploy helper (example) — adapt to your environment
set -e
PROJECT_DIR="/var/www/your-project-path"
cd "$PROJECT_DIR"

echo "Pulling changes..."
git pull origin main

echo "Installing composer dependencies..."
composer install --no-dev --optimize-autoloader

echo "Building assets (optional)..."
npm ci && npm run build

echo "Running migrations..."
php artisan migrate --force

echo "Config & route cache..."
php artisan config:cache
php artisan route:cache

echo "Restart queue workers..."
php artisan queue:restart

echo "Done."
