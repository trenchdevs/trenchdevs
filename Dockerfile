FROM ubuntu:20.04

# disable installs with choices
# e.g. Geographic area
ARG DEBIAN_FRONTEND=noninteractive

RUN apt update
RUN apt-get install -y \
    nginx \
    curl \
    php-fpm \
    php-mysql \
    php-xml \
    php7.4-zip \
    php-mbstring \
    nodejs \
    npm

RUN npm install --global yarn

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# nginx
RUN ln -s /etc/nginx/sites-available/trenchdevs /etc/nginx/sites-enabled
RUN unlink /etc/nginx/sites-enabled/default
COPY ./docker/nginx/trenchdevs /etc/nginx/sites-available/trenchdevs

# directories
RUN mkdir /var/www/trenchdevs
RUN chown -R $USER:$USER /var/www/trenchdevs

WORKDIR /var/www/trenchdevs



# back end dependencies
COPY composer.json composer.json
COPY composer.lock composer.lock
RUN composer install --prefer-dist --no-scripts --no-dev --no-autoloader && rm -rf /root/.composer

# copy all files not on on .dockerignore
COPY . .

# Finish composer
RUN composer dump-autoload --no-scripts --no-dev --optimize

RUN chown -R www-data:www-data /var/www/trenchdevs/storage
RUN chown -R www-data:www-data /var/www/trenchdevs/bootstrap/cache

# front end dependencies
#COPY package.json package-lock.json ./
#RUN yarn install

# front-end production build
#RUN yarn run production

EXPOSE 80

# RUN sed -i -e "s/;clear_env\s*=\s*no/clear_env = no/g" /etc/php/7.4/fpm/pool.d/www.conf

# on boot start nginx + fpm without the need of supervisord
CMD service nginx start && \
    service php7.4-fpm start && \
    exec /bin/bash -c "trap : TERM INT; sleep infinity & wait"

