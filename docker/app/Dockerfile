# Dockerfile
# Reference: https://hub.docker.com/_/php?tab=description

# Base docker image
FROM php:8.2-apache

# Install required packages
RUN apt-get update && apt-get install -y \
        geoip-database \
        unzip \
        wget \
        xvfb \
        zlib1g-dev \
        libzip-dev \
    && docker-php-ext-install zip

# Download and install composer per https://getcomposer.org/download/
ENV COMPOSER_HASH e21205b207c3ff031906575712edab6f13eb0b361f2085f1f1237b7126d785e826a450292b6cfd1d64d92e6563bbde02
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" \
    && php -r "if (hash_file('SHA384', 'composer-setup.php') === '${COMPOSER_HASH}') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;" \
    && php composer-setup.php \
    && php -r "unlink('composer-setup.php');" \
    && mv composer.phar /usr/local/bin/composer

# Use the default production configuration
RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"

# Apache vhost configuration
ENV APACHE_DOCUMENT_ROOT /var/www/application
COPY ../../ ${APACHE_DOCUMENT_ROOT}/
COPY 001-application.conf /etc/apache2/sites-available/
RUN a2enmod rewrite \
    && a2dissite 000-default default-ssl \
    && a2ensite 001-application \
    && apache2ctl restart
