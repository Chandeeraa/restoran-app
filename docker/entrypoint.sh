#!/bin/sh
set -e

cd /var/www/html

echo "==> Setting up storage directories..."
mkdir -p storage/app/public
mkdir -p storage/framework/cache/data
mkdir -p storage/framework/sessions
mkdir -p storage/framework/views
mkdir -p storage/logs
mkdir -p bootstrap/cache

chown -R www-data:www-data storage bootstrap/cache
chmod -R 775 storage bootstrap/cache

echo "==> Generating APP_KEY if not set..."
if [ -z "$APP_KEY" ]; then
    php artisan key:generate --force
fi

echo "==> Caching config, routes, and views..."
php artisan config:cache || echo "WARNING: config:cache failed, continuing..."
php artisan route:cache || echo "WARNING: route:cache failed, continuing..."
php artisan view:cache || echo "WARNING: view:cache failed, continuing..."

echo "==> Running migrations (if DB is available)..."
php artisan migrate --force 2>&1 || echo "WARNING: migrate failed (DB might not be ready), continuing..."

echo "==> Running database seeders..."
php artisan db:seed --force 2>/dev/null || true

echo "==> Creating storage symlink..."
php artisan storage:link 2>/dev/null || true

echo "==> Starting services..."
exec /usr/bin/supervisord -c /etc/supervisord.conf
