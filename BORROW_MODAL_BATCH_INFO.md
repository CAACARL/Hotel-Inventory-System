# Borrow & Return Modal Batch Information Feature

## Overview
Added real-time batch information display in both borrow and return modals to show users which batches will be used/returned in the transaction.

## Implementation Status
✅ **COMPLETE**

## What Was Added

### 1. Backend API Endpoints

#### Borrow Batches
**File:** `app/Http/Controllers/ItemController.php`
**Method:** `getBorrowBatches(Item $item, Request $request)`

- Accepts `quantity` parameter from query string
- Uses `getAvailableBatches()` to get batches in FIFO/FEFO order
- Calculates how much will be taken from each batch
- Returns JSON with batch details:
  - Batch number
  - Location
  - Quantity to borrow from this batch
  - Available quantity in batch
  - Expiry date (if applicable)

#### Return Batches
**File:** `app/Http/Controllers/ItemController.php`
**Method:** `getReturnBatches(Item $item, Request $request)`

- Accepts `quantity` parameter from query string
- Gets borrowed items by user ordered by oldest first
- Calculates how items will be distributed back to original batches
- Returns JSON with batch details:
  - Batch number
  - Location
  - Quantity to return to this batch
  - Total borrowed from this batch
  - Borrowed date
  - Expiry date (if applicable)

### 2. Route Registration
**File:** `routes/web.php`
```php
Route::get('/items/{item}/borrow-batches', [ItemController::class, 'getBorrowBatches'])
    ->name('items.get-borrow-batches');
Route::get('/items/{item}/return-batches', [ItemController::class, 'getReturnBatches'])
    ->name('items.get-return-batches');
```

### 3. Frontend Modal Enhancements
**File:** `resources/views/items/partials/edit-modal.blade.php`

#### Borrow Modal Alpine.js Data
```javascript
{
    borrowBatches: [],
    borrowQuantity: 1,
    async loadBorrowBatches() {
        if (!this.selectedItem?.id || !this.borrowQuantity) return;
        const response = await fetch(`/items/${this.selectedItem.id}/borrow-batches?quantity=${this.borrowQuantity}`);
        const data = await response.json();
        this.borrowBatches = data.batches || [];
    }
}
```

#### Return Modal Alpine.js Data
```javascript
{
    returnBatches: [],
    returnQuantity: 1,
    async loadReturnBatches() {
        if (!this.selectedItem?.id || !this.returnQuantity) return;
        const response = await fetch(`/items/${this.selectedItem.id}/return-batches?quantity=${this.returnQuantity}`);
        const data = await response.json();
        this.returnBatches = data.batches || [];
    }
}
```

#### Key Features
- **Debounced Input:** Quantity input has 500ms debounce to avoid excessive API calls
- **Auto-load:** Batches load automatically when modal opens
- **Dynamic Update:** Batch information updates as user changes quantity
- **Visual Cards:** Each batch displays with:
  - Batch number (bold)
  - Location with map icon
  - Relevant dates (borrowed date for returns, expiry date)
  - Quantity details

### 4. UI/UX Design

#### Borrow Modal - Batch Cards (Blue Theme)
- Blue gradient background (`bg-blue-50`)
- Blue border (`border-blue-200`)
- Shows batches in FIFO/FEFO order
- Label: "Will be borrowed from:"

#### Return Modal - Batch Cards (Green Theme)
- Green gradient background (`bg-green-50`)
- Green border (`border-green-200`)
- Shows batches in return order (oldest borrowed first)
- Label: "Will be returned to:"
- Includes "Borrowed on:" date for context

#### Information Display Examples

**Borrow Modal:**
```
┌─────────────────────────────────────┐
│ ℹ️ Will be borrowed from:            │
├─────────────────────────────────────┤
│ B20260101-A1F2                      │
│ 📍 Storage Room A                   │
│ Expires: Jun 15, 2026               │
│                          50 pcs     │
│                          of 100     │
└─────────────────────────────────────┘
```

**Return Modal:**
```
┌─────────────────────────────────────┐
│ ℹ️ Will be returned to:              │
├─────────────────────────────────────┤
│ B20260101-A1F2                      │
│ 📍 Storage Room A                   │
│ Borrowed on: May 15, 2026           │
│ Expires: Jun 15, 2026               │
│                          50 pcs     │
│                          of 80      │
└─────────────────────────────────────┘
```

## How It Works

### Borrow Flow

1. **User Opens Borrow Modal**
   - Modal initializes with `borrowQuantity = 1`
   - `loadBorrowBatches()` is called automatically

2. **User Changes Quantity**
   - Input field triggers `@input.debounce.500ms="loadBorrowBatches()"`
   - After 500ms of no typing, API call is made

3. **API Processes Request**
   - Fetches available batches in FIFO/FEFO order
   - Calculates distribution across batches
   - Returns structured batch information

