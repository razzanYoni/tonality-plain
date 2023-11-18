# Use the official PHP Apache image as the base image
FROM php:8.0-apache

# Install necessary PHP extensions and packages
RUN rm /etc/apt/preferences.d/no-debian-php \
    && apt-get update && apt-get install -y libxml2-dev \
    && apt-get install -y php-soap \
    && docker-php-ext-install pdo pdo_mysql

# Setup xdebug for debugging
RUN pecl install xdebug \
    && docker-php-ext-enable xdebug \
    && docker-php-ext-install soap \
    && echo "zend_extension=xdebug" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "[xdebug]" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.mode=develop,debug" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.client_host=host.docker.internal" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.start_with_request=yes" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "extension=soap" >> /usr/local/etc/php/php.ini \

# Set the working directory in the container
WORKDIR /var/www/html

# Copy source code into the container
COPY . /var/www/html

# Configure Apache to enable mod_rewrite (for clean URLs)
RUN a2enmod rewrite

# Start the Apache web server
CMD ["apache2-foreground"]