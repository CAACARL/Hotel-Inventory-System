# Process Flows

## 1. Core Inventory Flow

**Actor:** Admin

---

### Step 1 — Set Up Category Structure

- Admin navigates to **Categories**
- Creates a top-level category (e.g., `Office Supplies`)
- Optionally creates a sub-category under it (e.g., `Stationery`)
- Categories are hierarchical — items are assigned to the most specific level

---

### Step 2 — Create an Item

- Admin navigates to **Items** and clicks **Add New Item**
- Fills in:
  - **Name** — item label
  - **Category** — selected from the hierarchy
  - **Department** — optional assignment
  - **Item Type** — `consumable` (e.g., paper, cleaning supplies) or `non-consumable` (e.g., equipment, furniture)
  - **Status** — defaults to `available`
  - **Location** — optional storage location
  - **Description** — optional notes
  - **Image** — optional photo upload
- Item is created with **zero quantity** — stock is added via batches
- System sets a default minimum stock threshold of 10 (adjustable)

---

### Step 3 — Replenish Stock via Batch

- Admin navigates to **Batches** and clicks **Replenish Stock**
- Selects the item and fills in:
  - **Quantity** — units being added
  - **Unit Cost** — cost per unit
  - **Supplier** — optional vendor name
  - **Lot Number** — optional tracking reference
  - **Manufacture Date** — optional
  - **Expiry Date** — required for consumables to enable spoilage tracking
  - **Notes** — optional

- **For non-consumables only**, admin also sets:
  - **Depreciation Method** — `straight-line` or `declining balance`
  - **Useful Life (years)** — expected lifespan
  - **Salvage Value** — residual value at end of life
  - **Depreciation Rate** — percentage (for declining balance)

- A unique **Batch Number** is auto-generated (e.g., `B20260410-A3F2`)

---

### Step 4 — System Processes the Batch

Upon batch creation, the system automatically:

1. **Increments item quantity** by the batch quantity
2. **Records a replenish transaction** in the transaction history with a reference number (e.g., `REP-001`)
3. **Updates depreciation values** on the item if depreciation settings were provided:
   - Calculates accumulated depreciation
   - Updates current book value
   - Sets last depreciation date
4. **Notifies all other admins** of the new batch via the notification system

---

### Step 5 — Ongoing Automatic Monitoring

The system continuously monitors inventory state:

| Trigger | System Action |
|---------|--------------|
| Item quantity ≤ minimum stock | Sends low stock notification to all admins (once per day) |
| Batch expiry date passes (consumable) | Marks batch as `expired`, deducts quantity from item, marks item as `spoiled` if quantity reaches 0 |
| Batch expiry within 30 days | Sends expiring soon notification to all admins (once per day) |
| Batch already expired but still active | Sends expired batch notification to all admins (once per day) |
| Monthly interval passes | Recalculates depreciation for all eligible non-consumable items |

---

### Step 6 — Admin Reviews & Maintains

- Admin views item details at any time to see:
  - Current stock, minimum stock, borrowed quantity
  - Current book value and accumulated depreciation
  - Full transaction history with running stock levels
- Admin can export transaction history to CSV (with optional date range)
- Admin can update item details, change status, or delete the item
- Admin can edit or delete batches, adjusting item quantity accordingly

---

## 2. Borrow / Return Flow

**Actors:** Staff (borrower), Admin (notified)

**Borrow Steps:**

1. Staff browses the **Items** page
2. Staff clicks **Borrow** on an available item
3. Staff enters quantity and confirms
4. System:
   - Decrements item quantity
   - Creates a borrow transaction record
   - Creates a BorrowedItem record linked to the staff user
   - Sends a notification to all admins (except if admin is the borrower)
   - Checks if item is now low stock — notifies admins if so (once per day)

**Return Steps:**

1. Staff goes to **My Borrowed Items** or clicks **Return** on the items page
2. Staff enters quantity to return and confirms
3. System:
   - Increments item quantity back
   - Updates or removes the BorrowedItem record
   - Creates a return transaction record
   - Sends a notification to all admins (except if admin is the returner)

**Throughout:**
- Every borrow and return is logged in the **Transaction History**
- Admin can view all borrowed items at `/borrowed-items`
- Staff can view only their own borrowed items at `/borrowed-items`
- Reference numbers are auto-generated for each transaction
