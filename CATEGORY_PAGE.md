# Category Management Page

## Overview

The Category Management page lets admins organize inventory items using a hierarchical tree structure. Categories can have subcategories nested inside them, and each category can hold multiple inventory items.

---

## What's on the Page

### Header
- Page title and description
- Total category count indicator
- "Expand All / Collapse All" toggle — expands or collapses the entire category tree at once
- "Add New Category" button — opens the create modal

---

### Category Tree

Categories are displayed as expandable cards in a tree layout. Each card shows:

| Element | Description |
|---------|-------------|
| Category name | Bold title of the category |
| Item count | How many items are directly assigned to it |
| Active / Inactive badge | Green dot for active, red for inactive |
| Expand/collapse arrow | Appears only if the category has subcategories |

Subcategories are indented under their parent and follow the same card layout.

---

### Action Buttons (per category)

| Button | Visible When | What it Does |
|--------|-------------|--------------|
| View | Always | Opens a modal showing category name, full path, description, item count, and status |
| Edit | Always | Opens a modal to update name, parent, description, and active status |
| Add Sub | Always | Expands an inline form directly under the card to create a subcategory |
| Delete | Only if no items and no subcategories | Deletes the category permanently |
| Delete (disabled) | Has items or subcategories | Greyed out — cannot delete until items/subcategories are removed |

---

### Inline Add Subcategory Form

Appears directly under a category card when "Add Sub" is clicked. Includes:
- Subcategory name (required)
- Description (optional)
- Cancel and Create buttons

---

## Modals

### Create Category Modal
- Category name (required)
- Parent category selector (optional — defaults to root level)
- Description (optional)

### View Category Modal
- Read-only display of: name, full path, description, item count, and active status

### Edit Category Modal
- Same fields as create, pre-filled with existing data
- Includes active/inactive toggle

### Delete Confirmation Modal
- Warns that the category and all its subcategories will be permanently removed
- Requires confirmation before proceeding

---

## Rules

- A category with items or subcategories cannot be deleted
- Deleting a category also cascade-deletes all its subcategories
- Duplicate category names are not allowed within the same parent level
- A category cannot be set as its own parent or as a child of its own descendants
