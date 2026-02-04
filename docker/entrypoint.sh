#!/bin/bash
# Docker Entrypoint Script untuk Laravel - Lapas Jombang
# Handles initialization, migrations, and permissions

set -e

echo "🚀 Starting Lapas Jombang Application..."

# Function to wait for database
wait_for_db() {
    echo "⏳ Waiting for MySQL to be ready..."
    
    until php artisan db:show 2>/dev/null; do
        echo "   Database not ready yet, waiting..."
        sleep 2
    done
    
    echo "✅ Database is ready!"
}

# Function to run migrations
run_migrations() {
    if [ "$APP_ENV" = "production" ]; then
        echo "🔄 Running migrations (production mode)..."
        php artisan migrate --force --no-interaction
    else
        echo "🔄 Running migrations (development mode)..."
        php artisan migrate --no-interaction
    fi
}

# Function to setup Laravel
setup_laravel() {
    echo "🔧 Setting up Laravel..."
    
    # Create storage directories if not exist
    mkdir -p storage/framework/{sessions,views,cache}
    mkdir -p storage/logs
    mkdir -p bootstrap/cache
    
    # Link storage
    if [ ! -L public/storage ]; then
        echo "🔗 Linking storage..."
        php artisan storage:link --force
    fi
    
    # Set permissions
    echo "🔐 Setting permissions..."
    chmod -R 775 storage bootstrap/cache
    
    # Cache configuration (production only)
    if [ "$APP_ENV" = "production" ]; then
        echo "📦 Caching configuration..."
        php artisan config:cache
        php artisan route:cache
        php artisan view:cache
        php artisan event:cache
    else
        echo "🧹 Clearing caches (development mode)..."
        php artisan config:clear
        php artisan route:clear
        php artisan view:clear
        php artisan cache:clear
    fi
}

# Main execution
echo "================================================"
echo "  Lapas Jombang - Docker Container Init"
echo "  Environment: $APP_ENV"
echo "================================================"

# Wait for database to be ready
wait_for_db

# Run migrations
run_migrations

# Setup Laravel
setup_laravel

echo "✅ Initialization complete!"
echo "================================================"

# Execute the main command (PHP-FPM or custom command)
exec "$@"
