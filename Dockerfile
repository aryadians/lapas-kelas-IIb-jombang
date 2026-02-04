# Multi-stage Dockerfile untuk Laravel 12 - Lapas Jombang
# Optimized untuk production dengan image size minimal

# ============================================
# Stage 1: Composer Dependencies (Builder)
# ============================================
FROM composer:2.7 AS composer-builder

# Copy composer files
COPY composer.json composer.lock /app/

WORKDIR /app

# Install dependencies (production only, no dev)
RUN composer install \
    --no-dev \
    --no-scripts \
    --no-autoloader \
    --prefer-dist \
    --ignore-platform-reqs

# Copy source code & generate autoloader
COPY . /app
RUN composer dump-autoload --optimize --classmap-authoritative

# ============================================
# Stage 2: Node.js & Vite Build (Frontend)
# ============================================
FROM node:20-alpine AS node-builder

WORKDIR /app

# Copy package files
COPY package*.json ./

# Install dependencies
RUN npm ci --only=production

# Copy source code & build assets
COPY . .
RUN npm run build

# ============================================
# Stage 3: PHP Runtime (Production)
# ============================================
FROM php:8.3-fpm-alpine

# Install system dependencies & PHP extensions
RUN apk add --no-cache \
    bash \
    curl \
    libpng-dev \
    libjpeg-turbo-dev \
    freetype-dev \
    libzip-dev \
    icu-dev \
    oniguruma-dev \
    mysql-client \
    supervisor \
    nginx \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) \
        pdo_mysql \
        mysqli \
        gd \
        zip \
        intl \
        mbstring \
        bcmath \
        opcache \
    && pecl install redis \
    && docker-php-ext-enable redis

# Copy custom PHP configuration
COPY docker/php/php.ini /usr/local/etc/php/conf.d/custom.ini

# Copy custom PHP-FPM configuration
COPY docker/php/www.conf /usr/local/etc/php-fpm.d/www.conf

# Set working directory
WORKDIR /var/www/html

# Copy application from builder stages
COPY --from=composer-builder --chown=www-data:www-data /app /var/www/html
COPY --from=node-builder --chown=www-data:www-data /app/public/build /var/www/html/public/build

# Copy entrypoint script
COPY docker/entrypoint.sh /usr/local/bin/entrypoint
RUN chmod +x /usr/local/bin/entrypoint

# Set permissions
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 775 /var/www/html/storage \
    && chmod -R 775 /var/www/html/bootstrap/cache

# Expose port
EXPOSE 9000

# Health check
HEALTHCHECK --interval=30s --timeout=3s --start-period=40s --retries=3 \
    CMD php artisan schedule:list || exit 1

# Switch to www-data user
USER www-data

# Entrypoint
ENTRYPOINT ["/usr/local/bin/entrypoint"]

# Default command
CMD ["php-fpm"]
