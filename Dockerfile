FROM php:8.4.7-apache

# Enable Apache mod_rewrite
RUN a2enmod rewrite

# Copy custom Apache config
COPY apache/000-default.conf /etc/apache2/sites-available/000-default.conf
