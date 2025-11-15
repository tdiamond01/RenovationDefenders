#!/bin/bash

# Navigate to application directory
cd /var/app/current

# Set proper permissions
chmod -R 775 storage bootstrap/cache
chown -R webapp:webapp storage bootstrap/cache

# Clear and cache configurations
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Run migrations (optional - uncomment if you want auto-migrations)
# php artisan migrate --force

echo "Laravel optimization completed successfully!"
