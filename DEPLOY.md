# AdsNoval — Local Setup & Deployment Guide

AdsNoval is a self-owned Laravel 11 PPC (paid-to-click) platform. No third-party
license or activation gate. This guide gets it running locally (with MySQL),
then covers going live.

---

## 1. Requirements

- **PHP 8.2+** with extensions: `pdo_mysql`, `mbstring`, `openssl`, `bcmath`, `ctype`, `fileinfo`, `json`, `tokenizer`, `xml`, `curl`, `gd`
- **Composer 2**
- **MySQL 5.7.8+ / 8.x** (or MariaDB 10.3+)
- A web server for production (Apache/Nginx). For local testing, the built-in `php artisan serve` is enough.

Check versions:
```bash
php -v          # must be 8.2+
composer -V
mysql --version
```

---

## 2. Get the code & install dependencies

```bash
git clone https://github.com/peterman22/adsnoval.git
cd adsnoval
composer install
```

---

## 3. Create the MySQL database

Log into MySQL and create an empty database (name it `adsnoval`):

```bash
mysql -u root -p
```
```sql
CREATE DATABASE adsnoval CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
-- optional: a dedicated user
CREATE USER 'adsnoval'@'localhost' IDENTIFIED BY 'strong_password_here';
GRANT ALL PRIVILEGES ON adsnoval.* TO 'adsnoval'@'localhost';
FLUSH PRIVILEGES;
EXIT;
```

### Windows + XAMPP

If you're on XAMPP, `mysql` isn't on your PATH — use one of these:

- **phpMyAdmin (easiest):** XAMPP Control Panel → Start **Apache** + **MySQL** →
  open `http://localhost/phpmyadmin` → **New** → create a database named
  `adsnoval` (collation `utf8mb4_general_ci`).
- **CLI by full path:** `C:\xampp\mysql\bin\mysql -u root -p` then press **Enter**
  at the password prompt (XAMPP's root password is empty by default), and run the
  `CREATE DATABASE adsnoval ...` statement above.

XAMPP's root user has **no password**, so in `.env` set `DB_USERNAME=root` and
leave `DB_PASSWORD=` blank. Run the app with `php artisan serve` (not
`http://localhost/adsnoval`) so Laravel's `public/` folder is the web root.

---

## 4. Configure the environment

```bash
cp .env.example .env
php artisan key:generate
```

Open `.env` and set your DB credentials (they default to MySQL now):

```dotenv
APP_NAME=AdsNoval
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=adsnoval
DB_USERNAME=root          # or adsnoval
DB_PASSWORD=              # your MySQL password

# Email during local testing: 'log' writes emails to storage/logs/laravel.log
MAIL_MAILER=log
```

> Prefer no MySQL for a quick trial? Set `DB_CONNECTION=sqlite` and run
> `touch database/database.sqlite` instead — everything else is identical.

---

## 5. Run migrations & seed data

This creates all tables and inserts starter data (plans, a demo crypto wallet,
settings, demo ads, and an admin account):

```bash
php artisan migrate --seed
```

Expected tables include: `users`, `admins`, `plans`, `ads`, `ad_views`,
`transactions`, `deposits`, `withdrawals`, `crypto_methods`, `commissions`,
`settings`, `email_templates`, plus Laravel's `sessions`, `cache`, `jobs`.

Re-run from scratch at any time:
```bash
php artisan migrate:fresh --seed   # WARNING: wipes all data
```

---

## 6. Link storage (for QR codes & receipt uploads)

```bash
php artisan storage:link
```

---

## 7. Run it locally

```bash
php artisan serve
```
Open **http://127.0.0.1:8000**

---

## 8. Default logins (CHANGE THESE)

| Area  | URL                                   | Email / Username        | Password   |
|-------|---------------------------------------|-------------------------|------------|
| Admin | `http://127.0.0.1:8000/admin/login`   | `admin@adsnoval.test`   | `password` |
| User  | register a fresh account at `/register` | —                     | —          |

Change the admin password immediately:
```bash
php artisan tinker
>>> $a = App\Models\Admin::first();
>>> $a->email = 'you@yourdomain.com';
>>> $a->password = Illuminate\Support\Facades\Hash::make('a-strong-password');
>>> $a->save();
```

---

## 9. Smoke-test the full flow

1. **Register** a user at `/register` → lands on the dashboard.
2. **Watch Ads** → open an ad, wait the timer, solve the sum, confirm → balance goes up.
3. **Spin & Rewards** → spin the wheel and claim the daily streak.
4. **Deposit** → pick the seeded crypto wallet, enter amount + a fake TXID, submit.
5. **Admin → Deposits** → Approve it → the user's balance is credited (+ email logged).
6. **Withdraw** (as user) → request a payout (balance is held).
7. **Admin → Withdrawals** → Mark paid, or Reject with a reason (auto-refunds).
8. **Admin → Plans / Ads / Crypto Wallets** → add as many as you want.
9. **Admin → Settings** → set SMTP + toggles. **Admin → Email Templates** → edit emails.

Emails while `MAIL_MAILER=log`: read them in `storage/logs/laravel.log`.

---

## 10. Configure for real use

- **Admin → Settings:** site name, min withdrawal, referral %s, and **SMTP**
  (host/port/username/password/encryption/from). Once SMTP is set, welcome/OTP/
  transaction emails send for real. Turn on "Require email (OTP) verification" if wanted.
- **Admin → Crypto Wallets:** add your real deposit/withdrawal wallet addresses and
  upload a **QR code** image for each.
- **Admin → Plans:** create your membership tiers (unlimited).
- **Admin → Ads:** add ads (website / YouTube / image / script), unlimited.

---

## 11. Going live (production)

```dotenv
APP_ENV=production
APP_DEBUG=false
APP_URL=https://yourdomain.com
```
```bash
composer install --no-dev --optimize-autoloader
php artisan migrate --force
php artisan storage:link
php artisan config:cache && php artisan route:cache && php artisan view:cache
```

- Point your web server's **document root to `public/`**.
- Ensure `storage/` and `bootstrap/cache/` are writable by the web server.
- Set a real mailer (SMTP via Admin → Settings) and switch `MAIL_MAILER` off `log`.
- For scheduled tasks later, add cron: `* * * * * php /path/to/artisan schedule:run >> /dev/null 2>&1`

### Shared hosting (cPanel) note
If your host serves from `public_html`, either point the domain's docroot to the
project's `public/` folder, or move the contents of `public/` into `public_html`
and update the `require` paths in `public_html/index.php` to point back to the
project (`__DIR__.'/../adsnoval/vendor/autoload.php'` etc.).

---

## Troubleshooting

- **`could not find driver`** → enable `pdo_mysql` in php.ini.
- **`SQLSTATE...Access denied`** → wrong `DB_USERNAME`/`DB_PASSWORD` in `.env`.
- **Uploaded QR/receipts 404** → run `php artisan storage:link`.
- **Changed `.env` but nothing changed** → `php artisan config:clear`.
- **Blank page in production** → check `storage/logs/laravel.log`; ensure `storage/` is writable.
