# Technology Stack

## Core Framework & Language

- **PHP**: 8.2+
- **Laravel**: 12.x (latest framework version)
- **Database**: MySQL 8.0
- **Cache/Queue**: Redis (for real-time features and background jobs)

## Frontend Stack

- **CSS Framework**: Tailwind CSS 3.x with @tailwindcss/forms
- **JavaScript**: Alpine.js 3.x for reactive components
- **SPA Navigation**: Hotwire Turbo Drive (instant navigation without full page reloads)
- **Build Tool**: Vite 7.x with laravel-vite-plugin
- **Rich Text Editor**: Trix 2.x
- **3D Graphics**: Three.js (for visual effects)

## Key Laravel Packages

- **laravel/breeze**: Authentication scaffolding
- **laravel/sanctum**: API authentication
- **spatie/laravel-activitylog**: Activity logging
- **spatie/laravel-backup**: Automated backups
- **maatwebsite/excel**: Excel import/export
- **simplesoftwareio/simple-qrcode**: QR code generation
- **mews/purifier**: HTML sanitization
- **dedoc/scramble**: API documentation
- **league/flysystem-aws-s3-v3**: S3 storage support

## Architecture Patterns

### Storage Strategy
- **Base64 Storage**: KTP photos and QR codes stored as Base64 LongText in database (zero-file storage)
- **File Storage**: Videos and logos use traditional file storage via `storage/app/public`
- **Symlink Required**: Run `php artisan storage:link` after installation

### Real-time Features
- Redis-backed queue system for WhatsApp and Email notifications
- Event broadcasting for queue updates (AntrianUpdated event)
- Cache invalidation for news and announcements

### Image Processing
- Automatic Base64 compression for uploaded images
- Eager loading optimization for database relationships

## Common Commands

### Initial Setup
```bash
# Full setup (dependencies + database + build)
composer run setup

# Manual steps
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate --force
npm install
npm run build
```

### Development
```bash
# Start all dev services (server, queue, logs, vite)
composer run dev

# Individual services
php artisan serve                    # Development server (port 8000)
php artisan queue:listen --tries=3   # Queue worker (REQUIRED for notifications)
php artisan pail --timeout=0         # Real-time logs
npm run dev                          # Vite dev server
```

### Testing
```bash
composer run test
# or
php artisan test
```

### Docker
```bash
# Start all containers (Web, DB, Redis, Mailpit)
./docker-start.sh

# Access at http://localhost:8080
```

### Production
```bash
npm run build                # Build assets for production
php artisan config:cache     # Cache configuration
php artisan route:cache      # Cache routes
php artisan view:cache       # Cache views
php artisan optimize         # Optimize framework
```

### Maintenance
```bash
php artisan cache:clear      # Clear application cache
php artisan config:clear     # Clear config cache
php artisan route:clear      # Clear route cache
php artisan view:clear       # Clear compiled views
```

## Environment Requirements

- PHP 8.2 or higher
- Composer 2.x
- Node.js 18+ and npm
- MySQL 8.0+
- Redis server (for queue and cache)
- UV/UVX (Python package manager, optional for development)

## Critical Notes

1. **Queue Worker**: Must run `php artisan queue:listen --tries=3` for WhatsApp/Email notifications to work
2. **Storage Link**: Must run `php artisan storage:link` for video banners and logos to display
3. **Redis**: Required for real-time queue updates and background jobs
4. **Base64 Images**: KTP photos and QR codes are stored in database, not filesystem
