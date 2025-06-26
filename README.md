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
