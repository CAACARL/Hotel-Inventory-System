# Icon Venue & Suites — Inventory Management System

A web-based inventory management system built for Icon Venue & Suites to track stock, manage item borrowing, monitor batch expiry, and maintain a full audit trail of all inventory movements.

---

## Tech Stack

| Layer | Technology |
|-------|-----------|
| Backend | Laravel 12 (PHP 8.2) |
| Frontend | Blade templates, Tailwind CSS, Alpine.js |
| Database | SQLite (default), MySQL/PostgreSQL compatible |
| Email | SMTP via Laravel Mail |
| Build | Vite |

---

## Roles

| Role | Description |
|------|-------------|
| Admin | Full access to all features |
| Staff | Can browse items, borrow, return, and view their own transactions |

Users cannot self-register. All accounts are created by an admin.

---

## Authentication

- **Login** — `/login` with email and password. Rate-limited to 5 attempts per minute. Failed attempts are logged.
- **Two-Factor Authentication** — Optional per-user. A one-time code is sent via email on login. Trusted devices can skip 2FA for 30 days.
- **Account creation** — Admin-only. A welcome email with credentials is automatically sent to the new user.
- **Password reset** — Via "Forgot password?" on the login page. Requires SMTP.
- **Logout** — Invalidates the session and redirects to login.

---

## Features

### Dashboard
- Stat cards: total items, low stock count, active borrows, total inventory value
- Recent activity feed (latest transactions)
- Low stock alerts (items at or below minimum threshold)
- Currently borrowed items summary

### Categories
Hierarchical — parent categories can have child categories (e.g., `Office Supplies > Stationery`). Items are assigned to the most specific level.

- Admin-only management (create, edit, archive)
- Archive is blocked if the category has items or subcategories
- Archived categories are hidden from all dropdowns and item assignment
- Archived categories can be restored from `/categories/archived`

### Items
Core entity of the system. Each item has:
- Name, description, location
- Category (hierarchical), department (optional)
- Item type: `consumable` or `non-consumable`
- Status: `available`, `in_use`, `disposed`, `spoiled`
- Minimum stock threshold — triggers low stock alerts
- Optional image (thumbnail in lists, expandable lightbox)

Items start with zero quantity. Stock is added through batches.

**Archive** — Admins can archive items. Archiving is blocked if the item has stock remaining or active borrows. Archived items are hidden from inventory but their transaction history is preserved. Restorable from `/items/archived`.

**Dispose** — Admin-only. Reduces item quantity and records a disposal transaction. If quantity reaches zero, item status is set to `disposed`.

### Batches
Represent a stock replenishment event. Each batch records:
- Quantity, unit cost, supplier, lot number
- Manufacture and expiry dates (consumables)
- Depreciation settings: method (straight-line or declining balance), useful life, salvage value, depreciation rate (non-consumables)
- Notes

On batch creation:
- Item quantity is incremented
- A replenish transaction is logged
- All other admins are notified

For consumable batches with an expiry date, the system automatically marks the batch as expired and deducts the quantity when the expiry date passes. If item quantity reaches zero, it is marked as `spoiled`.

Depreciation is tracked at the batch level. Book value is calculated on-the-fly using the configured method and purchase date.

### Transactions
Every inventory movement is recorded:

| Type | Description |
|------|-------------|
| replenish | Stock added via a batch |
| borrow | Item borrowed by a user |
| return | Borrowed item returned |
| disposal | Stock written off |
| spoiled | Consumable stock expired |

Each transaction stores: item, user, quantity, type, reference number, date, and notes. Transactions referencing archived items are still visible in history.

### Borrow & Return
Staff and admins can borrow available items from the items list.

On borrow:
- Item quantity decremented
- BorrowedItem record created
- Borrow transaction logged
- Admins notified

On return:
- Item quantity restored
- BorrowedItem record updated or removed
- Return transaction logged
- Admins notified

Admins see all borrowed items at `/borrowed-items`. Staff see only their own.

### Departments
Admins can create, edit, and activate/deactivate departments. Inactive departments are hidden from all assignment dropdowns but their data and item assignments are preserved.

Departments with assigned items cannot be deleted.

### Users (Admin only)
Admins can create, edit, and activate/deactivate user accounts. A welcome email with credentials is sent on creation. Deactivated users cannot log in. Admins cannot deactivate their own account.

### Reports & Exports (Admin only)
The reports page provides transaction analytics with charts, filterable by date range. Four CSV exports are available:

| Export | Contents |
|--------|----------|
| Transactions | Full transaction history with item, type, quantity, staff, reference |
| Inventory | All items with stock, status, location, unit price, total value |
| Borrowed Items | Active borrows with borrower, department, days out, overdue status |
| Comprehensive Report | Executive summary + stock analysis + top borrowed items + all of the above |

### Notifications
Bell icon in the header with live unread count.

**Admins receive:**
- New borrow / item returned
- Low stock (once per day per item)
- New batch created
- Batch expiring soon (within 30 days, once per day)
- Expired batch (once per day)

**Staff receive:**
- Daily reminder of items they currently have borrowed

---

## UI

- Fully responsive — mobile and desktop
- Collapsible sidebar with persistent state
- Universal header: page search, notification bell, appearance settings, profile dropdown
- Image lightbox — click any item image to expand full screen
- Page transition loader animation
- Search modals on all list pages with relevant filters per page

---

## Installation

```bash
composer install
npm install
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
php artisan storage:link
npm run build
php artisan serve
```

On Windows, run `install.bat`.

Configure SMTP settings in `.env` for email features.

---

## Default Credentials

| Role | Email | Password |
|------|-------|----------|
| Admin | admin@iconvenue.com | password |
| Staff | staff@iconvenue.com | password |

---

## Scheduled Commands

| Command | Description |
|---------|-------------|
| `check:expired-consumables` | Marks expired consumable batches and deducts stock |
| `depreciation:update` | Recalculates depreciation for all active non-consumable batches |
| `update:category-hierarchy` | Rebuilds category path and level cache |

---

## Key File Structure

```
app/
  Http/Controllers/
    Auth/                         — login, 2FA, password reset
    ItemController.php            — items, borrow, return, disposal, archive
    BatchController.php           — batch management
    CategoryController.php        — category management, archive
    DepartmentController.php      — department management, toggle active
    TransactionController.php     — history, reports
    UserController.php            — user management, toggle active
    NotificationController.php    — mark notifications as read
    TransactionExportController.php — CSV exports
  Models/
    User.php                      — auth, roles, 2FA, avatar
    Item.php                      — inventory item, soft deletes
    Batch.php                     — batch, expiry, depreciation logic
    Category.php                  — hierarchical categories, soft deletes
    BorrowedItem.php              — active borrows tracker
    Transaction.php               — transaction history
    Notification.php              — in-app notifications
  Mail/
    WelcomeUser.php               — welcome email on account creation
    TwoFactorCode.php             — 2FA code email
  Providers/
    AppServiceProvider.php        — notification view composer

resources/views/
  layouts/                        — app and guest layouts
  auth/                           — login, 2FA, password reset
  emails/                         — email templates
  items/                          — item list, show, borrow, return, archived
  batches/                        — batch list, show, replenish modal
  categories/                     — category tree, archived
  departments/                    — department tiles
  transactions/                   — transaction list, show, reports
  users/                          — user cards
  dashboard/                      — dashboard partials

database/
  migrations/                     — all schema migrations
  seeders/
    AdminSeeder.php               — default admin account
    DatabaseSeeder.php            — runs all seeders
```
