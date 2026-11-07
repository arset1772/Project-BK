FROM richarvey/nginx-php-fpm:latest

COPY . /var/www/html

ENV WORKDIR=/var/www/html
ENV APP_ENV=production
ENV APP_KEY=base64:AZv8oQ1y0ou0CgDhzRbYSi2+w1s54OrumRKFt2gP2DU=
ENV DOCUMENT_ROOT=/var/www/html/public

RUN composer install --no-dev --optimize-autoloader

EXPOSE 80