# Symfony Final Project

## 📄 Giới thiệu / Introduction

Hệ thống API xây dựng bằng Symfony 8 + API Platform, hỗ trợ chức năng CRUD cho các entity như Product, Order, Customer, Coupon, Staff, ...

This API system is built using Symfony 8 + API Platform, supporting CRUD operations for entities such as Product, Order, Customer, Coupon, Staff, and more.

---

## ⚙️ Cài đặt & Triển khai / Setup & Deployment

### Yêu cầu / Requirements

- PHP 8.3 + Composer
- Docker & Docker Compose
- PostgreSQL (hoặc DB khác tùy chọn)
- Symfony CLI (tùy chọn)

### Dùng Docker

```bash
# Xây dựng và chạy container
docker-compose up -d --build

# Truy cập container
docker exec -it <container_name> bash

# Cài package PHP
composer install

# Tạo DB + migrate
php bin/console doctrine:migrations:migrate

# Chạy server Symfony
php -S 0.0.0.0:8000 -t public
```

### Dùng local (không Docker)

```bash
git clone https://github.com/thanhlamcode/symfony_final.git
cd symfony_final
composer install
php bin/console doctrine:migrations:migrate
symfony serve
```

---

## 🛠️ Dockerfile Breakdown

```Dockerfile
FROM php:8.3-fpm

ENV COMPOSER_ALLOW_SUPERUSER=1

RUN apt-get update && apt-get install -y \
    git zip unzip curl libpq-dev libicu-dev libonig-dev libxml2-dev libzip-dev \
    && docker-php-ext-install pdo pdo_pgsql intl opcache zip

RUN curl -sS https://get.symfony.com/cli/installer | bash && \
    mv /root/.symfony*/bin/symfony /usr/local/bin/symfony

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html
COPY . .

RUN composer install --optimize-autoloader

EXPOSE 8000
CMD ["php", "-S", "0.0.0.0:8000", "-t", "public"]
```

Giải thích:
- Image gốc là PHP 8.3-FPM
- Cho phép composer chạy dưới quyền root
- Cài đặt các package và extension cần thiết cho Symfony
- Cài Symfony CLI
- Copy composer binary từ image composer:2
- Sao chép mã nguồn và cài package
- Chạy server PHP tại cổng 8000

---

## 📃 API Usage

- Swagger UI: `http://localhost:8000/api/docs`
- CRUD cơ bản cho các entity: Product, Order, Customer, Staff, Coupon
- Hỗ trợ: filtering, pagination, serialization groups, validation
- File upload: `POST /api/uploaded_files`
- Authentication: JWT (đã thiết lập route "/auth/login", "/auth/register")
- Mail async: Symfony Messenger

---

## 📊 Technologies Used

- **Framework**: Symfony 8
- **API Platform**: RESTful endpoint scaffolding
- **ORM**: Doctrine ORM + Migrations
- **Database**: PostgreSQL (mặc định), SQLite hỗ trợ dev
- **Authentication**: LexikJWTAuthenticationBundle
- **File Upload**: VichUploaderBundle
- **Testing**: PHPUnit, symfony/test-pack
- **Async**: Messenger + queue
- **Deployment**: Docker + PHP built-in server
- **Documentation**: Swagger / OpenAPI via API Platform

---

## 📁 Directory Structure (partial)

```bash
.
├── config/
├── docker/
├── public/
├── src/
│   ├── Controller/
│   ├── Entity/
│   └── Repository/
├── tests/
├── .env
├── composer.json
├── Dockerfile
└── README.md
```

---

## 🚀 Cách phát triển / Dev Workflow

```bash
# Tạo entity
php bin/console make:entity

# Tạo migration
php bin/console make:migration
php bin/console doctrine:migrations:migrate

# Tạo API resource (với attribute #[ApiResource])
# Tạo form validator, controller custom với #[ApiProperty], #[Groups], ...

# Tạo test
php bin/phpunit
```

---

## 🔧 Ghi chú khác / Notes

- Symfony CLI không bắt buộc, chệ hỗ trợ local dev.
- Dự án tuân theo PSR-4 autoload, .env config cho local/dev/test.
- Đã thiết lập Faker Fixtures demo dữ liệu.
- Nếu bị lỗi "DB not found": 
  ```bash
  php bin/console doctrine:database:create
  php bin/console doctrine:migrations:migrate
  
