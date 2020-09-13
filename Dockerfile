FROM lorisleiva/laravel-docker:7.4 AS builder

WORKDIR /tmp
ADD . .

RUN composer install --no-progress && npm ci

FROM php:7.4-apache AS runtime
WORKDIR /var/www/html

COPY --from=builder /tmp /var/www/html
RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini" && \
    docker-php-ext-install pdo_mysql mysqli && \
    rm /etc/apache2/sites-enabled/* && \
    rm -rf /etc/apache2/sites-available && \
    mv apache /etc/apache2/sites-available && \
    ln -s /etc/apache2/sites-available/10-trenchdev.conf /etc/apache2/sites-enabled/. && \
    chown -R $USER:www-data /var/www/html && \
    chmod -R 775 storage && \
    chmod -R 775 bootstrap/cache && \
    a2enmod rewrite

