# Bookletto

Bookletto is a premium editorial-style Laravel 12 bookstore catalog and physical book sales site built with Blade, Tailwind CSS, Vite, and PostgreSQL.

## Stack

- Laravel 12
- PostgreSQL
- Blade
- Tailwind CSS
- Vite

## Database

Use the following local PostgreSQL settings in `.env`:

```env
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=bookletto
DB_USERNAME=postgres
DB_PASSWORD=SDNA8148
```

## Run Locally

```bash
composer install
npm install
php artisan migrate:fresh --seed
npm run dev
php artisan serve
```

If PowerShell blocks `npm run dev` with an execution policy error, use `cmd /c npm run dev` in Windows terminals or relax the local process policy for that session.

## Demo Accounts

- Admin: `admin@bookletto.test`
- Reader: `reader@bookletto.test`
- Password: `password`

## Features

- Premium landing page with hero, best seller, category, featured books, and CTA sections
- Login and register pages in the same visual language as the landing page
- Book detail page
- Session cart
- Simple checkout flow
- Admin dashboard
- CRUD buku fisik (judul, sinopsis, penulis, penerbit, tahun terbit, harga, cover, halaman, genre)
- CRUD kategori
- Order management

## Avast / IDP.Generic

If Avast flags Laravel, PHP, Composer, Node.js, npm, or Vite with `IDP.Generic`, treat it as a likely false positive and keep the standard Laravel workflow.

Recommended exceptions:

- Project folder: `e:\laragon\www\bookletto`
- `php.exe`
- `node.exe`
- `composer.exe`

Keep `php artisan serve` and `npm run dev` running in the normal Laravel/Vite way. Avoid custom looping or background processes beyond the standard dev server setup.

## Notes

- Route `/` renders the full landing page.
- Seed data is included so the homepage is populated immediately after migration and seeding.
- Checkout stores orders in PostgreSQL and the admin panel can manage books, categories, and orders.
