FROM composer:latest AS composer

RUN docker-php-ext-install mysqli

COPY ./composer.json /app

RUN composer install \
	--no-interaction \
	--no-plugins \
	--no-scripts \
	--prefer-dist

FROM php:7.2-fpm-stretch

COPY . /app

ENV COMPOSER_ALLOW_SUPERUSER 1
COPY --from=composer /usr/bin/composer /usr/bin/composer
COPY --from=composer /app/vendor /app/vendor

COPY ./docker/php/custom.ini $PHP_INI_DIR/conf.d/custom.ini

RUN apt-get update && docker-php-ext-install mysqli pdo_mysql

RUN usermod -u 1000 www-data

WORKDIR /app

RUN mkdir logs

CMD sleep 12; vendor/bin/phinx migrate -c bin/phinx.php; docker-php-entrypoint php-fpm;
