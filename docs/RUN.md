# Hướng dẫn chạy Database

## 🚀 Khởi động Database

```bash
docker-compose up -d
```

## 🛑 Dừng Database

```bash
docker-compose down
```

## 📊 Thông tin Database

- **Database**: `ueh_final`
- **Username**: `postgres`
- **Password**: `1234`
- **Port**: `5432`

## 🔗 DATABASE_URL cho Symfony

```
DATABASE_URL="pgsql://postgres:1234@localhost:5432/ueh_final?serverVersion=16&charset=utf8"
```

## 📝 Các lệnh Symfony cần thiết

### Tạo database:
```bash
php bin/console doctrine:database:create
```

### Chạy migrations:
```bash
php bin/console doctrine:migrations:migrate
```

### Load dữ liệu mẫu:
```bash
php bin/console doctrine:fixtures:load
```

## 🔍 Kiểm tra trạng thái

```bash
docker-compose ps
```

## 📋 Xem logs

```bash
docker-compose logs
``` 