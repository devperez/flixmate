#!/usr/bin/env bash
echo "🚀 Building Laravel application..."

# Installer les dépendances PHP
composer install --no-dev --optimize-autoloader

# Installer les dépendances npm
npm ci

# Build des assets
npm run build

# Générer la configuration
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan optimize