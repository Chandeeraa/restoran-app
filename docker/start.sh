#!/bin/sh
set -e

cd /var/www/html

echo ">>> [1/7] Setting up directories..."
mkdir -p storage/app/public \
         storage/framework/cache/data \
         storage/framework/sessions \
         storage/framework/views \
         storage/logs \
         bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache
chmod -R 775 storage bootstrap/cache

echo ">>> [2/7] Checking APP_KEY..."
if [ -z "$APP_KEY" ]; then
    echo "ERROR: APP_KEY is not set! Please set it in Railway Variables."
    exit 1
fi

echo ">>> [3/7] Caching Laravel config..."
php artisan config:cache 2>&1 && echo "config:cache OK" || echo "config:cache SKIPPED"
php artisan route:cache 2>&1 && echo "route:cache OK" || echo "route:cache SKIPPED"
php artisan view:cache  2>&1 && echo "view:cache OK"  || echo "view:cache SKIPPED"

echo ">>> [4/7] Running migrations..."
php artisan migrate --force 2>&1 && echo "migrate OK" || echo "migrate SKIPPED (check DB vars)"

echo ">>> [5/7] Storage link..."
php artisan storage:link 2>/dev/null || true

echo ">>> [6/7] Starting PHP-FPM..."
php-fpm -D
sleep 2

echo ">>> [7/7] Starting Queue Worker in background..."
php artisan queue:work --daemon --sleep=3 --tries=3 --max-time=3600 &

echo ">>> All services started! Starting Nginx..."
exec nginx -g "daemon off;"
