# MATCHING SITE

This repository contains backend.

## System Requirements:
*  Php 7.1.3 or greater
*  Laravel 5.7 or greater
*  MySQL
*  Composer

## Setting up Server

**Before we start:** 
1.  Clone this repository.  
2.  Run `cp .env.example .env`
3.  Fills up .env file for database.

**Run these in terminal. Ensure these are run in root folder.**  
1.  `composer install`
2.  `php artisan key:generate`
3.  `php artisan migrate`
4.  `php artisan migrate --seed`

** Admin **  
1.  Aceess {DOMAIN}/admin
2.  Account: admin@gmail.com/123456
