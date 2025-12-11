# Wedding Backend - Docker Setup

## Quick Start

### Prerequisites
- Docker & Docker Compose installed
- Git

### Run the Application

1. **Clone and navigate to project:**
   ```bash
   git clone <repository-url>
   cd WeddingBE-generic
   ```

2. **Copy environment file:**
   ```bash
   cp .env.docker .env
   ```

3. **Build and start containers:**
   ```bash
   docker-compose up -d --build
   ```

4. **Initialize database manually:**
   ```bash
   # Run migrations
   docker-compose exec app php artisan migrate
   
   # Seed database (optional)
   docker-compose exec app php artisan db:seed
   ```

5. **Access the application:**
   - API: http://localhost:8080
   - phpMyAdmin: http://localhost:8081

### Services

- **App (Port 8080)**: Laravel application with Nginx
- **MySQL (Port 3306)**: Database server
- **Redis (Port 6379)**: Cache and session storage
- **phpMyAdmin (Port 8081)**: Database management interface

### Docker Commands

```bash
# Start services
docker-compose up -d

# Stop services
docker-compose down

# View logs
docker-compose logs -f app

# Run artisan commands
docker-compose exec app php artisan migrate
docker-compose exec app php artisan db:seed

# Access container bash
docker-compose exec app bash

# Rebuild containers
docker-compose up -d --build

# Remove volumes (fresh start)
docker-compose down -v
```

### Database Access

**Via Container:**
- Host: mysql (internal)
- Port: 3306
- Database: wedding_db
- Username: wedding_user
- Password: wedding_password

**Via Host:**
- Host: localhost
- Port: 3306
- Database: wedding_db
- Username: wedding_user
- Password: wedding_password

### API Testing

Test the API endpoints:
```bash
# Health check
curl http://localhost:8080/api

# Login
curl -X POST http://localhost:8080/api/login \
  -H "Content-Type: application/json" \
  -d '{"email":"admin@example.com","password":"password"}'

# Access protected route (with token)
curl -X GET http://localhost:8080/api/data-busana \
  -H "Authorization: Bearer YOUR_TOKEN_HERE"
```

### Environment Variables

Key environment variables in `.env`:

```env
APP_URL=http://localhost:8080
DB_HOST=mysql
REDIS_HOST=redis
CACHE_DRIVER=redis
SESSION_DRIVER=redis
```

### Troubleshooting

**Container won't start:**
```bash
# Check logs
docker-compose logs app

# Rebuild from scratch
docker-compose down -v
docker-compose build --no-cache
docker-compose up -d
```

**Permission issues:**
```bash
# Fix storage permissions
docker-compose exec app chown -R www-data:www-data storage bootstrap/cache
docker-compose exec app chmod -R 775 storage bootstrap/cache
```

**Database connection issues:**
```bash
# Check MySQL is running
docker-compose ps

# Reset database
docker-compose exec mysql mysql -u root -proot_password -e "DROP DATABASE wedding_db; CREATE DATABASE wedding_db;"
# Then manually run migrations again
docker-compose exec app php artisan migrate
docker-compose exec app php artisan db:seed
```

**Manual Database Management:**
```bash
# Run specific migration
docker-compose exec app php artisan migrate --step

# Check migration status
docker-compose exec app php artisan migrate:status

# Rollback migrations
docker-compose exec app php artisan migrate:rollback

# Fresh migration (drops all tables)
docker-compose exec app php artisan migrate:fresh
```