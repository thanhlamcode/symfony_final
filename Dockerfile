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

# --- PHẦN CẤU HÌNH ĐÃ SỬA ---
# Copy Nginx and Supervisor configuration
COPY ./docker/nginx/conf.d/render.conf /etc/nginx/sites-available/default

# SỬA LỖI "File exists": Thêm cờ "-f" (force) để ghi đè lên file cấu hình mặc định cũ
RUN ln -sf /etc/nginx/sites-available/default /etc/nginx/sites-enabled/default

# Xóa thêm một file cấu hình mặc định khác cho chắc chắn
RUN rm -f /etc/nginx/conf.d/default.conf

# Copy file cấu hình của Supervisor
COPY supervisord.conf /etc/supervisor/conf.d/supervisord.conf
# --- KẾT THÚC PHẦN SỬA ---

# Change ownership
RUN chown -R www-data:www-data /var/www
# Đảm bảo các thư mục cache, log có quyền ghi (quan trọng cho Symfony)
RUN mkdir -p /var/www/var/cache /var/www/var/log && chmod -R 775 /var/www/var

# Install Composer dependencies as www-data user
USER www-data
RUN composer install --no-interaction --no-dev --optimize-autoloader

# Chuyển về user root
USER root

# Expose port 80 for Nginx
EXPOSE 80

# Run supervisor to start Nginx and PHP-FPM
CMD ["/usr/bin/supervisord", "-c", "/etc/supervisor/conf.d/supervisord.conf"]
