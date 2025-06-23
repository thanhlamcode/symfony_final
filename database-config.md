# Database Configuration

## PostgreSQL Database Credentials

### Database Connection Details:
- **Host**: localhost
- **Port**: 5432
- **Database**: symfony_final
- **Username**: postgres
- **Password**: 1234

### DATABASE_URL for Symfony:
```
DATABASE_URL="pgsql://postgres:1234@localhost:5432/ueh_final?serverVersion=16&charset=utf8"
```


### Stop Database:
```bash
docker-compose down
```

### View Logs:
```bash
docker-compose logs postgres
```

### Reset Database:
```bash
docker-compose down -v
docker-compose up -d postgres pgadmin
```

## Symfony Commands

### Create Database:
```bash
php bin/console doctrine:database:create
```

### Run Migrations:
```bash
php bin/console doctrine:migrations:migrate
```

### Load Fixtures:
```bash
php bin/console doctrine:fixtures:load
``` 
