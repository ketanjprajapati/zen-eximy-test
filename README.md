steps:

create database =E_commerce_store
php artisan migrate
php artisan make:seeder ProductMasterSeeder
composer install
php artisan serve