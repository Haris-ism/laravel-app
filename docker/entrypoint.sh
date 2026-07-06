#!/bin/sh
set -e

# Sync public directory (including Vite built assets) into the shared volume.
# This runs on every start so rebuilds are always reflected.
echo "Syncing public assets..."
cp -rf /tmp/app-public/. /var/www/html/public/

echo "Running migrations..."
php artisan migrate --force

echo "Caching config, routes, views..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "Starting PHP-FPM..."
exec "$@"
