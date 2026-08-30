# Studwise International — Rebuild

Awwwards-style rebuild of studwise.in, same content and real images, built with vanilla PHP + MySQL (no framework, no JS bundler).

## Requirements

- PHP 8.1+ with PDO MySQL extension
- MySQL 5.7+ / 8+

## Setup

1. Create the database and import schema + seed data:

   ```bash
   mysql -u root -e "CREATE DATABASE studwise_dev CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"
   mysql -u root studwise_dev < database/schema.sql
   mysql -u root studwise_dev < database/seed.sql
   ```

2. Download the real site images (one-time; skips anything already downloaded):

   ```bash
   bash scripts/download-images.sh
   ```

3. If your DB credentials differ from the defaults (`root` / no password / `127.0.0.1`), set env vars before starting PHP, e.g.:

   ```bash
   export STUDWISE_DB_USER=myuser
   export STUDWISE_DB_PASS=mypass
   ```

4. Run the site locally:

   ```bash
   php -S localhost:8000 -t public scripts/dev-router.php
   ```

   Then open http://localhost:8000/. The `dev-router.php` argument is optional — it just makes unmatched/typo'd URLs return a real 404 instead of PHP's built-in server default of falling back to the homepage. Everything works without it too.

## Structure

- `config/`, `database/`, `includes/`, `scripts/` — live **outside** `public/`, so credentials and SQL are never web-servable.
- `public/` — the actual document root: pages, `contact-submit.php` (the form handler), and `assets/`.
- `database/schema.sql` / `seed.sql` — all tables and the real content scraped from the live site.

## Contact form

`contact.php` posts to `contact-submit.php`, which validates input server-side, checks a CSRF token and a honeypot field, and inserts into the `contact_messages` table via a PDO prepared statement. View submissions with:

```sql
SELECT * FROM contact_messages ORDER BY created_at DESC;
```

## Production deployment note

For a real Apache/Nginx host, keep `public/` as the vhost document root and everything else one level up (outside it), exactly as laid out here. Add `.htaccess` / server rewrite rules only if you want pretty URLs later — plain `.php` URLs work as-is.
