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
  supervisor \
  sqlite3 # Thêm sqlite3 để hỗ trợ DATABASE_URL giả

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Cấu hình PHP-FPM để lắng nghe trên cổng TCP thay vì socket.
RUN sed -i 's|listen = /var/run/php-fpm.sock|listen = 9000|g' /usr/local/etc/php-fpm.d/www.conf

# Install PHP extensions
# Thêm pdo_sqlite để hỗ trợ DATABASE_URL giả
RUN docker-php-ext-install pdo pdo_pgsql mbstring exif pcntl bcmath gd pdo_sqlite

# Get latest Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www

# Copy application source code
COPY . .

# Copy Nginx and Supervisor configuration
COPY ./docker/nginx/conf.d/render.conf /etc/nginx/sites-available/default
# Ghi đè lên file cấu hình mặc định cũ để tránh lỗi "File exists"
RUN ln -sf /etc/nginx/sites-available/default /etc/nginx/sites-enabled/default
RUN rm -f /etc/nginx/conf.d/default.conf
COPY supervisord.conf /etc/supervisor/conf.d/supervisord.conf

# Change ownership
RUN chown -R www-data:www-data /var/www
# Đảm bảo các thư mục cache, log có quyền ghi (quan trọng cho Symfony)
RUN mkdir -p /var/www/var && chmod -R 775 /var/www/var

# Chuyển sang user www-data
USER www-data

# SỬA LỖI QUAN TRỌNG: Cung cấp DATABASE_URL giả để composer không cần kết nối DB thật
RUN DATABASE_URL="sqlite:///%kernel.project_dir%/var/data.db" composer install --no-interaction --no-dev --optimize-autoloader

# Chuyển về user root
USER root

# Expose port 80 for Nginx
EXPOSE 80

# Run supervisor to start Nginx and PHP-FPM
CMD ["/usr/bin/supervisord", "-c", "/etc/supervisor/conf.d/supervisord.conf"]
