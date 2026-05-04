# Functional Decomposition Diagram Guide

A functional decomposition diagram breaks the system down into its major functions, then sub-functions, then tasks. It reads top-down like a tree — the root is the system name, the first level is the main modules, and each branch below that is a sub-function.

**Legend:**
- [A] = Admin only
- [S] = Staff only
- [A/S] = Both roles

---

## Decomposition Structure

```
Icon Venue & Suites Inventory Management System
│
├── 1. User Management [A]
│   ├── 1.1 Create User Account
│   ├── 1.2 Edit User Details
│   ├── 1.3 Deactivate / Reactivate User
│   ├── 1.4 Delete User
│   └── 1.5 Send Welcome Email with Credentials
│
├── 2. Authentication [A/S]
│   ├── 2.1 Login
│   ├── 2.2 Logout
│   └── 2.3 Reset Password
│
├── 3. Category Management [A]
│   ├── 3.1 Create Category
│   ├── 3.2 Create Sub-Category
│   ├── 3.3 Edit Category
│   └── 3.4 Delete Category
│
├── 4. Item Management
│   ├── 4.1 Create Item [A]
│   ├── 4.2 Edit Item [A]
│   ├── 4.3 Delete Item [A]
│   ├── 4.4 Upload Item Image [A]
│   ├── 4.5 Assign Item to Category [A]
│   ├── 4.6 Assign Item to Department [A]
│   ├── 4.7 Track Item Status [A]
│   └── 4.8 View Items [A/S]
│
├── 5. Batch Management [A]
│   ├── 5.1 Create Batch (Replenish Stock)
│   ├── 5.2 Edit Batch
│   ├── 5.3 Delete Batch
│   ├── 5.4 Monitor Batch Expiry
│   └── 5.5 Auto-Expire Consumable Batches
│
├── 6. Borrow & Return
│   ├── 6.1 Borrow Item [A/S]
│   ├── 6.2 Return Item [A/S]
│   ├── 6.3 View All Borrowed Items [A]
│   └── 6.4 View Own Borrowed Items [S]
│
├── 7. Transaction Management [A]
│   ├── 7.1 Record Transaction
│   ├── 7.2 View Transaction History
│   ├── 7.3 Filter Transactions
│   └── 7.4 Export Transactions to CSV
│
├── 8. Depreciation Tracking [A]
│   ├── 8.1 Configure Depreciation Settings per Item
│   ├── 8.2 Calculate Accumulated Depreciation
│   └── 8.3 Update Current Book Value
│
├── 9. Department Management [A]
│   ├── 9.1 Create Department
│   ├── 9.2 Edit Department
│   └── 9.3 Deactivate Department
│
├── 10. Reports & Analytics [A]
│   ├── 10.1 View Transaction Analytics
│   ├── 10.2 Filter by Date Range / Type / Item / User
│   └── 10.3 Export Reports to CSV
│
└── 11. Notification System
    ├── 11.1 Notify Admin — New Borrow [A]
    ├── 11.2 Notify Admin — Item Returned [A]
    ├── 11.3 Notify Admin — Low Stock [A]
    ├── 11.4 Notify Admin — New Batch Created [A]
    ├── 11.5 Notify Admin — Batch Expiring Soon [A]
    ├── 11.6 Notify Admin — Batch Expired [A]
    └── 11.7 Notify Staff — Borrowed Item Reminder [S]
```

---

## Tips for Drawing It

- Use a top-down tree layout in your diagramming tool (Lucidchart, draw.io, Figma, etc.)
- Each box = one function
- Lines connect parent functions to child functions
- Number each node to match the structure above (1, 1.1, 1.2, etc.)
- Use color to distinguish roles — e.g., blue for Admin-only, green for Staff-only, gray for shared
- You don't need to go deeper than 3 levels for this system — the structure above is complete
