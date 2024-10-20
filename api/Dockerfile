FROM php:8.3-apache
# Install pdo_mysql extension
RUN docker-php-ext-install pdo pdo_mysql
# Enable Apache rewrite module
RUN a2enmod rewrite
# Set working directory
WORKDIR /var/www/html