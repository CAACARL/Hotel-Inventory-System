# Installation Guide - Icon Venue & Suites Inventory Management System

## Prerequisites

Before installing the system, ensure you have the following installed:

1. **PHP 8.2 or higher**
2. **Composer** (PHP dependency manager)
3. **Node.js and NPM** (for frontend assets)
4. **MariaDB or MySQL** (database server)
5. **Web server** (Apache, Nginx, or use Laravel's built-in server)

## Step-by-Step Installation

### 1. Extract/Clone the Project
```bash
# If you have the project files, navigate to the directory
cd hotel-inventory-system
```

### 2. Install PHP Dependencies
```bash
composer install
```

### 3. Install Node Dependencies
```bash
npm install
```

### 4. Environment Configuration
```bash
# Copy the environment file
copy .env.example .env

# Generate application key
php artisan key:generate
```

### 5. Configure Database
Edit the `.env` file and update the database configuration:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=hotel_inventory
DB_USERNAME=root
DB_PASSWORD=your_mysql_password
```

### 6. Create Database
You can create the database in several ways:

#### Option A: Using MySQL Command Line
```sql
mysql -u root -p
CREATE DATABASE hotel_inventory CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
exit
```

#### Option B: Using phpMyAdmin
1. Open phpMyAdmin in your browser
2. Click "New" to create a new database
3. Enter "hotel_inventory" as the database name
4. Select "utf8mb4_unicode_ci" as collation
5. Click "Create"

#### Option C: Using the provided SQL file
```bash
mysql -u root -p < setup-database.sql
```

### 7. Run Database Migrations and Seeders
```bash
# Run migrations to create tables
php artisan migrate

# Seed the database with sample data
php artisan db:seed
```

### 8. Build Frontend Assets
```bash
npm run build
```

### 9. Start the Development Server
```bash
php artisan serve
```

The application will be available at: http://localhost:8000

## Default Login Credentials

### Administrator Account
- **Email**: admin@iconvenue.com
- **Password**: password
- **Role**: Admin (full access)

### Staff Account
- **Email**: staff@iconvenue.com
- **Password**: password
- **Role**: Staff (limited access)

## Production Deployment

### 1. Web Server Configuration

#### Apache (.htaccess)
The Laravel framework includes a `.htaccess` file in the `public` directory. Make sure your Apache server has the `mod_rewrite` module enabled.

#### Nginx
```nginx
server {
    listen 80;
    server_name your-domain.com;
    root /path/to/hotel-inventory-system/public;

    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-Content-Type-Options "nosniff";

    index index.php;

    charset utf-8;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }

    error_page 404 /index.php;

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.2-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }
}
```

### 2. Production Environment
Update your `.env` file for production:

```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://your-domain.com

# Use strong database credentials
DB_PASSWORD=strong_password_here

# Configure mail settings for notifications
MAIL_MAILER=smtp
MAIL_HOST=your-smtp-server
MAIL_PORT=587
MAIL_USERNAME=your-email
MAIL_PASSWORD=your-email-password
```

### 3. Optimize for Production
```bash
# Cache configuration
php artisan config:cache

# Cache routes
php artisan route:cache

# Cache views
php artisan view:cache

# Optimize autoloader
composer install --optimize-autoloader --no-dev
```

### 4. Set Proper Permissions
```bash
# Set ownership (replace www-data with your web server user)
sudo chown -R www-data:www-data /path/to/hotel-inventory-system

# Set permissions
sudo chmod -R 755 /path/to/hotel-inventory-system
sudo chmod -R 775 /path/to/hotel-inventory-system/storage
sudo chmod -R 775 /path/to/hotel-inventory-system/bootstrap/cache
```

## Troubleshooting

### Common Issues

#### 1. Database Connection Error
- Verify database credentials in `.env`
- Ensure MySQL/MariaDB service is running
- Check if the database exists

#### 2. Permission Errors
```bash
# Fix storage permissions
sudo chmod -R 775 storage/
sudo chmod -R 775 bootstrap/cache/
```

#### 3. Composer Dependencies
```bash
# Clear composer cache and reinstall
composer clear-cache
composer install
```

#### 4. NPM Build Issues
```bash
# Clear npm cache and reinstall
npm cache clean --force
rm -rf node_modules
npm install
npm run build
```

#### 5. Application Key Missing
```bash
php artisan key:generate
```

### Log Files
Check Laravel logs for detailed error information:
- `storage/logs/laravel.log`

## System Requirements

### Minimum Requirements
- PHP 8.2+
- MySQL 5.7+ or MariaDB 10.3+
- 512MB RAM
- 100MB disk space

### Recommended Requirements
- PHP 8.3+
- MySQL 8.0+ or MariaDB 10.6+
- 1GB RAM
- 500MB disk space
- SSL certificate for production

## Security Considerations

1. **Change Default Passwords**: Update all default login credentials
2. **Use HTTPS**: Enable SSL/TLS in production
3. **Regular Updates**: Keep Laravel and dependencies updated
4. **Backup Strategy**: Implement regular database backups
5. **Access Control**: Limit database access to application only

## Backup and Maintenance

### Database Backup
```bash
# Create backup
mysqldump -u root -p hotel_inventory > backup_$(date +%Y%m%d_%H%M%S).sql

# Restore backup
mysql -u root -p hotel_inventory < backup_file.sql
```

### Application Updates
```bash
# Pull latest changes (if using version control)
git pull origin main

# Update dependencies
composer install --no-dev
npm install
npm run build

# Run any new migrations
php artisan migrate

# Clear caches
php artisan cache:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

## Support

For technical support or questions about the Icon Venue & Suites Inventory Management System, please refer to:

1. **Documentation**: README.md file
2. **Laravel Documentation**: https://laravel.com/docs
3. **System Logs**: Check `storage/logs/laravel.log` for errors

## Version Information

- **Laravel Version**: 11.x
- **PHP Version**: 8.2+
- **Database**: MySQL/MariaDB
- **Frontend**: Blade Templates with Tailwind CSS