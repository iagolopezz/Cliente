
FROM php:8.1-apache

RUN apt-get update && apt-get install -y \
    $PHPIZE_DEPS \
    libssl-dev \
    pkg-config \
    && pecl install mongodb-1.21.0 \
    && docker-php-ext-enable mongodb \
    && rm -rf /var/lib/apt/lists/*

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

COPY composer.json ./

RUN composer install --no-dev --no-interaction

