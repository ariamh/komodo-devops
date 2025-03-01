FROM php:latest

WORKDIR /var/www

COPY ./index.php .

EXPOSE 80

CMD php -S 0.0.0.0:80