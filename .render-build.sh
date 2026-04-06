#!/usr/bin/env bash
set -o errexit

composer install --no-dev --optimize-autoloader

php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan storage:link

php artisan migrate --force

php artisan db:seed --class=PathologieSeeder --force
php artisan db:seed --class=MassPathologieSeeder --force
php artisan db:seed --class=ExtraPathologieSeeder --force
php artisan db:seed --class=FinalPathologieSeeder --force
php artisan db:seed --class=UpdateCausesSeeder --force