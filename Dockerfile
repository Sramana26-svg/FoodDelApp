# Use the latest PHP image with Apache
FROM php:8.2-apache

# Copy app files into the container
COPY . /var/www/html/

# Set working directory
WORKDIR /var/www/html/

# Enable Apache mod_rewrite if needed
RUN a2enmod rewrite

# Expose port 80 for Render
EXPOSE 80
