#!/bin/bash

echo "==> Démarrage BioLink 🚀"

cd /var/www/html

# Permissions
chmod -R 775 storage bootstrap/cache 2>/dev/null || true

# Clear tous les caches
php artisan config:clear 2>/dev/null || true
php artisan cache:clear 2>/dev/null || true
php artisan route:clear 2>/dev/null || true
php artisan view:clear 2>/dev/null || true

# Cache production
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Storage
php artisan storage:link 2>/dev/null || true

# Attendre que la base soit prête
echo "==> Attente connexion base de données..."
sleep 5

# Migration complète
echo "==> Migration base de données..."
php artisan migrate:fresh --force

# Seeders
echo "==> Chargement pathologies..."
php artisan db:seed --class=PathologieSeeder --force
php artisan db:seed --class=MassPathologieSeeder --force
php artisan db:seed --class=ExtraPathologieSeeder --force
php artisan db:seed --class=FinalPathologieSeeder --force
php artisan db:seed --class=UpdateCausesSeeder --force

echo "==> BioLink est en ligne ! 🌍🚀"

# Démarrer Apache
exec apache2-foreground