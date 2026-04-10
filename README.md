# Icon Venue & Suites — Inventory Management System

A web-based inventory management system built for Icon Venue & Suites to track stock, manage borrowing, and monitor item lifecycle.

---

## Tech Stack

- **Backend:** Laravel 11 (PHP)
- **Frontend:** Blade templates, Tailwind CSS, Alpine.js
- **Database:** SQLite (default), compatible with MySQL/PostgreSQL

---

## Roles

| Role | Access |
|------|--------|
| **Admin** | Full access — manage items, categories, batches, users, departments, transactions, reports |
| **Staff** | Browse items, borrow and return items, view own transactions and borrowed items |

---

## Authentication

Users cannot self-register. Accounts are created by an admin through the Users management page.

**Login flow:**
1. User goes to `/login` and enters email and password
2. On success, redirected to the dashboard
3. On failure, shown an error message

**Password reset:**
- User clicks "Forgot password" on the login page
- Enters their email address
- Receives a reset link via email
- Sets a new password via the link

**Session:**
- Sessions are invalidated on logout
- Inactive users (is_active = false) cannot log in

---

## Installation

```bash
# 1. Clone and install dependencies
composer install
npm install

# 2. Copy environment file
cp .env.example .env

# 3. Generate app key
php artisan key:generate

# 4. Run migrations and seeders
php artisan migrate --seed

# 5. Create storage symlink
php artisan storage:link

# 6. Build assets
npm run build

# 7. Serve
php artisan serve
```

On Windows, run `install.bat` instead.

---

## Default Credentials

Seeded automatically on `php artisan migrate --seed`:

| Role | Email | Password |
|------|-------|----------|
| Admin | admin@iconvenue.com | password |
| Staff | staff@iconvenue.com | password |

Additional sample users are also seeded (John Manager, Sarah Johnson, Mike Wilson, Lisa Brown).

---

## Features

### Dashboard
- Stats: total items, low stock count, active borrows, total inventory value
- Recent activity feed
- Low stock and expiring batch alerts

### Categories
- Hierarchical structure (parent → child)
- Admin-only management
- Items are assigned to the most specific category level

### Items
- Admin creates and manages items
- Item types: **consumable** (e.g., supplies) or **non-consumable** (e.g., equipment)
- Status: available, in use, damaged, disposed, spoiled
- Optional image upload — shown as thumbnail in lists, expandable via lightbox
- Minimum stock threshold with low stock warnings
- Depreciation tracking for non-consumables (straight-line or declining balance)
- Assigned to categories and optionally to departments

### Batches
- Stock is added to items through batches
- Tracks: quantity, unit cost, supplier, lot number, manufacture/expiry dates
- Consumable batches with expiry dates are auto-monitored — item marked spoiled when expired
- Non-consumable batches support depreciation configuration

### Transactions
- Every inventory movement is recorded: delivery, borrow, return, replenish, disposal, recovery
- Running stock level shown per transaction
- Admin can export to CSV with optional date range filter

### Borrow & Return
- Staff borrows available items from the items page
- Staff returns items from the items page or borrowed items page
- Admin sees all borrowed items at `/borrowed-items`
- Staff sees only their own borrowed items at `/borrowed-items`
- Reference numbers auto-generated per transaction

### Reports (Admin only)
- Transaction analytics with charts
- Filter by date range, type, item, user
- CSV export

### Departments (Admin only)
- Manage departments
- Items can be assigned to departments

### Users (Admin only)
- Create, edit, deactivate users
- Assign roles (admin or staff)
- Deactivated users cannot log in

### Notifications
- Bell icon in header with unread count badge
- Opens as a dropdown, marks all as read on open
- **Admin receives:**
  - New borrow (from other users)
  - Item returned (from other users)
  - Low stock alert — once per day per item
  - New batch created (from other admins)
  - Expiring batches within 30 days — once per day
  - Expired batches — once per day
- **Staff receives:**
  - Daily reminder of currently borrowed items

### UI
- Responsive — works on mobile and desktop
- Collapsible sidebar (state saved across page loads)
- Universal header: page search, notifications, appearance settings, profile dropdown
- Dark mode, compact/comfortable density, animation toggle
- Image lightbox on item images
- Page transition loader

---

## Key File Structure

```
app/
  Http/Controllers/
    Auth/                         — login, logout, password reset
    ItemController.php            — items, borrow, return, disposal
    BatchController.php           — batch management
    TransactionController.php     — history & reports
    NotificationController.php    — mark as read
  Models/
    User.php                      — auth, roles, avatar
    Item.php                      — item + depreciation logic
    Batch.php                     — batch + expiry logic
    BorrowedItem.php              — active borrows tracker
    Transaction.php               — transaction history
    Notification.php              — in-app notifications
  Providers/
    AppServiceProvider.php        — notification view composer

resources/views/
  layouts/
    app.blade.php                 — main layout
    partials/
      header.blade.php            — universal header
      sidebar.blade.php           — navigation
      footer.blade.php            — universal footer
  auth/                           — login, register, reset, 2FA views
  items/                          — item views and partials
  batches/                        — batch views
  transactions/                   — transaction views
  dashboard/                      — dashboard partials
```

---

## Scheduled Commands

| Command | Description |
|---------|-------------|
| `check:expired-consumables` | Marks expired consumable batches and updates item status |
| `update:depreciation` | Recalculates depreciation for all eligible items |
| `update:category-hierarchy` | Rebuilds category path and level cache |
