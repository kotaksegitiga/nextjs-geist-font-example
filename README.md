# Laravel Persekot Application - Step by Step Installation and Setup

This guide will walk you through the installation and setup of the Laravel Persekot application, including database setup, user and admin views, and key features.

---

## Step 1: Install Laravel

1. Ensure you have PHP (>=8.0), Composer, and a web server installed.
2. Create a new Laravel project or clone this repository.

To create a new Laravel project:

```bash
composer create-project laravel/laravel persekot-app
cd persekot-app
```

---

## Step 2: Configure Database

1. Install MySQL or use an existing MySQL server.
2. Create a new database for the application, e.g., `persekot_db`.
3. (Optional) Create a MySQL user with privileges for this database.
4. Configure Laravel to use this database by editing the `.env` file:

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=persekot_db
DB_USERNAME=your_db_user
DB_PASSWORD=your_db_password
```

---

## Step 3: Run Migrations

Run the Laravel migrations to create the necessary tables:

```bash
php artisan migrate
```

This will create tables including `users` (with roles) and `persekot_requests`.

---

## Step 4: Install Dependencies

Install PHP dependencies:

```bash
composer install
```

Install Node dependencies and build assets:

```bash
npm install
npm run dev
```

---

## Step 5: Set Up Authentication

Laravel Breeze or default auth scaffolding is assumed.

If not installed, you can install Laravel Breeze:

```bash
composer require laravel/breeze --dev
php artisan breeze:install
npm install
npm run dev
php artisan migrate
```

---

## Step 6: Seed Admin User

Create an admin user manually in the database or via tinker:

```bash
php artisan tinker
>>> \App\Models\User::create([
... 'name' => 'Admin User',
... 'email' => 'admin@example.com',
... 'password' => bcrypt('password'),
... 'role' => 'admin',
... ]);
```

---

## Step 7: Run the Application

Start the Laravel development server:

```bash
php artisan serve
```

Access the app at [http://127.0.0.1:8000](http://127.0.0.1:8000).

---

## Step 8: Application Usage

- **Login Page:** Redirects here if not authenticated.
- **Admin User:** Redirected to AdminLTE dashboard with approval and export features.
- **Regular User:** Redirected to Persekot request list and form.
- **Create Request:** Users can create Persekot requests with detailed usage.
- **Approval:** Admin can approve/reject requests; notifications sent via WhatsApp and Email.
- **PDF Export:** Requests can be exported as PDF with approval barcode.
- **Barcode:** Approval section includes a QR code barcode for verification.

---

## Additional Notes

- Configure mail settings in `.env` for email notifications.
- Install `barryvdh/laravel-dompdf` for PDF generation:

```bash
composer require barryvdh/laravel-dompdf
```

- Install `milon/barcode` for barcode generation:

```bash
composer require milon/barcode
```

- Configure WhatsApp API credentials as needed.

---

For any questions or further assistance, please contact the developer.
