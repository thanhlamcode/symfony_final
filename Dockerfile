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
    npm

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-install pdo pdo_pgsql mbstring exif pcntl bcmath gd xml

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Set working directory
WORKDIR /var/www

# Copy composer files first
COPY composer.json composer.lock ./

# Install dependencies
RUN composer install --no-scripts --no-autoloader

# Copy the rest of the application
COPY . .

# Configure git
RUN git config --global --add safe.directory /var/www

# Create necessary directories and set permissions
RUN mkdir -p /var/www/var/cache /var/www/var/log \
    && chown -R www-data:www-data /var/www \
    && chmod -R 777 /var/www/var

# Generate autoloader
RUN composer dump-autoload --optimize

# Change current user to www-data
USER www-data

# Create PHP-FPM configuration
RUN echo "listen = 0.0.0.0:${PORT:-9000}" > /usr/local/etc/php-fpm.d/zz-docker.conf

# Expose port and start php-fpm server
EXPOSE ${PORT:-9000}
CMD ["php-fpm"] 