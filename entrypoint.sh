#!/bin/sh

# Ensure SQLite database exists and has write permissions
mkdir -p /var/www/html/database
touch /var/www/html/database/database.sqlite
chmod 666 /var/www/html/database/database.sqlite

# Run Laravel optimizations
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Fresh migrate and seed on startup so the portofolio always has fresh data
php artisan migrate:fresh --seed --force

# Execute the base image entrypoint (starts FPM and Nginx)
exec /init
