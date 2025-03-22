# Use the official PHP 8.1 image as the base
FROM php:8.1-apache

# Install necessary PHP extensions and tools
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    git \
    default-mysql-client \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Enable Apache mod_rewrite
RUN a2enmod rewrite

# Set the ServerName directive globally
RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf

# Set the DirectoryIndex directive
RUN echo "DirectoryIndex index.php index.html" >> /etc/apache2/apache2.conf

# Set the document root to the public directory
RUN sed -i 's|/var/www/html|/var/www/html/public|g' /etc/apache2/sites-available/000-default.conf /etc/apache2/apache2.conf

# Copy the application code to the container
COPY . /var/www/html/

# Set the working directory
WORKDIR /var/www/html/

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Install PHP dependencies
RUN composer install

# Set the appropriate permissions
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html

# Run migrations and stop the build if it fails
# Copy and set up entrypoint
COPY entrypoint.sh /usr/local/bin/
RUN chmod +x /usr/local/bin/entrypoint.sh
ENTRYPOINT ["entrypoint.sh"]
CMD ["apache2-foreground"]


# Expose port 80
EXPOSE 80