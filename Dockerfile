FROM php:8.2-apache

# Copy your files to the web directory
COPY . /var/www/html/

# Enable Apache rewrite module for .htaccess
RUN a2enmod rewrite

# Set proper permissions
RUN chown -R www-data:www-data /var/www/html