FROM php:7.2-fpm-stretch

ARG INTERFACE="0.0.0.0"

COPY ./custom.ini $PHP_INI_DIR/conf.d/custom.ini
COPY ./xdebug.ini $PHP_INI_DIR/conf.d/xdebug.ini

ENV INTERFACE $INTERFACE

RUN apt-get update
RUN docker-php-ext-install mysqli pdo_mysql
RUN pecl install xdebug && docker-php-ext-enable xdebug
RUN sed -i "1 a xdebug.remote_host="$INTERFACE $PHP_INI_DIR/conf.d/xdebug.ini

RUN usermod -u 1000 www-data

EXPOSE 9000
