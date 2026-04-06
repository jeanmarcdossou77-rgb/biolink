#!/bin/bash

echo "==> Démarrage BioLink 🚀"
cd /var/www/html

chmod -R 775 storage bootstrap/cache 2>/dev/null || true

php artisan config:clear 2>/dev/null || true
php artisan cache:clear 2>/dev/null || true
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan storage:link 2>/dev/null || true

echo "==> Attente base de données..."
sleep 8

echo "==> Migration..."
php artisan migrate --force

echo "==> Seed..."
php artisan db:seed --force

echo "==> BioLink en ligne ! 🌍"
exec apache2-foreground