#!/bin/bash
set -e

echo "==> Démarrage BioLink..."

# Générer la clé si pas définie
php artisan key:generate --force

# Cache
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Migrations
echo "==> Migration base de données..."
php artisan migrate --force

# Seeders
echo "==> Remplissage base de données..."
php artisan db:seed --class=PathologieSeeder --force
php artisan db:seed --class=MassPathologieSeeder --force
php artisan db:seed --class=ExtraPathologieSeeder --force
php artisan db:seed --class=FinalPathologieSeeder --force
php artisan db:seed --class=UpdateCausesSeeder --force

echo "==> BioLink est en ligne ! 🚀"

# Démarrer Apache
apache2-foreground