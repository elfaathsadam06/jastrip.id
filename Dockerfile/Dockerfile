FROM php:8.2

WORKDIR /var/www

COPY . .

RUN apt-get update && apt-get install -y \
    unzip curl libzip-dev zip \
    && docker-php-ext-install pdo pdo_mysql

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

RUN composer install

RUN chmod -R 777 storage bootstrap/cache

CMD php artisan serve --host=0.0.0.0 --port=10000
