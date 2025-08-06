# Symfony Final Project

## 📄 Introduction

This API system is built with **Symfony 8** and **API Platform**, providing full CRUD capabilities for entities such as **Product**, **Order**, **Customer**, **Coupon**, **Staff**, and more.

Visit my api here: [https://symfony-final.onrender.com/api/docs](https://symfony-final.onrender.com/api/docs)

---

## ⚙️ Setup & Deployment

### Requirements

* **PHP 8.3** with **Composer**
* **Docker** & **Docker Compose**
* **PostgreSQL** (or any database you prefer)
* **Symfony CLI** (optional)

### Using Docker

```bash
# Build and start the containers
docker-compose up -d --build

# Enter the PHP container
docker exec -it <container_name> bash

# Install PHP dependencies
composer install

# Create the database and run migrations
php bin/console doctrine:migrations:migrate

# Start the Symfony server
php -S 0.0.0.0:8000 -t public
```

### Local Setup (without Docker)

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

**Explanation:**

* Starts from the **PHP 8.3‑FPM** base image.
* Allows Composer to run as root inside the container.
* Installs all required OS packages and PHP extensions for Symfony.
* Installs the **Symfony CLI** for local tooling.
* Copies the Composer binary from the official `composer:2` image.
* Copies the project source code and installs PHP dependencies.
* Exposes port **8000** and launches the built‑in PHP server.

---

## 📃 API Usage

* **Swagger UI (local):** `http://localhost:8000/api/docs`
* **Swagger UI (production):** `https://symfony-final.onrender.com/api/docs`
* Basic CRUD endpoints for **Product**, **Order**, **Customer**, **Staff**, **Coupon**.
* Built‑in **filtering, pagination, serialization groups, and validation**.
* **File upload:** `POST /api/uploaded_files`
* **Authentication:** JSON Web Tokens (`/auth/login`, `/auth/register`).
* **Asynchronous email** handling via **Symfony Messenger**.

---

## 📊 Technologies Used

| Layer           | Technology                                    |
| --------------- | --------------------------------------------- |
| Framework       | Symfony 8                                     |
| API Scaffolding | API Platform (REST & OpenAPI docs)            |
| ORM             | Doctrine ORM + Migrations                     |
| Database        | PostgreSQL (default) / SQLite for development |
| Authentication  | LexikJWTAuthenticationBundle                  |
| File Upload     | VichUploaderBundle                            |
| Testing         | PHPUnit, `symfony/test-pack`                  |
| Async Tasks     | Messenger + queue                             |
| Deployment      | Docker + PHP built‑in server                  |
| Documentation   | Swagger / OpenAPI via API Platform            |

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

## 🚀 Development Workflow

```bash
# Create a new entity
php bin/console make:entity

# Generate a migration
php bin/console make:migration
php bin/console doctrine:migrations:migrate

# Expose the entity as an API resource (using #[ApiResource])
# Add custom validators, controllers, serialization groups, etc.

# Run the test suite
php bin/phpunit
```

---

## 🔧 Notes

* The **Symfony CLI** is optional but convenient for local development.
* The project follows **PSR‑4** autoloading; configuration lives in `.env` files for local, development, and test environments.
* **Faker fixtures** are included for sample data.
* If you encounter a "Database not found" error:

  ```bash
  php bin/console doctrine:database:create
  php bin/console doctrine:migrations:migrate
  ```
