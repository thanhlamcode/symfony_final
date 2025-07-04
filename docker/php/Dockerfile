FROM php:8.3-fpm

RUN apt-get update && apt-get install -y \
  git zip unzip curl libpq-dev libicu-dev libonig-dev libxml2-dev libzip-dev \
  && docker-php-ext-install pdo pdo_pgsql intl opcache zip

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html
