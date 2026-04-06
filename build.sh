#!/usr/bin/env bash
set -o errexit

echo "==> Installation des dépendances..."
composer install --no-dev --optimize-autoloader

echo "==> Génération de la clé..."
php artisan key:generate --force

echo "==> Cache de configuration..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "==> Migration de la base de données..."
php artisan migrate --force

echo "==> Remplissage de la base de données..."
php artisan db:seed --class=PathologieSeeder --force
php artisan db:seed --class=MassPathologieSeeder --force
php artisan db:seed --class=ExtraPathologieSeeder --force
php artisan db:seed --class=FinalPathologieSeeder --force
php artisan db:seed --class=UpdateCausesSeeder --force

echo "==> BioLink est prêt ! 🚀"