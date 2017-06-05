#!/usr/bin/env bash

# Going to the parent folder
cd ./..

# Create the Lumen .env file
echo "### Creating the Lumen .env file ###"
cp "$(pwd)"/api/lumen/.env.staging "$(pwd)"/api/lumen/.env

# Install Back-end dependencies for Lumen
echo "### Installing Back-end dependencies for Lumen ###"
docker run --rm -v "$(pwd)"/api/lumen:/app -w /app composer/composer install
