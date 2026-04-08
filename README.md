# Icon Venue & Suites — Inventory Management System

A web-based inventory management system developed as a capstone project for **Icon Venue & Suites**, a hotel property. The system was built to replace manual inventory tracking with a centralized, role-based digital solution that handles item management, stock replenishment, borrowing workflows, depreciation tracking, and consumable expiry automation.

---

## Why This System Was Built

Hotel inventory management is traditionally done through spreadsheets or paper logs, which leads to:
- Lost or untracked borrowed items
- No visibility into low stock until it's too late
- No audit trail for who took what and when
- Expired consumables going unnoticed and affecting operations
- No way to track the depreciation of non-consumable assets

This system solves all of the above by providing a structured, role-based platform that automates key processes and gives management real-time visibility into inventory health.

---

## Tech Stack

- **Backend:** Laravel 11 (PHP)
- **Frontend:** Blade templates, Tailwind CSS (CDN), Alpine.js (CDN)
- **Database:** MySQL
- **Mail:** Gmail SMTP (for 2FA codes)
- **Timezone:** Asia/Manila

---

## Requirements

- PHP >= 8.2
- Composer
- MySQL
- Node.js & npm
- XAMPP (or any local server stack)

---

## Installation

```bash
# 1. Clone the repo and install dependencies
composer install
npm install

# 2. Copy environment file
cp .env.example .env

# 3. Generate app key
php artisan key:generate

# 4. Configure your .env
DB_DATABASE=hotel_inventory
DB_USERNAME=root
DB_PASSWORD=

# 5. Run migrations and seeders
php artisan migrate --seed

# 6. Link storage for profile pictures
php artisan storage:link

# 7. Build assets
npm run build

# 8. Serve
php artisan serve
```

To seed only the admin account:
```bash
php artisan db:seed --class=AdminSeeder
```

---

## User Roles

The system has two roles with different levels of access, reflecting the real-world hierarchy of hotel operations.

| Role  | Access |
|-------|--------|
| Admin | Full access — manage items, categories, departments, users, batches, reports, transactions |
| Staff | View items, borrow/return items, edit own profile |

Staff cannot access transaction history, reports, or any management pages. This is intentional — staff only need to borrow and return items, not manage the system.

Default admin credentials (from seeder):
- Email: `admin@iconvenue.com`
- Password: `password`

---

## Features & Why Each Exists

### Authentication & Security
- **Email + password login** — standard secure access
- **Two-factor authentication (2FA) via email** — adds a second layer of security for hotel staff accounts, preventing unauthorized access if a password is compromised
- **Trusted device support** — once a device passes 2FA, it can be trusted so staff don't have to enter a code every single login from the same device
- **Password reset via email** — self-service recovery without needing admin intervention
- **Rate limiting on login attempts** — prevents brute force attacks, shows a 429 error page after too many failed attempts
- **Login failure logging** — tracks failed login attempts for security auditing

### Dashboard
- **Overview stats** — total items, low stock count, borrowed items count, total inventory value (including both depreciated non-consumable assets and active consumable batch values)
- **Expiring soon / expired batch alerts** — gives management early warning before consumables expire
- **Recent transaction activity** — quick view of the latest inventory movements (admin only)
- **Quick actions panel** — shortcuts to the most common tasks

The dashboard exists so management can see the health of the entire inventory at a glance without navigating through multiple pages.

### Items (`/items`)
- **Full item list** with search and filters by category, department, status, and low stock
- **Item types: Consumable vs Non-Consumable** — consumables (soap, cleaning supplies, food) are tracked differently from non-consumables (furniture, equipment) because they expire and depreciate differently
- **Statuses: Available, In Use, Damaged, Disposed, Spoiled** — reflects the real-world condition of each item
- **Borrow and return workflow** — staff can borrow items and return them, creating a full audit trail
- **Admin: create, edit, delete items** — full CRUD management
- **Admin: view transaction history per item** — see every movement of a specific item
- **Admin: export item transactions to CSV with date range filter** — for reporting and auditing

### Categories (`/categories`)
- **Hierarchical category tree** (parent → child) — allows organizing items into groups like "Cleaning Materials > Disinfectants" for better structure
- **Inline subcategory creation** — add subcategories directly from the parent card without navigating away
- **Admin only** — staff don't need to manage categories

Categories exist because a hotel has many different types of inventory across departments. Without categories, finding items becomes difficult at scale.

### Departments (`/departments`)
- **Manage hotel departments** (Housekeeping, Front Desk, Kitchen, Maintenance, etc.)
- **Items can be assigned to departments** — so each department knows what belongs to them
- **Admin only**

Departments allow filtering inventory by area of the hotel, making it easier to track which department is responsible for which items.

### Batch Management (`/batches`)
- **Replenish stock by creating batches** — every time new stock arrives, a batch is created with quantity, unit cost, supplier, lot number, manufacture date, and expiry date
- **Batch statuses: Active, Expired, Recalled, Depleted**
- **Filter by: All, Expiring Soon (within 30 days), Expired**
- **Depreciation settings per batch** (non-consumable assets only):
  - Methods: Straight Line, Declining Balance
  - Tracks: useful life, salvage value, depreciation rate
  - This allows the system to calculate the current book value of assets over time

