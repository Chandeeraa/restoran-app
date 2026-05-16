FROM php:8.3-fpm-alpine

# Install system dependencies
RUN apk add --no-cache \
    nginx \
    nodejs \
    npm \
    git \
    curl \
    zip \
    unzip \
    libpng-dev \
    libjpeg-turbo-dev \
    freetype-dev \
    oniguruma-dev \
    libzip-dev \
    icu-dev \
    && mkdir -p /var/log/nginx \
    && mkdir -p /run/nginx

# Install PHP extensions
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install \
        pdo \
        pdo_mysql \
        mbstring \
        exif \
        pcntl \
        bcmath \
        gd \
        zip \
        intl \
        opcache

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www/html

# Copy application files
COPY . .

# Create required directories BEFORE composer install
RUN mkdir -p bootstrap/cache \
    && mkdir -p storage/framework/cache/data \
    && mkdir -p storage/framework/sessions \
    && mkdir -p storage/framework/views \
    && mkdir -p storage/logs \
    && mkdir -p storage/app/public \
    && chmod -R 777 bootstrap/cache \
    && chmod -R 777 storage

# Install PHP dependencies - skip scripts to avoid artisan calls during build
RUN composer install --optimize-autoloader --no-dev --no-interaction --prefer-dist --no-scripts \
    && composer dump-autoload --optimize

# Install Node dependencies and build assets
RUN npm ci && npm run build && rm -rf node_modules

# Copy nginx config
COPY docker/nginx.conf /etc/nginx/nginx.conf

# Copy start script
COPY docker/start.sh /start.sh
RUN chmod +x /start.sh

# Set final permissions
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html/storage \
    && chmod -R 755 /var/www/html/bootstrap/cache

EXPOSE 8080

CMD ["/start.sh"]
