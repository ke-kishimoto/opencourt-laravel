FROM php:8.0.27-apache

ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

RUN  a2enmod rewrite

COPY . /var/www/html

RUN docker-php-ext-install pdo_mysql
RUN chown www-data:www-data -R /var/www/html

EXPOSE 80

CMD ["apache2-foreground"]