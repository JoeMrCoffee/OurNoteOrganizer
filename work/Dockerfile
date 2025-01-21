FROM php:8.0-apache
RUN apt update
RUN apt install libcurl4-openssl-dev pkg-config libssl-dev unzip -y
RUN pecl install mongodb
RUN docker-php-ext-enable mongodb.so
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN composer require --working-dir=/var/www mongodb/mongodb
RUN sed -i 's/upload_max_filesize = 2M/upload_max_filesize = 20M/' /usr/local/etc/php/php.ini
RUN sed -i 's/post_max_size = 8M/post_max_size = 20M/' /usr/local/etc/php/php.ini

EXPOSE 80
