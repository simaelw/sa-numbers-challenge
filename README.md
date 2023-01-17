# South Africa Numbers Challenge

A REST API application validates and attempts to fixes South African mobile numbers from a CSV file and single form.

This project is developed with [Laravel 9](https://laravel.com/docs/9.x) and php version `8.1.2` for external composer dependencies, composer and mysql database management

## Installation
1. Clone or download the repository
2. Create `.env` file by copying the `.env.example`. You may use the command to do that `cp .env.example .env`
3. Update the database name and credentials in `.env` file
4. If `.env` file was created by copying the `.env.example` you may need to run this: `php artisan key:generate` in order to create the app key
5. Go to the root project directory and run `composer install`
6. Run the command `php artisan migrate`

## Serving the project
After the project has been created, start Laravel's local development server using the Laravel's Artisan CLI serve command:
```shell
php artisan serve
```
Once you have started the Artisan development server, your application will be accessible in your web browser at http://localhost:8000

## Api doc Generation
In order to let the api documentation works please follow these next steps:

1. Update or add the parameter `APP_URL` with the local url of your project (if you served the app with the command `php artisan serve` then you can add the APP_URL value with: `http://localhost:8000`)
2. Run `php artisan scribe:generate`
3. Visit the apidoc to `{project_path}/docs`
4. Follow the doc to consume endpoints or download the provided postman collection from the direct link.