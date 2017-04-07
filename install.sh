#!/usr/bin/env bash
# Install Front-end dependencies for View.js
docker run --rm -v "$(pwd)"/client:/app -w /app node npm install
# Install Composer dependencies for Lumen
docker run --rm -v "$(pwd)"/api/lumen:/app -w /app composer/composer install