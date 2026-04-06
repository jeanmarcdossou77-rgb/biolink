#!/bin/bash

echo "==> Démarrage BioLink..."

cd /var/www/html

# Permissions
chmod -R 775 storage bootstrap/cache 2>/dev/null || true

# Cache production
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Storage link
php artisan storage:link 2>/dev/null || true

# Migrations avec gestion d'erreurs
echo "==> Migration base de données..."
php artisan migrate --force 2>/dev/null || true

# Seeders
echo "==> Remplissage base de données..."
php artisan db:seed --class=PathologieSeeder --force 2>/dev/null || true
php artisan db:seed --class=MassPathologieSeeder --force 2>/dev/null || true
php artisan db:seed --class=ExtraPathologieSeeder --force 2>/dev/null || true
php artisan db:seed --class=FinalPathologieSeeder --force 2>/dev/null || true
php artisan db:seed --class=UpdateCausesSeeder --force 2>/dev/null || true

echo "==> BioLink est en ligne ! 🚀"

# Démarrer Apache
exec apache2-foreground