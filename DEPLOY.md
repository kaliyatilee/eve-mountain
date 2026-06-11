# Eve Mountain Campsite — cPanel Deployment Guide

## Prerequisites
- cPanel hosting with PHP 8.2+
- MySQL database
- SSH access (recommended) OR File Manager
- Composer installed (or run locally and upload vendor/)

---

## Step 1 — Upload Files

### Option A: via SSH (recommended)
```bash
# Connect via SSH
ssh yourusername@yourserver.com

# Navigate to home directory (one level ABOVE public_html)
cd /home/yourusername/

# Upload the project zip and extract
unzip evemountain.zip
# This creates /home/yourusername/evemountain/
```

### Option B: via cPanel File Manager
1. Upload `evemountain.zip` to `/home/yourusername/` (NOT inside public_html)
2. Extract it there

Your directory structure should be:
```
/home/yourusername/
├── evemountain/          ← Laravel root (NOT public)
│   ├── app/
│   ├── bootstrap/
│   ├── config/
│   ├── database/
│   ├── public/           ← this is what your domain points to
│   ├── resources/
│   ├── routes/
│   ├── storage/
│   └── vendor/
└── public_html/          ← NOT used directly
```

---

## Step 2 — Point Domain to public/

### In cPanel → Domains (or Addon Domains):
- Set the document root to: `/home/yourusername/evemountain/public`

### OR create a symlink (via SSH):
```bash
# Remove existing public_html or rename it
mv public_html public_html_backup

# Create symlink from public_html to Laravel public/
ln -s /home/yourusername/evemountain/public /home/yourusername/public_html
```

---

## Step 3 — Create MySQL Database

In cPanel → MySQL Databases:
1. Create database: `yourusername_evemountain`
2. Create user: `yourusername_emuser` with a strong password
3. Add user to database with **ALL PRIVILEGES**

---

## Step 4 — Configure .env

```bash
cd /home/yourusername/evemountain/

# Copy the example file
cp .env.example .env

# Edit it (nano or vi via SSH, or File Manager)
nano .env
```

Update these values:
```env
APP_URL=https://yourdomain.com
APP_KEY=                          # leave blank — generated in Step 5

DB_DATABASE=yourusername_evemountain
DB_USERNAME=yourusername_emuser
DB_PASSWORD=your_db_password

MAIL_HOST=mail.yourdomain.com     # from cPanel Email Accounts
MAIL_USERNAME=info@yourdomain.com
MAIL_PASSWORD=your_email_password
MAIL_FROM_ADDRESS=info@yourdomain.com
MAIL_ADMIN_EMAIL=admin@yourdomain.com
```

---

## Step 5 — Install Dependencies & Setup

Via SSH:
```bash
cd /home/yourusername/evemountain/

# Install PHP dependencies
composer install --no-dev --optimize-autoloader

# Generate application key
php artisan key:generate

# Run database migrations
php artisan migrate

# Seed initial data (facilities, activities, admin user)
php artisan db:seed

# Create storage symlink (makes /public/storage point to /storage/app/public)
php artisan storage:link

# Set correct permissions
chmod -R 755 storage/
chmod -R 755 bootstrap/cache/
```

---

## Step 6 — Verify Installation

Visit these URLs to confirm everything works:

| URL | Expected |
|-----|----------|
| `https://yourdomain.com` | Home page |
| `https://yourdomain.com/facilities` | Facilities page |
| `https://yourdomain.com/book` | Booking form |
| `https://yourdomain.com/admin/login` | Admin login |

**Admin login credentials (change immediately):**
- Email: `admin@evemountain.co.zw`
- Password: `ChangeMe2024!`

---

## Step 7 — Post-deployment Checklist

- [ ] Change admin password: Admin → (top right) → Profile
- [ ] Update `.env` → `APP_DEBUG=false`
- [ ] Install SSL certificate in cPanel → SSL/TLS
- [ ] Update contact details in footer (`resources/views/layouts/app.blade.php`)
- [ ] Upload photos via Admin → Gallery
- [ ] Test booking form end-to-end
- [ ] Verify confirmation emails are received
- [ ] Update phone number and address on Contact page

---

## Composer Not Available via SSH?

If your host doesn't have Composer:

1. Run locally on your computer:
   ```bash
   composer install --no-dev --optimize-autoloader
   ```
2. Upload the entire `vendor/` folder via FTP/File Manager
3. Then on the server run only:
   ```bash
   php artisan key:generate
   php artisan migrate
   php artisan db:seed
   php artisan storage:link
   ```

---

## PHP Version Check

In cPanel → MultiPHP Manager, ensure the domain uses **PHP 8.2** or higher.

Required PHP extensions (usually enabled by default on cPanel):
- `pdo_mysql`
- `gd` (for image resizing)
- `mbstring`
- `openssl`
- `fileinfo`

---

## Email Setup (cPanel SMTP)

In cPanel → Email Accounts, create: `info@yourdomain.com`

Then in `.env`:
```env
MAIL_MAILER=smtp
MAIL_HOST=mail.yourdomain.com
MAIL_PORT=465
MAIL_USERNAME=info@yourdomain.com
MAIL_PASSWORD=your_email_password
MAIL_ENCRYPTION=ssl
```

Test by submitting a contact form on the live site.

---

## Troubleshooting

**500 error on home page:**
- Check `storage/logs/laravel.log` for the actual error
- Ensure `APP_KEY` is set in `.env`
- Ensure `storage/` and `bootstrap/cache/` are writable

**Images not showing after upload:**
- Run `php artisan storage:link`
- Verify `APP_URL` in `.env` matches your actual domain exactly

**Emails not sending:**
- Test SMTP credentials in cPanel → Email Accounts
- Try port 587 with TLS if 465 fails
- Check spam folder first

**Database connection error:**
- Double-check `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD` in `.env`
- In cPanel MySQL, confirm the user is added to the database with all privileges
