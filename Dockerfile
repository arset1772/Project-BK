FROM richarvey/nginx-php-fpm:latest

COPY . /var/www/html

ENV WEBROOT=/var/www/html/public
ENV APP_ENV=production
ENV APP_DEBUG=false

RUN composer install --no-dev --optimize-autoloader

# Perintah tambahan agar cache dan storage Laravel tidak error 500
RUN php artisan config:clear
RUN php artisan cache:clear
RUN chmod -R 777 storage bootstrap/cache

EXPOSE 80
