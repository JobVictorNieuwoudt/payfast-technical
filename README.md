<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>
PHP Laravel Application Setup

Prerequisites:

Before you begin setting up the Payfast Admin/User Message Application, ensure you have the following prerequisites installed:

1) XAMPP: If you don't have XAMPP installed, download it from https://www.apachefriends.org/download.html.

2) PHP 8.1 or Later: Download PHP 8.1 or a later version from https://windows.php.net/download#php-8.1. Be sure to download the "VS16 x64 Thread Safe Zip" package.

3) Node.js LTS: Download for Windows (x64) - nodejs.org/en

Setup Instructions:

Follow these steps to set up the Sales Management Application on your local environment:

1) Start XAMPP Services: Open the XAMPP Control Panel and start both the Apache and MySQL servers.

2) Open Command Prompt or Terminal: Navigate to the root directory of your project. For example, use the cd command to move to your project directory: cd C:\xampp\htdocs\Payfast\payfast

3) Run Laravel Development Server: Start the Laravel development server by running the following command:
    a) composer install
    b) php artisan serve
    c) npm run dev

5) Access phpMyAdmin: Open your web browser and go to http://localhost/phpmyadmin/

6) Create a Database: Create a new MySQL database named payfastdb.

7) Migrate Database Tables: Run the following command to create the necessary database tables for the application:
   a)php artisan migrate:fresh
       i) In your php.ini file make sure to uncomment 'extension=pdo=mysql' and 'extension=mysql'
   b)php artisan db:seed

9) Access the Application: Open a new browser window and navigate to http://127.0.0.1:8000/ to start using the Application.

Feel free to reach out if you encounter any issues or have further questions.

Seeded user:
name = 'Test User',
email = 'user@gmail.com',
password = 'password'

Seeded admin:
name = 'Admin User',
email = 'admin@gmail.com',
password = 'password'
