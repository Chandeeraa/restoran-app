#!/bin/sh
# NO set -e

cd /var/www/html

echo ">>> [1/7] Setup directories..."
mkdir -p storage/app/public \
         storage/framework/cache/data \
         storage/framework/sessions \
         storage/framework/views \
         storage/logs \
         bootstrap/cache
chmod -R 777 storage bootstrap/cache

echo ">>> [2/7] Starting PHP-FPM in background..."
php-fpm -D
sleep 2

echo ">>> [3/7] Check/generate APP_KEY..."
if [ -z "$APP_KEY" ]; then
    echo "WARNING: APP_KEY not set, generating..."
    php artisan key:generate --force
else
    echo "APP_KEY is set OK."
fi

echo ">>> [4/7] Clear all caches..."
php artisan config:clear 2>&1 || true
php artisan cache:clear  2>&1 || true
php artisan route:clear  2>&1 || true
php artisan view:clear   2>&1 || true

echo ">>> [5/7] Running migrations and seeding..."
php artisan migrate --force 2>&1 && echo "Migrations OK" || echo "WARNING: Migrations failed"
php artisan db:seed --force 2>&1 && echo "Seeding OK" || echo "WARNING: Seeding skipped"

echo ">>> [6/7] Storage link..."
php artisan storage:link 2>/dev/null || true

echo ">>> [7/7] Starting queue worker in background..."
php artisan queue:work --sleep=3 --tries=3 --max-time=3600 &

echo ">>> Starting Nginx in FOREGROUND (keeps container alive)..."
exec nginx -g "daemon off;"
