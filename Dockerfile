FROM php:8.2-fpm

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    libpq-dev \
    nodejs \
    npm \
    nginx

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-install pdo_pgsql mbstring exif pcntl bcmath gd

# Get latest Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www

# Copy composer files
COPY composer.json composer.lock ./

# Install dependencies
RUN composer install --no-scripts --no-autoloader

# Copy source code
COPY . .

# Configure Git
RUN git config --global --add safe.directory /var/www

# Create necessary directories and set permissions
RUN mkdir -p var/cache var/log \
    && chown -R www-data:www-data var/cache var/log \
    && chmod -R 777 var/cache var/log

# Generate optimized autoloader
RUN composer dump-autoload --optimize

# Configure Nginx
COPY nginx.conf /etc/nginx/nginx.conf

# Create start script
RUN echo '#!/bin/sh' > /usr/local/bin/start.sh
RUN echo 'php-fpm -D' >> /usr/local/bin/start.sh
RUN echo 'nginx -g "daemon off;"' >> /usr/local/bin/start.sh
RUN chmod +x /usr/local/bin/start.sh

# Switch to non-root user
USER www-data

# Expose port
EXPOSE 10000

# Start Nginx and PHP-FPM
CMD ["/usr/local/bin/start.sh"] 