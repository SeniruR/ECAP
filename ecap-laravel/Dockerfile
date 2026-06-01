FROM node:22-bookworm-slim AS frontend

WORKDIR /app

COPY package.json package-lock.json vite.config.js postcss.config.js tailwind.config.js ./

RUN npm ci

COPY resources ./resources
COPY public ./public

RUN npm run build

# Production Dockerfile for Laravel app running on Apache + PHP-FPM
FROM php:8.4-apache-bullseye

# Install system dependencies and PHP extensions
RUN apt-get update \
    && apt-get install -y --no-install-recommends \
        git \
        unzip \
        libzip-dev \
        libpng-dev \
        libonig-dev \
        libxml2-dev \
        libsqlite3-dev \
        curl \
    && docker-php-ext-configure zip \
    && docker-php-ext-install pdo_mysql pdo_sqlite sqlite3 zip gd \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Enable Apache modules needed for Laravel
RUN a2enmod rewrite headers

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Copy only composer files first for better layer caching
COPY composer.json composer.lock ./
# Install PHP dependencies without running composer scripts (artisan isn't available yet)
RUN composer install --no-dev --optimize-autoloader --no-interaction --prefer-dist --no-scripts

# Copy application source
COPY . .

# Copy the built frontend assets from the build stage.
COPY --from=frontend /app/public/build ./public/build

# Copy and install the entrypoint
COPY docker-entrypoint.sh /var/www/html/docker-entrypoint.sh
RUN chmod +x /var/www/html/docker-entrypoint.sh

# Run composer scripts and Laravel discovery now that application files exist
RUN composer dump-autoload --optimize && php artisan package:discover --ansi || true

# Set Apache document root to public/
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public
RUN sed -ri 's!/var/www/html!/var/www/html/public!g' /etc/apache2/sites-available/000-default.conf \
    && sed -ri 's!/var/www/!/var/www/html/public!g' /etc/apache2/apache2.conf

# Ensure Apache allows .htaccess overrides in the public directory so Laravel's
# front controller (public/index.php) and routing work properly.
RUN printf '%s\n' "<Directory /var/www/html/public>" \
    "    Options +FollowSymLinks" \
    "    AllowOverride All" \
    "    Require all granted" \
    "</Directory>" > /etc/apache2/conf-available/laravel.conf \
    && a2enconf laravel \
    && echo "ServerName localhost" >> /etc/apache2/apache2.conf

# Ensure storage and bootstrap/cache are writable
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Expose port 80 for HTTP traffic
EXPOSE 80

ENTRYPOINT ["/var/www/html/docker-entrypoint.sh"]
CMD ["apache2-foreground"]
