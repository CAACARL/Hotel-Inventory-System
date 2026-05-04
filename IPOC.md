# Booking Feature — IPOC Analysis

## Summary

| Component | Description |
|-----------|-------------|
| **Input** | Guest information fields, booking details, and data retrieved from the database |
| **Process** | Form validation, real-time availability checking, room availability logic, booking creation process, automatic calculations, and guest account auto-creation |
| **Output** | Booking confirmation message, booking details display, auto-generated booking and guest record, email notifications, error outputs, and visual feedback |
| **Control** | Date pickers, room selector, action buttons, input fields, navigation, and responsive controls |

---

## Input

Data entered by the user or retrieved from the system.

| Field | Type | Source |
|-------|------|--------|
| Guest first name | Text | User input |
| Guest last name | Text | User input |
| Guest email address | Email | User input |
| Guest phone number | Text | User input |
| Check-in date | Date | User input |
| Check-out date | Date | User input |
| Number of guests | Number | User input |
| Room selection | Dropdown | Database (available rooms) |
| Special requests / notes | Textarea | User input |
| Existing guest record | Auto-fill | Database lookup by email |
| Room details (type, rate, capacity) | Read-only | Database |

---

## Process

Logic and operations performed after input is received.

| Step | Description |
|------|-------------|
| Form validation | Validates required fields, formats, and logical date ranges (check-out must be after check-in) |
| Duplicate guest check | Looks up email in the database to find an existing guest account |
| Guest auto-creation | If no existing guest is found, a new guest record is automatically created |
| Availability check | Queries the database for room availability within the selected date range |
| Real-time availability | Updates available room options dynamically as dates are changed |
| Room availability logic | Excludes rooms with overlapping confirmed or pending bookings |
| Night calculation | Automatically calculates total nights from check-in and check-out dates |
| Total cost calculation | Multiplies room nightly rate by total nights |
| Booking record creation | Inserts a new booking record linked to the guest and room |
| Confirmation number generation | Auto-generates a unique booking reference number |
| Email notification trigger | Sends confirmation email to the guest upon successful booking |

---

## Output

Results and feedback produced by the system.

| Output | Type | Description |
|--------|------|-------------|
| Booking confirmation message | UI alert | Success message shown after booking is created |
| Booking details display | Page / modal | Summary of the confirmed booking (dates, room, total cost, reference number) |
| Auto-generated booking record | Database record | New entry in the bookings table |
| Auto-generated guest record | Database record | New guest account if one did not already exist |
| Confirmation email | Email | Sent to the guest with booking details and reference number |
| Validation error messages | UI alert | Inline errors shown per field when input is invalid |
| Availability error | UI alert | Message shown when no rooms are available for the selected dates |
| Visual feedback | UI state | Loading indicators, disabled states, and highlighted available/unavailable rooms |

---

## Control

UI elements and interactions available to the user.

| Control | Type | Purpose |
|---------|------|---------|
| Check-in date picker | Date input | Select the arrival date |
| Check-out date picker | Date input | Select the departure date |
| Room selector | Dropdown / card grid | Choose from available rooms |
| Guest count input | Number input | Specify number of guests |
| Special requests field | Textarea | Add optional notes or requests |
| Submit / Book Now button | Primary button | Submit the booking form |
| Reset / Clear button | Secondary button | Clear all form fields |
| Back / Cancel button | Navigation button | Return to previous page without saving |
| Real-time availability indicator | Dynamic UI | Shows room availability as dates are selected |
| Responsive layout | Adaptive UI | Form adapts to mobile, tablet, and desktop screen sizes |
