#!/bin/sh

# Storage symlink
php artisan storage:link --force

# Run migrations
php artisan migrate --force

# Run seeder (hanya pertama kali)
php artisan db:seed --class=AdminUserSeeder --force

# Cache
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Start PHP-FPM di background
php-fpm &

# Start Nginx di foreground
nginx -g "daemon off;"
