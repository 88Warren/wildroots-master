# Use an official PHP-FPM image
FROM php:8.3-fpm-alpine

# Copy the project files into the container (alternative to volumes)
# COPY . /var/www/html

# Set the working directory
WORKDIR /var/www/html

# Expose port 9000 for PHP-FPM
EXPOSE 9000