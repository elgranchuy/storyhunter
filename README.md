Steps to initialize project.

Create a mysql database locally named storyhunter
Rename .env.example file to .env inside your project root and fill the database information
Run composer install
Run php artisan key:generate
Run php artisan migrate
Run php artisan passport:install
Run php artisan serve
