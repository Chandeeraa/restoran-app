#!/bin/sh
# NO set -e - script harus tetap jalan meski ada error

cd /var/www/html

echo ">>> [1/8] Setup directories..."
mkdir -p storage/app/public \
         storage/framework/cache/data \
         storage/framework/sessions \
         storage/framework/views \
         storage/logs \
         bootstrap/cache
chmod -R 777 storage bootstrap/cache

echo ">>> [2/8] Starting PHP-FPM..."
php-fpm -D
sleep 2

echo ">>> [3/8] Starting Nginx (background)..."
nginx &
NGINX_PID=$!
echo "Nginx PID: $NGINX_PID"

echo ">>> [4/8] Check/generate APP_KEY..."
if [ -z "$APP_KEY" ]; then
    echo "WARNING: APP_KEY not set, generating..."
    php artisan key:generate --force
else
    echo "APP_KEY is set."
fi

echo ">>> [5/8] Clear old cache..."
php artisan config:clear  2>&1 || true
php artisan cache:clear   2>&1 || true

echo ">>> [6/8] Running migrations..."
php artisan migrate --force 2>&1 || echo "WARNING: migrate failed, check DB vars"

echo ">>> [7/8] Storage link..."
php artisan storage:link 2>/dev/null || true

echo ">>> [8/8] Starting queue worker..."
php artisan queue:work --sleep=3 --tries=3 --max-time=3600 &

echo ">>> All services running! Nginx PID: $NGINX_PID"
wait $NGINX_PID
