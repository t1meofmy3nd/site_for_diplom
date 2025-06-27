# MedTech Web Application

This project relies on environment variables for database connection settings.

Set the following variables before running the PHP scripts:

- `DB_HOST` — database server hostname
- `DB_NAME` — name of the database
- `DB_USER` — database user
- `DB_PASS` — password for the user

For local development, you can export them in your shell or configure your web
server to provide them. If no variables are supplied, `db.php` attempts to use
`localhost` with the `medtech` database and connects as the `root` user with an
empty password.
# MedTech Store

This project is a simple PHP application for an online medical technology store.

## Requirements
- PHP 7.4 or higher
- MySQL server

## Installation
1. Clone the repository:
   ```bash
   git clone <repo-url>
   ```
2. Import the database:
   ```bash
   mysql -u <user> -p < medtech.sql
   ```
   Alternatively, you can use phpMyAdmin to import the `medtech.sql` file.
3. Configure database credentials in `db.php` if they differ from the defaults.

## Running the local server
Navigate to the project directory and run the built-in PHP server:
```bash
php -S localhost:8000
```
The site will be available at [http://localhost:8000](http://localhost:8000).

## Pages
- `index.html` — главная страница с популярными товарами
- `catalog.html` — каталог медицинского оборудования
- `services.html` — описание доступных услуг

## Environment setup
Create a copy of `.env.example` named `.env` and update the variables as needed for your environment. The application reads these variables in `db.php` when establishing the database connection.