FROM php:8.2-apache

# Enable mod_rewrite for the .htaccess file to work
RUN a2enmod rewrite

# Copy your files into the default Apache directory
COPY . /var/www/html/

# Ensure Apache has permission to read the files
RUN chown -R www-data:www-data /var/www/html/

# php:8.2-apache exposes 80 by default
EXPOSE 80