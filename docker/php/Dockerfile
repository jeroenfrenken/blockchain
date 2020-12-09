FROM php:8.0-cli

RUN apt-get update \
    && apt-get install -y libzip-dev libpq-dev libmcrypt-dev unzip --no-install-recommends nano \
    && rm -rf /tmp/pear

RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" \
    && php composer-setup.php --filename=composer \
    && php -r "unlink('composer-setup.php');" \
    && mv composer /usr/local/bin/composer

WORKDIR /var/www/blockchain
