# Use the official PHP Apache image as the base image
FROM php:8.0-apache

# Install necessary PHP extensions and packages
RUN apt-get update && apt-get install -y \
    && docker-php-ext-install pdo pdo_mysql

# Set the working directory in the container
WORKDIR /var/www/html

# Copy source code into the container
COPY . /var/www/html

# Configure Apache to enable mod_rewrite (for clean URLs)
RUN a2enmod rewrite

# Start the Apache web server
CMD ["apache2-foreground"]