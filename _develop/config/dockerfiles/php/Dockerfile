FROM php:7.2-fpm
MAINTAINER damian

RUN apt-get update && apt-get install -y libssl-dev libxml2-dev zlib1g-dev libicu-dev libpq-dev curl git \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libpng-dev \
    && docker-php-ext-configure intl \
    && docker-php-ext-install intl \
    && docker-php-ext-install zip \
    && docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql \
    && docker-php-ext-install pdo \
    && docker-php-ext-install pdo_mysql pdo_pgsql pgsql \
    && docker-php-ext-install opcache \
    && docker-php-ext-enable opcache \
    && docker-php-ext-install ftp \
    && docker-php-ext-install exif \
    && docker-php-ext-enable exif \
    && docker-php-ext-install gd \
    && pecl install apcu \
    && docker-php-ext-enable apcu \
    && docker-php-ext-configure gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/ \
    && docker-php-ext-install -j$(nproc) gd

RUN printf "\
    date.timezone=\"UTC\"\n\
    request_order=GP\n\
    expose_php=Off\n\
    enable_dl=Off\n\
    enable_dl=Off\n\
    extension=php_pgsql.dll\n\
    short_open_tag=Off\n\
    " > /usr/local/etc/php/php.ini

RUN yes | pecl install xdebug-2.6.0alpha1 \
    && echo "zend_extension=$(find /usr/local/lib/php/extensions/ -name xdebug.so)" > /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "xdebug.remote_enable=on" >> /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "xdebug.remote_autostart=on" >> /usr/local/etc/php/conf.d/xdebug.ini

RUN docker-php-ext-enable xdebug

RUN echo "date.timezone = \"Europe/Warsaw\"" > /usr/local/etc/php/conf.d/datetime.ini

RUN usermod -u 1000 www-data

#SYMFONY
RUN mkdir -p /usr/local/bin
RUN curl -LsS https://symfony.com/installer -o /usr/local/bin/symfony
RUN chmod a+x /usr/local/bin/symfony

#COMPOSER
RUN curl -sS https://getcomposer.org/installer | php
RUN mv composer.phar /usr/local/bin/composer

RUN composer global require "phpunit/phpunit"
ENV PATH /root/.composer/vendor/bin:$PATH
RUN ln -s /root/.composer/vendor/bin/phpunit /usr/bin/phpunit