4. **Frontend Updates Display**
   - Blue batch cards appear below quantity input
   - Shows exactly which batches will be used
   - User sees the borrowing plan before confirming

### Return Flow

1. **User Opens Return Modal**
   - Modal initializes with `returnQuantity = borrowed_quantity`
   - `loadReturnBatches()` is called automatically

2. **User Changes Quantity**
   - Input field triggers `@input.debounce.500ms="loadReturnBatches()"`
   - After 500ms of no typing, API call is made

3. **API Processes Request**
   - Fetches borrowed items by user (oldest first)
   - Calculates return distribution to original batches
   - Returns structured batch information with borrowed dates

4. **Frontend Updates Display**
   - Green batch cards appear below quantity input
   - Shows which batches items will return to
   - Displays borrowed date for each batch
   - User sees the return plan before confirming

## FIFO/FEFO Logic

### Borrow (FIFO/FEFO)

#### For Consumables
- Uses **FEFO** (First Expired, First Out)
- Order: `expiry_date IS NULL, expiry_date ASC, created_at ASC`
- Batches with expiry dates are used first (sorted by soonest expiry)
- Batches without expiry dates are used last (sorted by oldest first)

#### For Non-Consumables
- Uses **FIFO** (First In, First Out)
- Order: `created_at ASC`
- Oldest batches are used first

### Return (Oldest Borrowed First)

- Returns to the same batches items were borrowed from
- Processes oldest borrowed items first
- Order: `borrowed_at ASC`
- Ensures items return to their original batches

## Benefits

1. **Full Transparency:** Users see exactly where items come from and where they go
2. **Location Awareness:** Users know which storage locations are involved
3. **Date Context:** 
   - Borrow: See expiry dates to understand urgency
   - Return: See borrowed dates to understand transaction history
4. **System Understanding:** Visual representation helps users understand FIFO/FEFO
5. **Reduced Errors:** Clear information prevents confusion about batch sources/destinations
6. **Audit Trail:** Borrowed dates provide context for returns

## Example Scenarios

### Scenario 1: Borrowing from Multiple Batches
**Item:** Paper Towels (500 available)
**Borrow Quantity:** 80

**Batch Display:**
- Batch A: 50 pcs from Storage Room A (expires Jun 15, 2026)
- Batch B: 30 pcs from Warehouse B

### Scenario 2: Returning to Multiple Batches
**Item:** Paper Towels (80 borrowed)
**Return Quantity:** 80

**Batch Display:**
- Batch A: 50 pcs to Storage Room A (borrowed May 1, 2026)
- Batch B: 30 pcs to Warehouse B (borrowed May 1, 2026)

### Scenario 3: Partial Return
**Item:** Laptops (5 borrowed)
**Return Quantity:** 3

**Batch Display:**
- Batch C: 3 pcs to IT Storage (borrowed Apr 20, 2026)

## Technical Notes

- **Performance:** Debounced to avoid excessive API calls (500ms)
- **Error Handling:** Falls back to empty array if API fails
- **Responsive:** Works on mobile and desktop
- **Accessibility:** Proper labels and semantic HTML
- **No Breaking Changes:** Existing functionality unchanged
- **Color Coding:** Blue for borrow (taking), green for return (giving back)

## Files Modified

1. `app/Http/Controllers/ItemController.php` - Added `getBorrowBatches()` and `getReturnBatches()` methods
2. `routes/web.php` - Added route registrations
3. `resources/views/items/partials/edit-modal.blade.php` - Enhanced both borrow and return modals

## Testing Checklist

- [x] Borrow route registered and accessible
- [x] Return route registered and accessible
- [x] Borrow API endpoint returns correct data
- [x] Return API endpoint returns correct data
- [x] Borrow modal displays batch information
- [x] Return modal displays batch information
- [x] Debounce works (500ms delay)
- [x] Multiple batches display correctly
- [x] Single batch displays correctly
- [x] FIFO order maintained in borrow
- [x] FEFO order maintained for consumables in borrow
- [x] Return order maintained (oldest borrowed first)
- [x] Location displayed properly in both modals
- [x] Expiry dates shown when available
- [x] Borrowed dates shown in return modal
- [x] No syntax errors in code
- [x] No diagnostic issues
- [x] "(FIFO/FEFO)" text removed from label

## UI Changes Summary

### Borrow Modal
- Label changed from "Will be borrowed from (FIFO/FEFO):" to "Will be borrowed from:"
- Blue-themed batch cards
- Shows expiry dates

### Return Modal
- New feature: Batch information display
- Label: "Will be returned to:"
- Green-themed batch cards
- Shows borrowed dates
- Shows which batch items originally came from

## Related Documentation

- `FIFO_IMPLEMENTATION.md` - Main FIFO/FEFO implementation details
- `FEFO_FIX_TEST_SCENARIOS.md` - FEFO mixed batch handling
- `INVENTORY_RECONCILIATION.md` - Batch quantity reconciliation
