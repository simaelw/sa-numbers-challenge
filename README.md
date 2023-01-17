# South Africa Numbers Challenge

A REST API application validates attempts to fixes South African mobile numbers from a CSV file and single form.

This project is developed with [Laravel 9](https://laravel.com/docs/9.x) which requires php version `^ 8.0.2` in order to work

## Installation
1. Clone or download the repository
2. Create `.env` file by copying the `.env.example`. You may use the command to do that `cp .env.example .env`
3. Update the database name and credentials in `.env` file
4. If `.env` file was created by copying the `.env.example` you may need to run this: `php artisan key:generate` in order to create the app key
5. Go to the root project directory and run `composer install`
6. Run the command `php artisan migrate`