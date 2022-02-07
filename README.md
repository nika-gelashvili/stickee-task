## Requirements
<ul>
<li>PHP >= 7.3</li>
</ul>

## Installation
Install Composer
```
curl -sS https://getcomposer.org/installer | php
mv composer.phar /usr/local/bin/composer
```
Run composer install command
```
composer i
```
Create .env folder and copy .env.example into .env file and change database values accordingly.

Run command for migrations
```
php artisan migrate
```
Run command to seed tables
```
php artisan db:seed
```

## Starting Server
To start server run command
```
php artisan serve
```
