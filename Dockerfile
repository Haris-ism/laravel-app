# ── Stage 1: Build Vite assets ────────────────────────────────────────────────
FROM node:20-alpine AS node-builder

WORKDIR /app

COPY package.json package-lock.json ./
RUN npm ci

COPY vite.config.js ./
COPY resources/ resources/
COPY public/ public/

RUN npm run build

# ── Stage 2: PHP application ──────────────────────────────────────────────────
FROM php:8.4-fpm-alpine AS app

# System deps for PHP extensions
RUN apk add --no-cache \
    postgresql-dev \
    oniguruma-dev \
    libxml2-dev \
    libzip-dev \
    zip \
    unzip \
    git \
    curl

# PHP extensions
RUN docker-php-ext-install \
    pdo_pgsql \
    pgsql \
    mbstring \
    xml \
    bcmath \
    zip \
    opcache \
    pcntl

# Opcache settings for production
RUN echo "opcache.enable=1" >> /usr/local/etc/php/conf.d/opcache.ini && \
    echo "opcache.memory_consumption=256" >> /usr/local/etc/php/conf.d/opcache.ini && \
    echo "opcache.max_accelerated_files=20000" >> /usr/local/etc/php/conf.d/opcache.ini && \
    echo "opcache.validate_timestamps=0" >> /usr/local/etc/php/conf.d/opcache.ini

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Install PHP dependencies (no dev, no scripts yet)
COPY composer.json composer.lock ./
RUN composer install --no-dev --no-scripts --no-autoloader --prefer-dist

# Copy application source
COPY . .

# Copy compiled frontend assets from node-builder stage
COPY --from=node-builder /app/public/build public/build

# Finalize composer autoloader
RUN composer dump-autoload --optimize --no-dev

# Keep a copy of public at a separate path so the entrypoint can sync it
# into the named volume on every container start (handles image rebuilds)
RUN cp -r /var/www/html/public /tmp/app-public

# Set permissions
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html/storage \
    && chmod -R 755 /var/www/html/bootstrap/cache

COPY docker/entrypoint.sh /usr/local/bin/entrypoint.sh
RUN chmod +x /usr/local/bin/entrypoint.sh

EXPOSE 9000
ENTRYPOINT ["entrypoint.sh"]
CMD ["php-fpm"]
