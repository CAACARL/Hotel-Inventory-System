# Data Flow Diagram — Level 1
## Icon Venue & Suites Inventory Management System

Based on the FDD and Context Diagram. Each process at Level 1 corresponds directly to the top-level functions in the FDD.

---

## External Entities (from Context Diagram)

| ID | Entity | Inputs to System | Outputs from System |
|----|--------|-----------------|---------------------|
| E1 | Admin | User Data, Item Data, Category Data, Department Data, Batch Data | Reports, Dashboard Information, Transaction History, CSV Exports, Confirmation Messages, Notifications |
| E2 | Staff | Borrow Request, Return Request | Item Availability, Borrowed Item List, Confirmation Messages, Notifications |

---

## Processes (from FDD Top-Level)

| ID | Process |
|----|---------|
| 1.0 | User Management |
| 2.0 | Category Management |
| 3.0 | Item Management |
| 4.0 | Batch Management |
| 5.0 | Borrow & Return Management |
| 6.0 | Transaction Management |
| 7.0 | Reports & Analytics |
| 8.0 | Department Management |
| 9.0 | Notification Management |

---

## Data Stores

| ID | Store |
|----|-------|
| D1 | User Data Store |
| D2 | Category Data Store |
| D3 | Item Data Store |
| D4 | Batch Data Store |
| D5 | Transaction Data Store |
| D6 | Borrowed Item Data Store |
| D7 | Department Data Store |
| D8 | Notification Data Store |

---

## Data Flows Per Process

### 1.0 User Management
| From | Data Flow | To |
|------|----------|----|
| E1 | User Data (name, email, role, department) | 1.0 |
| 1.0 | Created/Updated User Record | D1 |
| 1.0 | Welcome Email with Credentials | E1 (new user) |
| 1.0 | Confirmation Message | E1 |
| D1 | User List | E1 |
| D7 | Active Department Options | 1.0 |

**Sub-processes:** 1.1 Create User · 1.2 Edit User Details · 1.3 Deactivate/Reactivate User · 1.4 Auto-send Welcome Email with Credentials

---

### 2.0 Category Management
| From | Data Flow | To |
|------|----------|----|
| E1 | Category Data (name, description, parent) | 2.0 |
| 2.0 | Created/Updated/Archived Category Record | D2 |
| 2.0 | Confirmation Message | E1 |
| D2 | Category Tree / Active Categories | E1 |
| D2 | Active Category Options | 3.0 |

**Sub-processes:** 2.1 Create Category · 2.2 Create Sub-Category · 2.3 Edit Category · 2.4 Archive/Unarchive Category

---

### 3.0 Item Management
| From | Data Flow | To |
|------|----------|----|
| E1 | Item Data (name, type, category, dept, image) | 3.0 |
| 3.0 | Created/Updated/Archived Item Record | D3 |
| 3.0 | Confirmation Message | E1 |
| D3 | Item List with Stock Status | E1, E2 |
| D2 | Active Category Options | 3.0 |
| D7 | Active Department Options | 3.0 |

**Sub-processes:** 3.1 Create Item · 3.2 Edit Item · 3.3 Archive/Unarchive Item · 3.4 Track Item Status (Available, In Use, Disposed, Spoiled) · 3.5 View Item · 3.6 Dispose Item

---

### 4.0 Batch Management
| From | Data Flow | To |
|------|----------|----|
| E1 | Batch Data (qty, cost, expiry, depreciation, supplier) | 4.0 |
| 4.0 | Batch Record | D4 |
| 4.0 | Item Quantity Increment | D3 |
| 4.0 | Replenish Transaction Record | D5 |
| 4.0 | New Batch Notification Trigger | 9.0 |
| D4 | Batch List, Expiry Status | E1 |
| 4.0 | Expired Batch → Quantity Deduction | D3 |
| 4.0 | Spoiled Transaction Record (on expiry) | D5 |
| 4.0 | Depreciation Calculation (Non-Consumable) | D4 |

