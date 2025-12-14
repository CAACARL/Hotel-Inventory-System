# Icon Venue & Suites - Hotel Utility Inventory Management System

A professional web-based inventory management system built with Laravel and MariaDB for tracking and managing hotel utility supplies.

## Features

### Core Functionality
- **User Authentication & Role Management** (Admin/Staff roles)
- **Category Management** - Organize items by type (Linens, Cleaning Materials, Toiletries, etc.)
- **Item Management** - Track inventory with real-time stock levels
- **Transaction Logging** - Record all IN/OUT transactions with full audit trail
- **Low Stock Alerts** - Automated notifications for items below minimum stock
- **Reporting System** - Generate detailed reports on inventory status and activity
- **Responsive Design** - Works on desktop, tablet, and mobile devices

### User Roles & Permissions

#### Admin Users Can:
- Manage all inventory items and categories
- Add, edit, and delete items
- Manage user accounts and roles
- Generate comprehensive reports
- View all transaction history
- Configure system settings

#### Staff Users Can:
- Borrow items from inventory
- Return borrowed items
- View item availability
- Update item status (available, in use, damaged, disposed)
- View their own transaction history

## Technology Stack

- **Backend**: Laravel 11 (PHP Framework)
- **Database**: MariaDB/MySQL
- **Frontend**: Blade Templates with Tailwind CSS
- **Authentication**: Laravel Breeze
- **Architecture**: MVC Pattern with Eloquent ORM

## Installation

### Prerequisites
- PHP 8.2 or higher
- Composer
- Node.js & NPM
- MariaDB or MySQL
- Web server (Apache/Nginx) or use Laravel's built-in server

### Quick Setup

1. **Clone or extract the project**
   ```bash
   cd hotel-inventory-system
   ```

2. **Run the installation script**
   ```bash
   install.bat
   ```
   
   Or manually:

3. **Install PHP dependencies**
   ```bash
   composer install
   ```

4. **Install Node dependencies and build assets**
   ```bash
   npm install
   npm run build
   ```

5. **Configure environment**
   - Copy `.env.example` to `.env` (if not already done)
   - Update database credentials in `.env`:
   ```
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=hotel_inventory
   DB_USERNAME=root
   DB_PASSWORD=your_password
   ```

6. **Create database**
   ```sql
   CREATE DATABASE hotel_inventory;
   ```

7. **Generate application key**
   ```bash
   php artisan key:generate
   ```

8. **Run migrations and seed data**
   ```bash
   php artisan migrate
   php artisan db:seed
   ```

9. **Start the development server**
   ```bash
   php artisan serve
   ```

10. **Access the application**
    - Open http://localhost:8000 in your browser

## Default Login Credentials

### Admin Account
- **Email**: admin@iconvenue.com
- **Password**: password
- **Role**: Administrator

### Staff Account
- **Email**: staff@iconvenue.com
- **Password**: password
- **Role**: Staff

## System Overview

### Database Schema

#### Users Table
- User authentication and role management
- Supports Admin and Staff roles
- Department assignment for organizational structure

#### Categories Table
- Item categorization (Linens, Cleaning Materials, Toiletries, etc.)
- Active/inactive status management

#### Items Table
- Complete item information with stock tracking
- Minimum stock level configuration
- Status tracking (available, in use, damaged, disposed)
- Unit pricing and location tracking

#### Transactions Table
- Complete audit trail of all inventory movements
- IN transactions: deliveries, returns, recoveries
- OUT transactions: issues, borrowings, disposals
- Reference numbers and detailed notes

### Key Features Explained

#### Inventory Tracking
- Real-time stock level updates
- Automatic low stock detection
- Multi-unit support (pieces, sets, bottles, etc.)

#### Transaction Management
- Comprehensive logging of all inventory movements
- User attribution for accountability
- Transaction type categorization
- Reference number tracking for external documentation

#### Reporting & Analytics
- Stock status reports
- Transaction history reports
- Low stock alerts
- User activity tracking

#### Security Features
- Role-based access control
- Secure authentication with Laravel Breeze
- CSRF protection
- Input validation and sanitization

## Usage Guide

### For Administrators

1. **Managing Categories**
   - Navigate to Categories → Add New Category
   - Organize items by type for better inventory management

2. **Managing Items**
   - Add new items with complete details
   - Set minimum stock levels for automatic alerts
   - Track item locations and pricing

3. **User Management**
   - Create staff accounts with appropriate departments
   - Manage user roles and permissions

4. **Generating Reports**
   - Access comprehensive inventory reports
   - Monitor transaction history
   - Track low stock items

### For Staff Users

1. **Borrowing Items**
   - Browse available items
   - Submit borrow requests with quantity needed
   - Add notes for tracking purposes

2. **Returning Items**
   - Process returns with condition updates
   - Update item status if damaged or disposed

3. **Viewing Inventory**
   - Check item availability
   - View transaction history
   - Monitor personal borrowing records

## Customization

### Adding New Item Categories
1. Navigate to Categories in the admin panel
2. Click "Add New Category"
3. Provide name and description
4. Set active status

### Configuring Stock Alerts
- Set minimum stock levels for each item
- System automatically highlights low stock items
- Dashboard displays low stock alerts

### User Departments
- Customize department names in user management
- Track inventory usage by department
- Generate department-specific reports

## Maintenance

### Regular Tasks
- Monitor low stock alerts
- Review transaction logs
- Update user permissions as needed
- Backup database regularly

### Database Maintenance
```bash
# Create database backup
mysqldump -u root -p hotel_inventory > backup.sql

# Restore from backup
mysql -u root -p hotel_inventory < backup.sql
```

## Support & Documentation

### File Structure
```
hotel-inventory-system/
├── app/
│   ├── Http/Controllers/    # Application controllers
│   ├── Models/             # Eloquent models
│   └── Middleware/         # Custom middleware
├── database/
│   ├── migrations/         # Database schema
│   └── seeders/           # Sample data
├── resources/
│   ├── views/             # Blade templates
│   └── css/               # Stylesheets
└── routes/
    └── web.php            # Application routes
```

### Key Models
- **User**: Authentication and role management
- **Category**: Item categorization
- **Item**: Inventory items with stock tracking
- **Transaction**: Audit trail for all inventory movements

## License

This project is developed specifically for Icon Venue & Suites hotel inventory management needs.

## Version

Version 1.0 - Initial Release
- Complete inventory management system
- User role management
- Transaction tracking
- Reporting capabilities
- Responsive web interface