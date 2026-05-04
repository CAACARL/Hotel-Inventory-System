# How to Create a Context Diagram for Icon Venue & Suites Inventory Management System

## What is a Context Diagram?

A context diagram (also called a Level 0 DFD) shows the system as a single process and illustrates how it interacts with external entities. It does not show internal logic — just what goes in and out, and who or what is involved.

---

## Components

| Symbol | Shape | Represents |
|--------|-------|------------|
| Process | Circle / Rectangle | The system itself (one box only) |
| External Entity | Rectangle | People or systems outside your system |
| Data Flow | Arrow | Information moving in or out |

---

## Step-by-Step Guide

### Step 1 — Identify the System
Place your system in the center as a single process box.

```
[ Icon Venue Inventory Management System ]
```

---

### Step 2 — Identify External Entities

These are the people or systems that interact with yours. Do not include internal components.

| Entity | Role |
|--------|------|
| Admin | Manages users, items, categories, departments, batches, and reports |
| Staff | Borrows and returns items, views inventory |
| Email Server | Receives and delivers system-generated email notifications |
| Database | Stores and retrieves all system data (items, users, transactions, etc.) |

---

### Step 3 — Identify Data Flows

For each entity, define what data flows in (→ system) and out (system →).

#### Admin
| Direction | Data |
|-----------|------|
| → System | Login credentials, user details, item data, category/department info, batch info |
| System → | Dashboard stats, reports, confirmation messages, error messages |

#### Staff
| Direction | Data |
|-----------|------|
| → System | Login credentials, borrow requests, return confirmations |
| System → | Item availability, borrowed item list, confirmation messages |

#### Email Server
| Direction | Data |
|-----------|------|
| → System | Delivery status (optional) |
| System → | Welcome emails, 2FA codes, borrow/return notifications, low stock alerts, batch expiry alerts |

---

### Step 4 — Draw the Diagram

Arrange entities around the central system box and connect them with labeled arrows.

```
                        [ Admin ]
                            |
              Login, Item/User/Batch Data
                            |
                            ↓
[ Staff ] ---Borrow/Return--→ [ Icon Venue IMS ] ---Notifications--→ [ Email Server ]
                            ↑
                     Reports, Alerts
                            |
                        [ Admin ]
```

> In a proper diagram tool, each arrow should be labeled with the data it carries.

---

### Step 5 — Rules to Follow

- Only **one process box** — the entire system is one circle/rectangle
- External entities are **outside** the system boundary
- Every arrow must be **labeled** with the data it represents
- No internal processes, databases, or logic shown at this level
- Data flows should be **nouns** (e.g. "Borrow Request", not "Borrows")

---

## Recommended Tools

| Tool | Type | Link |
|------|------|-------|
| draw.io | Free, web-based | https://draw.io |
| Lucidchart | Web-based | https://lucidchart.com |
| Microsoft Visio | Desktop | Microsoft 365 |
| Creately | Web-based | https://creately.com |
| Figma | Web-based | https://figma.com |

---

## Quick Reference — System Boundary

Everything inside the box is your system. Everything outside is an external entity.

```
+-------------------------------------------------------+
|         Icon Venue Inventory Management System        |
|                                                       |
|  - User Management        - Batch Management         |
|  - Item Management        - Transaction Logging      |
|  - Category Management    - Reports & Exports        |
|  - Department Management  - Notifications            |
|  - Borrow & Return                                   |
+-------------------------------------------------------+
        ↑                          ↓
     [ Admin ]               [ Email Server ]
     [ Staff ]
```
