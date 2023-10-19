FROM php:apache

RUN apt-get update && apt-get install -y default-mysql-client
RUN docker-php-ext-install mysqli pdo pdo_mysql

#COPY docker-init.sh /docker-entrypoint-initdb.d/docker-init.sh

RUN a2enmod rewrite
WORKDIR /var/www/html
COPY /src .
EXPOSE 80

CMD ["apache2-foreground"]