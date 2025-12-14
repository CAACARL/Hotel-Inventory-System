@echo off
echo Setting up Icon Venue & Suites Inventory Management System...
echo.

echo Step 1: Installing dependencies...
call composer install
echo.

echo Step 2: Generating application key...
call php artisan key:generate
echo.

echo Step 3: Creating database (make sure MariaDB/MySQL is running)...
echo Please create a database named 'hotel_inventory' in your MariaDB/MySQL server
pause

echo Step 4: Running migrations...
call php artisan migrate
echo.

echo Step 5: Seeding database with sample data...
call php artisan db:seed
echo.

echo Step 6: Building assets...
call npm install
call npm run build
echo.

echo Installation complete!
echo.
echo Default login credentials:
echo Admin: admin@iconvenue.com / password
echo Staff: staff@iconvenue.com / password
echo.
echo To start the development server, run: php artisan serve
pause