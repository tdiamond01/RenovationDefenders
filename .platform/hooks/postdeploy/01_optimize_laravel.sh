#!/bin/bash
set -e  # Exit on error

# Navigate to application directory
cd /var/app/current

# Verify vendor directory exists (should be included from GitHub Actions build)
if [ ! -d "vendor" ]; then
    echo "ERROR: vendor directory not found! The deployment package may be incomplete."
    exit 1
fi

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
