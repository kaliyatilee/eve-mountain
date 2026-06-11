# Eve Mountain Campsite — Laravel Web Application

A full-stack booking and content management system built with Laravel 11.

## Features

### Public Website
- Home page with hero, capacity highlights, group types, facilities overview
- Facilities & rates page (database-driven, admin-editable)
- Activities page
- Photo gallery with lightbox and category filtering
- Contact form with email notification
- Booking form with:
  - 4-step wizard (dates → facilities → contact → review)
  - Live quote calculator (AJAX, no page reload)
  - Date picker with blocked dates
  - Availability checking (capacity limits enforced)
  - Auto-generated booking reference (EM-2024-0001)
  - Confirmation emails to client and admin

### Admin Panel (`/admin`)
- Dashboard with stats and upcoming arrivals
- Bookings manager (list, filter, confirm, cancel, notes)
- Gallery CMS (upload, drag-to-reorder, caption, show/hide, delete)
- Rates manager (edit facility and activity prices inline)

## Tech Stack

| Layer | Choice |
|-------|--------|
| Framework | Laravel 11 |
| Frontend | Blade + Tailwind CSS (CDN) |
| Database | MySQL |
| Auth | Session-based (custom, no Breeze) |
| Images | Intervention Image v2 |
| Date picker | Flatpickr |
| Drag & drop | SortableJS |
| Email | Laravel Mailable + SMTP |
| Hosting | cPanel (shared hosting) |

## Directory Structure

```
app/
├── Http/Controllers/
│   ├── HomeController.php         # Public pages
│   ├── BookingController.php      # Booking form + quote API
│   └── Admin/
│       ├── AuthController.php
│       ├── DashboardController.php
│       ├── BookingController.php
│       ├── GalleryController.php
│       └── RatesController.php
├── Models/
│   ├── Booking.php
│   ├── Facility.php
│   ├── Activity.php
│   ├── GalleryImage.php
│   └── User.php
├── Services/
│   ├── BookingQuoteService.php    # All quote calculation logic
│   └── AvailabilityService.php    # Date/capacity checking
└── Mail/
    ├── BookingConfirmation.php    # To client on submission
    ├── BookingNotification.php    # To admin on submission
    └── BookingStatusUpdate.php    # To client on confirm/cancel
```

## Quick Start (Development)

```bash
composer install
cp .env.example .env
php artisan key:generate
# Edit .env with your DB credentials
php artisan migrate --seed
php artisan storage:link
php artisan serve
```

## Deployment

See `DEPLOY.md` for complete cPanel deployment instructions.

Default admin: `admin@evemountain.co.zw` / `ChangeMe2024!`
**Change this password immediately after first login.**
# eve-mountain
