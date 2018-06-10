FROM php:7.0.4-fpm

RUN apt-get update && apt-get install -y mysql-client git

RUN apt-get update && apt-get install -y \
   libmcrypt-dev libpng12-dev libfreetype6-dev libjpeg62-turbo-dev \
   && docker-php-ext-install iconv mcrypt pdo_mysql \
   && docker-php-ext-configure gd --with-freetype-dir=/usr/include/ --with-gd-dir=/usr/include/ \
   && docker-php-ext-install gd \
   && docker-php-ext-install zip

# Install curl
RUN apt-get install -y libcurl4-openssl-dev \
    && docker-php-ext-install curl mbstring

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer