
drop database nowa;
create database nowa;




composer create-project laravel/laravel:^9.0 nowa
composer require laravel/breeze --dev
php artisan breeze:install
php artisan migrate
npm run dev