#!/bin/bash

# Wait until vendor/autoload.php exists
until [ -f /var/www/vendor/autoload.php ]; do
  echo "Waiting for Composer dependencies..."
  sleep 2
done

echo "Dependencies found. Starting queue worker..."
php artisan queue:work
