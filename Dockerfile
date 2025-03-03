FROM php:latest

WORKDIR /var/www

COPY ./index.php ./contact.php ./send_email.php ./services.php ./testimonials.php ./style.css .

EXPOSE 80

CMD php -S 0.0.0.0:80
