FROM php:apache
RUN docker-php-ext-install mysqli
RUN apt-get update && apt-get install -y libzip-dev zip && docker-php-ext-install zip 