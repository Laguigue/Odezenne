FROM php:7.1-fpm

MAINTAINER Bram van Osta <bramvanosta@gmail.com>

# Install modules
RUN apt-get update && apt-get install -y libmcrypt-dev git \
    mysql-client libmagickwand-dev --no-install-recommends zip unzip \
    && pecl install imagick \
    && docker-php-ext-enable imagick \
    && docker-php-ext-install mcrypt pdo_mysql

# Install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer