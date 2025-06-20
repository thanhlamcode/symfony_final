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
  libpq-dev

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-install pdo pdo_pgsql mbstring exif pcntl bcmath gd

# Install symfony CLI
RUN curl -sS https://get.symfony.com/cli/installer | bash && \
    mv /root/.symfony5/bin/symfony /usr/local/bin/symfony

ENV PATH="/usr/local/bin:${PATH}"

# Get latest Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www

# Copy existing application directory
COPY . .

# Xóa vendor và composer.lock để đảm bảo sạch
RUN rm -rf vendor composer.lock

# Install dependencies
RUN composer install --no-interaction --no-dev --optimize-autoloader

# Đảm bảo symfony-cmd có quyền thực thi
RUN if [ -f vendor/bin/symfony-cmd ]; then chmod +x vendor/bin/symfony-cmd; fi

# Change ownership of our applications
RUN chown -R www-data:www-data /var/www

# Change current user to www-data
USER www-data

# Expose port 9000 and start php-fpm server
EXPOSE 9000
CMD ["php-fpm"] 