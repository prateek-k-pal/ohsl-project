# Use the official PHP with Apache image as the base
FROM php:8.2-apache

# Install system dependencies and Composer
RUN apt-get update && apt-get install -y git
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Set the working directory in the container
WORKDIR /var/www/html/

# Copy your PHP web application files
COPY . /var/www/html/

# Copy the vendor directory (where Composer dependencies are installed)
COPY vendor/ /var/www/html/vendor/

# Install PHP extensions (if needed)
RUN docker-php-ext-install pdo pdo_mysql

# Expose ports for Apache
EXPOSE 80 443

# Define startup command to start Apache
CMD ["apache2-foreground"]