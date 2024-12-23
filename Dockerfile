FROM php:8.2-apache as web

RUN apt-get update && apt-get install -y \
    libzip-dev \
    zip \
    npm

RUN apt-get clean && rm -rf /var/lib/apt/list/*
RUN a2enmod rewrite
RUN docker-php-ext-install zip

ENV APACHE_DOCUMENT_ROOT=/var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

COPY . /var/www/html

WORKDIR /var/www/html

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN composer install

RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
RUN npm install
RUN npm run build

EXPOSE 8000

