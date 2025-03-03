FROM php:latest

# Install dependencies
RUN apt-get update && apt-get install -y \
    git \
    zip \
    unzip \
    curl

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Set working directory
WORKDIR /var/www

# Copy project files
COPY ./index.php ./contact.php ./send_email.php ./services.php ./testimonials.php ./style.css ./.env ./

# Create composer.json if not exists
RUN if [ ! -f composer.json ]; then \
    echo '{"require": {"phpmailer/phpmailer": "^6.8", "vlucas/phpdotenv": "^5.5"}}' > composer.json; \
    fi

# Install dependencies with Composer
RUN composer install

# Expose port 80
EXPOSE 80

# Start PHP server
CMD php -S 0.0.0.0:80
