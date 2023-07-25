# Start from a base image that includes PHP and other necessary components
FROM php:latest

# Install system dependencies and Composer
RUN apt-get update && apt-get install -y git
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Set the working directory in the container
WORKDIR /var/www/html/

# Copy your PHP web application files
COPY . /var/www/html/

# Install the OpenAI library using Composer
ENV COMPOSER_ALLOW_SUPERUSER 1
RUN composer install

# Set the appropriate permissions for log.txt
RUN touch log.txt
RUN chown www-data:www-data /var/www/html/log.txt
RUN chmod 644 /var/www/html/log.txt


# Install PHP extensions (if needed)
RUN docker-php-ext-install pdo pdo_mysql
RUN docker-php-ext-install mysqli


# Expose ports for Apache
EXPOSE 80 443

# Define startup command to start Apache
CMD ["apache2-foreground"]
