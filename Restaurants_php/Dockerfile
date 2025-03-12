
FROM php:8.0-apache

WORKDIR /var/www/html

COPY . .

USER root

RUN docker-php-ext-install mysqli && docker-php-ext-enable mysqli

RUN apt-get update && apt-get install -y \
    default-mysql-client \
    nano \
    && rm -rf /var/lib/apt/lists/*
    
EXPOSE 80

# CMD ["php", "-S", "0.0.0.0:80"]
CMD ["apache2-foreground"]
