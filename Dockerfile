FROM php:8.3-fpm

ENV COMPOSER_ALLOW_SUPERUSER=1

RUN apt-get update && apt-get install -y \
  git zip unzip curl libpq-dev libicu-dev libonig-dev libxml2-dev libzip-dev \
  && docker-php-ext-install pdo pdo_pgsql intl opcache zip

# Cài đặt Symfony CLI (tuỳ chọn – không cần nếu dùng --no-scripts)
RUN curl -sS https://get.symfony.com/cli/installer | bash && \
  mv /root/.symfony*/bin/symfony /usr/local/bin/symfony

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html
COPY . .

RUN composer install --optimize-autoloader

EXPOSE 8000
CMD ["php", "-S", "0.0.0.0:8000", "-t", "public"]
