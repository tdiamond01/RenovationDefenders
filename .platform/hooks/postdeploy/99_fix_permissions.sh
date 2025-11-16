#!/bin/bash
# Ensure storage directories exist with correct permissions
# This runs AFTER the app is deployed to /var/app/current/

cd /var/app/current

# Create all required storage directories
mkdir -p storage/framework/sessions
mkdir -p storage/framework/views
mkdir -p storage/framework/cache/data
mkdir -p storage/logs
mkdir -p storage/app/public
mkdir -p bootstrap/cache

# Set permissions
chmod -R 775 storage bootstrap/cache

# Set ownership to webapp user
chown -R webapp:webapp storage bootstrap/cache

echo "Storage directories created and permissions set successfully"
