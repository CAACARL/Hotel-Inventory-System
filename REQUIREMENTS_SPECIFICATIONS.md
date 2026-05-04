# Requirements Specifications

This section contains Operational Feasibility, Technical Feasibility, Schedule Feasibility, Economic Feasibility, Requirements Modeling, and Risk Assessment.

## Operational Feasibility

The proposed inventory management system for Icon Venue & Suites was intended to be intuitive, user-friendly, web-deployed, and guarantee a smooth experience for administrators and staff. The system featured a straightforward interface and uncomplicated terminology, enabling users with different levels of technical expertise to navigate it with ease. Its main objective was to improve operational efficiency and accuracy within the establishment by automating manual inventory tracking tasks. By incorporating useful features such as real-time stock monitoring, batch-based replenishment, borrow and return management, and automated notifications, the system sought to streamline workflows, reduce errors, and enhance overall asset visibility and accountability.

## Technical Feasibility

The system is built on Laravel 11, a well-established PHP framework with extensive documentation and community support. The frontend uses Blade templating, Tailwind CSS, and Alpine.js — all widely adopted technologies that require no specialized infrastructure. The application runs on a standard web server stack and is compatible with SQLite for local development and MySQL or PostgreSQL for production. Email functionality relies on SMTP and can be configured with any standard mail provider. The system is deployable on shared hosting, a VPS, or a cloud environment with minimal configuration.

## Schedule Feasibility

The system was developed incrementally, with core inventory features established first, followed by secondary features such as borrow and return management, depreciation tracking, notifications, and user management. This phased approach allowed for continuous testing and refinement throughout development without disrupting the overall timeline.

## Economic Feasibility

The system was built entirely using open-source technologies, incurring no licensing costs. Ongoing operational costs are limited to web hosting and a domain. The reduction in manual tracking effort, the prevention of stock shortages through automated low stock alerts, and the improved accountability through a complete transaction history all contribute to measurable operational savings over time.

## Requirements Modeling

### Functional Requirements

- The system shall allow administrators to create, edit, and delete inventory items, categories, batches, departments, and user accounts.
- The system shall allow staff to browse items and perform borrow and return transactions.
- The system shall track all inventory movements and maintain a complete transaction history with reference numbers.
- The system shall automatically adjust item stock quantities on borrow, return, replenishment, and disposal.
- The system shall monitor batch expiry dates and automatically mark consumable items as spoiled when their batch expires.
- The system shall calculate and track depreciation for non-consumable items using straight-line or declining balance methods.
- The system shall send in-app notifications to administrators for borrows, returns, low stock, new batches, and expiring or expired batches.
- The system shall send staff daily reminders of items they currently have borrowed.
- The system shall send a welcome email to newly created users containing their login credentials.
- The system shall enforce role-based access, restricting administrative functions to admin users only.
- The system shall support CSV export of transaction history, inventory snapshots, and borrowed item records.

### Non-Functional Requirements

- The system shall be accessible via a standard web browser without requiring any client-side installation.
- The system shall be responsive and usable on both desktop and mobile devices.
- The system shall enforce rate limiting on login attempts to mitigate brute-force attacks.
- The system shall hash all user passwords before storage.
- The system shall log all failed login attempts.
- The system shall maintain session security by invalidating sessions on logout and regenerating CSRF tokens.

## Risk Assessment

| Risk | Likelihood | Impact | Mitigation |
|------|-----------|--------|------------|
| Mail server misconfiguration preventing welcome emails or password resets | Medium | Medium | System continues to function without email; errors are logged silently and do not block user creation |
| Accidental deletion of items or users | Low | High | Confirmation modals required before destructive actions; admins cannot delete their own account |
| Stock discrepancy due to concurrent transactions | Low | Medium | Database transactions used for quantity updates to prevent race conditions |
| Expired batch not processed if scheduled command is not configured | Medium | Medium | Batch expiry is also checked on the batches index page load as a fallback |
| Unauthorized access to admin features | Low | High | All admin routes protected by middleware; role checked at both route and controller level |
| Data loss from accidental database deletion | Low | High | Regular database backups recommended as an operational procedure |
