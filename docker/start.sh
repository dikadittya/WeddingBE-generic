#!/bin/bash

# Start script for Laravel Docker container
echo "Starting Wedding Backend Application..."

# Wait for database to be ready
echo "Waiting for database connection..."
until nc -z mysql 3306; do
    echo "Database not ready, waiting..."
    sleep 5
done

# Generate application key if not exists
if [ ! -f .env ]; then
    echo "Creating .env file from .env.example..."
    cp .env.example .env
fi

if grep -q "APP_KEY=$" .env || grep -q "APP_KEY=null" .env; then
    echo "Generating application key..."
    php artisan key:generate --force
fi

# Clear and cache configuration
echo "Clearing and caching configuration..."
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear

# Create storage link
echo "Creating storage link..."
php artisan storage:link

# Set proper permissions
echo "Setting permissions..."
chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

echo "Application started successfully!"

# Start supervisor
exec /usr/bin/supervisord -c /etc/supervisor/conf.d/supervisord.conf