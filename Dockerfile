FROM php:8.2-apache


RUN a2enmod rewrite && \
    apt-get update && apt-get install -y libpq-dev && \
    docker-php-ext-install pdo pdo_pgsql && \
    sed -i '/<Directory \/var\/www\/>/,/<\/Directory>/ s/AllowOverride None/AllowOverride All/' /etc/apache2/apache2.conf

COPY . /var/www/html/
WORKDIR /var/www/html/
RUN chown -R www-data:www-data /var/www/html/

EXPOSE 80
