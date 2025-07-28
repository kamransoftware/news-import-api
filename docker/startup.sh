#!/bin/bash

echo "🚀 Starting News Import API Setup..."

# Install dependencies
# Install dependencies if not already installed
if [ ! -d "vendor" ]; then
  echo "Running composer install..."
  composer install --no-interaction --prefer-dist --optimize-autoloader
fi

# Copy .env if it doesn't exist
if [ ! -f .env ]; then
  cp .env.example .env
fi

# Create SQLite DB if using SQLite
mkdir -p database
touch database/database.sqlite

# Generate app key
php artisan key:generate

# Run migrations
php artisan migrate --force

# Create storage symlink
php artisan storage:link || true

# Start Laravel development server (optional)
php artisan serve --host=0.0.0.0 --port=8000