Batches exist because stock doesn't arrive all at once — different deliveries have different costs, suppliers, and expiry dates. Tracking by batch gives full traceability.

### Consumable Expiry Automation
- **When a consumable batch expires, the system automatically deducts the batch quantity from the item's total stock**
- This check runs on every `/batches` or `/items` page load — no waiting for midnight
- Also runs daily at midnight via the scheduler as a safety net
- If an item's quantity reaches 0 after deduction, its status is automatically set to **Spoiled**

This automation exists because expired consumables should not be counted as available stock. Without this, the system would show incorrect quantities and staff might try to use expired items.

### Transactions (`/transactions`)
- **Full audit log of all inventory movements** — every borrow, return, replenish, disposal, and recovery is recorded
- **Types: Borrow, Return, Replenish, Disposal, Recovery**
- **Admin only** — staff don't need to see the full transaction log

Transactions exist as the accountability layer. If an item goes missing or stock numbers don't add up, the transaction log shows exactly what happened and who did it.

### Reports (`/reports`)
- **Analytics dashboard with charts** — transaction types distribution, stock status (in stock / low stock / out of stock), monthly transaction trends, items by category
- **Top borrowed items** — shows which items are most frequently borrowed
- **User activity** — shows which staff members are most active
- **Export to CSV with optional date range filter:**
  - Complete analytics report
  - Transactions only
  - Inventory items only
- **Admin only**

Reports exist so management can make data-driven decisions — knowing which items run out fastest, which departments borrow the most, and what the total inventory value is.

### Users (`/users`)
- **Admin can create, edit, deactivate users**
- **Assign roles (admin/staff) and departments**
- **Profile pictures supported**
- **Admin only**

User management exists so the hotel can onboard new staff and remove access for staff who leave, without needing a developer.

### Profile (`/profile`)
- **Update name, email, profile picture**
- **Change password**
- **Enable/disable two-factor authentication**
- **Manage trusted devices** — remove devices that should no longer be trusted
- **Delete account**

Available to all users so they can manage their own account settings.

### Borrowed Items (`/borrowed-items`)
- **Admin view of all currently borrowed items** — shows who has what, from which department, since when
- **Mobile-friendly card layout on small screens**

This page exists so management can see at a glance what items are currently out and who has them, without digging through transaction history.

---

## Scheduled Tasks

For production, add this cron entry to your server:

```
* * * * * cd /path-to-project && php artisan schedule:run >> /dev/null 2>&1
```

| Command | Schedule | Description |
|---------|----------|-------------|
| `consumables:check-expired` | Daily at midnight | Deducts expired consumable batch quantities from item stock |
| `depreciation:update` | Daily | Recalculates depreciation values for non-consumable assets |

Manual run:
```bash
php artisan consumables:check-expired
php artisan depreciation:update
```

---

## Mobile Responsiveness

The system is fully mobile responsive. Key behaviors on small screens:
- Sidebar collapses into a slide-in drawer with a hamburger menu
- Page headers stack vertically
- Tables switch to card layouts for readability
- Buttons show icon-only on small screens to save space
- All modals are touch-friendly

---

## Project Structure

```
app/
├── Console/Commands/
│   ├── CheckExpiredConsumables.php   # Auto-deducts expired consumable stock
│   └── UpdateDepreciation.php        # Recalculates asset depreciation
├── Http/Controllers/
│   ├── BatchController.php           # Batch replenishment management
│   ├── CategoryController.php        # Hierarchical category management
│   ├── DashboardController.php       # Dashboard stats and data
│   ├── DepartmentController.php      # Department management
│   ├── ItemController.php            # Item CRUD, borrow/return/replenish
│   ├── ItemExportController.php      # Per-item CSV export
│   ├── TransactionController.php     # Transaction log and reports
│   ├── TransactionExportController.php # Bulk CSV exports with date filters
│   └── UserController.php            # User management
├── Models/
│   ├── Batch.php                     # Batch model with expiry and depreciation logic
│   ├── BorrowedItem.php              # Tracks currently borrowed items
│   ├── Category.php                  # Hierarchical category model
│   ├── Department.php
│   ├── Item.php                      # Item model with depreciation and consumable logic
│   ├── Transaction.php               # Audit log model
│   ├── TrustedDevice.php             # 2FA trusted device tracking
│   └── User.php                      # User model with 2FA and avatar support
resources/views/
├── batches/                          # Batch management pages + partials
├── categories/                       # Category tree pages + partials
├── dashboard/partials/               # Dashboard stats, alerts, activity
├── departments/                      # Department pages + partials
├── items/partials/                   # Item table, modals, filters, scripts
├── layouts/partials/                 # Sidebar, footer, toasts
├── transactions/                     # Transaction log and analytics reports
└── users/partials/                   # User management table and modals
```

---

## Environment Variables

```env
APP_TIMEZONE=Asia/Manila
DB_DATABASE=hotel_inventory
MAIL_HOST=smtp.gmail.com
MAIL_USERNAME=your@gmail.com
MAIL_PASSWORD=your_app_password
```

> For Gmail SMTP, use an **App Password** (not your regular Gmail password). Generate one at: Google Account → Security → 2-Step Verification → App Passwords.