**Sub-processes:** 4.1 Create Batch (Replenish Stock) · 4.2 Monitor Batch Expiry · 4.3 Auto-Expire (Spoiled/Depletable) Consumable Batches · 4.4 View Batch · 4.5 Depreciation Processing (Non-Consumable Items)

---

### 5.0 Borrow & Return Management
| From | Data Flow | To |
|------|----------|----|
| E1, E2 | Borrow Request (item, quantity) | 5.0 |
| 5.0 | Item Quantity Decrement | D3 |
| 5.0 | Borrow Record | D6 |
| 5.0 | Borrow Transaction Record | D5 |
| 5.0 | Borrow Notification Trigger | 9.0 |
| E1, E2 | Return Request (item, quantity) | 5.0 |
| 5.0 | Item Quantity Increment | D3 |
| 5.0 | Updated/Removed Borrow Record | D6 |
| 5.0 | Return Transaction Record | D5 |
| 5.0 | Return Notification Trigger | 9.0 |
| D6 | Active Borrowed Items List | E1, E2 |
| 5.0 | Confirmation Message | E1, E2 |

**Sub-processes:** 5.1 Borrow Item · 5.2 Return Item · 5.3 View Borrowed Items

---

### 6.0 Transaction Management
| From | Data Flow | To |
|------|----------|----|
| 3.0, 4.0, 5.0 | Transaction Data (type, qty, item, user) | 6.0 |
| 6.0 | Transaction Record | D5 |
| D5 | Transaction History | E1, E2 |
| D3 | Item Reference | 6.0 |
| D1 | User Reference | 6.0 |

**Sub-processes:** 6.1 Log Borrow · 6.2 Log Return · 6.3 Log Replenishment · 6.4 Log Disposal · 6.5 Log Spoiled

---

### 7.0 Reports & Analytics
| From | Data Flow | To |
|------|----------|----|
| E1 | Report Request (type, date range) | 7.0 |
| D5 | Transaction Records | 7.0 |
| D3 | Item and Stock Data | 7.0 |
| D6 | Active Borrow Data | 7.0 |
| 7.0 | Dashboard Information | E1 |
| 7.0 | Transaction History View | E1 |
| 7.0 | CSV Export (Transactions / Inventory / Borrowed / Comprehensive) | E1 |

**Sub-processes:** 7.1 View Analytics Dashboard · 7.2 Export Transactions Report · 7.3 Export Inventory Report · 7.4 Export Borrowed Items Report · 7.5 Export Comprehensive Report

---

### 8.0 Department Management
| From | Data Flow | To |
|------|----------|----|
| E1 | Department Data (name, location, description) | 8.0 |
| 8.0 | Created/Updated Department Record | D7 |
| 8.0 | Confirmation Message | E1 |
| D7 | Department List | E1 |
| D7 | Active Department Options | 1.0, 3.0 |

**Sub-processes:** 8.1 Create Department · 8.2 Edit Department · 8.3 Deactivate/Reactivate Department

---

### 9.0 Notification Management
| From | Data Flow | To |
|------|----------|----|
| 4.0, 5.0 | Notification Trigger (event, message, url) | 9.0 |
| 9.0 | Notification Record | D8 |
| D8 | Unread Notifications, Unread Count | E1, E2 |
| E1, E2 | Mark as Read Request | 9.0 |
| 9.0 | Updated Read Status | D8 |

**Sub-processes:** 9.1 Notify Admin: New Borrow · 9.2 Notify Admin: Item Returned · 9.3 Notify Admin: Low Stock · 9.4 Notify Admin: New Batch · 9.5 Batch Expiring Soon · 9.6 Batch Expired · 9.7 Notify Staff: Reminder (Borrowed Items)

---

## Drawing Reference

- **Rectangles** — External entities (Admin, Staff)
- **Circles / Rounded rectangles** — Processes (1.0–9.0)
- **Open-ended rectangles (parallel lines)** — Data stores (D1–D8)
- **Labeled arrows** — Data flows
- Each process bubble at Level 1 maps directly to a top-level FDD function
- Sub-processes listed under each section are your Level 2 decomposition if needed
