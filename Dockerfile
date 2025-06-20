# Bắt đầu với image PHP
FROM php:8.2-fpm

# Install system dependencies, including nginx and supervisor
RUN apt-get update && apt-get install -y \
  git \
  curl \
  libpng-dev \
  libonig-dev \
  libxml2-dev \
  zip \
  unzip \
  libpq-dev \
  nginx \
  supervisor

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# === BƯỚC SỬA QUAN TRỌNG ===
# Cấu hình PHP-FPM để lắng nghe trên cổng TCP thay vì socket.
# File www.conf là file cấu hình mặc định của PHP-FPM pool.
RUN sed -i 's|listen = /var/run/php-fpm.sock|listen = 9000|g' /usr/local/etc/php-fpm.d/www.conf

# Install PHP extensions
RUN docker-php-ext-install pdo pdo_pgsql mbstring exif pcntl bcmath gd

# Get latest Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www

# Copy application source code
COPY . .

# Copy Nginx and Supervisor configuration
COPY ./docker/nginx/conf.d/render.conf /etc/nginx/sites-available/default
RUN ln -s /etc/nginx/sites-available/default /etc/nginx/sites-enabled/default
RUN rm -f /etc/nginx/conf.d/default.conf

COPY supervisord.conf /etc/supervisor/conf.d/supervisord.conf

# Change ownership
RUN chown -R www-data:www-data /var/www
# Đảm bảo các thư mục cache, log có quyền ghi
RUN chmod -R 775 /var/www/var/cache /var/www/var/log

# Install Composer dependencies as www-data user
USER www-data
RUN composer install --no-interaction --no-dev --optimize-autoloader

# Chuyển về user root
USER root

# Expose port 80 for Nginx
EXPOSE 80

# Run supervisor to start Nginx and PHP-FPM
CMD ["/usr/bin/supervisord", "-c", "/etc/supervisor/conf.d/supervisord.conf"]
