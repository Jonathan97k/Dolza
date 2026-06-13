# Dolza Real Properties & Estate Agency

Full-featured real estate website with admin panel built with Laravel 11.

## Features

- **Public site** — Property listings, about, services, team, testimonials, contact form
- **Admin panel** — Dashboard, manage properties/team/testimonials/inquiries, content management, media library, settings
- **REST API** — All data available via JSON API with Sanctum token auth

## Quick Start (Development)

```bash
# 1. Start the server
cd F:\Dolza-website
php artisan serve --port=8000

# 2. Open in browser
# http://localhost:8000 — Public site
# http://localhost:8000/admin/login — Admin panel

# 3. Login
# Email:    dolza@admin.com
# Password: Dolza2008!
```

## Hosting Requirements

Laravel requires a PHP web server. **Vercel does not support PHP.** Choose one:

| Option | Cost | Difficulty | Best for |
|--------|------|-----------|----------|
| **Shared hosting** (cPanel) | $3-10/mo | Easy | Most users |
| **Railway / Render** | $5-15/mo | Medium | Developers |
| **DigitalOcean + Forge** | $10-20/mo | Easy | Production |
| **Hostinger / Namecheap** | $2-5/mo | Easy | Budget |

## Deployment (Shared Hosting)

```bash
# 1. Set up MySQL database in cPanel, note the DB name/user/password

# 2. Build frontend assets (if any) and config cache
php artisan config:cache
php artisan route:cache
php artisan view:cache

# 3. Upload entire project to server (excluding:
#    .git, node_modules/, tests/, storage/logs/, .env)

# 4. On the server:
cp .env.example .env
# Edit .env with your DB credentials, APP_URL, APP_KEY

# 5. Run migrations and seed
php artisan migrate --force
php artisan db:seed --force

# 6. Set permissions
chmod -R 775 storage bootstrap/cache
chmod -R 775 public/images
```

## Deployment (Railway)

[![Deploy on Railway](https://railway.app/button.svg)](https://railway.app/template/laravel)

1. Push to GitHub
2. Create Railway project from repo
3. Add MySQL plugin
4. Set env vars in Railway dashboard
5. Run `php artisan migrate --force` and `php artisan db:seed --force`

## Environment Variables

| Variable | Description | Example |
|----------|-------------|---------|
| `APP_KEY` | Laravel app key (run `php artisan key:generate`) | `base64:...` |
| `APP_URL` | Site URL | `https://dolza.com` |
| `DB_CONNECTION` | `mysql` or `sqlite` | `mysql` |
| `DB_HOST` | Database host | `127.0.0.1` |
| `DB_DATABASE` | Database name | `dolza_real_estate` |
| `DB_USERNAME` | Database user | `root` |
| `DB_PASSWORD` | Database password | |

## Admin Credentials

- **URL:** `http://yourdomain.com/admin/login`
- **Email:** `dolza@admin.com`
- **Password:** `Dolza2008!`

**Change the password immediately after first login.**

## Tech Stack

- **Backend:** Laravel 11, PHP 8.2+
- **Database:** SQLite (dev) / MySQL (production)
- **Auth:** Session-based (web admin), Sanctum tokens (API)
- **Frontend:** Blade templates, CSS custom properties, Font Awesome 6
- **Storage:** Local filesystem (`public/images/`)

## License

Private — All rights reserved. Dolza Real Properties & Estate Agency.
